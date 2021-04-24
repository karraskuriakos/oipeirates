/* admin stuff for Open */

function openCustomizerReady() {

	// Call to action
	var showCTA = jQuery( '[id$=wptouch_show_cta]' );
	showCTA.on( 'change wptouch.customizerReady', 'input[type="checkbox"]', function(){
		if ( jQuery( this ).is( ':checked' ) ) {
			showCTA.nextAll( 'li' ).css( 'visibility', '' );
		} else {
			showCTA.nextAll( 'li' ).css( 'visibility', 'hidden' );
		}
	});

	jQuery( '.accordion-section-content' ).find( 'input[type="checkbox"]' ).trigger( 'wptouch.customizerReady' );

}

jQuery( window ).load( function() {
	openCustomizerReady();
});