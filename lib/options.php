<?php
/**
 * Theme option accessor (ACF options page backed).
 *
 * Replaces Option Tree's ot_get_option(). Values live in ACF's
 * "options" post id, i.e. wp_options rows named options_<field_name>.
 *
 * @package Tofino
 */

if (!function_exists('tofino_get_option')) {
  /**
   * @param string $name    ACF field name on the Theme Options page.
   * @param mixed  $default Returned when ACF is inactive or the value is empty.
   */
  function tofino_get_option($name, $default = null) {
    if (!function_exists('get_field')) {
      return $default;
    }

    $value = get_field($name, 'option');

    if ($value === null || $value === '' || $value === false || $value === array()) {
      return $default;
    }

    return $value;
  }
}
