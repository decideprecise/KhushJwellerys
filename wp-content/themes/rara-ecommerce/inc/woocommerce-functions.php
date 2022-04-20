<?php
/**
 * Rara eCommerce Woocommerce hooks and functions.
 *
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Rara_eCommerce
 */

/**
 * Woocommerce related hooks
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
/**
 * Declare Woocommerce Support
*/
function rara_ecommerce_woocommerce_support() {
    global $woocommerce;
    
    add_theme_support( 'woocommerce' );
    
    if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}
add_action( 'after_setup_theme', 'rara_ecommerce_woocommerce_support');

/**
 * Woocommerce Sidebar
*/
function rara_ecommerce_wc_widgets_init(){
    register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'rara-ecommerce' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Sidebar displaying only in woocommerce pages.', 'rara-ecommerce' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );    
}
add_action( 'widgets_init', 'rara_ecommerce_wc_widgets_init' );

/**
 * Before Content
 * Wraps all WooCommerce content in wrappers which match the theme markup
*/
function rara_ecommerce_wc_wrapper(){    
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
    <?php
}
add_action( 'woocommerce_before_main_content', 'rara_ecommerce_wc_wrapper' );

/**
 * After Content
 * Closes the wrapping divs
*/
function rara_ecommerce_wc_wrapper_end(){
    ?>
        </main>
    </div>
    <?php
    do_action( 'rara_ecommerce_wo_sidebar' );
}
add_action( 'woocommerce_after_main_content', 'rara_ecommerce_wc_wrapper_end' );

/**
 * Callback function for Shop sidebar
*/
function rara_ecommerce_wc_sidebar_cb(){
    $sidebar = rara_ecommerce_sidebar();
    if( $sidebar ){
        echo '<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">';
        dynamic_sidebar( 'shop-sidebar' );
        echo '</aside>'; 
    }
}
add_action( 'rara_ecommerce_wo_sidebar', 'rara_ecommerce_wc_sidebar_cb' );

/**
 * Change Gravatar size for reviews
 */
function rara_ecommerce_woocommerce_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '94' ), '' );
}

// Add the new one
add_action( 'woocommerce_review_before', 'rara_ecommerce_woocommerce_review_display_gravatar', 10 );

/**
 * Removes the "shop" title on the main shop page
*/
add_filter( 'woocommerce_show_page_title' , '__return_false' );

if( ! function_exists( 'rara_ecommerce_wc_cart_count' ) ) :
/**
 * Woocommerce Cart Count
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header 
*/
function rara_ecommerce_wc_cart_count(){
    $count = WC()->cart->cart_contents_count; ?>
    <div class="cart-block">
        <div class="rr-cart-block-wrap">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'rara-ecommerce' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="13.87" height="16" viewBox="0 0 13.87 16"><path d="M15.8,5.219a.533.533,0,0,0-.533-.485H13.132V4.44A3.333,3.333,0,0,0,9.932,1a3.333,3.333,0,0,0-3.2,3.44v.293H4.6a.533.533,0,0,0-.533.485L3,16.419A.539.539,0,0,0,3.532,17h12.8a.539.539,0,0,0,.533-.581Zm-8-.779A2.267,2.267,0,0,1,9.932,2.067,2.267,2.267,0,0,1,12.065,4.44v.293H7.8ZM4.118,15.933,5.084,5.8H6.732v.683a1.067,1.067,0,1,0,1.067,0V5.8h4.267v.683a1.067,1.067,0,1,0,1.067,0V5.8H14.78l.965,10.133Z" transform="translate(-2.997 -1)"></path></svg>
                <span class="number"><?php echo absint( $count ); ?></span>
            </a>
            </div>
            <?php if ( ! wp_is_mobile() ) {
                echo '<div class="cart-block-popup"> ';
                the_widget( 'WC_Widget_Cart' );
                echo '</div>';
            } ?>
    </div>
    <?php
}
endif;

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header
 */
function rara_ecommerce_add_to_cart_fragment( $fragments ){
    ob_start();
    $count = WC()->cart->cart_contents_count; ?>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'rara-ecommerce' ); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="13.87" height="16" viewBox="0 0 13.87 16"><path d="M15.8,5.219a.533.533,0,0,0-.533-.485H13.132V4.44A3.333,3.333,0,0,0,9.932,1a3.333,3.333,0,0,0-3.2,3.44v.293H4.6a.533.533,0,0,0-.533.485L3,16.419A.539.539,0,0,0,3.532,17h12.8a.539.539,0,0,0,.533-.581Zm-8-.779A2.267,2.267,0,0,1,9.932,2.067,2.267,2.267,0,0,1,12.065,4.44v.293H7.8ZM4.118,15.933,5.084,5.8H6.732v.683a1.067,1.067,0,1,0,1.067,0V5.8h4.267v.683a1.067,1.067,0,1,0,1.067,0V5.8H14.78l.965,10.133Z" transform="translate(-2.997 -1)"></path></svg>
        <span class="number"><?php echo absint( $count ); ?></span>
    </a>
    <?php
 
    $fragments['a.cart'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'rara_ecommerce_add_to_cart_fragment' );

