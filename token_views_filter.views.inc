<?php

/**
 * @file
 * Primarily Drupal hooks to manipulate Token Views Filter.
 */

use Drupal\token_views_filter\Plugin\views\filter\TokensStringFilter;
use Drupal\token_views_filter\Plugin\views\filter\TokensNumericFilter;

/**
 * Implements hook_views_plugins_filter_alter().
 */
function token_views_filter_views_plugins_filter_alter(array &$plugins) {
  $plugins['string']['class'] = TokensStringFilter::class;
  $plugins['numeric']['class'] = TokensNumericFilter::class;
}
