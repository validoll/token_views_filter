<?php

namespace Drupal\token_views_filter\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\StringFilter;

/**
 * Extending if basic string filter to
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("string_with_tokens")
 */
class TokensStringFilter extends StringFilter {
  use TokensFilterTrait;

  /**
   * {@inheritdoc}
   *
   * Replace tokens
   */
  public function preQuery() {
    parent::preQuery();

    $this->value = \Drupal::token()->replace($this->value);
  }

}
