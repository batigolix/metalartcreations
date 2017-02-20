<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsContact .
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_contact",
 *   subject = @Translation("Contact"),
 *   admin_label = @Translation("Metalartcreations tools: Contact"),
 * )
 */
class MacToolsContact extends BlockBase {

  protected $defaultMarkup = '<ul class="social"><li><a class="icon fa-facebook" href="https://www.facebook.com/pages/Metalartcreationsnl-CursussenWorkshops-edelsmeden/251140938298459"><span class="label">Facebook</span></a></li><li><a class="icon fa-twitter" href="http://twitter.com/#!/Doesdesign_nl"><span class="label">Twitter</span></a></li><li><a class="icon fa-youtube" href="http://www.youtube.com/user/metalartcreations"><span class="label">YouTube</span></a></li><li><a class="icon fa-linkedin" href="http://nl.linkedin.com/in/birgitdoesborg"><span class="label">LinkedIn</span></a></li><li><a class="icon fa-google-plus" href="https://plus.google.com/103824648539381715794"><span class="label">Google+</span></a></li></ul><ul class="contact"><li><h3>Adres</h3><p>Metalartcreations<br />Tramkade 20<br />5211VB<br />\'s Hertogenbosch</p></li><li><h3>E-mail</h3><p><a href="mailto:birgit@metalartcreations.nl">birgit@metalartcreations.nl</a></p></li><li><h3>Telefoon</h3><p>06-38343719</p></li></ul>';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'label' => t("Contact"),
      'contact_markup_string' => $this->defaultMarkup,
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
    $form['contact_markup_string_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Contact markup'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['contact_markup_string'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['contact_markup_string']
      = $form_state->getValue('contact_markup_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->configuration['contact_markup_string'],
    );
  }

}
