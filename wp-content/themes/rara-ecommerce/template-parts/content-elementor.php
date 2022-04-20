<?php
/**
 * The Elementor main template file
 *
 * @package Rara_eCommerce
 */
get_header(); 
?>
<div class="elementor-wrapper">
    <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
     ?>
</div><!-- #primary -->
<?php get_footer();