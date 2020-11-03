<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\NumericFilter;

/**
 * Extending if basic integer filter to use tokens as value.
 *
 * @Plugin(
 *   id = "numeric",
 * )
 */
class TokensNumericFilter extends NumericFilter implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

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
