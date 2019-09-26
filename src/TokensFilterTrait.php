<?php

namespace Drupal\token_views_filter;

use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Filter trait to use for filter plugins.
 */
trait TokensFilterTrait {

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->token = $container->get('token');
    return $instance;
  }

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
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'view',
          'current-page',
        ],
      ];
    }
  }

  /**
   * {@inheritdoc}
   *
   * Replace tokens
   */
  public function preQuery() {
    parent::preQuery();

    if (!empty($this->options['use_tokens'])) {
      $this->replaceTokens($this->value);
    }
  }

}
