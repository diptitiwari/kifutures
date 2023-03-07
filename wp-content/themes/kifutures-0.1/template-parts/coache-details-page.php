<?php
/**
 * 
 * Template Name: Coache Details
 * Template Post Type: coaches
 *
 * @package kifutures-0.1
 */

?>

<?php
get_header();
/* Start the Loop */
while (have_posts()) : the_post();
   get_template_part('template-parts/content', get_post_format());
endwhile; // End of the loop.
get_footer();
?>