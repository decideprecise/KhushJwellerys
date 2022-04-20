<?php
/**
 * Front Page Settings
 *
 * @package Rara_eCommerce
 */

function rara_ecommerce_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'rara-ecommerce' ),
            'description' => __( 'Static Home Page settings.', 'rara-ecommerce' ),
        ) 
    );   

    $wp_customize->get_section( 'header_image' )->panel                    = 'frontpage_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'rara-ecommerce' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'rara_ecommerce_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'rara_ecommerce_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'rara_ecommerce_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'static_banner',
            'sanitize_callback' => 'rara_ecommerce_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Rara_eCommerce_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'       => __( 'Banner Options', 'rara-ecommerce' ),
                'description' => __( 'Choose banner as static image/video or as a slider.', 'rara-ecommerce' ),
                'section'     => 'header_image',
                'choices'     => rara_ecommerce_banner_types(),
                'priority' => 5 
            )            
        )
    );

    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => __( 'BIGGEST SALES', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Sub Title', 'rara-ecommerce' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'rara_ecommerce_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_subtitle', array(
        'selector' => '.site-banner .banner-caption .banner-desc',
        'render_callback' => 'rara_ecommerce_get_banner_subtitle',
    ) );
    
    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => __( 'BEST SEASON SALES', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'rara-ecommerce' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'rara_ecommerce_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.site-banner .banner-caption h2.banner-title',
        'render_callback' => 'rara_ecommerce_get_banner_title',
    ) );

    /** Banner Label */
    $wp_customize->add_setting(
        'banner_label',
        array(
            'default'           => __( 'SHOP NOW', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_label',
        array(
            'label'           => __( 'Button Label', 'rara-ecommerce' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'rara_ecommerce_banner_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'banner_label', array(
        'selector' => '.site-banner .banner-caption .button-wrap a.primary-btn',
        'render_callback' => 'rara_ecommerce_get_banner_label',
    ) );
    
    
    /** Banner Link */
    $wp_customize->add_setting(
        'banner_link',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'banner_link',
        array(
            'label'           => __( 'Banner Link', 'rara-ecommerce' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'rara_ecommerce_banner_ac'
        )
    );
    
    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'           => 'latest_posts',
            'sanitize_callback' => 'rara_ecommerce_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Rara_eCommerce_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'   => __( 'Slider Content Style', 'rara-ecommerce' ),
                'section' => 'header_image',
                'choices' => rara_ecommerce_banner_options(),
                'active_callback' => 'rara_ecommerce_banner_ac' 
            )
        )
    );
    
    /** Slider Category */
    $wp_customize->add_setting(
        'slider_cat',
        array(
            'default'           => '',
            'sanitize_callback' => 'rara_ecommerce_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Rara_eCommerce_Select_Control(
            $wp_customize,
            'slider_cat',
            array(
                'label'           => __( 'Slider Category', 'rara-ecommerce' ),
                'section'         => 'header_image',
                'choices'         => rara_ecommerce_get_categories(),
                'active_callback' => 'rara_ecommerce_banner_ac' 
            )
        )
    );

    if( rara_ecommerce_is_woocommerce_activated() ) {

        /** Slider Products Category */
        $wp_customize->add_setting(
            'slider_cat_product',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'slider_cat_product',
                array(
                    'label'           => __( 'Products Category', 'rara-ecommerce' ),
                    'section'         => 'header_image',
                    'choices'         => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_banner_ac'   
                )
            )
        );

        /** Slider Category */
        $wp_customize->add_setting(
            'banner_cat_product',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'banner_cat_product',
                array(
                    'label'           => __( 'Banner Category', 'rara-ecommerce' ),
                    'section'         => 'header_image',
                    'choices'         => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_banner_ac',
                    'multiple'        => 5, 
                )
            )
        );

        $wp_customize->add_setting(
            'product_cat_label',
            array(
                'default'           => __( 'Shop Now', 'rara-ecommerce' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'product_cat_label',
            array(
                'label'           => __( 'Button Label', 'rara-ecommerce' ),
                'section'         => 'header_image',
                'type'            => 'text',
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        );

        $wp_customize->selective_refresh->add_partial( 'product_cat_label', array(
            'selector' => '.site-banner .banner-caption .button-wrap a.btn-readmore',
            'render_callback' => 'rara_ecommerce_get_product_cat_label',
        ) );
    }
    
    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'rara_ecommerce_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Slider_Control( 
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Number of Slides', 'rara-ecommerce' ),
                'description' => __( 'Choose the number of slides you want to display', 'rara-ecommerce' ),
                'choices'     => array(
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1,
                ),
                'active_callback' => 'rara_ecommerce_banner_ac'                 
            )
        )
    );
    
    /** HR */
    $wp_customize->add_setting(
        'hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Note_Control( 
            $wp_customize,
            'hr',
            array(
                'section'     => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        )
    ); 

    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Banner Caption', 'rara-ecommerce' ),
                'description' => __( 'Enable to show banner caption.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        )
    );

    $wp_customize->add_setting( 
        'banner_caption_layout', 
        array(
            'default'           => 'left',
            'sanitize_callback' => 'rara_ecommerce_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Radio_Buttonset_Control(
            $wp_customize,
            'banner_caption_layout',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Banner Caption Alignment', 'rara-ecommerce' ),
                'description' => __( 'Choose alignment for banner caption.', 'rara-ecommerce' ),
                'choices'     => array(
                    'left'      => __( 'Left', 'rara-ecommerce' ),
                    'centered'  => __( 'Center', 'rara-ecommerce' ),
                    'right'     => __( 'Right', 'rara-ecommerce' ),
                ),
                'active_callback' => 'rara_ecommerce_banner_ac' 
            )
        )
    );

    /** Static Banner overlay option */
    $wp_customize->add_setting(
        'banner_overlay',
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'banner_overlay',
            array(
                'section'       => 'header_image',
                'label'         => __( 'Banner Overlay', 'rara-ecommerce' ),
                'description'   => __( 'Enable for banner overlay.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        )
    );
    
    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Auto', 'rara-ecommerce' ),
                'description' => __( 'Enable slider auto transition.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        )
    );
    
    /** Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'slider_loop',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Loop', 'rara-ecommerce' ),
                'description' => __( 'Enable slider loop.', 'rara-ecommerce' ),
                'active_callback' => 'rara_ecommerce_banner_ac'
            )
        )
    );
    
    /** Slider Animation */
    $wp_customize->add_setting(
        'slider_animation',
        array(
            'default'           => '',
            'sanitize_callback' => 'rara_ecommerce_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Rara_eCommerce_Select_Control(
            $wp_customize,
            'slider_animation',
            array(
                'label'       => __( 'Slider Animation', 'rara-ecommerce' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'bounceOut'      => __( 'Bounce Out', 'rara-ecommerce' ),
                    'bounceOutLeft'  => __( 'Bounce Out Left', 'rara-ecommerce' ),
                    'bounceOutRight' => __( 'Bounce Out Right', 'rara-ecommerce' ),
                    'bounceOutUp'    => __( 'Bounce Out Up', 'rara-ecommerce' ),
                    'bounceOutDown'  => __( 'Bounce Out Down', 'rara-ecommerce' ),
                    'fadeOut'        => __( 'Fade Out', 'rara-ecommerce' ),
                    'fadeOutLeft'    => __( 'Fade Out Left', 'rara-ecommerce' ),
                    'fadeOutRight'   => __( 'Fade Out Right', 'rara-ecommerce' ),
                    'fadeOutUp'      => __( 'Fade Out Up', 'rara-ecommerce' ),
                    'fadeOutDown'    => __( 'Fade Out Down', 'rara-ecommerce' ),
                    'flipOutX'       => __( 'Flip OutX', 'rara-ecommerce' ),
                    'flipOutY'       => __( 'Flip OutY', 'rara-ecommerce' ),
                    'hinge'          => __( 'Hinge', 'rara-ecommerce' ),
                    'pulse'          => __( 'Pulse', 'rara-ecommerce' ),
                    'rollOut'        => __( 'Roll Out', 'rara-ecommerce' ),
                    'rotateOut'      => __( 'Rotate Out', 'rara-ecommerce' ),
                    'rubberBand'     => __( 'Rubber Band', 'rara-ecommerce' ),
                    'shake'          => __( 'Shake', 'rara-ecommerce' ),
                    ''               => __( 'Slide', 'rara-ecommerce' ),
                    'slideOutLeft'   => __( 'Slide Out Left', 'rara-ecommerce' ),
                    'slideOutRight'  => __( 'Slide Out Right', 'rara-ecommerce' ),
                    'slideOutUp'     => __( 'Slide Out Up', 'rara-ecommerce' ),
                    'slideOutDown'   => __( 'Slide Out Down', 'rara-ecommerce' ),
                    'swing'          => __( 'Swing', 'rara-ecommerce' ),
                    'tada'           => __( 'Tada', 'rara-ecommerce' ),
                    'zoomOut'        => __( 'Zoom Out', 'rara-ecommerce' ),
                    'zoomOutLeft'    => __( 'Zoom Out Left', 'rara-ecommerce' ),
                    'zoomOutRight'   => __( 'Zoom Out Right', 'rara-ecommerce' ),
                    'zoomOutUp'      => __( 'Zoom Out Up', 'rara-ecommerce' ),
                    'zoomOutDown'    => __( 'Zoom Out Down', 'rara-ecommerce' ),                    
                ),
                'active_callback' => 'rara_ecommerce_banner_ac'                                 
            )
        )
    );
    /** Slider Settings Ends */ 

    /** Featured Area Settings */
    $wp_customize->add_section(
        'featured_section',
        array(
            'title'    => __( 'Featured Section', 'rara-ecommerce' ),
            'priority' => 40,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Featured Area */
    $wp_customize->add_setting( 
        'ed_featured_section', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_featured_section',
            array(
                'section'     => 'featured_section',
                'label'       => __( 'Enable Featured Area', 'rara-ecommerce' ),
                'description' => __( 'Enable to show featured section in home page.', 'rara-ecommerce' ),
            )
        )
    );
    
    if( rara_ecommerce_is_woocommerce_activated() ) {
        /** Featured Category One */
        $wp_customize->add_setting(
            'cat_featured_one',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_featured_one',
                array(
                    'label'   => __( 'Featured Category One', 'rara-ecommerce' ),
                    'section' => 'featured_section',
                    'choices' => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_featured_ac'
                )
            )
        );

        /** Featured Category Two */
        $wp_customize->add_setting(
            'cat_featured_two',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_featured_two',
                array(
                    'label'   => __( 'Featured Category Two', 'rara-ecommerce' ),
                    'section' => 'featured_section',
                    'choices' => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_featured_ac'
                )
            )
        );

        /** Featured Category Two */
        $wp_customize->add_setting(
            'cat_featured_three',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_featured_three',
                array(
                    'label'   => __( 'Featured Category Three', 'rara-ecommerce' ),
                    'section' => 'featured_section',
                    'choices' => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_featured_ac'
                )
            )
        );
        
        /** Featured Category Two */
        $wp_customize->add_setting(
            'cat_featured_four',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_featured_four',
                array(
                    'label'   => __( 'Featured Category Four', 'rara-ecommerce' ),
                    'section' => 'featured_section',
                    'choices' => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_featured_ac'
                )
            )
        );

        /** Category Links */
        $wp_customize->add_setting( 'featured_cat_links',
            array(
                'default' => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Note_Control( 
                $wp_customize,
                'featured_cat_links',
                array(
                    'section'     => 'featured_section',
                    'description' => sprintf( __( '<span>To set the image for product category %1$sClick here.%2$s</span>', 'rara-ecommerce' ),  '<a href="' . esc_url( admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ) ) . '" target="_blank">', '</a>' ),
                    'active_callback' => 'rara_ecommerce_featured_ac'
                )
            )
        );
    
        /** Featured Area Settings Ends */ 

        /** Category One Settings */
        $wp_customize->add_section(
            'cat_one_section',
            array(
                'title'    => __( 'Category One Section', 'rara-ecommerce' ),
                'priority' => 60,
                'panel'    => 'frontpage_settings',
            )
        );

        /** Enable Category One Section */
        $wp_customize->add_setting( 
            'ed_cat_one_section', 
            array(
                'default'           => false,
                'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Toggle_Control( 
                $wp_customize,
                'ed_cat_one_section',
                array(
                    'section'     => 'cat_one_section',
                    'label'       => __( 'Enable Category One Section', 'rara-ecommerce' ),
                    'description' => __( 'Enable to show Category One section area section in home page.', 'rara-ecommerce' ),
                )
            )
        );

        /** Category One Section title */
        $wp_customize->add_setting(
            'cat_one_title',
            array(
                'default'           => __( 'Clearance Sale', 'rara-ecommerce' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'cat_one_title',
            array(
                'section' => 'cat_one_section',
                'label'   => __( 'Section Title', 'rara-ecommerce' ),
                'type'    => 'text',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'cat_one_title', array(
            'selector'            => '.product-sale-section h2.section-title',
            'render_callback'     => 'rara_ecommerce_cat_one_title_selective_refresh',
            'container_inclusive' => false,
            'fallback_refresh'    => true,
        ) );

        /** Category One Section description */
        $wp_customize->add_setting(
            'cat_one_description',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage'
            )
        );
        
        $wp_customize->add_control(
            'cat_one_description',
            array(
                'section' => 'cat_one_section',
                'label'   => __( 'Section Description', 'rara-ecommerce' ),
                'type'    => 'text',
            )
        );

        $wp_customize->selective_refresh->add_partial( 'cat_one_description', array(
            'selector'            => '.product-sale-section .section-desc',
            'render_callback'     => 'rara_ecommerce_cat_one_description_selective_refresh',
            'container_inclusive' => false,
            'fallback_refresh'    => true,
        ) );

        /** Category One Section featured image */
        $wp_customize->add_setting(
            'cat_one_featured_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_image',
            )
        );
        
        $wp_customize->add_control(
           new WP_Customize_Image_Control(
               $wp_customize,
               'cat_one_featured_image',
               array(
                   'label'       => __( 'Featured Image', 'rara-ecommerce' ),
                   'section'     => 'cat_one_section',
                   'description' => esc_html__( 'Choose Image of your choice. Recommended size for this image is 474px by 629px.', 'rara-ecommerce' ),
               )
           )
        );

        /** Category One filter */    
        $wp_customize->add_setting( 
            'cat_one_filter', 
            array(
                'default'           => 'latest',
                'sanitize_callback' => 'rara_ecommerce_sanitize_radio'
            ) 
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Radio_Buttonset_Control(
                $wp_customize,
                'cat_one_filter',
                array(
                    'section'     => 'cat_one_section',
                    'label'       => __( 'Product Filter', 'rara-ecommerce' ),
                    'choices'     => array(
                        'latest'   => __( 'Latest', 'rara-ecommerce' ),
                        'popular'  => __( 'Popular', 'rara-ecommerce' ),
                        'category' => __( 'Category', 'rara-ecommerce' )
                    )
                )
            )
        );

        /** Category One Category */
        $wp_customize->add_setting(
            'cat_one_cat',
            array(
                'default'           => '',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_one_cat',
                array(
                    'label'           => __( 'Product Category', 'rara-ecommerce' ),
                    'section'         => 'cat_one_section',
                    'choices'         => rara_ecommerce_get_categories( true, 'product_cat' ),
                    'active_callback' => 'rara_ecommerce_cat_one_ac'
                )
            )
        );

        /** Category One Category Filter */
        $wp_customize->add_setting(
            'cat_one_cat_filter',
            array(
                'default'           => 'latest',
                'sanitize_callback' => 'rara_ecommerce_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Rara_eCommerce_Select_Control(
                $wp_customize,
                'cat_one_cat_filter',
                array(
                    'label'           => __( 'Category Filter', 'rara-ecommerce' ),
                    'section'         => 'cat_one_section',
                    'choices'     => array(
                        'latest'  => __( 'Latest products', 'rara-ecommerce' ),
                        'popular' => __( 'Popular products', 'rara-ecommerce' ),
                        'sale'    => __( 'Product on sales', 'rara-ecommerce' ),
                    ),
                    'active_callback' => 'rara_ecommerce_cat_one_ac'
                )
            )
        );

        /** Category One No. of product post */
        $wp_customize->add_setting(
            'no_of_cat_one_post',
            array(
                'default'           => 5,
                'sanitize_callback' => 'rara_ecommerce_sanitize_number_absint'
            )
        );
        
        $wp_customize->add_control(
            new Rara_eCommerce_Slider_Control( 
                $wp_customize,
                'no_of_cat_one_post',
                array(
                    'section'     => 'cat_one_section',
                    'label'       => __( 'Number of Posts', 'rara-ecommerce' ),
                    'description' => __( 'Choose the number of posts you want to display', 'rara-ecommerce' ),
                    'choices'     => array(
                        'min'   => 1,
                        'max'   => 20,
                        'step'  => 1,
                    )                 
                )
            )
        );
    }

    /** Testimonial Settings */
    $wp_customize->add_section(
        'testimonial_section',
        array(
            'title'    => __( 'Testimonial Section', 'rara-ecommerce' ),
            'priority' => 90,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Category One Section */
    $wp_customize->add_setting( 
        'ed_testimonial_section', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_testimonial_section',
            array(
                'section'     => 'testimonial_section',
                'priority'    => -1,
                'label'       => __( 'Enable Testimonial One Section', 'rara-ecommerce' ),
                'description' => __( 'Enable to show Testimonial section area section in home page.', 'rara-ecommerce' ),
            )
        )
    );

    /** Testimonial Section title */
    $wp_customize->add_setting(
        'testimonial_title',
        array(
            'default'           => __( 'The Story', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'testimonial_title',
        array(
            'section' => 'testimonial_section',
            'label'   => __( 'Section Title', 'rara-ecommerce' ),
            'type'    => 'text',
            'priority'  => -1,
        )
    );

    $wp_customize->selective_refresh->add_partial( 'testimonial_title', array(
        'selector'            => '.testimonial-section .testimonial-wrap h2.section-title',
        'render_callback'     => 'rara_ecommerce_testimonial_title_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Testimonial Section featured image */
    $wp_customize->add_setting(
        'testimonial_featured_image',
        array(
            'default'           => '',
            'sanitize_callback' => 'rara_ecommerce_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
            $wp_customize,
            'testimonial_featured_image',
            array(
                'label'   => __( 'Background Image', 'rara-ecommerce' ),
                'section' => 'testimonial_section',  
                'description' => esc_html__( 'Choose Image of your choice. Recommended size for this image is 693px by 609px.', 'rara-ecommerce' ),             
                'priority'  => -1,
           )
       )
    );

    /** Testimonial Background Color*/
    $wp_customize->add_setting( 
        'testimonial_bg_color', 
        array(
            'default'           => '#FAF7EE',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'testimonial_bg_color', 
            array(
                'label'       => __( 'Background Color', 'rara-ecommerce' ),
                'section'     => 'testimonial_section',
                'priority'    => -1,
            )
        )
    );

    /** Testimonial Font Color*/
    $wp_customize->add_setting( 
        'testimonial_font_color', 
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'testimonial_font_color', 
            array(
                'label'       => __( 'Font Color', 'rara-ecommerce' ),
                'section'     => 'testimonial_section',
                'priority'    => -1,
            )
        )
    );

    $testimonial_section = $wp_customize->get_section( 'sidebar-widgets-testimonial' );
    if ( ! empty( $testimonial_section ) ) {

        $testimonial_section->panel     = 'frontpage_settings';
        $testimonial_section->priority  = 90;
        $wp_customize->get_control( 'ed_testimonial_section' )->section     = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_title' )->section          = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_featured_image' )->section = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_bg_color' )->section       = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_font_color' )->section     = 'sidebar-widgets-testimonial';
    }  


    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'rara-ecommerce' ),
            'priority' => 105,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable Blog Section */
    $wp_customize->add_setting( 
        'ed_blog_section', 
        array(
            'default'           => false,
            'sanitize_callback' => 'rara_ecommerce_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Rara_eCommerce_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'     => 'blog_section',
                'label'       => __( 'Enable Blog Section', 'rara-ecommerce' ),
                'description' => __( 'Enable to show Blog section area section in home page.', 'rara-ecommerce' ),
            )
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'Latest Articles', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Title', 'rara-ecommerce' ),
            'type'    => 'text',
        )
    );

    /** Selective refresh for blog title. **/
    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector'            => '.blog-section .container-sm h2.section-title',
        'render_callback'     => 'rara_ecommerce_blog_title_selective_refresh',
    ) );

    /** Blog description */
    $wp_customize->add_setting(
        'blog_section_subtitle',
        array(
            'default'           => __( 'Our recent articles about fashion ideas products.', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_subtitle',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Description', 'rara-ecommerce' ),
            'type'    => 'text',
        )
    ); 

    /** Selective refresh for blog description. **/
    $wp_customize->selective_refresh->add_partial( 'blog_section_subtitle', array(
        'selector'            => '.blog-section .container-sm p',
        'render_callback'     => 'rara_ecommerce_blog_description_selective_refresh',
    ) );
    
    /** View All Label */
    $wp_customize->add_setting(
        'blog_view_all',
        array(
            'default'           => __( 'See More Posts', 'rara-ecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_view_all',
        array(
            'label'           => __( 'View All Label', 'rara-ecommerce' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'rara_ecommerce_blog_view_all_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'blog_view_all', array(
        'selector' => '.blog-section .container-sm a.bttn',
        'render_callback' => 'rara_ecommerce_get_blog_view_all_btn',
    ) ); 
      
}
add_action( 'customize_register', 'rara_ecommerce_customize_register_frontpage' );

if ( ! function_exists( 'rara_ecommerce_banner_types' ) ) :
    /**
     * @return array Content type options
     */
    function rara_ecommerce_banner_types() {
        $banner_options = array(
            'no_banner'        => __( 'Disable Banner Section', 'rara-ecommerce' ),
            'static_banner'    => __( 'Static/Video CTA Banner', 'rara-ecommerce' ),
            'slider_banner'    => __( 'Banner as Slider', 'rara-ecommerce' ),
        );
        if ( rara_ecommerce_is_woocommerce_activated() ) {
            $banner_options = array_merge( $banner_options, array( 'static_category' => __( 'Banner as Product Category', 'rara-ecommerce' ) ) );
        }
        $output = apply_filters( 'rara_ecommerce_banner_types', $banner_options );
        return $output;
    }
endif;

if ( ! function_exists( 'rara_ecommerce_banner_options' ) ) :
    /**
     * @return array Content type options
     */
    function rara_ecommerce_banner_options() {
        $banner_types = array(
            'latest_posts' => __( 'Latest Posts', 'rara-ecommerce' ),
            'cat'          => __( 'Category', 'rara-ecommerce' ),
        );
        if ( rara_ecommerce_is_woocommerce_activated() ) {
            $banner_types = array_merge( $banner_types, array( 'latest_products' => __( 'Latest Products', 'rara-ecommerce' ), 'cat_products' => __( 'Product Category', 'rara-ecommerce' ) ) );
        }
        $output = apply_filters( 'rara_ecommerce_banner_options', $banner_types );
        return $output;
    }
endif;