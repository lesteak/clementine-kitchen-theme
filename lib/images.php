<?php
/**
 * Responsive image helper (srcset / sizes).
 *
 * Wraps wp_get_attachment_image() so every theme image is output with a
 * srcset built from the same-aspect-ratio crops registered in functions.php.
 * Accepts an ACF image field value (array, with 'ID') or an attachment ID.
 *
 * @package Tofino
 */

if (!function_exists('tofino_image')) {
  /**
   * @param array|int $image ACF image array or attachment ID.
   * @param string    $size  Registered image size (hero, letterbox, cta, cropped, ...).
   * @param array     $attr  Extra attributes (alt, class, loading, fetchpriority ...).
   * @return string  <img> markup, or '' if there is no image.
   */
  function tofino_image($image, $size, $attr = array()) {
    $id = is_array($image) ? (isset($image['ID']) ? (int) $image['ID'] : 0) : (int) $image;

    if (!$id) {
      return '';
    }

    // Rendered width hints so the browser picks the smallest sufficient candidate.
    $sizes = array(
      'hero'      => '100vw',
      'letterbox' => '100vw',
      'cta'       => '(min-width: 768px) 540px, 100vw',
      'cropped'   => '(min-width: 768px) 540px, 100vw',
    );

    $defaults = array('class' => 'img-fluid');

    if (isset($sizes[$size])) {
      $defaults['sizes'] = $sizes[$size];
    }

    if (!isset($attr['alt']) && is_array($image) && isset($image['alt'])) {
      $attr['alt'] = $image['alt'];
    }

    return wp_get_attachment_image($id, $size, false, array_merge($defaults, $attr));
  }
}

/**
 * Slightly lower JPEG quality for generated crops (WP default is 82).
 */
add_filter('jpeg_quality', function () {
  return 75;
});
