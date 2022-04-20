<?php
/**
 * Banner Section
 * 
 * @package Rara_eCommerce
 */

$ed_banner          = get_theme_mod( 'ed_banner_section', 'static_banner' );
$slider_type        = get_theme_mod( 'slider_type', 'latest_posts' ); 
$slider_cat         = get_theme_mod( 'slider_cat' );
$slider_cat_product = get_theme_mod( 'slider_cat_product' );
$banner_cat_product = get_theme_mod( 'banner_cat_product', '' );
$posts_per_page     = get_theme_mod( 'no_of_slides', 3 );
$ed_caption         = get_theme_mod( 'slider_caption', true );
$banner_title       = get_theme_mod( 'banner_title', __( 'BEST SEASON SALES', 'rara-ecommerce' ) );
$banner_subtitle    = get_theme_mod( 'banner_subtitle', __( 'BIGGEST SALES', 'rara-ecommerce' ) );
$banner_label       = get_theme_mod( 'banner_label', __( 'SHOP NOW', 'rara-ecommerce' ) );
$banner_link        = get_theme_mod( 'banner_link', '#' );
$product_cat_label  = get_theme_mod( 'product_cat_label', __( 'Shop Now', 'rara-ecommerce' ) );
$banner_caption     = get_theme_mod( 'banner_caption_layout', 'left' );
$banner_overlay     = get_theme_mod( 'banner_overlay', true );
       
if( $ed_banner == 'static_banner' && has_custom_header() ){ 
    if( has_header_video() ) {
        $custom_header_class = esc_attr(' video-banner' );
    }else{
        $custom_header_class = esc_attr(' static-banner' );
    } ?>
    <div id="banner_section" class="site-banner <?php echo esc_attr( $banner_caption ); ?><?php echo $custom_header_class; ?><?php if( $ed_banner == 'static_banner' ) echo ' static-cta'; ?><?php if( $ed_banner == 'static_banner' && $banner_overlay ) echo ' has-static-overlay'; ?>">
        <?php 
            the_custom_header_markup(); 
            if( $ed_banner == 'static_banner' && ( $banner_title || $banner_subtitle || ( $banner_label && $banner_link ) ) ){
                echo '<div class="container-sm ' . esc_attr( $banner_caption ) . '"><div class=" banner-caption">';
                if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '</h2>';
                if( $banner_subtitle ) echo '<div class="banner-desc">' . esc_html( $banner_subtitle ) . '</div>';
                if( $banner_label && $banner_link ) echo '<div class="button-wrap"><a class="primary-btn" href="' . esc_url( $banner_link ) . '">' . esc_html( $banner_label ) . '</a></div>';
                echo '</div></div>';
            }
        ?>
    </div>
<?php
}elseif( $ed_banner == 'slider_banner' ){
    if( $slider_type == 'latest_posts' || $slider_type == 'cat' || $slider_type == 'pages' || ( rara_ecommerce_is_woocommerce_activated() && ( $slider_type == 'latest_products' || $slider_type == 'cat_products' ) ) ){
        $args = array(            
            'ignore_sticky_posts' => true
        );
        
        if( $slider_type == 'cat_products' && $slider_cat_product ) {
            $args['post_type']      = 'product';
            $args['tax_query']      = array( array( 'taxonomy' => 'product_cat', 'terms' => $slider_cat_product ) ); 
            $args['posts_per_page'] = -1;
        }elseif( $slider_type == 'latest_products' ){
            $args['post_type']      = 'product';
            $args['posts_per_page'] = $posts_per_page;          
        }elseif( $slider_type === 'cat' && $slider_cat ){
            $args['post_type']      = 'post';
            $args['cat']            = $slider_cat; 
            $args['posts_per_page'] = -1;  
        }else{
            $args['post_type']      = 'post';
            $args['posts_per_page'] = $posts_per_page;
        }
            
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() ){ ?>
            <div id="banner_section" class="site-banner banner-one">
                <div class="item-wrap owl-carousel">            
                    <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <div class="item <?php echo esc_attr( $banner_caption ); ?>">
                        <?php 
                        if( has_post_thumbnail() ){
                            the_post_thumbnail( 'rara-ecommerce-slider', array( 'itemprop' => 'image' ) );    
                        }else{ 
                            rara_ecommerce_get_fallback_svg( 'rara-ecommerce-slider' );//fallback
                        }
                        if( $ed_caption ){ ?>                        
                        <div class="banner-caption">
                            <div class="container">
                                <div class="text-holder">
                                    <?php
                                        rara_ecommerce_category();
                                        the_title( '<h2 class="banner-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php
        wp_reset_postdata();
        }
    
    }
}elseif( $ed_banner == 'static_category' && ! empty( $banner_cat_product ) ){
        
    $args = array(
        'taxonomy'   => 'product_cat',
        'include'    => $banner_cat_product,
        'hide_empty' => false,
        'number'     => 3
    );

    $terms = get_terms( $args );

    if( $terms ) :
        ?>
        <div id="banner_section" class="site-banner banner-cat-one<?php if( $banner_overlay ) echo ' banner-cat-overlay'; ?>">
            <div class="container-sm">
                <div class="item-wrap"> 
                    <?php
                    $i = 0;
                    foreach( $terms as $t ){
                        $i++;
                        if( $i == 2 && ! wp_is_mobile() ) echo '<div class="grid-wrap">'; ?>
                        <div class="item <?php echo esc_attr( $banner_caption ); ?>">
                            <div class="item-wrapper">
                                <?php 
                                $thumbnail_id = get_term_meta( $t->term_id, 'thumbnail_id', true ); 
                                $image = wp_get_attachment_url( $thumbnail_id ); 

                                if( $image ){
                                    echo '<img src="'.esc_url( $image ).'" alt="">';   
                                }else{ 
                                    rara_ecommerce_get_fallback_svg( 'rara-ecommerce-banner-cat-one' );//fallback
                                }
                        
                                if( $ed_caption ){ ?>                        
                                <div class="banner-caption">
                                    <div class="container">
                                        <div class="text-holder">
                                            <?php
                                            echo '<h2 class="banner-title"><a href="'. esc_url( get_term_link($t->slug, 'product_cat' ) ) .'" rel="bookmark">'.esc_html( $t->name ).'</a></h2>';
                                            if( !empty( $t->description ) ) echo '<p>'. esc_html( $t->description ).'</p>';
                                            if( $product_cat_label ) echo '<div class="button-wrap"><a href="' . esc_url( get_term_link($t->slug, 'product_cat' ) ) . '" class="btn-readmore">' . esc_html( $product_cat_label ) . '</a></div>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php 
                        if( $i == 3 && ! wp_is_mobile() ) echo '</div>';                        
                    } ?>
                </div>
            </div>
        </div>
    <?php endif;

}