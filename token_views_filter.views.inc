<?php

/**
 * @file
 * Primarily Drupal hooks to manipulate Token Views Filter.
 */

use Drupal\token_views_filter\Plugin\views\filter\TokensStringFilter;

/**
 * Implements hook_views_plugins_filter_alter().
 */
function token_views_filter_views_plugins_filter_alter(array &$plugins) {
  // Change the 'string' handler class.
  $plugins['string']['class'] = TokensStringFilter::class;
}
