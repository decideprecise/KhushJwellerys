<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after
 * 
 */
?>

		<footer id="colophon" class="site-footer footer-text" role="contentinfo" >
		
		<div class="container">
		<div class="row">
		
		<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'business-ecommerce' ); ?>">
			<?php
			if ( is_active_sidebar( 'footer-sidebar-1' ) ) {
			?>
				<div class="col-md-3 col-sm-3 footer-widget">
					<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
				</div>
			<?php
			}
			if ( is_active_sidebar( 'footer-sidebar-2' ) ) {
			?>
				<div class="col-md-3 col-sm-3 footer-widget">
					<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
				</div>			
			<?php
			}
			if ( is_active_sidebar( 'footer-sidebar-3' ) ) {
			?>
				<div class="col-md-3 col-sm-3 footer-widget">
					<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
				</div>
			<?php
			}
			if ( is_active_sidebar( 'footer-sidebar-4' ) ) {
			?>
				<div class="col-md-3 col-sm-3 footer-widget">
					<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
				</div>
			<?php }	?>
		</aside><!-- .widget-area -->
		
		</div>
		
		<div class="footer-info">
					
		
			<div class="row footer-social-menu">		
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'business-ecommerce' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>',
								)
							);
						?>
					</nav><!-- .social-navigation -->
					<?php endif; ?>			
			</div>
			
			<div class="row">
				<div class="site-info">
						<a href='https://wpbusinessthemes.com/'>
						<?php 
							echo wp_kses_post(get_theme_mod('footer_text', esc_html__('Copyright ...', 'business-ecommerce')).__(' | Business Ecommerce Theme','business-ecommerce') ); 
						?>
						</a>
				</div><!-- .site-info -->
			</div>

			
			</div>
		</div>	

		<a href="#" class="scroll-top-button"><i class="fa fa-angle-up"></i></a>

		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->
</div><!-- box layout style-->
<?php wp_footer(); ?>
</body>
</html>
