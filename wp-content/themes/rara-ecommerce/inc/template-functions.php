<?php
/**
 * Rara eCommerce Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Rara_eCommerce
 */

if( ! function_exists( 'rara_ecommerce_doctype' ) ) :
/**
 * Doctype Declaration
*/
function rara_ecommerce_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'rara_ecommerce_doctype', 'rara_ecommerce_doctype' );

if( ! function_exists( 'rara_ecommerce_head' ) ) :
/**
 * Before wp_head 
*/
function rara_ecommerce_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'rara_ecommerce_before_wp_head', 'rara_ecommerce_head' );

if( ! function_exists( 'rara_ecommerce_page_start' ) ) :
/**
 * Page Start
*/
function rara_ecommerce_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'rara-ecommerce' ); ?></a>
    <?php
}
endif;
add_action( 'rara_ecommerce_before_header', 'rara_ecommerce_page_start', 20 );

if( ! function_exists( 'rara_ecommerce_header' ) ) :
/**
 * Header Start
*/
function rara_ecommerce_header(){ 
    $header_product_search = get_theme_mod( 'ed_header_product_search', true );
    $ed_cart               = get_theme_mod( 'ed_shopping_cart', true );
    ?>
    <header id="masthead" class="site-header" itemscope itemtype="http://schema.org/WPHeader">
        <?php rara_ecommerce_top_bar(); ?>

        <div class="header-mid">
            <div class="container-sm">
                <?php 
                rara_ecommerce_site_branding(); 

                if ( rara_ecommerce_is_woocommerce_activated() && $header_product_search ) rara_ecommerce_product_search_form(); ?>

                <div class="right">
                    <?php 
                    rara_ecommerce_favourite_block(); 
                    rara_ecommerce_user_block();
                    if( rara_ecommerce_is_woocommerce_activated() && $ed_cart ) rara_ecommerce_wc_cart_count(); 
                    ?>
                </div>
            </div>
        </div><!-- Headermid -->

        <div class="header-main">
            <div class="container-sm">
                <div class="header-main-wrapper">
                    <?php 
                    rara_ecommerce_primary_nagivation(); 
                    rara_ecommerce_header_note(); ?>
                </div>
            </div>
        </div><!-- header-main -->
        <?php 
        rara_ecommerce_mobile_header(); ?>
    </header>
    <?php
}
endif;
add_action( 'rara_ecommerce_header', 'rara_ecommerce_header', 10 );

if( ! function_exists( 'rara_ecommerce_content_start' ) ) :
/**
 * Content Start
 *  
*/
function rara_ecommerce_content_start(){       
    $home_sections = rara_ecommerce_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ 
        echo '<div id="content" class="site-content">'; ?>
            <div class="page-header">
                <div class="container-sm">
                <?php       
                   if ( ! is_front_page() ) rara_ecommerce_breadcrumb();
                    
                    if( is_archive() && ( rara_ecommerce_is_woocommerce_activated() && ! ( is_shop() && is_search() )) ){ 
                        if( is_author() ){ ?>
                            <div class="author-section">
                                <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 95 ); ?></figure>
                                <div class="author-content-wrap">
                                    <div class="author-title-wrap">
                                        <div class="author-name-holder">
                                            <?php 
                                                echo '<h3 class="author-name">' . esc_html( get_the_author() ) . '</h3>';
                                            ?>
                                        </div>
                                        <div class="author-content">
                                            <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
                                        </div>                                 
                                    </div>  
                                </div>
                            </div> 
                            <?php
                        }else{ 
                            the_archive_title();
                            the_archive_description( '<span class="sub-title">', '</span>' );
                        }               
                    }
                    
                    if( is_search() ){ 
                        global $wp_query;
                        echo '<div class = "search-wrapper">';
                        echo '<span>' . esc_html__( 'Search Results for', 'rara-ecommerce' ) . '</span>';
                        get_search_form();
                        echo '</div>'; 
                    }
                    
                    if( is_page() ){ 
                        the_title( '<h1 class="page-title">', '</h1>' );
                    }
                ?>
                </div>
            </div>
            <div class="container-sm">
        <?php        
        if( ! is_404() && ! rara_ecommerce_is_elementor_activated_post() ) echo '<div class="row">';

        if( is_search() ){ 
            global $wp_query;
            if( is_search() && $wp_query->found_posts > 0 ) {
                $posts_per_page = get_option( 'posts_per_page' );
                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $start_post_number = 0;
                $end_post_number   = 0;

                if( $wp_query->found_posts > 0 && !( rara_ecommerce_is_woocommerce_activated() && is_shop() ) ):                
                    $start_post_number = 1;
                    if( $wp_query->found_posts < $posts_per_page  ) {
                        $end_post_number = $wp_query->found_posts;
                    }else{
                        $end_post_number = $posts_per_page;
                    }

                    if( $paged > 1 ){
                        $start_post_number = $posts_per_page * ( $paged - 1 ) + 1;
                        if( $wp_query->found_posts < ( $posts_per_page * $paged )  ) {
                            $end_post_number = $wp_query->found_posts;
                        }else{
                            $end_post_number = $paged * $posts_per_page;
                        }
                    }

                    printf( esc_html__( '%1$s Showing: %2$s - %3$s of %4$s Articles %5$s', 'rara-ecommerce' ), '<span class="result-count">', absint( $start_post_number ), absint( $end_post_number ), esc_html( number_format_i18n( $wp_query->found_posts ) ), '</span>' );
                endif;
            }
        }
    }
}
endif;
add_action( 'rara_ecommerce_content', 'rara_ecommerce_content_start' );

