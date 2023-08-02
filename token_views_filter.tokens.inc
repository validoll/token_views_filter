<?php

/**
 * @file
 * Token integration for the Token Views Filter module.
 */

/**
 * Implements hook_token_info_alter().
 */
function token_views_filter_token_info_alter(&$info) {
  // Fix the view `url` property module.
  $info['tokens']['view']['url']['module'] = $info['tokens']['view']['url']['module'] ?? 'token';
}
