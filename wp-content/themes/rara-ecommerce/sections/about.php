<?php
/**
 * About Section
 * 
 * @package Rara_eCommerce
 */
if( is_active_sidebar( 'about' ) ){ ?>
<section id="about_section" class="about-section">
	<div class="container-sm">
        <div class="about-shop-wrapper">
    		<?php dynamic_sidebar( 'about' ); ?>
    	</div>
    </div>
</section><!-- .about-section -->
<?php
}