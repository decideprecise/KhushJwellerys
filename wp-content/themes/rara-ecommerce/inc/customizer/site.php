<?php
/**
 * Site Title Setting
 *
 * @package Rara_eCommerce
 */

function rara_ecommerce_customize_register( $wp_customize ) {
	
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
	
	if( isset( $wp_customize->selective_refresh ) ){
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'rara_ecommerce_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'rara_ecommerce_customize_partial_blogdescription',
		) );
	}
    
    /** Site Title Font */
    $wp_customize->add_setting( 
        'site_title_font', 
        array(
            'default' => array(                                			
                'font-family' => 'Poppins',
                'variant'     => 'regular',
            ),
            'sanitize_callback' => array( 'Rara_eCommerce_Fonts', 'sanitize_typography' )
        ) 
    );

	$wp_customize->add_control( 
        new Rara_eCommerce_Typography_Control( 
            $wp_customize, 
            'site_title_font', 
            array(
                'label'       => __( 'Site Title Font', 'rara-ecommerce' ),
                'description' => __( 'Site title and tagline font.', 'rara-ecommerce' ),
                'section'     => 'title_tagline',
                'priority'    => 60, 
            ) 
        ) 
    );
    
    /** Logo Width */
    $wp_customize->add_setting(
        'logo_width',
        array(
            'default'           => 150,
            'sanitize_callback' => 'rara_ecommerce_sanitize_number_absint',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'logo_width',
        array(
            'label'       => __( 'Logo Width', 'rara-ecommerce' ),
            'description' => __( 'Set the width(px) of your Site Logo.', 'rara-ecommerce' ),
            'section'     => 'title_tagline',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 1
            )
        )
    );
    
    /** Site Title Font Size*/
    $wp_customize->add_setting( 
        'site_title_font_size', 
        array(
            'default'           => 32,
            'sanitize_callback' => 'rara_ecommerce_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
		new Rara_eCommerce_Slider_Control( 
			$wp_customize,
			'site_title_font_size',
			array(
				'section'	  => 'title_tagline',
				'label'		  => __( 'Site Title Font Size', 'rara-ecommerce' ),
				'description' => __( 'Change the font size of your site title.', 'rara-ecommerce' ),
                'priority'    => 65,
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 200,
					'step'	=> 1,
				)                 
			)
		)
	);
    
    /** Site Title Color*/
    $wp_customize->add_setting( 
        'site_title_color', 
        array(
            'default'           => '#111111',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'site_title_color', 
            array(
                'label'       => __( 'Site Title Color', 'rara-ecommerce' ),
                'description' => __( 'Site Title color of the theme.', 'rara-ecommerce' ),
                'section'     => 'title_tagline',
                'priority'    => 66,
            )
        )
    );
    
}
add_action( 'customize_register', 'rara_ecommerce_customize_register' );