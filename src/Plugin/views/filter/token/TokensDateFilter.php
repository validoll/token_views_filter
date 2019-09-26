<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensDateFilterTrait;
use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\Date;

/**
 * Extending if basic date filter to use tokens as value.
 *
 * @Plugin(
 *   id = "date",
 * )
 */
class TokensDateFilter extends Date implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;
  use TokensDateFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens(&$value) {
    $data = ['view' => $this->view];

    $value['value'] = $this->token->replace($value['value'], $data, ['clear' => TRUE]);
    $value['min'] = $this->token->replace($value['min'], $data, ['clear' => TRUE]);
    $value['max'] = $this->token->replace($value['max'], $data, ['clear' => TRUE]);
  }

}
