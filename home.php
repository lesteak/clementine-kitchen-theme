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
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 text-xs-center">
					<?php if( have_rows('testimonial') ): ?>
					<div class="outer-wrapper">
						<div class="openquote">&ldquo;</div>
						<div class="closequote">&rdquo;</div>
						<div class="testimonial-wrapper">
							<?php while ( have_rows('testimonial') ) : the_row(); ?>
								<div class="testimonial-item">
									<?php echo get_sub_field('quote'); ?>
									<div class="author"><strong><?php echo get_sub_field('author'); ?></strong></div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					<?php endif; ?>
        </div> <!-- col -->
      </div> <!-- row -->
		</div>
    <?php endforeach;
    wp_reset_postdata(); ?>

    <?php echo do_shortcode('[instagram-feed]'); ?>
    
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
