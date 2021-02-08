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
  protected $defaultTheme = 'stable';

  /**
   * {@inheritdoc}
   */
  public static $modules = ['mac_tools'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testSomething() {
    $admin_user = $this->drupalCreateUser(['access administration pages']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin');
    $this->assertSession()->elementExists('xpath', '//h1[text() = "Administration"]');
  }

  /**
   * Test access.
   */
  public function testAccess() {
    $this->drupalGet('contact');
    $this->assertSession()->statusCodeEquals(200, 'Status code is equal to 200');
  }


  /**
   * Test title tag and text.
   */
  public function testTitle() {
    $this->assertSession()
      ->pageTextContains('Gebruik het formulier beneden om contact op te nemen met Birgit.
');
    $this->assertSession()->elementExists('xpath', '//h1[text() = "Contact opnemen"]');
    $this->assertSession()->elementExists('xpath', '//h3[text() = "Contactformulier"]');
  }

}
