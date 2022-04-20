<?php
/**
 * General Settings
 *
 * @package Rara_eCommerce
 */

function rara_ecommerce_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'rara-ecommerce' ),
            'description' => __( 'Customize Header, Social, Sharing, SEO, Post/Page, Newsletter, Performance and Miscellaneous settings.', 'rara-ecommerce' ),
        ) 
    );

    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'rara-ecommerce' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );

    /** Phone Label */
    $wp_customize->add_setting(
        'phone_label',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'phone_label',
        array(
            'type'            => 'text',
            'section'         => 'header_settings',
            'label'           => __( 'Phone Label', 'rara-ecommerce' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'phone_label', array(
        'selector'            => '.header-t .content span',
        'render_callback'     => 'rara_ecommerce_phone_label_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Phone */
    $wp_customize->add_setting(
        'phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'phone',
        array(
            'section'         => 'header_settings',
            'label'           => __( 'Phone', 'rara-ecommerce' ),
            'type'            => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'phone', array(
        'selector'            => '.header-t .content a',
        'render_callback'     => 'rara_ecommerce_phone_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_header_product_search', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_header_product_search',
            array(
                'section'         => 'header_settings',
                'label'           => __( 'Enable Header Search', 'rara-ecommerce' ),
                'description'     => __( 'Enable to show Search button in header.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_is_woocommerce_activated',
            )
        )
    );

    /** Wishlist Cart */
    $wp_customize->add_setting( 
        'ed_whislist', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_whislist',
            array(
                'section'         => 'header_settings',
                'label'           => __( 'Wishlist Cart', 'rara-ecommerce' ),
                'description'     => __( 'Enable to show Wishlist cart in the header.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_is_woocommerce_activated',
            )
        )
    );
    
    /** User Login */
    $wp_customize->add_setting( 
        'ed_user_login', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_user_login',
            array(
                'section'         => 'header_settings',
                'label'           => __( 'User Login', 'rara-ecommerce' ),
                'description'     => __( 'Enable to show user login in the header.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_is_woocommerce_activated',
            )
        )
    );

    /** Shopping Cart */
    $wp_customize->add_setting( 
        'ed_shopping_cart', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_shopping_cart',
            array(
                'section'         => 'header_settings',
                'label'           => __( 'Shopping Cart', 'rara-ecommerce' ),
                'description'     => __( 'Enable to show Shopping cart in the header.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_is_woocommerce_activated',
            )
        )
    );

    /** Header Note */
    $wp_customize->add_setting(
        'header_note',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'header_note',
        array(
            'label'           => __( 'Header Note', 'rara-ecommerce' ),
            'type'            => 'text',
            'section'         => 'header_settings',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'header_note', array(
        'selector'            => '.header-main .shipping-cost',
        'render_callback'     => 'rara_ecommerce_header_note_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );
    /** Header Settings Ends */

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'rara-ecommerce' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'       => __( 'Enable Social Links', 'rara-ecommerce' ),
                'description' => __( 'Enable to show social links at header.', 'rara-ecommerce' ),
            )
        )
    );
    
    $wp_customize->add_setting( 
        new Rara_eCommerce_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Rara_eCommerce_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',               
                'label'   => __( 'Social Links', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_social_ac',
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'rara-ecommerce' ),
                        'description' => __( 'Example: fab fa-facebook-f', 'rara-ecommerce' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'rara-ecommerce' ),
                        'description' => __( 'Example: https://facebook.com', 'rara-ecommerce' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'rara-ecommerce' ),
                    'field' => 'link'
                )                        
            )
        )
    );
    /** Social Media Settings Ends */

    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'rara-ecommerce' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Last Update Post Date', 'rara-ecommerce' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'rara-ecommerce' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'rara-ecommerce' ),
        )
    );  
    /** SEO Settings Ends */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'rara-ecommerce' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );
    
    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Enable Blog Excerpt', 'rara-ecommerce' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 55,
            'sanitize_callback' => 'rara_ecommerce_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Slider_Control( 
            $wp_customize,
            'excerpt_length',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Excerpt Length', 'rara-ecommerce' ),
                'description' => __( 'Automatically generated excerpt length (in words).', 'rara-ecommerce' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 5,
                )                 
            )
        )
    );
    
    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Note_Control( 
            $wp_customize,
            'post_note_text',
            array(
                'section'     => 'post_page_settings',
                'description' => sprintf( __( '%s These options affect your individual posts.', 'rara-ecommerce' ), '<hr/>' ),
            )
        )
    );
    
    /** Hide Author Section */
    $wp_customize->add_setting( 
        'ed_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Author Section', 'rara-ecommerce' ),
                'description' => __( 'Enable to hide author section.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Related Posts', 'rara-ecommerce' ),
                'description' => __( 'Enable to show related posts in single page.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'You may also like...', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Posts Section Title', 'rara-ecommerce' ),
            'active_callback' => 'rara_ecommerce_post_page_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.related-posts .title',
        'render_callback' => 'rara_ecommerce_get_related_title',
    ) );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Category', 'rara-ecommerce' ),
                'description' => __( 'Enable to hide category.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'rara-ecommerce' ),
                'description' => __( 'Enable to hide post author.', 'rara-ecommerce' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Posted Date', 'rara-ecommerce' ),
                'description' => __( 'Enable to hide posted date.', 'rara-ecommerce' ),
            )
        )
    );
    /** Posts(Blog) & Pages Settings Ends */

    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_settings',
        array(
            'title'    => __( 'Instagram Settings', 'rara-ecommerce' ),
            'priority' => 65,
            'panel'    => 'general_settings',
        )
    );
    
    if( rara_ecommerce_is_btif_activated() ){
        /** Enable Instagram Section */
        $wp_customize->add_setting( 
            'ed_instagram', 
            array(
                'default'           => false,
                'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Toggle_Control( 
                $wp_customize,
                'ed_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __( 'Instagram Section', 'rara-ecommerce' ),
                    'description' => __( 'Enable to show Instagram Section', 'rara-ecommerce' ),
                )
            )
        );
        
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'You can change the setting of BlossomThemes Social Feed %1$sfrom here%2$s.', 'rara-ecommerce' ), '<a href="' . esc_url( admin_url( 'admin.php?page=class-blossomthemes-instagram-feed-admin.php' ) ) . '" target="_blank">', '</a>' )
                )
            )
        );        
    }else{
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Social Feed%2$s. After that option related with this section will be visible.', 'rara-ecommerce' ), '<a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '" target="_blank">', '</a>' )
                )
            )
        );
    }

    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'rara-ecommerce' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

    /** Enable Elementor Page Builder in FrontPage */
    $wp_customize->add_setting( 
        'ed_elementor', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_elementor',
            array(
                'section'         => 'misc_settings',
                'label'           => __( 'Enable Elementor Page Builder in FrontPage', 'rara-ecommerce' ),
                'description'     => __( 'You can override your Homepage Contents from this Elementor Page Builder', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_is_elementor_activated'
            )
        )
    );

    /** Drop Cap */
    $wp_customize->add_setting(
        'ed_drop_cap',
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_drop_cap',
            array(
                'section'       => 'misc_settings',
                'label'         => __( 'Drop Cap', 'rara-ecommerce' ),
                'description'   => __( 'Enable to show first letter of word in post/page content in drop cap.', 'rara-ecommerce' ),
            )
        )
    );

    /** 404 Page Image Settings */
    $wp_customize->add_setting( 
        '404_page_image', 
        array(
            'default'           => get_template_directory_uri() . '/images/error.jpg',
            'sanitize_callback' => 'esc_url_raw'
        ) 
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            '404_page_image',
            array(
                'section'     => 'misc_settings',
                'label'       => __( '404 Page Image', 'rara-ecommerce' ),
                'description' => __( 'Upload image for 404 page.', 'rara-ecommerce' ),
            )
        )
    ); 
    
}
add_action( 'customize_register', 'rara_ecommerce_customize_register_general' );