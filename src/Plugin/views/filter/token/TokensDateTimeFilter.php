<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensDateFilterTrait;
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
  use TokensDateFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens(&$value) {
    $data = ['view' => $this->view];
    $value_keys = ['value', 'min', 'max'];

    foreach ($value_keys as $key) {
      if (isset($value[$key])) {
        $value[$key] = $this->token->replace($value[$key], $data, ['clear' => TRUE]);
      }
    }
  }

}
