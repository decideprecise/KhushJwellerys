<?php
/**
 * Rara eCommerce Standalone Functions.
 *
 * @package Rara_eCommerce
 */

if ( ! function_exists( 'rara_ecommerce_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function rara_ecommerce_posted_on() {
    $ed_post_date = get_theme_mod( 'ed_post_date', false );

    if( $ed_post_date ) return false;

    $ed_updated_post_date = get_theme_mod( 'ed_post_update_date', true );
    $on = '';
    
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		if( $ed_updated_post_date ){
            $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
            $on = __( 'Updated on ', 'rara-ecommerce' );		  
		}else{
            $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';  
		}        
	}else{
	   $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';   
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
    
    $posted_on = sprintf( '%1$s %2$s', esc_html( $on ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' );
	
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'rara_ecommerce_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function rara_ecommerce_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'Posted by %s', 'post author', 'rara-ecommerce' ),
		'<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url">' . esc_html( get_the_author() ) . '</a></span>' 
    );
	echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">' . $byline . '</span>';
}
endif;

if( ! function_exists( 'rara_ecommerce_comment_count' ) ) :
/**
 * Comment Count
*/
function rara_ecommerce_comment_count(){

    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments"><i class="far fa-comment"></i>';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'rara-ecommerce' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}    
}
endif;

if ( ! function_exists( 'rara_ecommerce_category' ) ) :
/**
 * Prints categories
 */
function rara_ecommerce_category(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' ', 'rara-ecommerce' ) );
		if ( $categories_list ) {
			echo '<span class="cat-links" itemprop="about">' . $categories_list . '</span>';
		}
	}
}
endif;

if ( ! function_exists( 'rara_ecommerce_tag' ) ) :
/**
 * Prints tags
 */
function rara_ecommerce_tag(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="tags" itemprop="about">' . esc_html__( '%1$sTags:%2$s %3$s', 'rara-ecommerce' ) . '</div>', '<span>', '</span>', $tags_list );
		}
	}
}
endif;

if( ! function_exists( 'rara_ecommerce_get_posts_list' ) ) :
/**
 * Returns Latest, Related & Popular Posts
*/
function rara_ecommerce_get_posts_list( $status ){
    global $post;
    
    $args = array(
        'post_type'           => 'post',
        'posts_status'        => 'publish',
        'ignore_sticky_posts' => true
    );
    
    switch( $status ){
        case 'latest':        
        $args['posts_per_page'] = 3;
        $title                  = __( 'Latest Posts', 'rara-ecommerce' );
        $class                  = 'recent-posts';
        break;
        
        case 'related':
        $args['posts_per_page'] = 3;
        $args['post__not_in']   = array( $post->ID );
        $args['orderby']        = 'rand';
        $title                  = get_theme_mod( 'related_post_title', __( 'You may also like...', 'rara-ecommerce' ) );
        $class                  = 'related-posts';
        
        $cats = get_the_category( $post->ID );        
        if( $cats ){
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id; 
            }
            $args['category__in'] = $c;
        }
        break;        
    }
    
    $qry = new WP_Query( $args );
    
    if( $qry->have_posts() ){ ?>    
        <div class="<?php echo esc_attr( $class ); ?>">
            <?php if( $title ) echo '<h2 class="title">' . esc_html( $title ) . '</h2>'; ?>
            <div class="post-wrapper">
    			<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <article class="post">
        				<a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'rara-ecommerce-recent', array( 'itemprop' => 'image' ) );
                                }else{ 
                                    rara_ecommerce_get_fallback_svg( 'rara-ecommerce-recent' );//fallback
                                }
                            ?>
                        </a>
        				<header class="entry-header">
        					<?php
                                the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                            ?>                        
        				</header>
        			</article>
    			<?php }?>   
            </div> 		
    	</div>
        <?php
        wp_reset_postdata();
    }
}
endif;

if( ! function_exists( 'rara_ecommerce_site_branding' ) ) :
/**
 * Site Branding
*/
function rara_ecommerce_site_branding( $mobile = false ){ ?>
    <div class="site-branding" itemscope itemtype="http://schema.org/Organization">
		<?php 
        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
            the_custom_logo();
        } 
        
        if( is_front_page() && ! $mobile ){ ?>
            <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
            <?php 
        }else{ ?>
            <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
        <?php
        }
            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ){ ?>
                <p class="site-description" itemprop="description"><?php echo $description; ?></p>
            <?php

            }
        ?>
	</div>    
    <?php
}
endif;

