<?php
/**
 * Rara eCommerce Custom functions and definitions
 *
 * @package Rara_eCommerce
 */

if ( ! function_exists( 'rara_ecommerce_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rara_ecommerce_setup() {

    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Rara eCommerce, use a find and replace
	 * to change 'rara-ecommerce' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'rara-ecommerce', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary', 'rara-ecommerce' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
    // Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rara_ecommerce_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 
        'custom-logo', 
        array( 
            'header-text' => array( 'site-title', 'site-description' ) 
        )
    );
    
    /**
     * Add support for custom header.
    */
    add_theme_support( 
        'custom-header', 
        apply_filters( 
            'rara_ecommerce_custom_header_args', 
            array(
        		'default-image' => '',
                'video'         => true,
        		'width'         => 1920, /** change width as per theme requirement */
        		'height'        => 760, /** change height as per theme requirement */
        		'header-text'   => false
            ) 
        ) 
    );
 
    /**
     * Add Custom Images sizes.
    */    
    add_image_size( 'rara-ecommerce-slider', 1220, 750, true );
    add_image_size( 'rara-ecommerce-banner-cat-one', 636, 540, true );
    add_image_size( 'rara-ecommerce-featured', 860, 860, true );
    add_image_size( 'rara-ecommerce-featured-one', 860, 415, true );
    add_image_size( 'rara-ecommerce-product-sale', 400, 400, true );
    add_image_size( 'rara-ecommerce-blog-classic', 968, 493, true );
    add_image_size( 'rara-ecommerce-blog-classic-full', 1308, 650, true );
    add_image_size( 'rara-ecommerce-blog-list', 445, 320, true );
    add_image_size( 'rara-ecommerce-with-sidebar', 970, 495, true );
    add_image_size( 'rara-ecommerce-fullwidth', 445, 320, true );
    add_image_size( 'rara-ecommerce-recent', 302, 376, true );
    /** Starter Content */
    $starter_content = array(
        // Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array( 
            'home', 
            'blog',
        ),
		
        // Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),
        
        // Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'primary' => array(
				'name' => __( 'Primary', 'rara-ecommerce' ),
				'items' => array(
					'page_home',
					'page_blog'
				)
			)
		),
    );
    
    $starter_content = apply_filters( 'rara_ecommerce_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
    
    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

    // Add excerpt support for pages
    add_post_type_support( 'page', 'excerpt' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     *
     */
    add_editor_style( array(
            'css' . $build . '/editor-style' . $suffix . '.css',
            rara_ecommerce_fonts_url()
        )
    );

    // Add support for block editor styles.
    add_theme_support( 'wp-block-styles' );

    // Remove widget block.
    remove_theme_support( 'widgets-block-editor' );
}
endif;
add_action( 'after_setup_theme', 'rara_ecommerce_setup' );

if( ! function_exists( 'rara_ecommerce_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rara_ecommerce_content_width() {
    
    $GLOBALS['content_width'] = apply_filters( 'rara_ecommerce_content_width', 968 );
}
endif;
add_action( 'after_setup_theme', 'rara_ecommerce_content_width', 0 );

if( ! function_exists( 'rara_ecommerce_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function rara_ecommerce_template_redirect_content_width(){
	$sidebar = rara_ecommerce_sidebar();
    if( $sidebar ){
        $GLOBALS['content_width'] = 968;        
	}else{
        if( is_singular() ){
            if( rara_ecommerce_sidebar( true ) === 'full-width centered' ){
                $GLOBALS['content_width'] = 968; 
            }else{
                $GLOBALS['content_width'] = 1322;                 
            }                
        }else{
            $GLOBALS['content_width'] = 1322; 
        }
	}
}
endif;
add_action( 'template_redirect', 'rara_ecommerce_template_redirect_content_width' );

if( ! function_exists( 'rara_ecommerce_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function rara_ecommerce_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
   
    wp_enqueue_style( 'rara-ecommerce-google-fonts', rara_ecommerce_fonts_url(), array(), null );

    wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.3.4' );
    wp_enqueue_style( 'animate', get_template_directory_uri(). '/css' . $build . '/animate' . $suffix . '.css', array(), '3.5.2' );
    
    wp_enqueue_style( 'rara-ecommerce', get_stylesheet_uri(), array(), RARA_ECOMMERCE_THEME_VERSION );
    
    if( rara_ecommerce_is_elementor_activated() ){
        wp_enqueue_style( 'rara-ecommerce-elementor', get_template_directory_uri(). '/css' . $build . '/elementor' . $suffix . '.css', array(), RARA_ECOMMERCE_THEME_VERSION );
    }
    wp_enqueue_style( 'rara-ecommerce-gutenberg', get_template_directory_uri(). '/css' . $build . '/gutenberg' . $suffix . '.css', array(), RARA_ECOMMERCE_THEME_VERSION );
    
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery', 'all' ), '5.6.3', true );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );
    wp_enqueue_script( 'rara-ecommerce-modal-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), RARA_ECOMMERCE_THEME_VERSION, true );
	wp_enqueue_script( 'rara-ecommerce', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), RARA_ECOMMERCE_THEME_VERSION, true );
    
    $array = array( 
        'rtl'           => is_rtl(),
        'auto'          => (bool) get_theme_mod( 'slider_auto', true ),
        'loop'          => (bool) get_theme_mod( 'slider_loop', true ),
        'animation'     => esc_attr( get_theme_mod( 'slider_animation' ) ),
        'drop_cap'      => (bool) get_theme_mod( 'ed_drop_cap', false ),
    );
    
    wp_localize_script( 'rara-ecommerce', 'rara_ecommerce_data', $array );
               
    if ( rara_ecommerce_is_jetpack_activated( true ) ) {
        wp_enqueue_style( 'tiled-gallery', plugins_url() . '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.css' );            
    }
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'rara_ecommerce_scripts' );

if( ! function_exists( 'rara_ecommerce_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function rara_ecommerce_admin_scripts( $hook ){    
    if( $hook == 'post-new.php' || $hook == 'post.php' || $hook == 'user-new.php' || $hook == 'user-edit.php' || $hook == 'profile.php' ){
        wp_enqueue_style( 'rara-ecommerce-admin', get_template_directory_uri() . '/inc/css/admin.css', '', RARA_ECOMMERCE_THEME_VERSION );
    }
}
endif; 
add_action( 'admin_enqueue_scripts', 'rara_ecommerce_admin_scripts' );

if( ! function_exists( 'rara_ecommerce_block_editor_styles' ) ) :
/**
 * Enqueue editor styles for Gutenberg
 */
function rara_ecommerce_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'rara-ecommerce-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    wp_add_inline_style( 'rara-ecommerce-block-editor-style', rara_ecommerce_gutenberg_inline_style() );

    // Add custom fonts.
    wp_enqueue_style( 'rara-ecommerce-google-fonts', rara_ecommerce_fonts_url(), array(), null );
}
endif;
add_action( 'enqueue_block_editor_assets', 'rara_ecommerce_block_editor_styles' );

if( ! function_exists( 'rara_ecommerce_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rara_ecommerce_body_classes( $classes ) {
    $editor_options      = get_option( 'classic-editor-replace' );
    $allow_users_options = get_option( 'classic-editor-allow-users' );
    
    // Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    if ( rara_ecommerce_is_woocommerce_activated() && is_shop() ) {
        $classes[] = 'shop-grid-layout';
    }

    if( !rara_ecommerce_is_classic_editor_activated() || ( rara_ecommerce_is_classic_editor_activated() && $editor_options == 'block' ) || ( rara_ecommerce_is_classic_editor_activated() && $allow_users_options == 'allow' && has_blocks() ) ) {
        $classes[] = 'rara-ecommerce-has-blocks';
    }
    
    if( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    $classes[] = rara_ecommerce_sidebar( true );

    if( is_home() || is_archive() || is_search() ) $classes[] = 'classic-view';
    
	return $classes;
}
endif;
add_filter( 'body_class', 'rara_ecommerce_body_classes' );

if( ! function_exists( 'rara_ecommerce_post_classes' ) ) :
/**
 * Add custom classes to the array of post classes.
*/
function rara_ecommerce_post_classes( $classes ){
    
    global $wp_query;
    if( is_front_page() && is_home() && $wp_query->current_post == 0 ){
        $classes[] = 'first-post';
    }
    
    $classes[] = 'latest_post';
    return $classes;
}
endif;
add_filter( 'post_class', 'rara_ecommerce_post_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function rara_ecommerce_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'rara_ecommerce_pingback_header' );

if( ! function_exists( 'rara_ecommerce_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function rara_ecommerce_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );    
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'rara-ecommerce' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'rara-ecommerce' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'rara-ecommerce' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'rara-ecommerce' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'rara-ecommerce' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'rara-ecommerce' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'rara_ecommerce_change_comment_form_default_fields' );

if( ! function_exists( 'rara_ecommerce_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function rara_ecommerce_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'rara-ecommerce' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'rara-ecommerce' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'rara_ecommerce_change_comment_form_defaults' );

if ( ! function_exists( 'rara_ecommerce_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function rara_ecommerce_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}

endif;
add_filter( 'excerpt_more', 'rara_ecommerce_excerpt_more' );

if ( ! function_exists( 'rara_ecommerce_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function rara_ecommerce_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'excerpt_length', 55 );
    return is_admin() ? $length : absint( $excerpt_length );    
}
endif;
add_filter( 'excerpt_length', 'rara_ecommerce_excerpt_length', 999 );

if( ! function_exists( 'rara_ecommerce_get_comment_author_link' ) ) :
/**
 * Filter to modify comment author link
 * @link https://developer.wordpress.org/reference/functions/get_comment_author_link/
 */
function rara_ecommerce_get_comment_author_link( $return, $author, $comment_ID ){
    $comment = get_comment( $comment_ID );
    $url     = get_comment_author_url( $comment );
    $author  = get_comment_author( $comment );
 
    if ( empty( $url ) || 'http://' == $url )
        $return = '<span itemprop="name">'. esc_html( $author ) .'</span>';
    else
        $return = '<span itemprop="name"><a href=' . esc_url( $url ) . ' rel="external nofollow noopener" class="url" itemprop="url">' . esc_html( $author ) . '</a></span>';

    return $return;
}
endif;
add_filter( 'get_comment_author_link', 'rara_ecommerce_get_comment_author_link', 10, 3 );

if( ! function_exists( 'rara_ecommerce_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function rara_ecommerce_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'rara_ecommerce_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'rara-ecommerce' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'rara-ecommerce' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=rara-ecommerce-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'rara-ecommerce' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?rara_ecommerce_admin_notice=1"><?php esc_html_e( 'Dismiss', 'rara-ecommerce' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'rara_ecommerce_admin_notice' );

if( ! function_exists( 'rara_ecommerce_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function rara_ecommerce_update_admin_notice(){
    if ( isset( $_GET['rara_ecommerce_admin_notice'] ) && $_GET['rara_ecommerce_admin_notice'] = '1' ) {
        update_option( 'rara_ecommerce_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'rara_ecommerce_update_admin_notice' );

if ( ! function_exists( 'rara_ecommerce_get_fontawesome_ajax' ) ) :
/**
 * Return an array of all icons.
 */
function rara_ecommerce_get_fontawesome_ajax() {
    // Bail if the nonce doesn't check out
    if ( ! isset( $_POST['rara_ecommerce_customize_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['rara_ecommerce_customize_nonce'] ), 'rara_ecommerce_customize_nonce' ) ) {
        wp_die();
    }

    // Do another nonce check
    check_ajax_referer( 'rara_ecommerce_customize_nonce', 'rara_ecommerce_customize_nonce' );

    // Bail if user can't edit theme options
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die();
    }

    // Get all of our fonts
    $fonts = rara_ecommerce_get_fontawesome_list();
    
    ob_start();
    if( $fonts ){ ?>
        <ul class="font-group">
            <?php 
                foreach( $fonts as $font ){
                    echo '<li data-font="' . esc_attr( $font ) . '"><i class="' . esc_attr( $font ) . '"></i></li>';                        
                }
            ?>
        </ul>
        <?php
    }
    echo ob_get_clean();

    // Exit
    wp_die();
}
endif;
add_action( 'wp_ajax_rara_ecommerce_get_fontawesome_ajax', 'rara_ecommerce_get_fontawesome_ajax' );

if ( ! function_exists( 'rara_ecommerce_dynamic_mce_css' ) ) :
/**
 * Add Editor Style 
 * Add Link Color Option in Editor Style (MCE CSS)
 */
function rara_ecommerce_dynamic_mce_css( $mce_css ){
    $mce_css .= ', ' . add_query_arg( array( 'action' => 'rara_ecommerce_dynamic_mce_css', '_nonce' => wp_create_nonce( 'rara_ecommerce_dynamic_mce_nonce', __FILE__ ) ), admin_url( 'admin-ajax.php' ) );
    return $mce_css;
}
endif;
add_filter( 'mce_css', 'rara_ecommerce_dynamic_mce_css' );
 
if ( ! function_exists( 'rara_ecommerce_dynamic_mce_css_ajax_callback' ) ) : 
/**
 * Ajax Callback
 */
function rara_ecommerce_dynamic_mce_css_ajax_callback(){
 
    /* Check nonce for security */
    $nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
    if( ! wp_verify_nonce( $nonce, 'rara_ecommerce_dynamic_mce_nonce' ) ){
        die(); // don't print anything
    }
    
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'Jost' );
    $primary_fonts   = seva_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Jost' );
    $secondary_fonts = seva_get_fonts( $secondary_font, 'regular' );
    $primary_color    = get_theme_mod( 'primary_color', '#C4B583' );
    $secondary_color  = get_theme_mod( 'secondary_color', '#D5001B' );

    $rgb  = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $primary_color ) );
    $rgb2 = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $secondary_color ) );
 
    /* Set File Type and Print the CSS Declaration */
    header( 'Content-type: text/css' );
    echo ':root .mce-content-body {
        --primary-color: ' . rara_ecommerce_sanitize_hex_color( $primary_color ) . ';
        --primary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ) . ';
        --secondary-color: ' . rara_ecommerce_sanitize_hex_color( $secondary_color ) . ';
        --secondary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ) . ';
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }';
    die(); // end ajax process.
}
endif;
add_action( 'wp_ajax_rara_ecommerce_dynamic_mce_css', 'rara_ecommerce_dynamic_mce_css_ajax_callback' );
add_action( 'wp_ajax_no_priv_rara_ecommerce_dynamic_mce_css', 'rara_ecommerce_dynamic_mce_css_ajax_callback' );