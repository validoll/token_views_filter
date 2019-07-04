<?php

use \Drupal\Core\Render\BubbleableMetadata;

/**
 * Implements hook_token_info()
 */
function token_views_filter_test_token_info() {
  $types['test'] = [
    'name' => t("Test data"),
    'description' => t("Tokens for testing."),
  ];

  $test['value'] = [
    'name' => t("Test value"),
    'description' => t("Value for test."),
  ];

  return [
    'types' => $types,
    'tokens' => [
      'test' => $test,
    ],
  ];
}


/**
 * Implements hook_tokens().
 */
function token_views_filter_test_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $token_service = \Drupal::token();
  $replacements = [];

  if ($type == 'test') {
    if ($created_tokens = $token_service->findWithPrefix($tokens, 'value')) {
      foreach ($created_tokens as $name => $original) {
        $replacements[$original] = $name;
      }
    }
  }

  return $replacements;
}
