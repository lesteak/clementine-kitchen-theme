<?php
/**
 * One-off migration: Option Tree -> ACF options page.
 *
 * Run (idempotent; safe to re-run):
 *   wp eval-file wp-content/themes/clementine-kitchen-theme/migrations/001-option-tree-to-acf.php
 *
 * Copies every value in the `option_tree` wp_options row into ACF options
 * (wp_options rows `options_<name>` + `_options_<name>`). Existing ACF values are
 * never overwritten. The old Option Tree rows are NOT deleted here; see
 * DB-CHANGES.md for the cleanup commands to run once the site is verified.
 */

if (!function_exists('update_field') || !function_exists('get_field')) {
  WP_CLI::error('ACF is not active.');
}

$old = get_option('option_tree');

if (!is_array($old)) {
  WP_CLI::success('No option_tree option found. Nothing to migrate.');
  return;
}

// Option Tree checkboxes saved as arrays (e.g. array("") ) were treated as
// "on" by the old code (non-empty array is truthy). Keep that behaviour.
$bool_fields = array(
  'menu_fixed_checkbox', 'footer_sticky_checkbox', 'critical_css_checkbox',
  'jquery_in_footer', 'maintenance_mode_enabled', 'enable_captcha_checkbox',
);

// Option Tree fields that no longer exist (theme tracker was removed).
$dropped = array('theme_tracker_enabled', 'theme_tracker_api_key', 'theme_tracker_api_url', 'theme_tracker_debug');

$written = 0;
$skipped = 0;

foreach ($old as $name => $value) {
  if (in_array($name, $dropped, true)) {
    continue;
  }

  if (in_array($name, $bool_fields, true)) {
    $value = !empty($value) ? 1 : 0;
  } elseif ($name === 'social_links') {
    $rows = array();
    foreach ((array) $value as $link) {
      if (!empty($link['href'])) {
        $rows[] = array('name' => isset($link['name']) ? $link['name'] : '', 'href' => $link['href']);
      }
    }
    $value = $rows;
  }

  if ($value === '' || $value === array() || $value === null) {
    $skipped++;
    continue;
  }

  // Never clobber a value that was already entered in ACF.
  if (get_option('options_' . $name, null) !== null) {
    $skipped++;
    continue;
  }

  update_field($name, $value, 'option');
  $written++;
  WP_CLI::log("  migrated: $name");
}

WP_CLI::success("Option Tree -> ACF migration done. Written: $written, skipped (empty/existing): $skipped.");
