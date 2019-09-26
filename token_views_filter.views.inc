<?php

/**
 * @file
 * Primarily Drupal hooks to manipulate Token Views Filter.
 */

/**
 * Implements hook_views_plugins_filter_alter().
 */
function token_views_filter_views_plugins_filter_alter(array &$plugins) {
  /** @var \Drupal\token_views_filter\TokenViewsFilterPluginManager $plugin_manager */
  $plugin_manager = \Drupal::service('plugin.manager.token_views_filter');

  foreach ($plugins as $name => &$definition) {
    $plugin_definition = $plugin_manager->getDefinition($name, FALSE);
    if (!isset($plugin_definition['class'])) {
      continue;
    }

    $definition['class'] = $plugin_definition['class'];
  }
}
