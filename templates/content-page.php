<?php while (have_posts()) : the_post();
$hero = get_field('hero-image')['sizes']['letterbox'];
$team = get_field('team-row');
$profile_run = false;
$count = 0;
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
      <?php if(the_content()) : ?>
        <div class="row">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-xs-center">
            <div class="intro-tag">
              <?php the_content(); ?>
            </div>
          </div> <!-- col -->
        </div> <!-- row -->
      <?php endif; ?>

      <div class="row">
        <div class="col-xs-12">

            <?php
              if( have_rows('row') ): ?>
              <div class="flipper">
              <?php
                while ( have_rows('row') ) : the_row();
                  $title = get_sub_field('title');
                  $images = get_sub_field('image');
                  $content = get_sub_field('content');
                  $count ++;

                if($images && $content): ?>
                  <div class="row row-flip flex-stretch-row">
                    <div class="col-xs-12 col-md-6 flex-stretch-col">
                      <?php foreach( $images as $image ) : ?>
                        <div class="faux-image" style="background: url(<?php echo $image['sizes']['large']; ?>) center / cover no-repeat;"><img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid hidden-md-up"></div>
                      <?php endforeach; ?>
                    </div> <!-- col -->

                    <div class="col-xs-12 col-md-6">
                      <?php if ($title): ?>
                        <h2><?php echo $title; ?></h2>
                      <?php endif; ?>
                      <?php echo $content; ?>
                      <?php
                        if( have_rows('team-row') && !$profile_run):
                          while ( have_rows('team-row') ) : the_row();
                            $title = get_sub_field('team-name');
                            $image = get_sub_field('team-image')['sizes']['medium'];
                            $content = get_sub_field('team-content');
                            $profile_run = true;
                      ?>
                      <div class="row profile">
                        <div class="col-xs-5 col-md-12 col-xl-5">
                          <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
                        </div>
                        <div class="col-xs-7 col-md-12 col-xl-7">
                          <h4><?php echo $title; ?></h4><?php echo $content; ?>
                        </div>
                      </div>
                      <?php
                          endwhile;
                        endif;
                      ?>
                    </div> <!-- col -->
                  </div> <!-- row -->
                <?php elseif($title): ?>
                  <h2 class="text-xs-center"><?php echo $title; ?></h2>
                <?php endif; ?>
            <?php
              endwhile; ?>
            </div> <!-- flipper -->
            <?php
              endif; ?>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->

    <?php
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
      <a class="hero hidden-sm-down" href="<?php the_permalink(); ?>">
        <img src="<?php echo $hero; ?>" alt="<?php the_title(); ?>" class="img-fluid">
        <div class="hero-overlay">&nbsp;</div>
        <div class="hero-content text-xs-center">
          <h1><?php the_title(); ?></h1>
        </div> <!-- hero-content -->
      </a> <!-- hero -->
    <?php endif;
      endforeach;
      wp_reset_postdata();
    ?>
  </main>
<?php endwhile; ?>
