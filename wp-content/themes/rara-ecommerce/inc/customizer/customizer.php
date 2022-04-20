<?php
/**
 * Rara eCommerce Theme Customizer
 *
 * @package Rara_eCommerce
 */

/**
 * Requiring customizer panels & sections
*/

$rara_ecommerce_panels = array( 'info', 'site', 'appearance', 'layout', 'general', 'frontpage', 'footer' );

foreach( $rara_ecommerce_panels as $p ){
    require get_template_directory() . '/inc/customizer/' . $p . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function rara_ecommerce_customize_preview_js() {
	wp_enqueue_script( 'rara-ecommerce-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), RARA_ECOMMERCE_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'rara_ecommerce_customize_preview_js' );

function rara_ecommerce_customize_script(){
    $array = array(
        'home'    => get_permalink( get_option( 'page_on_front' ) )
    );
    wp_enqueue_style( 'rara-ecommerce-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), RARA_ECOMMERCE_THEME_VERSION );
    wp_enqueue_script( 'rara-ecommerce-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), RARA_ECOMMERCE_THEME_VERSION, true );
    wp_localize_script( 'rara-ecommerce-customize', 'rara_ecommerce_cdata', $array );

    wp_localize_script( 'rara-ecommerce-repeater', 'rara_ecommerce_customize',
		array(
			'nonce' => wp_create_nonce( 'rara_ecommerce_customize_nonce' )
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'rara_ecommerce_customize_script' );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

$config_customizer = array(
	'recommended_plugins' => array(
		//change the slug for respective plugin recomendation
        'raratheme-companion' => array(
			'recommended' => true,
			'description' => sprintf(
				/* translators: %s: plugin name */
				esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'rara-ecommerce' ), '<strong>Raratheme Companion</strong>'
			),
		),
	),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'rara-ecommerce' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'rara-ecommerce' ),
	'activate_button_label'     => esc_html__( 'Activate', 'rara-ecommerce' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'rara-ecommerce' ),
);
Rara_eCommerce_Customizer_Notice::init( apply_filters( 'rara_ecommerce_customizer_notice_array', $config_customizer ) );