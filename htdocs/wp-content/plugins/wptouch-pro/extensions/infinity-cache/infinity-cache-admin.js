function doInfinityCacheReady() {

	// Hide the text items that mess up styling in WPtouch 4
	jQuery( 'li[class*="setting-cdn_show"]', '#section-extension-infinity-cache-cdn' ).remove();

	// Main toggle on/off
		var infinityCheck = jQuery( '#cache_enable' );
		var allItems = jQuery( '#section-extension-infinity-cache li, #section-extension-infinity-cache-cdn' ).not( 'li#setting-cache_enable' );
		wptouchCheckToggle( infinityCheck, allItems );

	// Purge cache button
	var cacheDeleteButton = jQuery( '#cache_delete_cache' );
	cacheDeleteButton.click( function( e ) {
		var ajaxParams = {};

		cacheDeleteButton.attr( 'disabled', 'disabled' );
		wptouchAdminAjax( 'infinity-cache-reset', ajaxParams, function( result ) {
			cacheDeleteButton.removeAttr( 'disabled' );
			cacheDeleteButton.after( ' <span class="update-cache">Cache cleared!</span>' );
			setTimeout( function(){ jQuery( '.update-cache' ).remove(); }, 1500 );
		});
		e.preventDefault();
	});

	// Show/hide for CDN fields
	jQuery( '#cache_optimize_cdn' ).change( function(){
		if ( jQuery( this ).val() == 'maxcdn' ) {
			jQuery( 'li[id*="optimize_cdn_"]' ).fadeIn();
		} else {
			jQuery( 'li[id*="optimize_cdn_"]' ).hide();
		}
	}).change();

}


jQuery( document ).ready( function() { doInfinityCacheReady(); });