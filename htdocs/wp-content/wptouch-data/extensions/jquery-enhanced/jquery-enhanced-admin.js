function doJqueryEnhancedReady() {
	var jqueryECheck = jQuery( '#enable_jquery_e' );
	if ( jqueryECheck.length ) {
		function jqueryEnhancedCheckState(){
			var checked = jqueryECheck.attr( 'checked' );
			var allItems = jQuery( '#section-addons-jquery-e li' ).not( '#setting-enable_jquery_e' );
			if ( !checked ) {
				allItems.hide();
			} else {
				allItems.fadeIn();
			}
		}

		jqueryECheck.change( function() {
			jqueryEnhancedCheckState();
		}).change();
	}
}

jQuery( document ).ready( function() { doJqueryEnhancedReady(); });