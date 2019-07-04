<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\StringFilter;

/**
 * Extending basic string filter to use tokens as value.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("string_with_tokens")
 */
class TokensStringFilter extends StringFilter implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens() {
    $this->value = $this->token->replace($this->value, [], ['clear' => TRUE]);
  }

}
