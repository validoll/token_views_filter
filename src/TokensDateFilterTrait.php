<?php

namespace Drupal\token_views_filter;

use Drupal\Core\Form\FormStateInterface;

/**
 * Trait for Tokens Date Filter.
 */
trait TokensDateFilterTrait {

  /**
   * {@inheritdoc}
   */
  public function validateOptionsForm(&$form, FormStateInterface $form_state) {
    // Replace tokens to validate date.
    $options = $form_state->getValue('options');
    $value = &$options['value'];
    $original_value = $value;
    $this->replaceTokens($value);
    $form_state->setValue('options', $options);
    parent::validateOptionsForm($form, $form_state);

    // Restore tokens to use it in filters.
    $options['value'] = $original_value;
    $form_state->setValue('options', $options);
  }

  /**
   * {@inheritdoc}
   */
  public function validateExposed(&$form, FormStateInterface $form_state) {
    // Replace tokens to validate date.
    $options = $form_state->getValue('options');
    $value = &$options['value'];
    $original_value = $value;
    $this->replaceTokens($value);
    $form_state->setValue('options', $options);
    parent::validateExposed($form, $form_state);

    // Restore tokens to use it in filters.
    $options['value'] = $original_value;
    $form_state->setValue('options', $options);
  }

}
