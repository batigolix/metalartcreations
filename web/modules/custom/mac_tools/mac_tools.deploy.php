<?php

/**
 * @file
 * Deploy hooks for mac_tools.
 *
 * AI generated
 */

declare(strict_types=1);

use Drupal\Core\Database\Database;
use Drupal\editor\Entity\Editor;
use Drupal\filter\Entity\FilterFormat;
use Drupal\node\Entity\Node;

/**
 * Purge orphaned deleted-field entries whose entity type no longer exists.
 *
 * FieldPurger::purgeBatch() runs on every cron and blows up on these
 * (e.g. field_tags referencing taxonomy_term after taxonomy was uninstalled).
 */
function mac_tools_deploy_purge_orphan_deleted_fields_v3(): string {
  $state = \Drupal::state();
  $valid = array_keys(\Drupal::entityTypeManager()->getDefinitions());
  $removed = [];

  $storages = $state->get('field.storage.deleted') ?: [];
  $storage_index = [];
  foreach ($storages as $uuid => $storage) {
    if (!is_object($storage)) {
      continue;
    }
    $host = $storage->getTargetEntityTypeId();
    $target = $storage->getSettings()['target_type'] ?? NULL;
    if (!in_array($host, $valid, TRUE) || ($target !== NULL && !in_array($target, $valid, TRUE))) {
      $removed[] = "storage " . $storage->getName();
      unset($storages[$uuid]);
      continue;
    }
    $storage_index["$host:" . $storage->getName()] = TRUE;
  }
  $state->set('field.storage.deleted', $storages);

  $fields = $state->get('field.field.deleted') ?: [];
  foreach ($fields as $uuid => $field) {
    if (!is_object($field)) {
      continue;
    }
    $host = $field->getTargetEntityTypeId();
    $key = "$host:" . $field->getName();
    // Drop fields whose host is gone, or whose storage no longer exists in
    // field.storage.deleted (left over from a prior incomplete cleanup).
    if (!in_array($host, $valid, TRUE) || !isset($storage_index[$key])) {
      $removed[] = "field " . $field->getName() . "@" . $field->getTargetBundle();
      unset($fields[$uuid]);
    }
  }
  $state->set('field.field.deleted', $fields);

  return $removed
    ? 'Purged orphan deleted-field entries: ' . implode(', ', $removed) . '.'
    : 'No orphan deleted-field entries to purge.';
}

/**
 * Migrate all content to advanced_html; remove the other CKEditor formats.
 */
function mac_tools_deploy_consolidate_text_formats(): string {
  $connection = Database::getConnection();
  $target = 'advanced_html';
  $deprecated = ['basic_html', 'restricted_html', 'full_html'];

  $tables = [
    'node__body' => 'body_format',
    'node_revision__body' => 'body_format',
    'node__field_costs' => 'field_costs_format',
    'node_revision__field_costs' => 'field_costs_format',
    'block_content__body' => 'body_format',
    'block_content_revision__body' => 'body_format',
  ];

  $migrated = [];
  $schema = $connection->schema();
  foreach ($tables as $table => $column) {
    if (!$schema->tableExists($table)) {
      continue;
    }
    $count = $connection->update($table)
      ->fields([$column => $target])
      ->condition($column, $deprecated, 'IN')
      ->execute();
    if ($count > 0) {
      $migrated[] = "$table: $count";
    }
  }

  foreach ($deprecated as $id) {
    if ($editor = Editor::load($id)) {
      $editor->delete();
    }
    if ($format = FilterFormat::load($id)) {
      $format->delete();
    }
  }

  $summary = $migrated
    ? ' Rows migrated: ' . implode(', ', $migrated) . '.'
    : ' No rows needed migration.';
  return 'Consolidated text formats onto advanced_html.' . $summary;
}

/**
 * Fix scheme-less href on node 34 that caused a crawler 404 flood.
 */
function mac_tools_deploy_fix_node_34_schemeless_href(): string {
  $node = Node::load(34);
  if (!$node) {
    return 'Node 34 not found; skipping.';
  }
  $body = $node->get('body')->value;
  $fixed = str_replace(
    'href="www.metalartcreations.nl/',
    'href="https://www.metalartcreations.nl/',
    $body
  );
  if ($fixed === $body) {
    return 'Node 34 already clean; no changes.';
  }
  $node->set('body', [
    'value' => $fixed,
    'format' => $node->get('body')->format,
    'summary' => $node->get('body')->summary,
  ]);
  $node->setNewRevision(TRUE);
  $node->revision_log = 'Fix scheme-less href on node 34 (crawler 404 flood).';
  $node->save();
  return 'Node 34 body updated and new revision created.';
}
