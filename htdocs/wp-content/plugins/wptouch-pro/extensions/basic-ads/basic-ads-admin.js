
function adsAdminReady(){

	// Advertising Options
	jQuery( '#advertising_type' ).on( 'change', function() {

		var presentationDiv = jQuery( '#section-advertising-presentation' );
		var googleDiv = jQuery( '#section-advertising-google-adsense' );
		var customDiv = jQuery( '#section-advertising-custom-ads' );
		var optionsDev = jQuery( '#section-advertising-active-pages' );

		switch( jQuery( '#advertising_type' ).val() ) {
			case 'none':
				presentationDiv.hide();
				googleDiv.hide();
				customDiv.hide();
				optionsDev.hide();
				break;
			case 'google':
				customDiv.hide();
				presentationDiv.fadeIn();
				googleDiv.fadeIn();
				optionsDev.fadeIn();
				break;
			case 'custom':
				googleDiv.hide();
				presentationDiv.fadeIn();
				optionsDev.fadeIn();
				customDiv.fadeIn();
				break;
		}
	} ).trigger( 'change' );

	// Available locations depending on settings
	var presentationSelect = jQuery( '#advertising_location' );
	presentationSelect.change( function(){
		var selectedOption = presentationSelect.val();
		var els = jQuery( '#advertising_blog_listings, #advertising_search' );
		if ( selectedOption != 'header' ) {
			els.prop( 'disabled', 'disabled' )
		} else {
			els.prop( 'disabled', '' )
		}
	}).change();

}

jQuery( document ).ready( function() {
	adsAdminReady();
});