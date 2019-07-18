<?php

/**
 * Drupal VM drush aliases.
 *
 * @see example.aliases.drushrc.php.
 */

$aliases['doesb'] = array(
  'os' => 'Linux',
  'remote-host' => 'doesb.org',
  'remote-user' => 'doesborg',
  'ssh-options' => '-p 7822',
  'path-aliases' => array(
    '%drush-script' => '/usr/local/bin/drush',
  ),
);

$aliases['live'] = array(
    'uri' => 'www.metalartcreations.nl',
    'root' => '/home/doesborg/public_html/metalartcreations-project/production/web',
  ) + $aliases['doesb'];

$aliases['stage'] = array(
    'uri' => 'metalartcreations-stage.doesb.org',
    'root' => '/home/doesborg/public_html/metalartcreations-project/stage/web',
  ) + $aliases['doesb'];