if( ! function_exists( 'rara_ecommerce_entry_header' ) ) :
/**
 * Entry Header
*/
function rara_ecommerce_entry_header(){ ?>
    <header class="entry-header">
		<?php 
            $ed_cat_single  = get_theme_mod( 'ed_category', false );
            $ed_post_author = get_theme_mod( 'ed_post_author', false );
            
            if( ! is_single() && 'post' === get_post_type() ) {
                echo '<div class="entry-meta">';
                rara_ecommerce_posted_on();
                echo '</div>';
            }

            if( is_single() && 'post' === get_post_type() && ! $ed_cat_single ) {
                echo '<div class="entry-meta">';
                rara_ecommerce_category();
                echo '</div>';
            }
            
            if ( is_singular() ) :
    			the_title( '<h1 class="entry-title">', '</h1>' );
    		else :
    			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    		endif; 	

            if( is_single() && 'post' === get_post_type() ) {
                echo '<div class="entry-meta">';
                if( ! $ed_post_author) rara_ecommerce_posted_by();
                rara_ecommerce_posted_on();
                rara_ecommerce_comment_count();
                echo '</div>';
            }

		?>
	</header>         
    <?php    
}
endif;
add_action( 'rara_ecommerce_post_entry_content', 'rara_ecommerce_entry_header', 10 );
add_action( 'rara_ecommerce_before_single_post_entry_content', 'rara_ecommerce_entry_header', 10 );

if ( ! function_exists( 'rara_ecommerce_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function rara_ecommerce_post_thumbnail() {
	global $wp_query;
    $image_size = 'thumbnail';
    $sidebar    = rara_ecommerce_sidebar();
    
    if( is_home() ){        
        $image_size = ( $sidebar ) ? 'rara-ecommerce-blog-classic' : 'rara-ecommerce-blog-classic-full';
        echo '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        if( has_post_thumbnail() ){  
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
        }else{
            rara_ecommerce_get_fallback_svg( $image_size );//fallback    
        }        
        echo '</a>';
    }elseif( is_archive() || is_search() ){
        $image_size = ( $sidebar ) ? 'rara-ecommerce-blog-classic' : 'rara-ecommerce-blog-classic-full';
        echo '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        if( has_post_thumbnail() ){
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            rara_ecommerce_get_fallback_svg( $image_size );//fallback
        }
        echo '</a>';
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'rara-ecommerce-with-sidebar' : 'rara-ecommerce-fullwidth';
        if( is_single() ){
            if( has_post_thumbnail() ){
                echo '<div class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</div>';    
            }
        }else{
            if( has_post_thumbnail() ){
                echo '<div class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</div>';    
            }            
        }
    }
}
endif;
add_action( 'rara_ecommerce_before_page_entry_content', 'rara_ecommerce_post_thumbnail' );
add_action( 'rara_ecommerce_before_post_entry_content', 'rara_ecommerce_post_thumbnail', 15 );
add_action( 'rara_ecommerce_before_single_post_entry_content', 'rara_ecommerce_post_thumbnail', 10 );

if( ! function_exists( 'rara_ecommerce_entry_content' ) ) :
/**
 * Entry Content
*/
function rara_ecommerce_entry_content(){ 
    $ed_excerpt     = get_theme_mod( 'ed_excerpt', true ); 
    $ed_post_author = get_theme_mod( 'ed_post_author', false ); ?>

    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rara-ecommerce' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
    if( ! is_single() && 'post' === get_post_type() ){
        echo '<div class="entry-meta">';
        if( ! $ed_post_author ) rara_ecommerce_posted_by();
        echo '</div>';
    }
}
endif;
add_action( 'rara_ecommerce_page_entry_content', 'rara_ecommerce_entry_content', 15 );
add_action( 'rara_ecommerce_post_entry_content', 'rara_ecommerce_entry_content', 15 );
add_action( 'rara_ecommerce_before_single_post_entry_content', 'rara_ecommerce_entry_content', 15 );

