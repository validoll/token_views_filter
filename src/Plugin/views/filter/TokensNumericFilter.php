<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\views\Plugin\views\filter\NumericFilter;

/**
 * Extending if basic integer filter to use tokens as value.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("numeric_with_tokens")
 */
class TokensNumericFilter extends NumericFilter {
  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   *
   * Replace tokens
   */
  public function preQuery() {
    parent::preQuery();

    $this->value['value'] = \Drupal::token()->replace($this->value['value']);
    $this->value['min'] = \Drupal::token()->replace($this->value['min']);
    $this->value['max'] = \Drupal::token()->replace($this->value['max']);
  }

}
