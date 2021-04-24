
function multiadsABChange(){
	jQuery( '#setting-advertising_header_ab_enabled, #setting-advertising_footer_ab_enabled, #setting-advertising_pre_content_ab_enabled, #setting-advertising_post_content_ab_enabled, #setting-advertising_mid_content_ab_enabled, #setting-advertising_page_level_ab_enabled' ).change( function() {

			var thisId = jQuery( this ).prop( 'id' );
			var newId = thisId.replace( '_ab_enabled', '_code_2' );
			newId = newId.replace( 'setting-', '' );

			if ( !jQuery( this ).find( 'input' ).is( ":checked" ) ) {
				jQuery( '#' + newId ).parent().hide();
			} else {
				jQuery( '#' + newId ).parent().fadeIn();
			}
	}).change();
}

function wptouchMultiadsAdminReady(){

	jQuery( '#setting-advertising_header_enabled, #setting-advertising_footer_enabled, #setting-advertising_pre_content_enabled, #setting-advertising_post_content_enabled, #setting-advertising_mid_content_enabled, #setting-advertising_page_level_enabled' ).change( function() {
		if ( jQuery( this ).find( '.checkbox' ).is( ":checked" ) ) {
			jQuery( this ).parent().find( 'li' ).not( ':first, .setting-hidden' ).fadeIn();
			multiadsABChange();
		} else {
			jQuery( this ).parent().find( 'li' ).not( ':first, .setting-hidden' ).hide();
		}
	}).change();
}

jQuery( document ).ready( function() {
	wptouchMultiadsAdminReady();
});