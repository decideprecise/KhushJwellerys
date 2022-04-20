<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rara_eCommerce
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); if( ! is_single() ) echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
	<?php 
        /**
         * @hooked rara_ecommerce_post_thumbnail - 15
        */
        do_action( 'rara_ecommerce_before_post_entry_content' );
        
        echo '<div class="content-wrap">';
        /**
         * @hooked rara_ecommerce_entry_header  - 10 
         * @hooked rara_ecommerce_entry_content - 15
         * @hooked rara_ecommerce_entry_footer  - 20
        */
        do_action( 'rara_ecommerce_post_entry_content' );
        echo '</div>';

    ?>
</article><!-- #post-<?php the_ID(); ?> -->
