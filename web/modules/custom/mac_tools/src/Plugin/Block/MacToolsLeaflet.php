<?php

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Leaflet block.
 *
 * @Block(
 *   id = "leaflet",
 *   subject = @Translation("Leaflet"),
 *   admin_label = @Translation("Metalartcreations tools: Leaflet")
 * )
 */
class MacToolsLeaflet extends BlockBase {

  /**
   * Implements \Drupal\Core\Block\BlockBase::blockBuild().
   */
  public function build() {
    $build = [];
    $build['#attached']['library'][] = 'mac_tools/leaflet';
    return $build;
  }

}
