<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rara_eCommerce
 */
    
    /**
     * After Content
     * 
     * @hooked rara_ecommerce_content_end - 20
    */
    do_action( 'rara_ecommerce_before_footer' );
    
    /**
     * Before footer
     * @hooked rara_ecommerce_instagram - 10
     * @hooked rara_ecommerce_service - 20
    */
    do_action( 'rara_ecommerce_before_footer_start' );

    /**
     * Footer
     * 
     * @hooked rara_ecommerce_footer_start  - 20
     * @hooked rara_ecommerce_footer_top    - 30
     * @hooked rara_ecommerce_footer_bottom - 40
     * @hooked rara_ecommerce_footer_end    - 50
    */
    do_action( 'rara_ecommerce_footer' );
    
    /**
     * After Footer
     * 
     * @hooked rara_ecommerce_back_to_top - 15
     * @hooked rara_ecommerce_page_end    - 20
    */
    do_action( 'rara_ecommerce_after_footer' );

    wp_footer(); ?>

</body>
</html>