if( ! function_exists( 'rara_ecommerce_top_bar' ) ) :
/**
 * Top bar
*/
function rara_ecommerce_top_bar(){
    $phone_label        = get_theme_mod( 'phone_label' );
    $phone              = get_theme_mod( 'phone' );
    $ed_social_links    = get_theme_mod( 'ed_social_links', false );

    if( $phone_label || $phone || $ed_social_links ) { ?>
        <div class="header-t">
            <div class="container-sm">
                <div class="details">
                    <?php 
                    if( ! wp_is_mobile() && ( $phone_label || $phone ) ) {
                        echo '<div class="content"><span class="phn-lbl">'.esc_html( $phone_label ).''.'</span>';
                        echo '<a href="'. esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ).'">'. esc_html( $phone ).'</a>';
                        echo '</div>';                            
                    } 

                    if( $ed_social_links ) {
                        echo '<div class="right">';
                            if( $ed_social_links){
                                echo '<div class="socio-wrap">';
                                rara_ecommerce_social_links();
                                echo '</div>';
                            }
                        echo '</div>';
                    } ?>
                </div>
            </div>
        </div><!-- Header-top -->
        <?php 
    }
}
endif;

if( ! function_exists( 'rara_ecommerce_header_note' ) ) :
/**
 * Header Note
*/
function rara_ecommerce_header_note(){
    $header_note = get_theme_mod( 'header_note' );

    echo '<div class="shipping-cost">'. esc_html( $header_note ) .'</div>';
}
endif;

if( ! function_exists( 'rara_ecommerce_mobile_header' ) ) :
/**
 * Mobile Header
*/
function rara_ecommerce_mobile_header(){ 
    $ed_cart               = get_theme_mod( 'ed_shopping_cart', true );
    $phone_label           = get_theme_mod( 'phone_label' );
    $phone                 = get_theme_mod( 'phone' );
    $ed_social_links       = get_theme_mod( 'ed_social_links', false );
    ?>
    <div class="mobile-header">
        <?php 
        if( $phone_label && $phone ) {
            echo '<div class="content">'.esc_html( $phone_label ).'';
            echo '<a href="'. esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ).'">'. esc_html( $phone ).'</a>';
            echo '</div>';                            
        }
        ?>
        <div class="container-sm">
            <?php  
            echo '<div class="mobile-site-wrap">';
                ?>
                <button type="button" class="toggle-btn mobile-menu-opener" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                    <span class="toggle-bar"></span>
                </button>
                <?php
                rara_ecommerce_site_branding( true ); 
                if( rara_ecommerce_is_woocommerce_activated() && $ed_cart ) {
                    echo '<div class="header-cart">';
                    rara_ecommerce_wc_cart_count();
                    echo '</div>';
                } 
            echo '</div>'; ?>
            
            <div class="mobile-header-popup">                
                <div class="mbl-header-inner">
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                        <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'rara-ecommerce' ); ?>">
                            <button class="btn-close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal">
                            <span></span>
                            <span></span>
                            <span></span>

                            </button>
                            <?php 
                                if( $phone_label && $phone ) {
                                    echo '<div class="content">'.esc_html( $phone_label ).'';
                                    echo '<a href="'. esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ).'">'. esc_html( $phone ).'</a>';
                                    echo '</div>';                            
                                }
                            ?>
                            <div class="mbl-header-top container-sm">
                                <?php  
                                rara_ecommerce_site_branding( true ); 
                                if( rara_ecommerce_is_woocommerce_activated() && $ed_cart ) {
                                    echo '<div class="header-cart">';
                                    rara_ecommerce_wc_cart_count();
                                    echo '</div>';
                                } 
                                ?>
                            </div>
                            <div class="mbl-wrapper">
                                <div class="mbl-header-mid">
                                    <?php 
                                    get_search_form();
                                    rara_ecommerce_primary_nagivation(); ?>
                                </div>
                                <div class="mbl-header-right">
                                    <?php 
                                        rara_ecommerce_user_block();
                                        rara_ecommerce_favourite_block(); 
                                        rara_ecommerce_top_bar();
                                    ?>
                                </div>
                                <div class="mbl-switcher">
                                    <?php
                                    if( $ed_social_links ) {
                                        echo '<div class="right">';
                                            echo '<div class="socio-wrap">';
                                            rara_ecommerce_social_links();
                                            echo '</div>';
                                        echo '</div>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <?php
}
endif;

