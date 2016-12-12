<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsGa.
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Google analytics block.
 *
 * @Block(
 *   id = "ga",
 *   subject = @Translation("Google analytics"),
 *   admin_label = @Translation("Metalartcreations tools: Google analytics")
 * )
 */
class MacToolsGa extends BlockBase {

  /**
   * Implements \Drupal\Core\Block\BlockBase::blockBuild().
   */
  public function build() {
    $build = array();
    $build['#attached']['library'][] = 'mac_tools/ga';
    return $build;
  }
}
