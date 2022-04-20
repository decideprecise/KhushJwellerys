<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rara_eCommerce
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
        /**
         * Post Thumbnail
         * 
         * @hooked rara_ecommerce_post_thumbnail
        */
        do_action( 'rara_ecommerce_before_page_entry_content' );
    
        /**
         * Entry Content
         * 
         * @hooked rara_ecommerce_entry_content - 15
         * @hooked rara_ecommerce_entry_footer  - 20
        */
        do_action( 'rara_ecommerce_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
