<?php

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Google translate block.
 *
 * @Block(
 *   id = "gtranslate",
 *   subject = @Translation("Google translate"),
 *   admin_label = @Translation("Metalartcreations tools: Google translate")
 * )
 */
class MacToolsGtranslate extends BlockBase {

  /**
   * Implements \Drupal\Core\Block\BlockBase::blockBuild().
   */
  public function build() {
    $build = [];
    $build['container']['#markup'] = '<div id="google_translate_element"></div>';
    $build['#attached']['library'][] = 'mac_tools/gtranslate';
    $build['#attached']['library'][] = 'mac_tools/gtranslate_external';
    return $build;
  }

}
