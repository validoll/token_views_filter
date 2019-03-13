<?php

namespace Drupal\Tests\token_views_filter\Functional\Plugin;

use Drupal\Tests\views\Functional\ViewTestBase;

/**
 * Tests token filter plugin functionality.
 *
 * @group views
 * @see \Drupal\token_views_filter\Plugin\views\filter\TokensStringFilter
 */
class FilterTest extends ViewTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['views_ui', 'node', 'token_views_filter'];

  protected function setUp($import_test_views = TRUE) {
    parent::setUp($import_test_views);

    $this->enableViewsTestModule();

    $this->adminUser = $this->drupalCreateUser(['administer views']);
    $this->drupalLogin($this->adminUser);
  }

  /**
   * Tests the settings form field exists.
   */
  public function testFormFieldUseTokenExists() {
    $out = $this->drupalGet('admin/structure/views/nojs/handler/test_filter/default/filter/type');
    // Make sure the field exists.
    $this->assertSession()
      ->fieldExists('options[use_tokens]');
  }

}
