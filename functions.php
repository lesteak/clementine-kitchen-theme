<?php

/**
 * Config array
 */
$theme_config = [
  'svg' => [
    'sprite_file' => get_template_directory_uri() . '/dist/svg/sprite.symbol.svg'
  ]
];

/**
 * Tofino includes
 *
 * Library includes are now defined in the composer.json and autloaded.
 * Use 'composer dump-autoload -o' after adding new files.
 *
 */
if (file_exists(get_template_directory() . '/vendor/autoload.php')) { //Check composer autoload file exists. Result is cached by PHP.
  require_once 'vendor/autoload.php';
} else {
  if (is_admin()) {
    add_action('admin_notices', 'composer_error_notice');
  } else {
    wp_die(composer_error_notice(), 'An error occured.');
  }
}

//Check for missing dist directory. Result is cached by PHP.
if (!is_dir(get_template_directory() . '/dist')) {
  if (is_admin()) {
    add_action('admin_notices', 'missing_dist_error_notice');
  } else {
    wp_die(missing_dist_error_notice(), 'An error occured.');
  }
}

//Admin notice for missing composer autoload.
function composer_error_notice() {
  ?>
  <div class="error notice">
    <p><?php _e('Composer autoload file not found. Run composer install on the command line.', 'tofino'); ?></p>
  </div><?php
}

//Admin notice for missing dist directory.
function missing_dist_error_notice() {
  ?>
  <div class="error notice">
    <p><?php _e('/dist directory not found. You probably want to run npm install and gulp on the command line.', 'tofino'); ?></p>
  </div><?php
}

add_image_size( 'hero', 1980, 750, true );
add_image_size( 'letterbox', 1980, 300, true );
add_image_size( 'cropped', 600, 600, true );
add_image_size( 'cta', 600, 400, true );
