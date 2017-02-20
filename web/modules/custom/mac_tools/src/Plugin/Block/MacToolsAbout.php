<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsAbout .
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_about",
 *   subject = @Translation("About"),
 *   admin_label = @Translation("Metalartcreations tools: About"),
 * )
 */
class MacToolsAbout extends BlockBase {

  protected $defaultMarkup = '<p>Birgit Doesborg is meestergoudsmid en parttime docent metaaltechniek. De mogelijkheid bestaat om haar als gastdocent uit te nodigen bij kunst educatieve centra\'s en/of scholen.<br> Zie<a href="workshops-cursussen/Priveles.html"> privé workshops.</a> <br>Zelf ontwerpt zij haar eigen stijl, handgemaakte sieraden en objecten met als specialiteit Mokume-gane die te bezichtigen zijn op <a href="http://www.doesdesign.nl/">Doesdesign.nl</a>';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'label' => t("About"),
      'about_markup_string' => $this->defaultMarkup,
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
    $form['about_markup_string_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('About markup'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['about_markup_string'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['about_markup_string']
      = $form_state->getValue('about_markup_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->configuration['about_markup_string'],
    );
  }

}
