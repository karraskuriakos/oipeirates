
function wptouchWebAppModeAdminReady(){
	// Notice message functions toggle
	wptouchCheckToggle( '#webapp_show_notice', '#setting-webapp_notice_expiry_days' );
}

jQuery( document ).ready( function() {
	wptouchWebAppModeAdminReady();
});