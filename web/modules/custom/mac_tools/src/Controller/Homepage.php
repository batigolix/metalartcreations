<?php
/**
 * @file
 * Contains \Drupal\mac_tools\Controller\Homepage.
 */

namespace Drupal\mac_tools\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides an empty homepage.
 */
class Homepage extends ControllerBase {
  /**
   * Returns (no) markup.
   */
  public function content() {

    // Returning an empty page. Homepage content will be provided by blocks.
    return array(
      '#type' => 'markup',
      '#markup' => '',
    );
  }

}
