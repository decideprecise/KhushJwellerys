<?php 
if( ! function_exists( 'rara_ecommerce_widget_filter' ) ) :
/**
 * Filter for Featured page widget
*/
function rara_ecommerce_widget_filter( $html, $args, $instance ){ 
    $name        = ! empty( $instance['name'] ) ? $instance['name'] : '' ;        
    $designation = ! empty( $instance['designation'] ) ? $instance['designation'] : '' ;        
    $testimonial = ! empty( $instance['testimonial'] ) ? $instance['testimonial'] : '';
    $image       = ! empty( $instance['image'] ) ? $instance['image'] : '';

    if( $image ){
        $attachment_id = $image;
        $icon_img_size = apply_filters('icon_img_size','rttk-thumb');
    }
    
    ob_start(); ?>

    <div class="rtc-testimonial-holder">
        <div class="rtc-testimonial-inner-holder">
            
            <?php if( $testimonial ) echo '<div class="testimonial-content">'.wpautop( wp_kses_post( $testimonial ) ).'</div>'; ?>

            <div class="text-holder">
                <div class="testimonial-meta">
                   <?php 
                        if( $name ) { echo '<span class="name">'. esc_html( $name ).'</span>'; }
                        if( isset( $designation ) && $designation!='' ){
                            echo '<span class="designation">'.esc_html( $designation ).'</span>';
                        }
                    ?>
                </div>   
                <?php if( $image ){ ?>
                    <div class="img-holder">
                        <?php echo wp_get_attachment_image( $attachment_id, $icon_img_size, false, array( 'alt' => esc_attr( $name ))) ;?>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>                 
    <?php    
    $html = ob_get_clean();
    wp_reset_postdata();
    return $html;
}
endif;
add_filter( 'raratheme_companion_testimonial_widget_filter', 'rara_ecommerce_widget_filter', 10, 3 );