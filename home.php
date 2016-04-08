<?php get_header(); ?>

<?php
$args = array(
	'name'           => 'get-inspired',
	'post_type'      => 'page'
);
$page = get_posts( $args );
foreach ( $page as $post ) : setup_postdata( $post );
  $hero = get_field('hero-image')['sizes']['letterbox'];
?>
  <main>
    <?php if($hero): ?>
      <div class="hero">
        <img src="<?php echo $hero; ?>" alt="<?php the_title(); ?>" class="img-fluid">
        <div class="hero-overlay">&nbsp;</div>
        <div class="hero-content text-xs-center">
          <h1><?php the_title(); ?></h1>
        </div> <!-- hero-content -->
      </div> <!-- hero -->
    <?php endif; ?>

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-xs-center">
            <?php the_content(); ?>
        </div> <!-- col -->
      </div> <!-- row -->
    <?php endforeach;
    wp_reset_postdata(); ?>

      <div class="row">
        <?php
        $args = array(
        	'post_type' => 'post',
          'limit' => -1
        );
        $posts = get_posts( $args );
        foreach ( $posts as $post ) : setup_postdata( $post );
        $thumb = get_field('hero-thumb')['sizes']['large'];
        ?>
          <div class="col-xs-12 col-md-6">
            <a href="<?php the_permalink(); ?>" class="text-uppercase overlay text-xs-center">
              <?php if($thumb): ?>
                <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" class="img-fluid">
              <?php endif; ?>
              <div class="overlay-grad"></div>
              <div class="overlay-content">
                <h2><?php the_title(); ?></h2>
                <span class="faux-button">Learn More</span>
              </div>
            </a>
          </div>
        <?php endforeach;
        wp_reset_postdata(); ?>
      </div>
    </div> <!-- container -->

    <?php
    $args = array(
    	'name'           => 'get-inspired',
    	'post_type'      => 'page'
    );
    $page = get_posts( $args );
    foreach ( $page as $post ) : setup_postdata( $post );

      $pagelist = get_pages('sort_column=menu_order&sort_order=asc');
      $pages = array();
      foreach ($pagelist as $page) {
        $pages[] += $page->ID;
      }

      $current = array_search($post->ID, $pages);
      $nextID = $pages[$current+1];

      $args = array(
        'post_type' => 'page',
        'include' => $nextID
      );

      $posts = get_posts( $args );

      foreach ( $posts as $post ) : setup_postdata( $post );
      $hero = get_field('hero-image')['sizes']['letterbox'];
      if($hero):
    ?>
      <a class="hero" href="<?php the_permalink(); ?>">
        <img src="<?php echo $hero; ?>" alt="<?php the_title(); ?>" class="img-fluid">
        <div class="hero-overlay">&nbsp;</div>
        <div class="hero-content text-xs-center">
          <h1><?php the_title(); ?></h1>
        </div> <!-- hero-content -->
      </a> <!-- hero -->
    <?php
      endif;
      endforeach;
      wp_reset_postdata();

    endforeach;
    wp_reset_postdata();
    ?>


  </main>

<?php get_footer(); ?>
