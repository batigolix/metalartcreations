<?php

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_trainings",
 *   subject = @Translation("Trainings"),
 *   admin_label = @Translation("Metalartcreations tools: Trainings"),
 * )
 */
class MacToolsTrainings extends BlockBase {

  /**
   * The default string.
   *
   * @var string
   */
  protected $defaultMarkup = '<p>Cursussen <a href="workshops-cursussen/Cursussen-edelsmeden.html">Edelsmeden</a> te s\'-Hertogenbosch. <br><a href="workshops-cursussen/creatieve-workshops.html">Workshops</a> speciale technieken zoals <a href="workshops-cursussen/workshop-Mokume-gane.htm">Mokume-gane</a>, <a href="workshops-cursussen/workshop-sieraden-vilten.html">Sieraden vilten</a>, <a href="workshops-cursussen/Workshop-sieraden-maken-van-Fimoklei.html">Fimoklei sieraden</a>, <a href="workshops-cursussen/workshop-zilvergieten.html">Zilver gieten</a>, etc. </p>';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label' => t("Trainings"),
      'trainings_markup_string' => $this->defaultMarkup,
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
    $form['trainings_markup_string_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Trainings markup'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['trainings_markup_string'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['trainings_markup_string']
      = $form_state->getValue('trainings_markup_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->configuration['trainings_markup_string'],
    ];
  }

}
