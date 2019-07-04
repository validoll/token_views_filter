<?php

namespace Drupal\Tests\token_views_filter\Kernel;

use Drupal\Tests\views\Kernel\ViewsKernelTestBase;
use Drupal\views\Tests\ViewTestData;
use Drupal\views\Views;

/**
 * Tests handler token replacement in filter.
 *
 * @group views
 */
class TokenReplacementTest extends ViewsKernelTestBase {

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
  public static $modules = ['token_views_filter', 'token_views_filter_test'];

  /**
   * {@inheritdoc}
   *
   * @param bool $import_test_views
   *   Should the views specified on the test class be imported. If you need
   *   to setup some additional stuff, like fields, you need to call false and
   *   then call createTestViews for your own.
   */
  protected function setUp($import_test_views = TRUE) {
    parent::setUp($import_test_views);

    if ($import_test_views) {
      ViewTestData::createTestViews(get_class($this), ['token_views_filter_test']);
    }
  }

  /**
   * Tests token replacement in filters.
   */
  public function testTokenStringReplacement() {
    $view = Views::getView('test_token_filter');
    $view->initDisplay();

    $this->executeView($view);

    $this->assertSame('Drupal', $view->filter['test_filter_string']->value);

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '333',
      ],
      $view->filter['test_filter_numeric']->value
    );

    $this->assertSame(
      [
        'min' => '111',
        'max' => '999',
        'value' => '',
        'type' => 'numeric'
      ],
      $view->filter['test_filter_numeric_between']->value
    );
  }

}
