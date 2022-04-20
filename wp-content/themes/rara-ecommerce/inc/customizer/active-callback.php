<?php
/**
 * Active Callback
 * 
 * @package Rara_eCommerce
*/

/**
 * Active Callback for Banner Slider
*/
function rara_ecommerce_banner_ac( $control ){
    $banner           = $control->manager->get_setting( 'ed_banner_section' )->value();
    $slider_type      = $control->manager->get_setting( 'slider_type' )->value();
    $slider_caption   = $control->manager->get_setting( 'slider_caption' )->value();
    $slider_animation = $control->manager->get_setting( 'slider_animation' )->value();
    $control_id  = $control->id;
    
    if ( $control_id == 'header_image' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_title' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_subtitle' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_label' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'product_cat_label' && $banner == 'static_category' ) return true;
    if ( $control_id == 'banner_link' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_caption_layout' && !( $banner == 'no_banner' || $banner == 'static_category' || $banner == 'slider_banner' ) ) return true;
    if ( $control_id == 'banner_overlay' && ( $banner == 'static_banner' || $banner == 'static_category'  ) ) return true;
    if ( $control_id == 'banner_cat_product' && $banner == 'static_category' ) return true;
    
    if ( $control_id == 'slider_type' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_auto' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_loop' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_caption' && ( $banner == 'static_category' || $banner == 'slider_banner' ) ) return true;   
    if ( $control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat' ) return true;
    if ( $control_id == 'slider_cat_product' && $banner == 'slider_banner' && $slider_type == 'cat_products' ) return true;
    if ( $control_id == 'no_of_slides' && $banner == 'slider_banner' && $slider_type == 'latest_posts' ) return true;
    if ( $control_id == 'slider_animation' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'hr' && $banner == 'slider_banner' ) return true;
    
    return false;
}

/**
 * Active Callback for featuerd content
*/
function rara_ecommerce_featured_ac( $control ){
    
    $ed_featured_section   = $control->manager->get_setting( 'ed_featured_section' )->value();
    $control_id      = $control->id;
    
    if ( $control_id == 'cat_featured_one' && ( rara_ecommerce_is_woocommerce_activated() && $ed_featured_section ) ) return true;
    if ( $control_id == 'cat_featured_two' && ( rara_ecommerce_is_woocommerce_activated() && $ed_featured_section ) ) return true;
    if ( $control_id == 'cat_featured_three' && ( rara_ecommerce_is_woocommerce_activated() && $ed_featured_section ) ) return true;
    if ( $control_id == 'cat_featured_four' && ( rara_ecommerce_is_woocommerce_activated() && $ed_featured_section ) ) return true;
    
    return false;
}

/**
 * Active Callback for Product Sale
*/
function rara_ecommerce_cat_one_ac( $control ){
    
    $product_filter   = $control->manager->get_setting( 'cat_one_filter' )->value();
    $control_id       = $control->id;
    
    if ( $control_id == 'cat_one_cat' &&  $product_filter == 'category' ) return true;
    if ( $control_id == 'cat_one_cat_filter' && $product_filter == 'category' ) return true;
    
    return false;
}

/**
 * Active Callback for Blog View All Button
*/
function rara_ecommerce_blog_view_all_ac(){
    $blog = get_option( 'page_for_posts' );
    if( $blog ) return true;
    
    return false; 
}

/**
 * Active Callback for post/page
*/
function rara_ecommerce_post_page_ac( $control ){
    
    $ed_related = $control->manager->get_setting( 'ed_related' )->value();
    $control_id = $control->id;
    
    if ( $control_id == 'related_post_title' && $ed_related == true ) return true;
    
    return false;
}

/**
 * Active Callback for social link
*/
function rara_ecommerce_social_ac( $control ){
    
    $ed_social_links = $control->manager->get_setting( 'ed_social_links' )->value();
    $control_id = $control->id;
    
    if ( $control_id == 'social_links' && $ed_social_links ) return true;
    
    return false;
}