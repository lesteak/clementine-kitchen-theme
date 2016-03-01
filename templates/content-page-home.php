<?php while (have_posts()) : the_post();
$headline = get_field('headline');
$subhead = get_field('subhead');
$slideshow = get_field('slideshow');
?>
  <main>
    <div class="hero">
      <div class="hero-images">
        <?php if( $slideshow ): ?>
          <?php foreach( $slideshow as $image ): ?>
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid" />
          <?php endforeach; ?>
        <?php endif; ?>
      </div> <!-- hero-images -->
      <div class="hero-content text-xs-center">
        <p class="lead"><?php echo $subhead; ?></p>
        <h1><?php echo $headline; ?></h1>
      </div> <!-- hero-content -->
    </div> <!-- hero -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-xs-center">
            <?php the_content(); ?>
        </div> <!-- col -->
      </div> <!-- row -->
      <div class="row">
        <?php

        $args = array(
        'post_type' => 'page',
        'exclude' => $post->ID,
        'posts_per_page' => 4
        );

        $posts = get_posts( $args );
        foreach ( $posts as $post ) : setup_postdata( $post );
        $thumb = get_field('hero-thumb');
        ?>
          <div class="col-xs-12 col-md-6">
            <a href="<?php the_permalink(); ?>" class="text-uppercase overlay text-xs-center">
              <?php if($thumb): ?>
                <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" class="img-fluid">
              <?php endif; ?>
              <div class="overlay-content">
                <h2><?php the_title(); ?></h2>
                <span class="faux-button">Learn More</span>
              </div>
            </a>
          </div>
        <?php endforeach;
        wp_reset_postdata();?>
      </div>
    </div>
  </main>
<?php endwhile; ?>