/**
 * Ajax Callback for adding product in cart
 * 
*/
function rara_ecommerce_add_cart_ajax() {
	global $woocommerce;
    
    $product_id = $_POST['product_id'];

	WC()->cart->add_to_cart( $product_id, 1 );
	$count = WC()->cart->cart_contents_count;
	$cart_url = $woocommerce->cart->get_cart_url(); 
    
    ?>
    <a href="<?php echo esc_url( $cart_url ); ?>" rel="bookmark" class="btn-add-to-cart"><?php esc_html_e( 'View Cart', 'rara-ecommerce' ); ?></a>
    <input type="hidden" id="<?php echo esc_attr( 'cart-' . $product_id ); ?>" value="<?php echo esc_attr( $count ); ?>" />
    <?php 
    die();
}
add_action( 'wp_ajax_rara_ecommerce_add_cart_single', 'rara_ecommerce_add_cart_ajax' );
add_action( 'wp_ajax_nopriv_rara_ecommerce_add_cart_single', 'rara_ecommerce_add_cart_ajax' );

if ( ! function_exists( 'rara_ecommerce_product_search_form' ) ) :
    /**
     * Display Product search form with categories
     *
     * @return void
     */
    function rara_ecommerce_product_search_form( $sticky = false ){ ?>
        <div class="advance-product-search">
            <form role="search" method="get" class="form-inline woocommerce-product-search"
                  action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="form-group style-search">
                    <label class="screen-reader-text"
                           for="woocommerce-product-search-field"><?php esc_html_e( 'Search for:', 'rara-ecommerce' ); ?></label>
                    <input type="search" id="woocommerce-product-search-field" class="search-field"
                           placeholder="<?php esc_attr_e( 'Product Search', 'rara-ecommerce' ); ?>"
                           value="<?php echo esc_attr( get_search_query() ); ?>" name="s"/>
                    <?php

                    $product_cats = get_terms( array(
                        'taxonomy' => 'product_cat',
                    ) );

                    if ( !empty( $product_cats ) && !is_wp_error( $product_cats ) ) :
                        $selected_product_cat = get_query_var('product_cat');
                        ?>
                        <select name="product_cat" class="cat-dropdown">

                            <option value=""><?php esc_html_e( 'Select Category', 'rara-ecommerce' ); ?></option>
                            <?php
                            foreach ( $product_cats as $product_cat ) { ?>
                                <option value="<?php echo esc_attr( $product_cat->slug ) ?>" <?php selected( $product_cat->slug, $selected_product_cat ) ?>><?php echo esc_html( $product_cat->name ); ?></option>
                            <?php } ?>
                        </select>
                    <?php endif; ?>
                    <button type="submit" value="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21.995" height="22" viewBox="0 0 21.995 22">
                        <path id="Icon_ionic-ios-search" data-name="Icon ionic-ios-search" d="M26.237,24.9l-6.117-6.174a8.717,8.717,0,1,0-1.323,1.34L24.873,26.2a.941.941,0,0,0,1.329.034A.948.948,0,0,0,26.237,24.9Zm-12.967-4.76a6.884,6.884,0,1,1,4.869-2.016A6.841,6.841,0,0,1,13.269,20.141Z" transform="translate(-4.5 -4.493)" fill="#292929"></path>
                    </svg>
                    </button>
                    <input type="hidden" name="post_type" value="product"/>
                </div>
            </form>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'rara_ecommerce_get_out_of_stock_query' ) ) :
/**
 * Display out of stock product
 *
 * @return void
 */
function rara_ecommerce_get_out_of_stock_query(){ 
    $stock_query = array(
    'post_type'         => 'product',
    'posts_per_page'    => -1,
    'fields'            => 'ids',
    'meta_query'        => array(
        array(
            'key'       => '_stock_status',
            'value'     => 'outofstock',
        )
    ) );
    $out_of_stocks  = new WP_Query( $stock_query );
    $exclude_ids    = $out_of_stocks->posts;
    return $exclude_ids;
}
endif;

if ( ! function_exists('rara_ecommerce_onsale_product_count' ) ) :
/**
 * Onsale Product Count
*/
function rara_ecommerce_onsale_product_count( $cat_id = 0 ) {
    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'published',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cat_id
            ),
            array(
                'taxonomy' => 'product_visibility',
                'terms' => array('exclude-from-catalog'),
                'field' => 'name',
                'operator' => 'NOT IN',
            ),
        ),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'relation' => 'OR',
                array(
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            ),
        )
    );

    $qry    = new WP_Query($args);
    $count  = $qry->found_posts;
    wp_reset_postdata();
    
    if( $count ) {
        return '<span class="product-count onsale-product-count"><span class="item-count">' . absint($count) . '</span><span class="item-texts item-texts-onsale">' . esc_html__( 'Sale!', 'rara-ecommerce' ) . '</span></span>';
    }else{
        return false;
    }
}
endif;

/**
 * Add Yith Wish list to Shop Page
 * 
*/
function rara_ecommerce_add_whislist_shop() {    

    if ( rara_ecommerce_is_yith_whislist_activated() ) {
        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
    }
}
add_action( 'woocommerce_after_shop_loop_item', 'rara_ecommerce_add_whislist_shop', 12 );

/**
 * Add html to Shop Page
 * 
*/
function rara_ecommerce_add_extra_div() {    
    echo '<div class="product-meta">';
}
add_action( 'woocommerce_after_shop_loop_item', 'rara_ecommerce_add_extra_div', 1 );

/**
 * Add html to Shop Page
 * 
*/
function rara_ecommerce_add_extra_div_end() {    
    echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item', 'rara_ecommerce_add_extra_div_end', 20 );

/**
 *  Add wrapper div to Shop Page
 */
function woocommerce_before_shop_loop_start() { 
    if ( is_shop() ) echo '<div class="shop-page-wrapper">';
}
add_action( 'woocommerce_before_shop_loop', 'woocommerce_before_shop_loop_start', 5 );

/**
 *  wrapper div end
 */
function woocommerce_before_shop_loop_end() { 
    if ( is_shop() ) echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'woocommerce_before_shop_loop_end', 35 );