<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kifutures-0.1
 */

?>

<footer id="colophon" class="site-footer">

  <div class="site-container">

    <div class="footer-upper">

      <div class="footer-col-1">
        <div class="footer-nav">
          <h4 class="main-title">Stay up to date with the latest on sustainability</h4>
          <p class="title">Sign up for our newsletter.</p>
          <!--End mc_embed_signup-->
          <?php echo do_shortcode('[yikes-mailchimp form="1"]') ?>
        </div>
      </div>

      <div class="footer-col-2"></div>

      <div class="footer-col-3">

        <div class="footer-nav">
          <div class="nav-title">Resources</div>
          <?php
						wp_nav_menu(
							array(
								'theme_location' => 'FM-1',
							)
						);
						?>
        </div>

        <div class="footer-nav">
          <div class="nav-title">About Us</div>
          <?php
						wp_nav_menu(
							array(
								'theme_location' => 'FM-2',
							)
						);
						?>
        </div>

      </div>

    </div>

    <div class="footer-lower">
      <p class="copyright">Copyright &copy; 2021 <?php echo bloginfo('name'); ?></p>

      <div class="social-nav">
        <?php
          wp_nav_menu(
            array(
              'theme_location' => 'footer-social',
            )
          );
				?>
      </div>
    </div>

  </div>

</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>