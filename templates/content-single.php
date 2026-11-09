<?php while (have_posts()) : the_post();
$hero = get_field('hero-image');
?>
  <main>
    <?php if($hero): ?>
      <div class="hero">
        <?php echo tofino_image($hero, 'letterbox', array('alt' => get_the_title())); ?>
        <meta property="og:image" content="<?php echo $hero; ?>" />
        <div class="hero-overlay">&nbsp;</div>
        <div class="hero-content text-xs-center">
          <h1><?php the_title(); ?></h1>
        </div> <!-- hero-content -->
      </div> <!-- hero -->
    <?php endif; ?>

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-8">
          <div class="post-content">
            <?php the_content(); ?>
          </div>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->
  </main>
<?php endwhile; ?>