if( ! function_exists( 'rara_ecommerce_entry_footer' ) ) :
/**
 * Entry Footer
*/
function rara_ecommerce_entry_footer(){ ?>
	<footer class="entry-footer">
		<?php
			if( is_single() ) rara_ecommerce_tag();

            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'rara-ecommerce' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'rara_ecommerce_page_entry_content', 'rara_ecommerce_entry_footer', 20 );
add_action( 'rara_ecommerce_post_entry_content', 'rara_ecommerce_entry_footer', 20 );
add_action( 'rara_ecommerce_before_single_post_entry_content', 'rara_ecommerce_entry_footer', 20 );

if( ! function_exists( 'rara_ecommerce_navigation' ) ) :
/**
 * Navigation
*/
function rara_ecommerce_navigation(){
    if( is_singular( 'post' ) ) {
        $next_post = get_next_post();
        $prev_post = get_previous_post();

        if( $prev_post || $next_post ) { ?>            
            <nav class="post-navigation pagination" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'rara-ecommerce' ); ?></h2>
                <div class="nav-links">
                    <?php if( $prev_post ){ ?>
                    <div class="nav-previous">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                            <span class="meta-nav"><?php esc_html_e( 'Previous', 'rara-ecommerce' ); ?></span>
                            <article class="post">
                                <header class="entry-header">
                                    <h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>
                                </header>                               
                            </article>
                        </a>                        
                    </div>
                    <?php } ?>
                    <?php if( $next_post ){ ?>
                    <div class="nav-next">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                            <span class="meta-nav"><?php esc_html_e( 'Next', 'rara-ecommerce' ); ?> </span>
                            <article class="post">
                                <header class="entry-header">
                                    <h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
                                </header>                               
                            </article>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </nav>        
            <?php
        }
    }else{            
        the_posts_pagination( array(
            'prev_text'          => __( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M152.485 396.284l19.626-19.626c4.753-4.753 4.675-12.484-.173-17.14L91.22 282H436c6.627 0 12-5.373 12-12v-28c0-6.627-5.373-12-12-12H91.22l80.717-77.518c4.849-4.656 4.927-12.387.173-17.14l-19.626-19.626c-4.686-4.686-12.284-4.686-16.971 0L3.716 247.515c-4.686 4.686-4.686 12.284 0 16.971l131.799 131.799c4.686 4.685 12.284 4.685 16.97-.001z"></path></svg>', 'rara-ecommerce' ),
            'next_text'          => __( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M295.515 115.716l-19.626 19.626c-4.753 4.753-4.675 12.484.173 17.14L356.78 230H12c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h344.78l-80.717 77.518c-4.849 4.656-4.927 12.387-.173 17.14l19.626 19.626c4.686 4.686 12.284 4.686 16.971 0l131.799-131.799c4.686-4.686 4.686-12.284 0-16.971L312.485 115.716c-4.686-4.686-12.284-4.686-16.97 0z"></path></svg>', 'rara-ecommerce' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'rara-ecommerce' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'rara_ecommerce_after_post_content', 'rara_ecommerce_navigation', 15 );
add_action( 'rara_ecommerce_after_posts_content', 'rara_ecommerce_navigation' );

if( ! function_exists( 'rara_ecommerce_author' ) ) :
/**
 * Author Section
*/
function rara_ecommerce_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_name  = get_the_author();
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
    <div class="author-section">
        <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 95 ); ?></figure>
        <div class="author-content-wrap">
            <div class="author-title-wrap">
                <div class="author-name-holder">
                <?php 
                    if( $author_name ) echo '<h3 class="author-name">' . esc_html( $author_name ) . '</h3>';
                ?>
                </div>
                <div class="author-content">
                    <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
                </div>          
            </div>   
        </div>
    </div>
    <?php
    }
}
endif;
add_action( 'rara_ecommerce_after_post_content', 'rara_ecommerce_author', 25 );

if( ! function_exists( 'rara_ecommerce_related_posts' ) ) :
/**
 * Related Posts 
*/
function rara_ecommerce_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        rara_ecommerce_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'rara_ecommerce_after_post_content', 'rara_ecommerce_related_posts', 35 );

if( ! function_exists( 'rara_ecommerce_latest_posts' ) ) :
/**
 * Latest Posts
*/
function rara_ecommerce_latest_posts(){ 
    rara_ecommerce_get_posts_list( 'latest' );
}
endif;
add_action( 'rara_ecommerce_latest_posts', 'rara_ecommerce_latest_posts' );

if( ! function_exists( 'rara_ecommerce_comment' ) ) :
/**
 * Comments Template 
*/
function rara_ecommerce_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
}
endif;
add_action( 'rara_ecommerce_after_post_content', 'rara_ecommerce_comment', 45 );
add_action( 'rara_ecommerce_after_page_content', 'rara_ecommerce_comment' );

if( ! function_exists( 'rara_ecommerce_content_end' ) ) :
/**
 * Content End
*/
function rara_ecommerce_content_end(){ 
    $home_sections = rara_ecommerce_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){     
        if( ! is_404() && !rara_ecommerce_is_elementor_activated_post() ) echo '</div><!-- .row -->'; ?>            
        </div><!-- .container/ -->        
    </div><!-- .error-holder/site-content -->
    <?php
    }
}
endif;
add_action( 'rara_ecommerce_before_footer', 'rara_ecommerce_content_end', 20 );

