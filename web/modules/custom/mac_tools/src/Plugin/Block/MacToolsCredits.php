<?php

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_credits",
 *   subject = @Translation("Credits"),
 *   admin_label = @Translation("Metalartcreations tools: Credits"),
 * )
 */
class MacToolsCredits extends BlockBase {

  /**
   * The default string.
   *
   * @var string
   */
  protected $defaultMarkup = '<ul class="links"><li>© Birgit Doesborg. All rights reserved.</li><li>Design: Dope trope theme by <a href="http://html5up.net">HTML5 UP</a></li><li>Gemaakt met <a href="http://drupal.org">Drupal</a></li></ul>';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label' => t("Credits"),
      'credits_markup_string' => $this->defaultMarkup,
      'cache' => [
        'max_age' => 3600,
        'contexts' => [
          'cache_context.user.roles',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['credits_markup_string_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Credits markup'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['credits_markup_string'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['credits_markup_string']
      = $form_state->getValue('credits_markup_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->configuration['credits_markup_string'],
    ];
  }

}
