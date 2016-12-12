<?php
/**
 * @file
 * Contains \Drupal\mac_tools\Controller\Homepage.
 */

namespace Drupal\mac_tools\Controller;

use Drupal\Core\Controller\ControllerBase;

class Homepage extends ControllerBase {
  public function content() {

    // Returning an empty page. Homepage content will be provided by blocks.
    return array(
      '#type' => 'markup',
      '#markup' => '',
    );
  }
}
?>