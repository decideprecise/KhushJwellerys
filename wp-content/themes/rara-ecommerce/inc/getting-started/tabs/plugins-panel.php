<?php
/**
 * Help Panel.
 *
 * @package Rara_Ecommerce
 */
?>
<!-- Updates panel -->
<div id="plugins-panel" class="panel-left visible">
	<h4><?php esc_html_e( 'Recommended Plugins', 'rara-ecommerce' ); ?></h4>

	<p><?php printf( esc_html__( 'Here is a list of recommended plugins you should install to get most out of the %1$s. Though every plugin is optional, we recommend you to at least install %2$sRaraTheme Companion%3$s & %2$sRara One Click Demo Import%3$s to create a website similar to the %1$s demo and also to ensure every feature of the theme works correctly.', 'rara-ecommerce' ), RARA_ECOMMERCE_THEME_NAME,'<strong>','</strong>' ); ?></p>

	<hr/>

	<?php 
	$free_plugins = array(
		'raratheme-companion' => array(
			'slug'     	=> 'raratheme-companion',
			'filename' 	=> 'raratheme-companion.php',
		),                
		'regenerate-thumbnails' => array(
			'slug' 		=> 'regenerate-thumbnails',
			'filename' 	=> 'regenerate-thumbnails.php',
		),                
		'blossomthemes-instagram-feed' => array(
			'slug' 		=> 'blossomthemes-instagram-feed',
			'filename' 	=> 'blossomthemes-instagram-feed.php',
		),                
        'woocommerce' => array(
			'slug' 		=> 'woocommerce',
			'filename' 	=> 'woocommerce.php',
		),
        'contact-form-7' => array(
			'slug' 		=> 'contact-form-7',
			'filename' 	=> 'wp-contact-form-7.php',
		),
		'yith-woocommerce-wishlist' => array(
			'slug' 		=> 'yith-woocommerce-wishlist',
			'filename' 	=> 'init.php',
		),
		'yith-woocommerce-quick-view' => array(
			'slug' 		=> 'yith-woocommerce-quick-view',
			'filename' 	=> 'init.php',
		),
		'yith-woocommerce-compare' => array(
			'slug' 		=> 'yith-woocommerce-compare',
			'filename' 	=> 'init.php',
		),                         
	);

	if( $free_plugins ){ ?>
		<h4 class="recomplug-title"><?php esc_html_e( 'Free Plugins', 'rara-ecommerce' ); ?></h4>
		<p><?php esc_html_e( 'These Free Plugins might be handy for you.', 'rara-ecommerce' ); ?></p>
		<div class="recomended-plugin-wrap">
    		<?php
    		foreach( $free_plugins as $plugin ) {
    			$info     = rara_ecommerce_call_plugin_api( $plugin['slug'] );
    			$icon_url = rara_ecommerce_check_for_icon( $info->icons ); ?>    
    			<div class="recom-plugin-wrap">
    				<div class="plugin-img-wrap">
    					<img src="<?php echo esc_url( $icon_url ); ?>" />
    					<div class="version-author-info">
    						<span class="version"><?php printf( esc_html__( 'Version %s', 'rara-ecommerce' ), $info->version ); ?></span>
    						<span class="seperator">|</span>
    						<span class="author"><?php echo esc_html( strip_tags( $info->author ) ); ?></span>
    					</div>
    				</div>
    				<div class="plugin-title-install clearfix">
    					<span class="title" title="<?php echo esc_attr( $info->name ); ?>">
    						<?php echo esc_html( $info->name ); ?>	
    					</span>
                        <div class="button-wrap">
    					   <?php echo Rara_Ecommerce_Getting_Started_Page_Plugin_Helper::instance()->get_button_html( $plugin['slug'], $plugin['filename'] ); ?>
                        </div>
    				</div>
    			</div>
    			<?php
    		} 
            ?>
		</div>
	<?php
	} 
?>
</div><!-- .panel-left -->