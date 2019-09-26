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
    /** @var \Drupal\views\Plugin\views\filter\FilterPluginBase $plugin */
    if (!$plugin_manager->hasDefinition($name)) {
      continue;
    }

    $plugin = $plugin_manager->createInstance($name);
    $definition['class'] = get_class($plugin);
  }
}
