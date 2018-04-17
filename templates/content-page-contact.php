<?php while (have_posts()) : the_post();
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
      <?php echo do_shortcode('[contact-form-7 id="4" title="Contact form 1"]'); ?>
    </div> <!-- container -->
  </main>
<?php endwhile; ?>