if( ! function_exists( 'rara_ecommerce_social_links' ) ) :
/**
 * Social Links 
*/
function rara_ecommerce_social_links( $echo = true ){ 
    $ed_social    = get_theme_mod( 'ed_social_links', false ); 
    $social_links = get_theme_mod( 'social_links' );
    
    if( $ed_social && $social_links && $echo ){ ?>
    <ul class="social-networks">
    	<?php 
        foreach( $social_links as $link ){
    	   if( $link['link'] ){ ?>
            <li>
                <a href="<?php echo esc_url( $link['link'] ); ?>" target="_blank" rel="nofollow noopener">
                    <i class="<?php echo esc_attr( $link['font'] ); ?>"></i>
                </a>
            </li>    	   
            <?php
            } 
        } 
        ?>
	</ul>
    <?php    
    }elseif( $ed_social && $social_links ){
        return true;
    }else{
        return false;
    }
    ?>
    <?php                                
}
endif;

if( ! function_exists( 'rara_ecommerce_primary_nagivation' ) ) :
/**
 * Primary Navigation.
*/
function rara_ecommerce_primary_nagivation(){ 
    
    if( current_user_can( 'manage_options' ) || has_nav_menu( 'primary' ) ) { ?>
        <nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'fallback_cb'    => 'rara_ecommerce_primary_menu_fallback',
                ) );
            ?>
        </nav><!-- #site-navigation -->
    <?php
    }
}
endif;