if( ! function_exists( 'rara_ecommerce_instagram' ) ) :
/**
 * Blossom Instagram Plugin
*/
function rara_ecommerce_instagram(){
    if( rara_ecommerce_is_btif_activated() ){
        $ed_instagram = get_theme_mod( 'ed_instagram', false );
        if( $ed_instagram ){
            echo '<div class="instagram-section">';
            echo do_shortcode( '[blossomthemes_instagram_feed]' );
            echo '</div>';    
        }
    }
}
endif;
add_action( 'rara_ecommerce_before_footer_start', 'rara_ecommerce_instagram', 10 );

if( ! function_exists( 'yith_wcwl_disable_title' ) ){
    function yith_wcwl_disable_title( $params ) {
        $params['page_title'] = '';

        return $params;
    }
    add_filter( 'yith_wcwl_wishlist_params', 'yith_wcwl_disable_title' );
}

if( ! function_exists( 'rara_ecommerce_service' ) ) :
/**
 * Service Section
*/
function rara_ecommerce_service(){
    if( is_active_sidebar( 'service' ) ){ ?>
        <section id="service_section" class="service-section">
            <div class="container-sm">
                <?php dynamic_sidebar( 'service' ); ?>
            </div>
        </section> <!-- .service-section -->
    <?php
    }
}
endif;
add_action( 'rara_ecommerce_before_footer_start', 'rara_ecommerce_service', 20 );

if( ! function_exists( 'rara_ecommerce_footer_start' ) ) :
/**
 * Footer Start
*/
function rara_ecommerce_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'rara_ecommerce_footer', 'rara_ecommerce_footer_start', 20 );

if( ! function_exists( 'rara_ecommerce_footer_top' ) ) :
/**
 * Footer Top
*/
function rara_ecommerce_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-t">
    		<div class="container-sm">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }
}
endif;
add_action( 'rara_ecommerce_footer', 'rara_ecommerce_footer_top', 30 );

if( ! function_exists( 'rara_ecommerce_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function rara_ecommerce_footer_bottom(){ 

    $footer_payment_image = get_theme_mod( 'footer_payment_image' );
    ?>
    <div class="footer-b">
		<div class="container-sm">
			<div class="site-info">            
            <?php 
                rara_ecommerce_get_footer_copyright();
                echo esc_html__( ' Rara eCommerce | Developed By ', 'rara-ecommerce' ); 
                echo '<a href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Theme', 'rara-ecommerce' ) . '</a>.';                
                printf( esc_html__( ' Powered by %s. ', 'rara-ecommerce' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'rara-ecommerce' ) ) .'" target="_blank">WordPress</a>' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
            <?php if ($footer_payment_image) { ?>      
            <div class="footer-payment-image">
                <img src="<?php echo esc_url( $footer_payment_image ); ?>">
            </div> 
            <?php } ?>
		</div>
	</div>
    <?php
}
endif;
add_action( 'rara_ecommerce_footer', 'rara_ecommerce_footer_bottom', 40 );

if( ! function_exists( 'rara_ecommerce_footer_end' ) ) :
/**
 * Footer End 
*/
function rara_ecommerce_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'rara_ecommerce_footer', 'rara_ecommerce_footer_end', 50 );

if( ! function_exists( 'rara_ecommerce_back_to_top' ) ) :
/**
 * Back to top
*/
function rara_ecommerce_back_to_top(){ ?>
    <div id="back-to-top">
		<span><i class="fas fa-long-arrow-alt-up"></i></span>
	</div>
    <?php
}
endif;
add_action( 'rara_ecommerce_after_footer', 'rara_ecommerce_back_to_top', 15 );

if( ! function_exists( 'rara_ecommerce_page_end' ) ) :
/**
 * Page End
*/
function rara_ecommerce_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'rara_ecommerce_after_footer', 'rara_ecommerce_page_end', 20 );