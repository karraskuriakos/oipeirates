function doMobileStoreRadioEvaluate( selectedOption ) {
	if ( selectedOption == 'small' ) {
		jQuery( '#setting-mobilestore_show_h4' ).hide();
	} else {
		jQuery( '#setting-mobilestore_show_h4' ).slideDown( 200 );
	}
}

function doMobileStoreH4Radio() {
	var radioSelect = jQuery( 'input[name="wptouch__mobilestore__mobilestore_header_type"]' );
	radioSelect.on( 'change', function(){
		var selectedOption = jQuery( 'input[name="wptouch__mobilestore__mobilestore_header_type"]:checked' ).val();
		doMobileStoreRadioEvaluate( selectedOption );
	}).change();

}

function doMobileStoreCartOptions(){
	var ajaxAddInput = jQuery( '#mobilestore_use_ajax_add_to_cart' );

	jQuery( '#mobilestore_show_minicart' ).on( 'change', function(){
		if ( jQuery( this ).is( ':checked' ) ) {
			ajaxAddInput.prop( 'disabled', false );
		} else {
			ajaxAddInput.prop( 'checked', '' ).prop( 'disabled', 'disabled' );
		}
	}).change();
}

jQuery( document ).ready( function() {
	// Hide the Pages section
	jQuery( '#section-foundation-pages' ).hide();

	jQuery( 'a.menu-icons-menus, a.menu-icons-manage-icon-sets' ).remove();

	jQuery( '#enable_menu_icons' ).prop( 'checked', false ).attr( 'disabled', 'disabled' );

	doMobileStoreH4Radio();
	doMobileStoreCartOptions();
} );