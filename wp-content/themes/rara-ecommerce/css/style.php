<?php
/**
 * Rara eCommerce Dynamic Styles
 * 
 * @package Rara_eCommerce
*/

function rara_ecommerce_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Jost' );
    $primary_fonts   = rara_ecommerce_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Jost' );
    $secondary_fonts = rara_ecommerce_get_fonts( $secondary_font, 'regular' );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Poppins', 'variant'=>'regular' ) );
    $site_title_fonts     = rara_ecommerce_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 32 );
    
	$primary_color    = get_theme_mod( 'primary_color', '#C4B583' );
	$secondary_color  = get_theme_mod( 'secondary_color', '#D5001B' );
	$site_title_color = get_theme_mod( 'site_title_color', '#111111' );
	$logo_width       = get_theme_mod( 'logo_width', 150 );
    
    $rgb = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $primary_color ) );
    $rgb2 = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $secondary_color ) );
    
    $image = '';
         
    echo "<style type='text/css' media='all'>"; ?>
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        <?php echo 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);'; ?>
    }
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;    
    }
    
    :root {
        --primary-color: <?php echo rara_ecommerce_sanitize_hex_color( $primary_color ); ?>;
        --primary-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
        --secondary-color: <?php echo rara_ecommerce_sanitize_hex_color( $secondary_color ); ?>;
        --secondary-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ); ?>;
        --primary-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
        --secondary-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
    }

    .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    .site-title a{
		color: <?php echo rara_ecommerce_sanitize_hex_color( $site_title_color ); ?>;
	}

	.custom-logo-link img{
        width    : <?php echo absint( $logo_width ); ?>px;
        max-width: 100%;
    }    
    
    /*Typography*/
	
	body {
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;     
    }   
           
    <?php echo "</style>";
}
add_action( 'wp_head', 'rara_ecommerce_dynamic_css', 99 );

/**
 * Function for sanitizing Hex color 
 */
function rara_ecommerce_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function rara_ecommerce_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

if ( ! function_exists( 'rara_ecommerce_gutenberg_inline_style' ) ) : 
/**
 * Gutenberg Dynamic Style
 */
function rara_ecommerce_gutenberg_inline_style(){
    
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'Jost' );
    $primary_fonts   = rara_ecommerce_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Jost' );
    $secondary_fonts = rara_ecommerce_get_fonts( $secondary_font, 'regular' );
    $primary_color    = get_theme_mod( 'primary_color', '#C4B583' );
    $secondary_color  = get_theme_mod( 'secondary_color', '#818181' );

    $rgb  = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $primary_color ) );
    $rgb2 = rara_ecommerce_hex2rgb( rara_ecommerce_sanitize_hex_color( $secondary_color ) );
 
    $custom_css = ':root .block-editor-page {
        --primary-color: ' . rara_ecommerce_sanitize_hex_color( $primary_color ) . ';
        --primary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ) . ';
        --secondary-color: ' . rara_ecommerce_sanitize_hex_color( $secondary_color ) . ';
        --secondary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ) . ';
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }';

    return $custom_css;
}
endif;