if( ! function_exists( 'rara_ecommerce_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function rara_ecommerce_primary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'rara-ecommerce' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'rara_ecommerce_breadcrumb' ) ) :
/**
 * Breadcrumbs
*/
function rara_ecommerce_breadcrumb(){ 
    global $post;
    $post_page  = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front = get_option( 'show_on_front' ); //What to show on the front page    
    $home       = get_theme_mod( 'home_text', __( 'Home', 'rara-ecommerce' ) ); // text for the 'Home' link
    $delimiter  = '<span class="separator"> / </span>';
    $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after      = '</span>'; // tag after the current crumb
    
    if( get_theme_mod( 'ed_breadcrumb', true ) ){
        $depth = 1;
        echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="' . esc_url( home_url() ) . '" itemprop="item"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
        
        if( is_home() ){ 
            $depth = 2;                       
            echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;            
        }elseif( is_category() ){  
            $depth = 2;          
            $thisCat = get_category( get_query_var( 'cat' ), false );            
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;  
            }            
            if( $thisCat->parent != 0 ){
                $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                $parent_categories = explode( ',', $parent_categories );
                foreach( $parent_categories as $parent_term ){
                    $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                    if( is_object( $parent_obj ) ){
                        $term_url  = get_term_link( $parent_obj->term_id );
                        $term_name = $parent_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $thisCat->term_id) ) . '"><span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;       
        }elseif( rara_ecommerce_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ //For Woocommerce archive page
            $depth = 2;
            $current_term = $GLOBALS['wp_query']->get_queried_object();            
            if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                if ( ! $_name ) {
                    $product_post_type = get_post_type_object( 'product' );
                    $_name = $product_post_type->labels->singular_name;
                }
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            if( is_product_category() ){
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'product_cat' );    
                    if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $current_term->term_id ) ) . '"><span itemprop="name">' . esc_html( $current_term->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( rara_ecommerce_is_woocommerce_activated() && is_shop() ){ //Shop Archive page
            $depth = 2;
            if( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ){
                return;
            }
            $_name    = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
            $shop_url = ( wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0 )  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
            if( ! $_name ){
                $product_post_type = get_post_type_object( 'product' );
                $_name             = $product_post_type->labels->singular_name;
            }
            echo $before . '<a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_tag() ){ 
            $depth          = 2;
            $queried_object = get_queried_object();
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />'. $after;
        }elseif( is_author() ){  
            global $author;
            $depth    = 2;
            $userdata = get_userdata( $author );
            echo $before . '<a itemprop="item" href="' . esc_url( get_author_posts_url( $author ) ) . '"><span itemprop="name">' . esc_html( $userdata->display_name ) .'</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;     
        }elseif( is_search() ){ 
            $depth       = 2;
            $request_uri = $_SERVER['REQUEST_URI'];
            echo $before . '<a itemprop="item" href="'. esc_url( $request_uri ) . '"><span itemprop="name">' . sprintf( __( 'Search Results for "%s"', 'rara-ecommerce' ), esc_html( get_search_query() ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_day() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ), get_the_time( __( 'm', 'rara-ecommerce' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'rara-ecommerce' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ), get_the_time( __( 'm', 'rara-ecommerce' ) ), get_the_time( __( 'd', 'rara-ecommerce' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'd', 'rara-ecommerce' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_month() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ), get_the_time( __( 'm', 'rara-ecommerce' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'rara-ecommerce' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_year() ){ 
            $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'rara-ecommerce' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
        }elseif( is_single() && !is_attachment() || rara_ecommerce_is_elementor_activated() ){   
            $depth = 2;         
            if( rara_ecommerce_is_woocommerce_activated() && 'product' === get_post_type() ){ //For Woocommerce single product
                if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;                    
                }           
                if( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ){
                    $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;
                }
                echo $before . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
            }elseif( is_404() ){ 
                $depth = 2;
                echo $before . '<a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . esc_html__( '404 Error - Page Not Found', 'rara-ecommerce' ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
            }elseif( get_post_type() != 'post' ){               
                $post_type = get_post_type_object( get_post_type() );                
                if( $post_type->has_archive == true ){// For CPT Archive Link                   
                   // Add support for a non-standard label of 'archive_title' (special use case).
                   $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                   echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';
                   $depth++;    
                }
                echo $before . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
            }else{ //For Post                
                $cat_object       = get_the_category();
                $potential_parent = 0;
                
                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';  
                    $depth++; 
                }
                
                if( $cat_object ){ //Getting category hierarchy if any        
                    //Now try to find the deepest term of those that we know of
                    $use_term = key( $cat_object );
                    foreach( $cat_object as $key => $object ){
                        //Can't use the next($cat_object) trick since order is unknown
                        if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                            $use_term         = $key;
                            $potential_parent = $object->term_id;
                        }
                    }                    
                    $cat  = $cat_object[$use_term];              
                    $cats = get_category_parents( $cat, false, ',' );
                    $cats = explode( ',', $cats );
                    foreach ( $cats as $cat ) {
                        $cat_obj = get_term_by( 'name', $cat, 'category' );
                        if( is_object( $cat_obj ) ){
                            $term_url  = get_term_link( $cat_obj->term_id );
                            $term_name = $cat_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;   
            }        
        }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){ //For Custom Post Archive
            $depth     = 2;
            $post_type = get_post_type_object( get_post_type() );
            if( get_query_var('paged') ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '/</span>';
                echo $before . sprintf( __('Page %s', 'rara-ecommerce'), get_query_var('paged') ) . $after; 
            }else{
                echo $before . '<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
            }    
        }elseif( is_attachment() ){ 
            $depth = 2;           
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && !$post->post_parent ){            
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && $post->post_parent ){            
            $depth       = 2;
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while( $parent_id ){
                $current_page  = get_post( $parent_id );
                $breadcrumbs[] = $current_page->ID;
                $parent_id     = $current_page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            echo $before . '<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></span>' . $after;
        }
        
        if( get_query_var('paged') ) printf( __( ' (Page %s)', 'rara-ecommerce' ), get_query_var('paged') );
        
        echo '</div><!-- .crumbs -->';
        
    }                
}
endif;

if( ! function_exists( 'rara_ecommerce_theme_comment' ) ) :
/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
function rara_ecommerce_theme_comment( $comment, $args, $depth ){
    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    
    <?php if ( 'div' != $args['style'] ) : ?>
    <article id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
    <?php endif; ?>
        
        <footer class="comment-meta">
            <div class="comment-author vcard">
               <?php if ( $args['avatar_size'] != 0 ) get_avatar( $comment, $args['avatar_size'] ); ?>
            </div>
        </footer>
        <div class="comment-metadata commentmetadata">
            <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b> <span class="says">says:</span>', 'rara-ecommerce' ), get_comment_author_link() ); ?>
            <div class="time-wrap">
                <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
                <time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'rara-ecommerce' ), get_comment_date(),  get_comment_time() ); ?></time>
                </a>
            </div>
            <div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>
            <div class="reply">
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) )  ;?>
            </div> 
           
        </div>
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'rara-ecommerce' ); ?></p>
            <br />
        <?php endif; ?>
               
    <?php if ( 'div' != $args['style'] ) : ?>
    </article><!-- .comment-body -->
    <?php endif; ?>
    
<?php
}
endif;

if( ! function_exists( 'rara_ecommerce_sidebar' ) ) :
/**
 * Return sidebar layouts for pages/posts
*/
function rara_ecommerce_sidebar( $class = false ){
    global $post;
    $return = false;
    $page_layout = get_theme_mod( 'page_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Pages
    $post_layout = get_theme_mod( 'post_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Posts
    $layout      = get_theme_mod( 'layout_style', 'right-sidebar' ); //Default Layout Style for Styling Settings
    
    if( is_singular( array( 'page', 'post' ) ) ){         
        if( get_post_meta( $post->ID, '_rara_ecommerce_sidebar_layout', true ) ){
            $sidebar_layout = get_post_meta( $post->ID, '_rara_ecommerce_sidebar_layout', true );
        }else{
            $sidebar_layout = 'default-sidebar';
        }
        
        if( is_page() ){
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'centered' ) ){
                    $return = $class ? 'full-width centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }elseif( is_single() ){
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'centered' ) ){
                    $return = $class ? 'full-width centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }
    }elseif( rara_ecommerce_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || get_post_type() == 'product' ) ){
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'shop-sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'shop-sidebar';
            }         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }elseif( is_404() ){
        $return = $class ? 'full-width' : false;
    }else{
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'sidebar';    
            }                         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }    
    return $return; 
}
endif;

