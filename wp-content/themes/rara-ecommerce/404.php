<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package Rara_eCommerce
 */

get_header(); 

	$img = get_theme_mod( '404_page_image', get_template_directory_uri() . '/images/error.jpg' );
    
    if( $img ){ ?>
        <div class="img-holder">
            <img src="<?php echo esc_url( $img ); ?>" alt="<?php esc_attr_e( '404 Not Found', 'rara-ecommerce' ); ?>">
        </div>
	<?php } ?>

	<div class="text-holder">
		<h2><?php esc_html_e( 'Uh-Oh...', 'rara-ecommerce' ); ?></h2>
		<p><?php esc_html_e( 'The page you are looking for may have been moved, deleted, or possibly never existed.', 'rara-ecommerce' ); ?></p>
        
		<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-home"><?php esc_html_e( 'TAKE ME TO THE HOMEPAGE', 'rara-ecommerce' ); ?></a>
	</div>

	<?php 
        get_search_form(); 

	    /**
	     * @see rara_ecommerce_latest_posts
	    */
	    do_action( 'rara_ecommerce_latest_posts' );
    
get_footer();