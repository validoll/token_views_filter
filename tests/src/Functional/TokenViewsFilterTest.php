<?php

namespace Drupal\Tests\token_views_filter\Functional\Plugin;

use Drupal\Tests\views\Functional\ViewTestBase;
use Drupal\views\Views;

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
  public static $testViews = ['test_filter'];

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['views_ui', 'token_views_filter'];

  /**
   * {@inheritdoc}
   */
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
    $this->drupalGet('admin/structure/views/nojs/handler/test_filter/default/filter/type');
    // Make sure the field exists.
    $this->assertSession()
      ->fieldExists('options[use_tokens]');
  }

  /**
   * Tests token replacement.
   */
  public function testTokenReplacement() {
    $view = Views::getView('test_filter');
    $view->initDisplay();

    $filters = $view->display_handler->getOption('filters');
    $filters['type']['value'] = '[site:name]';
    $filters['type']['use_tokens'] = TRUE;

    $view->display_handler->overrideOption('filters', $filters);
    $this->executeView($view);

    $this->assertSame('Drupal', $view->filter['type']->value);
  }

}
