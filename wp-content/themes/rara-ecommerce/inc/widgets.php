<?php
/**
 * Rara eCommerce Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Rara_eCommerce
 */

function rara_ecommerce_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'rara-ecommerce' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'rara-ecommerce' ),
        ),
        'about' => array(
            'name'        => __( 'About Section', 'rara-ecommerce' ),
            'id'          => 'about', 
            'description' => __( 'Add "Rara: A Featured Page Widget" for about section.', 'rara-ecommerce' ),
        ),
        'testimonial' => array(
            'name'        => __( 'Testimonial Section', 'rara-ecommerce' ),
            'id'          => 'testimonial', 
            'description' => __( 'Add "Rara: Testimonial" widget for testimonial section.', 'rara-ecommerce' ),
        ),
        'service' => array(
            'name'        => __( 'Service Section', 'rara-ecommerce' ),
            'id'          => 'service', 
            'description' => __( 'Add "Text" and "Rara: Icon Text" widget for service section.', 'rara-ecommerce' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'rara-ecommerce' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'rara-ecommerce' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'rara-ecommerce' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'rara-ecommerce' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'rara-ecommerce' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'rara-ecommerce' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'rara-ecommerce' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'rara-ecommerce' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
}
add_action( 'widgets_init', 'rara_ecommerce_widgets_init' );