if( ! function_exists( 'rara_ecommerce_get_posts' ) ) :
/**
 * Fuction to list Custom Post Type
*/
function rara_ecommerce_get_posts( $post_type = 'post', $slug = false ){    
    $args = array(
    	'posts_per_page'   => -1,
    	'post_type'        => $post_type,
    	'post_status'      => 'publish',
    	'suppress_filters' => true 
    );
    $posts_array = get_posts( $args );
    
    // Initate an empty array
    $post_options = array();
    $post_options[''] = __( ' -- Choose -- ', 'rara-ecommerce' );
    if ( ! empty( $posts_array ) ) {
        foreach ( $posts_array as $posts ) {
            if( $slug ){
                $post_options[ $posts->post_title ] = $posts->post_title;
            }else{
                $post_options[ $posts->ID ] = $posts->post_title;    
            }
        }
    }
    return $post_options;
    wp_reset_postdata();
}
endif;

if( ! function_exists( 'rara_ecommerce_get_categories' ) ) :
/**
 * Function to list post categories in customizer options
*/
function rara_ecommerce_get_categories( $select = true, $taxonomy = 'category', $slug = false ){    
    /* Option list of all categories */
    $categories = array();
    
    $args = array( 
        'hide_empty' => false,
        'taxonomy'   => $taxonomy 
    );
    
    $catlists = get_terms( $args );
    if( $select ) $categories[''] = __( 'Choose Category', 'rara-ecommerce' );
    if ( $catlists ) {
        foreach( $catlists as $category ){
            if( $slug ){
                $categories[$category->slug] = $category->name;
            }else{
                $categories[$category->term_id] = $category->name;    
            }        
        }
    }
    
    return $categories;
}
endif;

