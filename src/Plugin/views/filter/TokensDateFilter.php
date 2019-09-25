<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\Date;

/**
 * Extending if basic date filter to use tokens as value.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("date_with_tokens")
 */
class TokensNumericFilter extends Date implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens() {
    $data = ['view' => $this->view];

    $this->value['value'] = $this->token->replace($this->value['value'], $data, ['clear' => TRUE]);
    $this->value['min'] = $this->token->replace($this->value['min'], $data, ['clear' => TRUE]);
    $this->value['max'] = $this->token->replace($this->value['max'], $data, ['clear' => TRUE]);
  }

}
