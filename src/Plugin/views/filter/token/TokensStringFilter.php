<?php

namespace Drupal\token_views_filter\Plugin\views\filter\token;

use Drupal\token_views_filter\TokensFilterTrait;
use Drupal\token_views_filter\TokenViewsFilterPluginInterface;
use Drupal\views\Plugin\views\filter\StringFilter;

/**
 * Extending basic string filter to use tokens as value.
 *
 * @Plugin(
 *   id = "string",
 * )
 */
class TokensStringFilter extends StringFilter implements TokenViewsFilterPluginInterface {

  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   */
  public function replaceTokens(&$value) {
    $value = $this->token->replace($value, ['view' => $this->view], ['clear' => TRUE]);
  }

}
