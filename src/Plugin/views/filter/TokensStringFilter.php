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

  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['use_tokens'] = ['default' => FALSE];

    return $options;
  }

  /**
   * Provide a simple textfield options to use tokens in filter.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['use_tokens'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use tokens in value'),
      '#default_value' => $this->options['use_tokens'],
    ];
  }

}
