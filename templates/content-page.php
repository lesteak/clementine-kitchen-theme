<?php while (have_posts()) : the_post();
$hero = get_field('hero-image');
$team = get_field('team-row');
?>
  <main>
    <?php if($hero): ?>
      <div class="hero">
        <img src="<?php echo $hero; ?>" alt="<?php the_title(); ?>" class="img-fluid">

        <div class="hero-content text-xs-center">
          <h1><?php the_title(); ?></h1>
        </div> <!-- hero-content -->
      </div> <!-- hero -->
    <?php endif; ?>

    <div class="container">
      <div class="row">
        <div class="col-xs-12">



            <?php the_content(); ?>

            <div class="flipper">

            <?php
              if( have_rows('row') ):
                while ( have_rows('row') ) : the_row();
                  $title = get_sub_field('title');
                  $images = get_sub_field('image');
                  $content = get_sub_field('content');
            ?>
                <?php if($title && !$images && !$content): ?>
                    <h2 class="text-xs-center"><?php echo $title; ?></h2>
                <?php elseif($title && $images && !$content): ?>

                <?php elseif($title && $content && !$images): ?>

                <?php elseif($images && $content && !$title): ?>
                  <div class="row row-flip">
                    <div class="col-xs-12 col-md-6">
                      <?php if( $images ): ?>
                        <?php foreach( $images as $image ): ?>
                          <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid" />
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div> <!-- col -->

                    <div class="col-xs-12 col-md-6">
                      <?php echo $content; ?>
                    </div> <!-- col -->
                  </div> <!-- row -->
                <?php elseif($title && $images && $content): ?>
                  <div class="row row-flip">
                    <div class="col-xs-12 col-md-6">
                      <?php if( $images ): ?>
                        <?php foreach( $images as $image ): ?>
                          <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid" />
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div> <!-- col -->

                    <div class="col-xs-12 col-md-6">
                      <h2><?php echo $title; ?></h2>
                      <?php echo $content; ?>
                      <?php
                        if( have_rows('team-row') ):
                          while ( have_rows('team-row') ) : the_row();
                            $title = get_sub_field('team-name');
                            $image = get_sub_field('team-image');
                            $content = get_sub_field('team-content');
                      ?>
                        <p><strong><?php echo $title; ?></strong> <?php echo $content; ?></p>
                      <?php
                          endwhile;
                        endif;
                      ?>
                    </div> <!-- col -->
                  </div> <!-- row -->
                <?php endif; ?>


            <?php
                endwhile;
              endif;
            ?>
            </div> <!-- flipper -->

        </div>
      </div>
    </div>
  </main>
<?php endwhile; ?>
