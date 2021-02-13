<?php

namespace Drupal\Tests\mac_tools\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test description.
 *
 * @group mac_tools
 */
class ContactTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $profile = 'standard';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['mac_tools', 'contact', 'node'];

  /**
   * {@inheritdoc}
   */
  public function setUp() : void {
    parent::setUp();

  }

  /**
   * Test access.
   */
  public function testAccess() {
    $this->drupalGet('user');
    $this->assertSession()->statusCodeEquals(200);
  }

}
