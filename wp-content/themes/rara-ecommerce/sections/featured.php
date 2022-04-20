<?php
/**
 * Feature Section
 * 
 * @package Rara_eCommerce
 */
$ed_featured_section = get_theme_mod( 'ed_featured_section', false );
$featured_cat_one    = get_theme_mod( 'cat_featured_one' );
$featured_cat_two    = get_theme_mod( 'cat_featured_two' );
$featured_cat_three  = get_theme_mod( 'cat_featured_three' );
$featured_cat_four   = get_theme_mod( 'cat_featured_four' );
$featured_cats       = array( $featured_cat_one, $featured_cat_two, $featured_cat_three, $featured_cat_four );

$ed_crop_all   = get_theme_mod( 'ed_crop_all', false );
$image_size = '';

                    
if( $ed_featured_section && rara_ecommerce_is_woocommerce_activated() && $featured_cats ){ ?>
    <section id="featured_section" class="featured-section style-four feat_cat">
		<div class="container-lg">
		<?php 
            $index = 0; 
            foreach( $featured_cats as $featured_cat ) :
            	if( !$featured_cat ) break;
            	$cat_count = get_term( $featured_cat, 'product_cat' );

		        if( $index == 0 || $index == 1 || $index == 2 ){
		        	$image_size = 'rara-ecommerce-featured';    
		        }elseif( $index == 3 ){
		        	$image_size = 'rara-ecommerce-featured-one';    
		        }

                $image_size = ( $ed_crop_all ) ? 'full' : $image_size; 
                ?>
				<div class="section-block">
                    <figure class="block-img">
                        <?php 
                            if( get_term_meta( absint( $featured_cat ), 'thumbnail_id', true ) ){
                                $image_id = get_term_meta( absint( $featured_cat ), 'thumbnail_id', true );
                                echo wp_get_attachment_image( $image_id, $image_size );
                            }else{
                            	rara_ecommerce_get_fallback_svg( $image_size );
                            }
                        ?>                                   
                    </figure>
                    <div class="block-content">
                    	<?php 
                    	$term_meta = get_term_by( 'id', $featured_cat, 'product_cat' );

                    	echo '<div class="block-title"><a href="'. esc_url( get_term_link( absint( $featured_cat ), 'product_cat' ) ) .'">' . esc_html( $term_meta->name ) . '</a></div>';

                    	echo '<div class="product-sale-count">';
                    	if ( $cat_count->count ) : ?>
                            <span class="product-count">
                                <?php printf( _n( '<span class="item-count">%s</span><span class="item-texts">product</span>', '<span class="item-count">%s</span><span class="item-texts">products</span>', $cat_count->count, 'rara-ecommerce' ), number_format_i18n( $cat_count->count ) ); ?>
                            </span>
                        <?php endif;

                        echo rara_ecommerce_onsale_product_count( $featured_cat );
                        echo '</div>'; ?>
					</div>
				</div>
			<?php
                $index++;
			endforeach; ?>
		</div>
	</section>
<?php
}    