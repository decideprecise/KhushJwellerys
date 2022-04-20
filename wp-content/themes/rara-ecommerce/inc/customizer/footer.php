<?php
/**
 * Footer Setting
 *
 * @package Rara_eCommerce
 */

function rara_ecommerce_customize_register_footer( $wp_customize ) {
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'rara-ecommerce' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'       => __( 'Footer Copyright Text', 'rara-ecommerce' ),
            'section'     => 'footer_settings',
            'type'        => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector' => '.site-info .copyright',
        'render_callback' => 'rara_ecommerce_get_footer_copyright',
    ) );

    /** Payment Support Image */
    $wp_customize->add_setting( 'footer_payment_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'rara_ecommerce_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'footer_payment_image',
            array(
                'label'         => esc_html__( 'Payment Support Image', 'rara-ecommerce' ),
                'description'   => esc_html__( 'Recommended Image size is 300px by 25px.', 'rara-ecommerce' ),
                'section'       => 'footer_settings',
                'type'          => 'image'
            )
        )
    );
        
}
add_action( 'customize_register', 'rara_ecommerce_customize_register_footer' );