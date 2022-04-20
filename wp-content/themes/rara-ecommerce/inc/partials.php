<?php
/**
 * Rara eCommerce Customizer Partials
 *
 * @package Rara_eCommerce
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function rara_ecommerce_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function rara_ecommerce_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Header Phone Label
 *
 * @return void
 */
function rara_ecommerce_phone_label_selective_refresh() {
    return esc_html( get_theme_mod( 'phone_label' ) );
}

/**
 * Header Phone Number
 *
 * @return void
 */
function rara_ecommerce_phone_selective_refresh() {
    return esc_html( get_theme_mod( 'phone' ) );
}

/**
 * Header Note Label
 *
 * @return void
 */
function rara_ecommerce_header_note_selective_refresh() {
    return esc_html( get_theme_mod( 'header_note' ) );
}

if( ! function_exists( 'rara_ecommerce_get_banner_title' ) ) :
/**
 * Banner Title
*/
function rara_ecommerce_get_banner_title(){
    return esc_html( get_theme_mod( 'banner_title', __( 'BEST SEASON SALES', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_banner_subtitle' ) ) :
/**
 * Banner subtitle
*/
function rara_ecommerce_get_banner_subtitle(){
    return esc_html( get_theme_mod( 'banner_subtitle', __( 'BIGGEST SALES', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_banner_label' ) ) :
/**
 * Banner subtitle
*/
function rara_ecommerce_get_banner_label(){
    return esc_html( get_theme_mod( 'banner_label', __( 'SHOP NOW', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_product_cat_label' ) ) :
/**
 * Banner subtitle
*/
function rara_ecommerce_get_product_cat_label(){
    return esc_html( get_theme_mod( 'product_cat_label', __( 'Shop Now', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_cat_one_title_selective_refresh' ) ) :
/**
 * Product Sale title
*/
function rara_ecommerce_cat_one_title_selective_refresh(){
    return esc_html( get_theme_mod( 'cat_one_title', __( 'Clearance Sale', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_cat_one_description_selective_refresh' ) ) :
/**
 * Product Sale Description
*/
function rara_ecommerce_cat_one_description_selective_refresh(){
    return wp_kses_post( get_theme_mod( 'cat_one_description' ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_testimonial_title_selective_refresh' ) ) :
/**
 * Testimonial Title
*/
function rara_ecommerce_testimonial_title_selective_refresh(){
    return esc_html( get_theme_mod( 'testimonial_title', __( 'The Story', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_blog_title_selective_refresh' ) ) :
/**
 * Blog Title
*/
function rara_ecommerce_blog_title_selective_refresh(){
    return esc_html( get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_blog_description_selective_refresh' ) ) :
/**
 * Blog Description
*/
function rara_ecommerce_blog_description_selective_refresh(){
    return wp_kses_post( get_theme_mod( 'blog_section_subtitle', __( 'Our recent articles about fashion ideas products.', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_blog_view_all_btn' ) ) :
/**
 * Display blog See More Posts button
*/
function rara_ecommerce_get_blog_view_all_btn(){
    return esc_html( get_theme_mod( 'blog_view_all', __( 'See More Posts', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function rara_ecommerce_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'You may also like...', 'rara-ecommerce' ) ) );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function rara_ecommerce_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'rara-ecommerce' );
        echo date_i18n( esc_html__( 'Y', 'rara-ecommerce' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'rara-ecommerce' );
    }
    echo '</span>'; 
}
endif;