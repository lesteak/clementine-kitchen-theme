<?php while (have_posts()) : the_post();
$hero = get_field('hero-image')['sizes']['hero'];
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

        <div class="col-xs-12">
          <div class="js-form-result"></div>

          <form name="contact" class="contact-form">
            <div class="row">
              <!-- Name / Text input -->
              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="name"><?php _e('Name', 'tofino'); ?></label>
                <input type="text" name="name" class="form-control" id="name" placeholder="<?php _e('Your name', 'tofino'); ?>" required="required">
              </fieldset>

              <!-- Email address -->
              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="email"><?php _e('Email Address', 'tofino'); ?></label>
                <input type="email" name="email" class="form-control" id="email" placeholder="<?php _e('Your email', 'tofino'); ?>" required="required">
              </fieldset>

              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Your phone" required="required">
              </fieldset>

              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="size">Event Size</label>
                <input type="text" name="size" class="form-control" id="size" placeholder="Number of guests" required="required">
              </fieldset>

              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="location">Event Location</label>
                <input type="text" name="location" class="form-control" id="location" placeholder="Your venue">
              </fieldset>

              <fieldset class="form-group col-xs-12 col-md-6 col-xl-4">
                <label for="date">Event Date</label>
                <input type="date" name="date" class="form-control" id="date" placeholder="dd/mm/yy">
              </fieldset>

              <!-- Message / Textarea -->
              <fieldset class="form-group col-xs-12">
               <label for="message">Details</label>
               <textarea class="form-control" name="details" id="details" rows="3" placeholder="Brief details, eg. occasion" required="required"></textarea>
             </fieldset>

              <?php if (true == ot_get_option('enable_captcha_checkbox')) : ?>
                <!-- Not a Robot -->
                <fieldset class="form-group">
                  <div class="g-recaptcha" data-size="normal" data-theme="light" data-sitekey="<?php echo ot_get_option('captcha_site_key'); ?>"></div>
                  <small class="text-muted"><?php _e('Human tester', 'tofino'); ?></small>
                  <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
                </fieldset><?php
              endif; ?>

              <div class="col-xs-12 text-xs-center">
                <button type="submit" class="btn btn-primary"><?php _e('Submit', 'tofino'); ?></button>
              </div> <!-- col -->
            </div> <!-- row -->
          </form>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->
  </main>
<?php endwhile; ?>
