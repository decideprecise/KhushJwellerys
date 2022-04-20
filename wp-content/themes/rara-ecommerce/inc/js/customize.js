( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['rara-ecommerce-pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );

jQuery(document).ready(function($){
    /* Move Fornt page widgets to frontpage panel */
	wp.customize.section( 'sidebar-widgets-about' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-about' ).priority( '20' );
    wp.customize.section( 'sidebar-widgets-testimonial' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-testimonial' ).priority( '90' );       
    
    /* Move widgets to general panel */
    wp.customize.section( 'sidebar-widgets-service' ).panel( 'general_settings' );
	wp.customize.section( 'sidebar-widgets-service' ).priority( '70' );   
    
    //Scroll to front page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    }); 
    
    /* Home page preview url */
    wp.customize.panel( 'frontpage_settings', function( section ){
        section.expanded.bind( function( isExpanded ) {
            if( isExpanded ){
                wp.customize.previewer.previewUrl.set( rara_ecommerce_cdata.home );
            }
        });
    });
});

function scrollToSection( section_id ){
    var preview_section_id = "banner_section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
        
        case 'accordion-section-sidebar-widgets-about':
        preview_section_id = "about_section";
        break;

        case 'accordion-section-featured_section':
        preview_section_id = "featured_section";
        break;

        case 'accordion-section-cat_one_section':
        preview_section_id = "sale_section";
        break;  

        case 'accordion-section-sidebar-widgets-testimonial':
        preview_section_id = "testimonial_section";
        break;     
        
        case 'accordion-section-blog_section':
        preview_section_id = "blog_section";
        break;
        
        case 'accordion-section-front_sort':
        preview_section_id = "banner_section";
        break;
    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
}