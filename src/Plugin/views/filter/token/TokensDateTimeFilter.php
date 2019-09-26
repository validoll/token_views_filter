<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\datetime\Plugin\views\filter\Date;

/**
 * Extending if basic datetime filter to use tokens as value.
 *
 * @Plugin(
 *   id = "datetime",
 * )
 */
class TokensDateTimeFilter extends Date implements TokenViewsFilterPluginInterface {

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
