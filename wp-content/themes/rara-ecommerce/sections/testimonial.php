<?php
/**
 * Testimonial Section
 * 
 * @package Rara_eCommerce
 */
$ed_testimonial_section = get_theme_mod( 'ed_testimonial_section', false );
$testimonial_title      = get_theme_mod( 'testimonial_title', __( 'The Story', 'rara-ecommerce' ) );
$testimonial_image      = get_theme_mod( 'testimonial_featured_image' );

if( $ed_testimonial_section && is_active_sidebar( 'testimonial' ) ){ ?>
<section id="testimonial_section" class="testimonial-section">
	<div class="container-lg">
		<div class="testimonial-wrapper">
			<div class="container-sm<?php if( !$testimonial_image ) echo ' no-image'; ?>">
	
				<?php 
				if ( $testimonial_image ) {
					echo '<div class="testimonial-image-wrapper">';
					echo '<img src="'. esc_url( $testimonial_image ).'" alt="">';
					echo '</div>';
				}
				echo '<div class="testimonial-wrap">';					
					if( $testimonial_title ) echo '<h2 class="section-title">' . esc_html( $testimonial_title ) . '</h2>';

					echo '<div class="section-grid">';
						dynamic_sidebar( 'testimonial' ); 
					echo '</div>';
				echo '</div>';
				?>
    		</div>
    	</div>
    </div>
</section> <!-- .testimonial-section -->
<?php
}