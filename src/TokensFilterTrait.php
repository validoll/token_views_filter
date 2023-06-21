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
   * Replace tokens.
   */
  public function preQuery() {
    parent::preQuery();

    if (!empty($this->options['use_tokens'])) {
      $this->replaceTokens($this->value);
    }
  }

  /**
   * {@inheritDoc}
   *
   * In case of grouped filters we have to override the parent class
   * method so that we can tokenize the individual group_item's value.
   *
   * @see \Drupal\views\Plugin\views\filter\FilterPluginBase::convertExposedInput()
   */
  public function convertExposedInput(&$input, $selected_group_id = NULL) {
    if ($this->isAGroup()) {
      // If it is already defined the selected group, use it. Only valid
      // when the filter uses checkboxes for widget.
      if (!empty($selected_group_id)) {
        $selected_group = $selected_group_id;
      }
      else {
        $selected_group = $input[$this->options['group_info']['identifier']];
      }
      if ($selected_group == 'All' && !empty($this->options['group_info']['optional'])) {
        return NULL;
      }
      if ($selected_group != 'All' && empty($this->options['group_info']['group_items'][$selected_group])) {
        return FALSE;
      }
      if (isset($selected_group) && isset($this->options['group_info']['group_items'][$selected_group])) {
        $input[$this->options['expose']['operator']] = $this->options['group_info']['group_items'][$selected_group]['operator'];

        // Value can be optional, for example 'empty' and 'not empty' filters.
        if (isset($this->options['group_info']['group_items'][$selected_group]['value']) && $this->options['group_info']['group_items'][$selected_group]['value'] !== '') {

          if (!empty($this->options['use_tokens'])) {
            // Tokenize the selected group_item's value.
            $value = $this->options['group_info']['group_items'][$selected_group]['value'];
            $this->replaceTokens($value);
            $input[$this->options['group_info']['identifier']] = $value;
          }
          else {
            $input[$this->options['group_info']['identifier']] = $this->options['group_info']['group_items'][$selected_group]['value'];
          }

        }
        $this->options['expose']['use_operator'] = TRUE;

        $this->group_info = $input[$this->options['group_info']['identifier']];

        return TRUE;
      }
      else {
        return FALSE;
      }
    }
  }

}
