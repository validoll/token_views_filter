<?php

namespace Drupal\token_views_filter;

use Drupal\Core\Form\FormStateInterface;

/**
 * Filter trait to use for filter plugins.
 */
trait TokensFilterTrait {

  /**
   * {@inheritdoc}
   *
   * @see \Drupal\views\Plugin\views/PluginBase::defineOptions()
   */
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
      '#title' => $this->t('Use tokens'),
      '#default_value' => $this->options['use_tokens'],
    ];

    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['token_help'] = [
        '#type' => 'container',
        '#states' => [
          'visible' => [
            ':input[name="options\\[use_tokens\\]"]' => ['checked' => TRUE],
          ],
        ],
      ];
      $form['token_help']['browser'] = [
        '#type' => 'markup',
        '#theme' => 'token_tree_link',
      ];
    }
  }

}
