<?php

namespace Drupal\token_views_filter;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Provides Valeo Status plugin manager.
 *
 * @see plugin_api
 */
class TokenViewsFilterPluginManager extends DefaultPluginManager {

  /**
   * Constructs a StatusManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/views/filter/token',
      $namespaces,
      $module_handler
    );
    $this->alterInfo('token_views_filter');
    $this->setCacheBackend($cache_backend, 'token_views_filter_plugins');
  }

}
