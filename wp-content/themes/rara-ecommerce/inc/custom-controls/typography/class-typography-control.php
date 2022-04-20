<?php
/**
 * Rara eCommerce Customizer Typography Control
 *
 * @package Rara_eCommerce
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Rara_eCommerce_Typography_Control' ) ) {
    
    class Rara_eCommerce_Typography_Control extends WP_Customize_Control {
    
    	public $tooltip = '';
    	public $js_vars = array();
    	public $output = array();
    	public $option_type = 'theme_mod';
    	public $type = 'rara-ecommerce-typography';
    
    	/**
    	 * Refresh the parameters passed to the JavaScript via JSON.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function to_json() {
    		parent::to_json();
    
    		if ( isset( $this->default ) ) {
    			$this->json['default'] = $this->default;
    		} else {
    			$this->json['default'] = $this->setting->default;
    		}
    		$this->json['js_vars'] = $this->js_vars;
    		$this->json['output']  = $this->output;
    		$this->json['value']   = $this->value();
    		$this->json['choices'] = $this->choices;
    		$this->json['link']    = $this->get_link();
    		$this->json['tooltip'] = $this->tooltip;
    		$this->json['id']      = $this->id;
    		$this->json['l10n']    = apply_filters( 'rara_ecommerce_il8n_strings', array(
    			'on'                 => esc_attr__( 'ON', 'rara-ecommerce' ),
    			'off'                => esc_attr__( 'OFF', 'rara-ecommerce' ),
    			'all'                => esc_attr__( 'All', 'rara-ecommerce' ),
    			'cyrillic'           => esc_attr__( 'Cyrillic', 'rara-ecommerce' ),
    			'cyrillic-ext'       => esc_attr__( 'Cyrillic Extended', 'rara-ecommerce' ),
    			'devanagari'         => esc_attr__( 'Devanagari', 'rara-ecommerce' ),
    			'greek'              => esc_attr__( 'Greek', 'rara-ecommerce' ),
    			'greek-ext'          => esc_attr__( 'Greek Extended', 'rara-ecommerce' ),
    			'khmer'              => esc_attr__( 'Khmer', 'rara-ecommerce' ),
    			'latin'              => esc_attr__( 'Latin', 'rara-ecommerce' ),
    			'latin-ext'          => esc_attr__( 'Latin Extended', 'rara-ecommerce' ),
    			'vietnamese'         => esc_attr__( 'Vietnamese', 'rara-ecommerce' ),
    			'hebrew'             => esc_attr__( 'Hebrew', 'rara-ecommerce' ),
    			'arabic'             => esc_attr__( 'Arabic', 'rara-ecommerce' ),
    			'bengali'            => esc_attr__( 'Bengali', 'rara-ecommerce' ),
    			'gujarati'           => esc_attr__( 'Gujarati', 'rara-ecommerce' ),
    			'tamil'              => esc_attr__( 'Tamil', 'rara-ecommerce' ),
    			'telugu'             => esc_attr__( 'Telugu', 'rara-ecommerce' ),
    			'thai'               => esc_attr__( 'Thai', 'rara-ecommerce' ),
    			'serif'              => _x( 'Serif', 'font style', 'rara-ecommerce' ),
    			'sans-serif'         => _x( 'Sans Serif', 'font style', 'rara-ecommerce' ),
    			'monospace'          => _x( 'Monospace', 'font style', 'rara-ecommerce' ),
    			'font-family'        => esc_attr__( 'Font Family', 'rara-ecommerce' ),
    			'font-size'          => esc_attr__( 'Font Size', 'rara-ecommerce' ),
    			'font-weight'        => esc_attr__( 'Font Weight', 'rara-ecommerce' ),
    			'line-height'        => esc_attr__( 'Line Height', 'rara-ecommerce' ),
    			'font-style'         => esc_attr__( 'Font Style', 'rara-ecommerce' ),
    			'letter-spacing'     => esc_attr__( 'Letter Spacing', 'rara-ecommerce' ),
    			'text-align'         => esc_attr__( 'Text Align', 'rara-ecommerce' ),
    			'text-transform'     => esc_attr__( 'Text Transform', 'rara-ecommerce' ),
    			'none'               => esc_attr__( 'None', 'rara-ecommerce' ),
    			'uppercase'          => esc_attr__( 'Uppercase', 'rara-ecommerce' ),
    			'lowercase'          => esc_attr__( 'Lowercase', 'rara-ecommerce' ),
    			'top'                => esc_attr__( 'Top', 'rara-ecommerce' ),
    			'bottom'             => esc_attr__( 'Bottom', 'rara-ecommerce' ),
    			'left'               => esc_attr__( 'Left', 'rara-ecommerce' ),
    			'right'              => esc_attr__( 'Right', 'rara-ecommerce' ),
    			'center'             => esc_attr__( 'Center', 'rara-ecommerce' ),
    			'justify'            => esc_attr__( 'Justify', 'rara-ecommerce' ),
    			'color'              => esc_attr__( 'Color', 'rara-ecommerce' ),
    			'select-font-family' => esc_attr__( 'Select a font-family', 'rara-ecommerce' ),
    			'variant'            => esc_attr__( 'Variant', 'rara-ecommerce' ),
    			'style'              => esc_attr__( 'Style', 'rara-ecommerce' ),
    			'size'               => esc_attr__( 'Size', 'rara-ecommerce' ),
    			'height'             => esc_attr__( 'Height', 'rara-ecommerce' ),
    			'spacing'            => esc_attr__( 'Spacing', 'rara-ecommerce' ),
    			'ultra-light'        => esc_attr__( 'Ultra-Light 100', 'rara-ecommerce' ),
    			'ultra-light-italic' => esc_attr__( 'Ultra-Light 100 Italic', 'rara-ecommerce' ),
    			'light'              => esc_attr__( 'Light 200', 'rara-ecommerce' ),
    			'light-italic'       => esc_attr__( 'Light 200 Italic', 'rara-ecommerce' ),
    			'book'               => esc_attr__( 'Book 300', 'rara-ecommerce' ),
    			'book-italic'        => esc_attr__( 'Book 300 Italic', 'rara-ecommerce' ),
    			'regular'            => esc_attr__( 'Normal 400', 'rara-ecommerce' ),
    			'italic'             => esc_attr__( 'Normal 400 Italic', 'rara-ecommerce' ),
    			'medium'             => esc_attr__( 'Medium 500', 'rara-ecommerce' ),
    			'medium-italic'      => esc_attr__( 'Medium 500 Italic', 'rara-ecommerce' ),
    			'semi-bold'          => esc_attr__( 'Semi-Bold 600', 'rara-ecommerce' ),
    			'semi-bold-italic'   => esc_attr__( 'Semi-Bold 600 Italic', 'rara-ecommerce' ),
    			'bold'               => esc_attr__( 'Bold 700', 'rara-ecommerce' ),
    			'bold-italic'        => esc_attr__( 'Bold 700 Italic', 'rara-ecommerce' ),
    			'extra-bold'         => esc_attr__( 'Extra-Bold 800', 'rara-ecommerce' ),
    			'extra-bold-italic'  => esc_attr__( 'Extra-Bold 800 Italic', 'rara-ecommerce' ),
    			'ultra-bold'         => esc_attr__( 'Ultra-Bold 900', 'rara-ecommerce' ),
    			'ultra-bold-italic'  => esc_attr__( 'Ultra-Bold 900 Italic', 'rara-ecommerce' ),
    			'invalid-value'      => esc_attr__( 'Invalid Value', 'rara-ecommerce' ),
    		) );
    
    		$defaults = array( 'font-family'=> false );
    
    		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
    	}
    
    	/**
    	 * Enqueue scripts and styles.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function enqueue() {
    		wp_enqueue_style( 'rara-ecommerce-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.css', null );
            
            wp_enqueue_script( 'jquery-ui-core' );
    		wp_enqueue_script( 'jquery-ui-tooltip' );
    		wp_enqueue_script( 'jquery-stepper-min-js' );
    		wp_enqueue_script( 'rara-ecommerce-selectize', get_template_directory_uri() . '/inc/js/selectize.js', array( 'jquery' ), false, true );
    		wp_enqueue_script( 'rara-ecommerce-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.js', array( 'jquery', 'rara-ecommerce-selectize' ), false, true );
    
    		$google_fonts   = Rara_eCommerce_Fonts::get_google_fonts();
    		$standard_fonts = Rara_eCommerce_Fonts::get_standard_fonts();
    		$all_variants   = Rara_eCommerce_Fonts::get_all_variants();
    
    		$standard_fonts_final = array();
    		foreach ( $standard_fonts as $key => $value ) {
    			$standard_fonts_final[] = array(
    				'family'      => $value['stack'],
    				'label'       => $value['label'],
    				'is_standard' => true,
    				'variants'    => array(
    					array(
    						'id'    => 'regular',
    						'label' => $all_variants['regular'],
    					),
    					array(
    						'id'    => 'italic',
    						'label' => $all_variants['italic'],
    					),
    					array(
    						'id'    => '700',
    						'label' => $all_variants['700'],
    					),
    					array(
    						'id'    => '700italic',
    						'label' => $all_variants['700italic'],
    					),
    				),
    			);
    		}
    
    		$google_fonts_final = array();
    
    		if ( is_array( $google_fonts ) ) {
    			foreach ( $google_fonts as $family => $args ) {
    				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
    				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
    
    				$available_variants = array();
    				foreach ( $variants as $variant ) {
    					if ( array_key_exists( $variant, $all_variants ) ) {
    						$available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
    					}
    				}
    
    				$google_fonts_final[] = array(
    					'family'   => $family,
    					'label'    => $label,
    					'variants' => $available_variants
    				);
    			}
    		}
    
    		$final = array_merge( $standard_fonts_final, $google_fonts_final );
    		wp_localize_script( 'rara-ecommerce-typography', 'all_fonts', $final );
    	}
    
    	/**
    	 * An Underscore (JS) template for this control's content (but not its container).
    	 *
    	 * Class variables for this control class are available in the `data` JS object;
    	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
    	 *
    	 * I put this in a separate file because PhpStorm didn't like it and it fucked with my formatting.
    	 *
    	 * @see    WP_Customize_Control::print_template()
    	 *
    	 * @access protected
    	 * @return void
    	 */
    	protected function content_template(){ ?>
    		<# if ( data.tooltip ) { #>
                <a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
            <# } #>
            
            <label class="customizer-text">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            
            <div class="wrapper">
                <# if ( data.default['font-family'] ) { #>
                    <# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
                    <# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
                    <div class="font-family">
                        <h5>{{ data.l10n['font-family'] }}</h5>
                        <select id="rara-ecommerce-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}"></select>
                    </div>
                    <div class="variant rara-ecommerce-variant-wrapper">
                        <h5>{{ data.l10n['style'] }}</h5>
                        <select class="variant" id="rara-ecommerce-typography-variant-{{{ data.id }}}"></select>
                    </div>
                <# } #>   
                
            </div>
            <?php
		}  
		
		protected function render_content(){
			
		}
    }
}