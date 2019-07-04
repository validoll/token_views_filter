<?php

namespace Drupal\Tests\token_views_filter\Functional;

use Drupal\Tests\views\Functional\ViewTestBase;
use Drupal\views\Tests\ViewTestData;

/**
 * Tests token filter plugin functionality.
 *
 * @group views
 * @see \Drupal\token_views_filter\Plugin\views\filter\TokensStringFilter
 */
class TokenViewsFilterTest extends ViewTestBase {

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['test_token_filter'];

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['views_ui', 'token_views_filter', 'token_views_filter_test'];

  /**
   * {@inheritdoc}
   */
  protected function setUp($import_test_views = TRUE) {
    parent::setUp($import_test_views);

    if ($import_test_views) {
      ViewTestData::createTestViews(get_class($this), ['token_views_filter_test']);
    }

    $this->enableViewsTestModule();

    $this->adminUser = $this->drupalCreateUser(['administer views']);
    $this->drupalLogin($this->adminUser);
  }

  /**
   * Tests the settings form field exists (string).
   */
  public function testFormFieldStringUseTokenExists() {
    $this->drupalGet('admin/structure/views/nojs/handler/test_token_filter/default/filter/test_filter_string');
    // Make sure the field exists.
    $this->assertSession()
      ->fieldExists('options[use_tokens]');
  }

  /**
   * Tests the settings form field exists (numeric).
   */
  public function testFormFieldNumericUseTokenExists() {
    $this->drupalGet('admin/structure/views/nojs/handler/test_token_filter/default/filter/test_filter_numeric');
    // Make sure the field exists.
    $this->assertSession()
      ->fieldExists('options[use_tokens]');
  }

}
