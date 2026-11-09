<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>

  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/favicon/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon/android-chrome-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/favicon/manifest.json">
  <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/favicon/mstile-144x144.png">
  <meta name="theme-color" content="#ffffff">

</head>
<body <?php body_class(); ?>>

<?php \Tofino\ThemeOptions\notification('top'); ?>

<!--[if lte IE 9]>
  <div class="alert alert-danger browser-warning">
    <p><?php _e('You are using an <strong>outdated</strong> browser. <a href="http://browsehappy.com/">Update your browser</a> to improve your experience.', 'tofino'); ?></p>
  </div>
<![endif]-->

<nav class="navbar navbar-light text-xs-center <?php echo \Tofino\ThemeOptions\menu_fixed(); ?> <?php echo \Tofino\ThemeOptions\menu_position(); ?>">
  <button class="navbar-toggler hidden-md-up collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
    <div class="bar-wrapper">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <span class="sr-only"><?php _e('Toggle Navigation Button', 'tofino'); ?></span>
  </button>
  <a class="navbar-brand" href="<?php echo home_url(); ?>" title="<?php echo esc_attr(bloginfo('name')); ?>">
    <img src="<?php echo get_template_directory_uri() . '/dist/svg/logo-clementine.svg'; ?>" alt="<?php echo bloginfo('name'); ?>" class="hidden-md-up logo-small">
    <img src="<?php echo get_template_directory_uri() . '/dist/svg/logo.svg'; ?>" alt="<?php echo bloginfo('name'); ?>" class="hidden-sm-down logo-large">
  </a>
  <div class="curve-upper hidden-sm-down">
    <img src="<?php echo get_template_directory_uri() . '/dist/svg/nav-curve-upper.svg'; ?>" class="img-full">
  </div>
  <div id="main-menu" class="collapse navbar-toggleable-sm navbar-wrapper">
    <?php
    if (has_nav_menu('primary_navigation')) :
      wp_nav_menu(array(
        'menu'            => 'nav_menu',
        'theme_location'  => 'primary_navigation',
        'depth'           => 2,
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'nav navbar-nav',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'walker'          => new Tofino\Nav\NavWalker()
      ));
    endif;
    ?>
  </div>
</nav>

<?php if (tofino_get_option('footer_sticky_checkbox')) : ?>
  <div class="wrapper">
<?php endif; ?>
