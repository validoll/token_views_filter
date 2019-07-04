<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\NumericFilter;

/**
 * Extending if basic integer filter to use tokens as value.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("numeric_with_tokens")
 */
class TokensNumericFilter extends NumericFilter implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens() {
    $this->value['value'] = $this->token->replace($this->value['value'], [], ['clear' => TRUE]);
    $this->value['min'] = $this->token->replace($this->value['min'], [], ['clear' => TRUE]);
    $this->value['max'] = $this->token->replace($this->value['max'], [], ['clear' => TRUE]);
  }

}