if( ! function_exists( 'rara_ecommerce_get_home_sections' ) ) :
/**
 * Returns Home Sections 
*/
function rara_ecommerce_get_home_sections(){
    $ed_banner = get_theme_mod( 'ed_banner_section', 'static_banner' );

    $sections = array( 
        'about'       => array( 'sidebar' => 'about' ),
        'featured'    => array( 'section' => 'featured' ),
        'cat_one'     => array( 'section' => 'cat_one' ),
        'testimonial' => array( 'sidebar' => 'testimonial' ),
        'blog'        => array( 'section' => 'blog' ), 
    );
    
    $enabled_section = array();
    
    if( $ed_banner == 'static_banner' || $ed_banner == 'slider_banner' || ( rara_ecommerce_is_woocommerce_activated() && $ed_banner == 'static_category' ) ) array_push( $enabled_section, 'banner' );
    
    foreach( $sections as $k => $v ){
        if( array_key_exists( 'sidebar', $v ) ){
            if( is_active_sidebar( $v['sidebar'] ) ) array_push( $enabled_section, $v['sidebar'] );
        }else{
            if( get_theme_mod( 'ed_' . $v['section'] . '_section', false ) ) array_push( $enabled_section, $v['section'] );
        }
    }  
    
    return apply_filters( 'rara_ecommerce_home_sections', $enabled_section );
}
endif;

