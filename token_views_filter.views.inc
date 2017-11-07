<?php

/**
 * @file
 * Primarily Drupal hooks to manipulate Token Views Filter.
 */

function token_views_filter_views_plugins_filter_alter(array &$plugins) {
  // Change the 'string' handler class.
  $plugins['string']['class'] = 'Drupal\\token_views_filter\\Plugin\\views\\filter\\TokensStringFilter';
}
