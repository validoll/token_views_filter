<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\views\Plugin\views\filter\StringFilter;

/**
 * Extending basic string filter to use tokens as value.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("string_with_tokens")
 */
class TokensStringFilter extends StringFilter {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function preQuery() {
    parent::preQuery();

    // Replace tokens.
    $this->value = \Drupal::token()->replace($this->value);
  }

}
