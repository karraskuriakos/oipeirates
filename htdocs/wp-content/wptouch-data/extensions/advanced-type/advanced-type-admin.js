jQuery( document ).ready( function() {
	advancedTypeAdminReady();
});

function advancedTypeAdminReady(){

	// Advanced Type Options
	jQuery( '#advanced_type_source' ).on( 'change', function() {

		var googleDiv = jQuery( '#section-addon-type-subsets' );
		var typekitDiv = jQuery( '#section-addon-type-typekit' );
		var  fontDeck = jQuery( '#section-addon-type-fontdeck' );

		switch( jQuery( this ).val() ) {
			default:
				googleDiv.hide();
				typekitDiv.hide();
				fontDeck.hide();
				break;
			case 'google':
				googleDiv.fadeIn();
				typekitDiv.hide();
				fontDeck.hide();
				break;
			case 'typekit':
				googleDiv.hide();
				typekitDiv.fadeIn();
				fontDeck.hide();
				break;
			case 'fontdeck':
				googleDiv.hide();
				typekitDiv.hide();
				fontDeck.fadeIn();
				break;
		}

	} ).trigger( 'change' );

}