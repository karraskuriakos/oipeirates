if ( wptouchFdnAddToHome.bubbleExpiryInDays == 0 ) {
	localStorage.removeItem( 'org.cubiq.addtohome' );
}

var str = wptouchFdnAddToHome.themeLanguage;
var lowercaseLang = str.toLowerCase().replace('-', '_');	

var addToHomeConfig = {
//	debug: true,
	displayPace: wptouchFdnAddToHome.bubbleExpiryInDays,	// Days to wait before showing the popup again (0 = always displayed)
	autostart: true,										// Automatically open the balloon
	skipFirstVisit: false,									// Show the balloon to returning visitors only (setting this to true is HIGHLY RECCOMENDED)
	startDelay: 1,											// Display the message after that many seconds from page load
	lifespan: 0,											// 20 seconds before it is automatically destroyed
	language: lowercaseLang,								// WPtouch theme language
	icon: true												// Display the homescreen icon
};

addToHomescreen( addToHomeConfig );