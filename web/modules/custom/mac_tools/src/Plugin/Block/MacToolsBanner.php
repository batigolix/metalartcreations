<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsBanner .
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_banner",
 *   subject = @Translation("Banner"),
 *   admin_label = @Translation("Metalartcreations tools: Banner"),
 * )
 */
class MacToolsBanner extends BlockBase {

  protected $default_markup = ' <section id="banner"><header><h2>Cursussen en workshops edelsmeden</h2><p>Voor individuen en groepen</p></header></section>';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'label' => t("Banner"),
      'banner_markup_string' => $this->default_markup,
      'cache' => array(
        'max_age' => 3600,
        'contexts' => array(
          'cache_context.user.roles',
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['banner_markup_string_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Banner markup'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['banner_markup_string'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['banner_markup_string']
      = $form_state->getValue('banner_markup_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->configuration['banner_markup_string'],
    );
  }

}
