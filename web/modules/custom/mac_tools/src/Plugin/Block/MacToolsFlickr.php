<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsFlickr .
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "flickr",
 *   subject = @Translation("Flickr"),
 *   admin_label = @Translation("Metalartcreations tools: Flickr")
 * )
 */
class MacToolsFlickr extends BlockBase {

  /**
   * Overrides \Drupal\Core\Block\BlockBase::defaultConfiguration().
   */
//  public function defaultConfiguration() {
//    return array(
//      'label' => t("Photo's on Flickr"),
//      'content' => t('Default demo content'),
//      'cache' => array(
//        'max_age' => 3600,
//        'contexts' => array(
//          'cache_context.user.roles',
//        ),
//      ),
//    );
//  }



  /**
   * Overrides \Drupal\Core\Block\BlockBase::blockForm().
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();

    // Add a form field to the existing block configuration form.
    $form['flickr_items'] = array(
      '#type' => 'select',
      '#title' => t('Number of items'),
      '#options' => array(
        10 => 10,
        12 => 12,
        15 => 15,
        16 => 16,
        18 => 18,
        20 => 20
      ),
      '#description' => t('Number of items that will be shown in the slideshow.'),
      '#default_value' => isset($config['flickr_items']) ? $config['flickr_items'] : '',
    );

//    $config = $this->configuration;
//    $defaults = $this->defaultConfiguration();
//    $form['flickr_items'] = array(
//      '#type' => 'select',
//      '#title' => t('Number of items'),
//      '#options' => array(
//        10 => 10,
//        12 => 12,
//        15 => 15,
//        16 => 16,
//        18 => 18,
//        20 => 20
//      ),
//      '#description' => t('This number of items will be shown in the Flickr block'),
//      '#default_value' => $config['flickr_items'],
//    );
//
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
//    $this->configuration['flickr_items'] = $form_state->getValue('flickr_items');
    $this->setConfigurationValue('flickr_items', $form_state->getValue('flickr_items'));
//    $this->setConfigurationValue('slideshow_order', $form_state->getValue('slideshow_order'));
  }


  /**
   * Implements \Drupal\Core\Block\BlockBase::blockBuild().
   */
  public function build() {
    $config = $this->getConfiguration();
    $flickr_items = isset($config['flickr_items']) ? $config['flickr_items'] : 12;
    $build = array();
    $build['container']['#markup'] = '<div id="flickr_images"></div>';
    $build['#attached']['library'][] = 'mac_tools/flickr';
    $build['#attached']['drupalSettings']['mac_tools']['flickr']['flickr_items'] = $flickr_items;
    $build['#attributes']['class'][] = 'mac-tools-flickr';
    return $build;
  }


}
