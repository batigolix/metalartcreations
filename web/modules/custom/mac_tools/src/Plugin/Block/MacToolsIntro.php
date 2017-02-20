<?php

/**
 * @file
 * Contains \Drupal\mac_tools\Plugin\Block\MacToolsIntro .
 */

namespace Drupal\mac_tools\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "mac_tools_intro",
 *   subject = @Translation("Intro"),
 *   admin_label = @Translation("Metalartcreations tools: Intro"),
 * )
 */
class MacToolsIntro extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {

    $path = drupal_get_path('module', 'mac_tools');
    $items = array(
      'first' => array(
        'img' => $path . '/images/Does-smeed.png',
        'title' => 'Workshops',
        'text' => 'Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus',
      ),
      'second' => array(
        'img' => $path . '/images/Ponzen.png',
        'title' => 'Cursussen',
        'text' => 'Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus',
      ),
      'third' => array(
        'img' => $path . '/images/Polijsten.png',
        'title' => 'Lesmateriaal',
        'text' => 'Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus',
      ),
    );

    foreach ($items as $key => $item) {
      $build[$key] = array(
        '#type' => 'markup',
        '#markup' => '<section class="' . $key . '">
                      <img src="/' . $item['img'] . '">
                      <header>
                        <h2>' . $item['title'] . '</h2>
                      </header>
                      <p>' . $item['text'] . '</p>
                    </section>',
      );
    }
    return $build;
  }

}
