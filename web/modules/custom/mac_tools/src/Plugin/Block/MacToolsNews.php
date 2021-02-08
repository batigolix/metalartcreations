<?php

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "News",
 *   subject = @Translation("News"),
 *   admin_label = @Translation("Metalartcreations tools: News")
 * )
 */
class MacToolsNews extends BlockBase {

  /**
   * Overrides \Drupal\Core\Block\BlockBase::defaultConfiguration().
   */
  public function defaultConfiguration() {
    return [
      'label' => t("Mac tools: News"),
      'content' => t('Default news content'),
      'cache' => [
        'max_age' => 3600,
        'contexts' => [
          'cache_context.user.roles',
        ],
      ],
    ];
  }

  /**
   * Overrides \Drupal\Core\Block\BlockBase::blockForm().
   */
  public function blockForm($form, FormStateInterface $form_state) {

    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();
    $nr_items = isset($config['nr_items']) ? $config['nr_items'] : 3;
    $form['nr_items'] = [
      '#type' => 'select',
      '#options' => [2 => 2, 5 => 5, 10 => 10],
      '#description' => t('This number of items will be shown in the news block'),
      '#title' => t('Number of items'),
      '#default_value' => $nr_items,
    ];
    return $form;
  }

  /**
   * Overrides \Drupal\Core\Block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('nr_items', $form_state->getValue('nr_items'));
  }

  /**
   * Implements \Drupal\Core\Block\BlockBase::blockBuild().
   */
  public function build() {

    $config = $this->getConfiguration();
    $nr_items = isset($config['nr_items']) ? $config['nr_items'] : 3;

    // Fetches the slideshow nodes.
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'article')
      ->range(0, $nr_items);
    $nids = $query->execute();

    $items = [];
    foreach ($nids as $nid) {
      $items[] = [
        '#markup' => 'sfdsdf',
        '#wrapper_attributes' => ['class' => ['slide']],
      ];
    }

    $build = [];
    $build['items']['#markup'] = $nr_items;
    $build['elements']['#markup'] = 'placeholder';
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $nr_items = $form_state->getValue('nr_items');

    if (!is_numeric($nr_items)) {
      $form_state->setErrorByName('nr_items', t('Needs to be an interger'));
    }
  }

}
