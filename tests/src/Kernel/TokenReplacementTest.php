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
  public static $modules = ['token_views_filter', 'token', 'token_views_filter_test'];

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
  public function testTokenReplacement() {
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
      ],
      $view->filter['test_filter_numeric_between']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => date('Y-m-d'),
        'type' => 'date'
      ],
      $view->filter['test_filter_date']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => date('Y-m-d'),
        'type' => 'date'
      ],
      $view->filter['test_filter_datetime']->value
    );
  }

  /**
   * Tests disabled token replacement in filters.
   */
  public function testDisabledTokenReplacement() {
    $view = Views::getView('test_token_filter');
    $view->initDisplay();

    // Disable token replacement.
    $filters = $view->display_handler->getOption('filters');
    $filters['test_filter_string']['use_tokens'] = FALSE;
    $filters['test_filter_numeric']['use_tokens'] = FALSE;
    $filters['test_filter_numeric_between']['use_tokens'] = FALSE;
    $filters['test_filter_date']['use_tokens'] = FALSE;
    $filters['test_filter_datetime']['use_tokens'] = FALSE;
    $view->display_handler->overrideOption('filters', $filters);

    $this->executeView($view);

    $this->assertSame('[test:value:Drupal]', $view->filter['test_filter_string']->value);

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '[test:value:333]',
      ],
      $view->filter['test_filter_numeric']->value
    );

    $this->assertSame(
      [
        'min' => '[test:value:111]',
        'max' => '[test:value:999]',
        'value' => '',
      ],
      $view->filter['test_filter_numeric_between']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '[current-date:custom:Y-m-d]',
        'type' => 'date'
      ],
      $view->filter['test_filter_date']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '[current-date:custom:Y-m-d]',
        'type' => 'date'
      ],
      $view->filter['test_filter_datetime']->value
    );
  }


  /**
   * Tests empty token replacement in filters.
   */
  public function testEmptyTokenReplacement() {
    $view = Views::getView('test_token_filter');
    $view->initDisplay();

    // Disable token replacement.
    $filters = $view->display_handler->getOption('filters');
    $filters['test_filter_string']['value'] = '[test:value]';
    $filters['test_filter_numeric']['value'] = [
      'min' => '',
      'max' => '',
      'value' => '[test:value]',
    ];
    $filters['test_filter_numeric_between']['value'] = [
      'min' => '[test:value]',
      'max' => '[test:value]',
      'value' => '',
    ];
    $filters['test_filter_date']['value'] = [
      'min' => '',
      'max' => '',
      'value' => '[test:value]',
    ];
    $filters['test_filter_datetime']['value'] = [
      'min' => '',
      'max' => '',
      'value' => '[test:value]',
    ];
    $view->display_handler->overrideOption('filters', $filters);

    $this->executeView($view);

    $this->assertSame('', $view->filter['test_filter_string']->value);

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '',
      ],
      $view->filter['test_filter_numeric']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '',
      ],
      $view->filter['test_filter_numeric_between']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '',
        'type' => 'date',
      ],
      $view->filter['test_filter_date']->value
    );

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '',
        'type' => 'date',
      ],
      $view->filter['test_filter_datetime']->value
    );

  }

  /**
   * Tests views tokens replacement in filters.
   */
  public function testTokenViewsReplacement() {
    $view = Views::getView('test_token_filter');
    $view->initDisplay();

    // Disable token replacement.
    $filters = $view->display_handler->getOption('filters');
    $filters['test_filter_string']['value'] = '[view:id]';
    $filters['test_filter_numeric']['value'] = [
      'min' => '',
      'max' => '',
      'value' => '[view:page-count]',
    ];

    $view->display_handler->overrideOption('filters', $filters);

    $this->executeView($view);

    $this->assertSame('test_token_filter', $view->filter['test_filter_string']->value);

    $this->assertSame(
      [
        'min' => '',
        'max' => '',
        'value' => '1',
      ],
      $view->filter['test_filter_numeric']->value
    );

  }

}
