<?php
/**
 * Product Sale Section
 * 
 * @package Rara_eCommerce
 */
if( rara_ecommerce_is_woocommerce_activated() ) {
    global $product;
    $ed_cat_one_section = get_theme_mod( 'ed_cat_one_section', false );
    $section_title      = get_theme_mod( 'cat_one_title', __( 'Clearance Sale', 'rara-ecommerce' ) );
    $section_subtitle   = get_theme_mod( 'cat_one_description' );
    $no_of_post         = get_theme_mod( 'no_of_cat_one_post', 5 );
    $featured_image     = get_theme_mod( 'cat_one_featured_image' );
    $product_filter     = get_theme_mod( 'cat_one_filter', 'latest' );
    $cat_one_cat        = get_theme_mod( 'cat_one_cat' );
    $product_cat_filter = get_theme_mod( 'cat_one_cat_filter', 'latest' );

    $args = array(
        'post_type'      => 'product',            
        'posts_per_page' => $no_of_post
    );

    if( $product_filter == 'popular' ){
        $args['meta_key'] = 'total_sales'; 
        $args['orderby']  = 'meta_value_num';  
    }elseif( $product_filter == 'category' && $cat_one_cat ){   
        $args['tax_query'] = array(array(
                'taxonomy'          => 'product_cat',
                'terms'             => $cat_one_cat,
                'include_children'  => false,
            )); 

        if ( $product_cat_filter == 'popular' ) {
           $args['meta_key'] = 'total_sales'; 
           $args['orderby']  = 'meta_value_num';     
        }elseif( $product_cat_filter == 'sale' ){
            $args['post__in'] = wc_get_product_ids_on_sale();
        }   
    }

    $woocommerce_hide_out_of_stock_items = get_option( 'woocommerce_hide_out_of_stock_items' );
    $exclude_ids =  rara_ecommerce_get_out_of_stock_query();

    if( $woocommerce_hide_out_of_stock_items === 'yes' ){
        $args['post__not_in'] = $exclude_ids;
    }
    
    $qry_cat_one = new WP_Query( $args ); 
    
    if( $ed_cat_one_section && $qry_cat_one->have_posts() ){ ?>
        <section id="sale_section" class="product-sale-section <?php if(! $featured_image) echo 'no-image'; ?>">
            <div class="container-sm">                
                <div class="product-grid-wrapper">
                    <div class="product-sale-grid">
                        <?php if( $section_title || $section_subtitle ){ ?>
                            <div class="product-sale-wrap">  
                                <?php
                                if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '</h2>';
                                if( $section_subtitle ) echo '<div class="section-desc">' . esc_html(  $section_subtitle ) . '</div>'; 
                                ?>
                            </div>
                        <?php } ?>
                        <div class="sale-item-wrapper owl-carousel">
                            <?php
                            while( $qry_cat_one->have_posts() ){
                                $qry_cat_one->the_post(); global $product; ?>
                                <div class="item">
                                    <?php
                                    $stock = get_post_meta( get_the_ID(), '_stock_status', true );
                                                                        
                                    if( $stock == 'outofstock' ){
                                        echo '<span class="outofstock">' . esc_html__( 'Sold Out', 'rara-ecommerce' ) . '</span>';
                                    }elseif( $product->is_on_sale() ){
                                        $max_percentage ='';
                                        if ( $product->is_type( 'simple' ) ){
                                            $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
                                        }elseif( $product->is_type( 'variable' ) ){
                                            $max_percentage = 0;
                                            foreach ( $product->get_children() as $child_id ){

                                                $variation = wc_get_product( $child_id );
                                                $price     = $variation->get_regular_price();
                                                $sale      = $variation->get_sale_price();

                                                if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
                                                if ( $percentage > $max_percentage ) $max_percentage = $percentage;
                                            }
                                        }

                                        if ( $max_percentage > 0 ) echo "<span class='onsale'>-" . round($max_percentage) . "%</span>"; 
                                    }
                                    ?>                              
                                    <div class="product-sale-image">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php 
                                            if( has_post_thumbnail() ){
                                                the_post_thumbnail( 'rara-ecommerce-product-sale', array( 'itemprop' => 'image' ) );    
                                            }else{
                                                rara_ecommerce_get_fallback_svg( 'rara-ecommerce-product-sale' );
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    
                                    <?php  
                                    $product_cats_ids = wc_get_product_term_ids( get_the_ID(), 'product_cat' );

                                    foreach( $product_cats_ids as $cat_id ) {
                                        $term = get_term_by( 'id', $cat_id, 'product_cat' );

                                        if( $cat_id )echo '<span class="product-cat"><a href="' . esc_url( get_term_link( $cat_id ) ) . '">' .esc_html( $term->name ).'</a></span>';
                                    }

                                    the_title( '<div class="sec-subtitle"><a href="' . esc_url( get_permalink() ) . '">', '</a></div>' ); 
                                    echo wc_get_rating_html( $product->get_average_rating() );                               
                                    woocommerce_template_single_price(); //price                             
                                    ?>
                                </div>
                                <?php                               
                            }
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                 
                   <?php if ($featured_image) { ?>      
                    <div class="featured-image">
                        <img src="<?php echo esc_url( $featured_image ); ?>" alt="">
                    </div> 
                    <?php } ?> 
                </div>          
            </div>
        </section> 
    <?php 
    }
}