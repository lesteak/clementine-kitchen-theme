
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
                  <div class="row row-flip">
                    <div class="col-xs-12 col-md-6 <?php echo ($count%2 == 0 ) ? 'col-md-push-6' : ''; ?>">
                      <div class="slick-wrap">
                        <?php foreach($images as $image) : ?>
                          <img src="<?php echo $image['sizes']['cropped']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid" />
                        <?php endforeach; ?>
                      </div>
                    </div> <!-- col -->

                    <div class="col-xs-12 col-md-6 <?php echo ($count%2 == 0 ) ? 'col-md-pull-6' : ''; ?>">
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
      <?php if( have_rows('menu') ): ?>
        <?php $count = 1; ?>
        <div class="row cta-area menus">
          <?php while ( have_rows('menu') ) : the_row(); ?>
            <?php $thumb = get_sub_field('image')['sizes']['cta']; ?>
            <div class="col-xs-12 col-md-6">
              <a href="#" class="text-uppercase overlay text-xs-center modal-link" data-toggle="modal" data-target="#menu<?php echo $count; ?>">
                <?php if($thumb): ?>
                  <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" class="img-fluid">
                <?php endif; ?>
                <div class="overlay-grad"></div>
                <div class="overlay-content">
                  <h3><?php echo get_sub_field('name'); ?></h3>
                  <span class="faux-button">Read Menu</span>
                </div>
              </a>
            </div>

            <div class="modal fade" id="menu<?php echo $count; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleMenu<?php echo $count; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title"><?php echo get_sub_field('name'); ?></h2>
                    <em><?php echo get_sub_field('tagline'); ?></em>
                  </div>
                  <div class="modal-body">
                    <?php if(get_sub_field('intro')) : ?>
                      <strong class="intro"><?php echo get_sub_field('intro'); ?></strong>
                    <?php endif; ?>
                    <?php echo get_sub_field('content'); ?>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

          <?php $count ++; ?>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
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
