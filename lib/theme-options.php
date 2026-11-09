<?php

namespace Tofino\ThemeOptions;

/**
 * Theme Options page, powered by ACF Pro.
 *
 * Fields are registered in code (lib/theme-options-fields.php), so no field
 * group sync is needed on deploy. Values are stored in wp_options as
 * options_<field_name>. Read them with tofino_get_option().
 */
function register_options_page() {
  if (!function_exists('acf_add_options_page')) {
    return;
  }

  acf_add_options_page(array(
    'page_title' => __('Theme Options', 'tofino'),
    'menu_title' => __('Theme Options', 'tofino'),
    'menu_slug'  => 'theme-options',
    'capability' => 'manage_options',
    'redirect'   => false,
  ));
}
add_action('acf/init', __NAMESPACE__ . '\\register_options_page');

function register_field_group() {
  if (!function_exists('acf_add_local_field_group')) {
    return;
  }

  acf_add_local_field_group(array(
    'key'      => 'group_tofino_theme_options',
    'title'    => __('Theme Options', 'tofino'),
    'fields'   => require __DIR__ . '/theme-options-fields.php',
    'location' => array(
      array(
        array('param' => 'options_page', 'operator' => '==', 'value' => 'theme-options'),
      ),
    ),
  ));
}
add_action('acf/init', __NAMESPACE__ . '\\register_field_group');

/**
 * Load Google Analyrics
 */
function google_analytics() {
  if (!WP_DEBUG && tofino_get_option('google_analytics')) { ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '<?php echo tofino_get_option('google_analytics'); ?>', 'auto');
      ga('send', 'pageview');
    </script><?php
  }
}

add_action('wp_footer', __NAMESPACE__ . '\\google_analytics');

/**
 * Change admin login screen logo
 */
function admin_login_logo() {
  if (tofino_get_option('admin_login_logo_id')) {
    $src = wp_get_attachment_image_src(tofino_get_option('admin_login_logo_id'), 'original'); ?>
    <style type="text/css">
      .login h1 a {
        background-image: url(<?php echo $src[0]; ?>);
        padding-bottom: 30px;
      }
    </style>
    <?php
  }
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\admin_login_logo');

/**
 * Add menu-sticky and/or the footer sticky classes to the body.
 */
function add_theme_options_body_class($classes) {
  //Menu Sticky
  $menu_sticky_disabled = tofino_get_option('menu_fixed_checkbox');
  if (!$menu_sticky_disabled) {
    $classes[] = 'menu-fixed';
  }

  //Footer Sticky
  $footer_sticky_enabled = tofino_get_option('footer_sticky_checkbox');
  if ($footer_sticky_enabled) {
    $classes[] = 'footer-sticky';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\add_theme_options_body_class');

/**
 * Return menu position classes based on theme option.
 */
function menu_position() {
  $position = tofino_get_option('menu_position_select');
  switch ($position) {
    case 'left':
      $class = '';
      break;
    case 'center':
      $class = 'menu-center';
      break;
    case 'right':
      $class = 'menu-right';
      break;
    default:
      $class = null;
  }
  return $class;
}

/**
 * Return menu fixed class based on theme option.
 */
function menu_fixed() {
  $is_disabled = tofino_get_option('menu_fixed_checkbox');
  if (!$is_disabled) {
    $class = 'navbar-sticky-top';
  } else {
    $class = null;
  }
  return $class;
}

/**
 * Display notification Top/Bottom based on theme option.
 */
function notification($position) {
  if ($position == tofino_get_option('notification_position')) {
    if (tofino_get_option('notification_text') && !isset($_COOKIE['tofino-notification-closed'])) : ?>
      <!-- Notifcation <?php echo $position; ?> -->
      <div class="alert alert-info notification <?php echo $position; ?>" id="tofino-notification">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><?php echo svg('icon-close'); ?></span>
                <span class="sr-only"><?php _e('Close', 'tofino'); ?></span>
              </button>
              <p><?php echo nl2br(tofino_get_option('notification_text')); ?></p>
            </div>
          </div>
        </div>
      </div><?php
    endif;
  }
}
