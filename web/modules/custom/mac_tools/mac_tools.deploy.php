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
