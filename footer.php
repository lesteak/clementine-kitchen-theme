<?php if (ot_get_option('footer_sticky_checkbox')) : ?>
  </div>
<?php endif; ?>

<footer class="text-xs-center">
  <div class="footer-upper">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <img src="<?php echo get_template_directory_uri() . '/dist/svg/logo-clementine.svg'; ?>">
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- footer-upper -->
  <div class="footer-lower">
    <div class="container">
      <div class="row">
        <ul class="social">
          <li><a href="https://www.facebook.com/theclementinekitchen" target="_blank"><?php echo svg('facebook'); ?></a></li>
          <li><a href="https://www.instagram.com/theclementinekitchen/" target="_blank"><?php echo svg('instagram'); ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <p>&copy; <?php bloginfo('name'); ?> <?php echo current_time('Y'); ?> All rights reserved. <a href="http://xinc.digital" target="_blank">Site by Xinc</a></p>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- footer-lower -->
</footer>

<?php wp_footer(); ?>

<?php \Tofino\ThemeOptions\notification('bottom'); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77035959-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
