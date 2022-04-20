<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rara_eCommerce
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
        /**
         * @hooked rara_ecommerce_entry_header  - 10 
        */
        do_action( 'rara_ecommerce_before_single_post_entry_content' );
        
        echo '<div class="content-wrap">';
        /**
         * @hooked rara_ecommerce_post_thumbnail - 10
         * @hooked rara_ecommerce_entry_content - 15
         * @hooked rara_ecommerce_entry_footer  - 20
        */
        do_action( 'rara_ecommerce_single_post_entry_content' );
        echo '</div>';

    ?>
</article><!-- #post-<?php the_ID(); ?> -->