if( ! function_exists( 'rara_ecommerce_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function rara_ecommerce_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'rara_ecommerce_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function rara_ecommerce_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size    = rara_ecommerce_get_image_sizes( $post_thumbnail );
    $primary_color = get_theme_mod( 'primary_color', '#C4B583' );

    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:<?php echo rara_ecommerce_sanitize_hex_color( $primary_color );?>;opacity:0.1;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

/**
 * Is BlossomThemes Social Feed active or not
*/
function rara_ecommerce_is_btif_activated(){
    return class_exists( 'Blossomthemes_Instagram_Feed' ) ? true : false;
}

/**
 * Query WooCommerce activation
 */
function rara_ecommerce_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

/**
 * Checks if classic editor is active or not
*/
function rara_ecommerce_is_classic_editor_activated(){
    return class_exists( 'Classic_Editor' ) ? true : false; 
}

/**
 * Is RaraTheme Companion active or not
*/
function rara_ecommerce_is_rtc_activated(){
    return class_exists( 'RaraTheme_Companion' ) ? true : false;        
}

/**
 * Query Jetpack activation
*/
function rara_ecommerce_is_jetpack_activated( $gallery = false ){
	if( $gallery ){
        return ( class_exists( 'jetpack' ) && Jetpack::is_module_active( 'tiled-gallery' ) ) ? true : false;
	}else{
        return class_exists( 'jetpack' ) ? true : false;
    }           
}

/**
 * Query Yith activation
 */
function rara_ecommerce_is_yith_whislist_activated() {
    return class_exists( 'YITH_WCWL' ) ? true : false;
}

/**
 * Checks if elementor is active or not
*/
function rara_ecommerce_is_elementor_activated(){
    return class_exists( 'Elementor\\Plugin' ) ? true : false; 
}

if( ! function_exists( 'rara_ecommerce_elementor' ) ) :
/**
 * Before wp_head 
*/
function rara_ecommerce_elementor(){ 
    if( rara_ecommerce_is_elementor_activated() ){
    
        /**Disable Default Colours and Default Fonts of elementor on Theme Activation*/

        $fresh        = get_option( 'rara_ecommerce_flag' );
        if( ! $fresh ){
            update_option('elementor_disable_color_schemes', 'yes');
            update_option('elementor_disable_typography_schemes', 'yes');
            update_option( 'rara_ecommerce_flag', true ); 
        }
    }
}
endif;
add_action( 'after_setup_theme', 'rara_ecommerce_elementor' );

/**
 * Checks if elementor has override that particular page/post or not
*/
function rara_ecommerce_is_elementor_activated_post(){
    if( rara_ecommerce_is_elementor_activated() ){
        global $post;
        $post_id = $post->ID;
        return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id ) ? true : false;
    }else{
        return false;
    }
}

if( ! function_exists( 'rara_ecommerce_favourite_block' ) ) :
/**
 * Header favourite Block
*/
function rara_ecommerce_favourite_block(){ 
    if( rara_ecommerce_is_woocommerce_activated() && rara_ecommerce_is_yith_whislist_activated() ) : 
        $whislist_url = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
        $ed_whislist  = get_theme_mod( 'ed_whislist', true );
        if( $ed_whislist && $whislist_url ) : ?> 
            <div class="favourite-block">
                <a href="<?php echo esc_url( get_permalink( $whislist_url ) ); ?>" class="favourite" title="<?php esc_attr_e( 'View your favourite cart', 'rara-ecommerce' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15"><path d="M15.719,9.545A4.339,4.339,0,0,0,12.14,6.413a4.669,4.669,0,0,0-.815-.064,4.374,4.374,0,0,0-3.34,1.6c-.016.016-.032.048-.048.064A7.419,7.419,0,0,0,7.315,7.4,4.353,4.353,0,0,0,4.47,6.349,4.459,4.459,0,0,0,.076,9.784a5.4,5.4,0,0,0,.7,4.17,13.563,13.563,0,0,0,2.573,3A27.341,27.341,0,0,0,7.826,20.25a.182.182,0,0,0,.128.048.232.232,0,0,0,.112-.032A27.657,27.657,0,0,0,13.53,16a9.646,9.646,0,0,0,1.933-2.732A4.722,4.722,0,0,0,15.9,11.8a.227.227,0,0,1,.032-.1V10.424C15.863,10.128,15.8,9.832,15.719,9.545Zm-.92,2a.352.352,0,0,0-.016.128,3.568,3.568,0,0,1-.336,1.134,8.5,8.5,0,0,1-1.742,2.413A24.928,24.928,0,0,1,7.944,19a27.921,27.921,0,0,1-3.835-2.876,12.246,12.246,0,0,1-2.365-2.764,4.314,4.314,0,0,1-.559-3.34A3.362,3.362,0,0,1,4.493,7.451a3.234,3.234,0,0,1,2.125.783c.112.1.224.208.352.336a2.857,2.857,0,0,1,.208.224l.959.959.751-1.119a3.19,3.19,0,0,1,2.461-1.182,4.092,4.092,0,0,1,.623.048A3.22,3.22,0,0,1,14.687,9.88a2.023,2.023,0,0,1,.1.447c.016.064.016.128.032.192v1.023Z" transform="translate(0.073 -6.349)"></path></svg>
                </a>
                <span class="count"><?php echo yith_wcwl_count_products(); ?></span>
            </div>
            <?php
        endif; 
    endif; 
}
endif;

if( ! function_exists( 'rara_ecommerce_user_block' ) ) :
/**
 * Header User Block
*/
function rara_ecommerce_user_block(){ 
    $ed_user = get_theme_mod( 'ed_user_login', true ); 

    if( $ed_user && rara_ecommerce_is_woocommerce_activated() && wc_get_page_id( 'myaccount' ) ) : 
        ?>
        <div class="user-block">
            <a href="<?php the_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(3.52)"><path d="M29.571,13.853a4.427,4.427,0,1,1,4.471-4.427A4.461,4.461,0,0,1,29.571,13.853Zm0-7.609a3.182,3.182,0,1,0,3.214,3.182A3.2,3.2,0,0,0,29.571,6.244Z" transform="translate(-25.1 -5)"></path></g><g transform="translate(0 9.173)"><path d="M21.5,63.427H20.243c0-3.076-3.017-5.582-6.734-5.582s-6.752,2.507-6.752,5.582H5.5c0-3.769,3.591-6.827,8.009-6.827S21.5,59.658,21.5,63.427Z" transform="translate(-5.5 -56.6)"></path></g></svg>
            </a>
            <?php if ( is_user_logged_in() && ! wp_is_mobile() ): ?>
                <div class="user-block-popup">
                    <?php
                    $orders             = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
                    $edit_account       = get_option( 'woocommerce_myaccount_edit_account_endpoint', 'edit-account' );
                    $customer_logout    = get_option( 'woocommerce_logout_endpoint', 'customer-logout' );

                    ?>
                    <?php if( $orders ) : ?> <li><a class="user-order" href="<?php echo esc_url( wc_get_account_endpoint_url( $orders ) ); ?>"><?php esc_html_e( 'My Orders','rara-ecommerce' ); ?></a></li><?php endif; ?>
                    <?php if( $edit_account ) : ?><li><a class="user-account-edit" href="<?php echo esc_url( wc_get_account_endpoint_url( $edit_account ) ); ?>"><?php esc_html_e( 'Edit Account','rara-ecommerce' ); ?></a></li><?php endif; ?>
                    <?php if( $customer_logout ) : ?><li><a class="user-account-log" href="<?php echo esc_url( wc_get_account_endpoint_url( $customer_logout ) ); ?>"><?php esc_html_e( 'Logout','rara-ecommerce' ); ?></a></li><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    endif; 
}
endif;