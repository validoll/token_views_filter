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
   *
   * @param mixed $value
   *   Array of values `min`, `max` and `value` or just value.
   */
  public function replaceTokens(&$value);

}
