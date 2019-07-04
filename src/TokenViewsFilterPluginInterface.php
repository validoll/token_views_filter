<?php

namespace Drupal\token_views_filter;

/**
 * Interface of filter plugin with token replacement.
 *
 * @package Drupal\token_views_filter
 */
interface TokenViewsFilterPluginInterface {

  /**
   * Replace tokens in filters.
   */
  public function replaceTokens();

}
