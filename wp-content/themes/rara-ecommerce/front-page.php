<?php
/**
 * Front Page
 * 
 * @package Rara_eCommerce
 */
$ed_elementor  = get_theme_mod( 'ed_elementor', false );
$home_sections = rara_ecommerce_get_home_sections();

if ( 'posts' == get_option( 'show_on_front' ) ) { //Show Static Blog Page
    include( get_home_template() );
}elseif( rara_ecommerce_is_elementor_activated_post() && $ed_elementor ){ 
    get_template_part('template-parts/content-elementor');
}elseif( $home_sections ){ 

get_header();

//If any one section are enabled then show custom home page.

foreach( $home_sections as $section ){
    get_template_part( 'sections/' . esc_attr( $section ) );  
}
get_footer();

}else {
    //If all section are disabled then show respective page template. 
    include( get_page_template() );
}