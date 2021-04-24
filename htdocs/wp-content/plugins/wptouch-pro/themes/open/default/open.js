/* WPtouch Open Theme Js File */

function doOpenReady() {
	openDoElManip();
}

function openDoElManip(){
	jQuery( '.home #header-area p, nav, .hours dd, .footer-action a' ).addClass( 'heading-font' );
	jQuery( '.sharing-options' ).insertBefore( '.post-content' );
	jQuery( '.post' ).each( function() {
		post = jQuery( this );
		meta = 	post.children( '.post-meta' );
		title = post.children( '.post-title' );
		meta.insertAfter( title );
	});

	if ( jQuery( 'div.header-image' ).is( 'div' ) ) {
		jQuery( 'body' ).addClass( 'has-header-image' );
	}
}

// Add 'touched' class to these elements when they're actually touched (100ms delay) for a better UI experience (tappable module)
function openBindTappableLinks(){
	// Drop down menu items
	jQuery( 'li.menu-item' ).each( function(){
		jQuery( this ).addClass( 'tappable' );
	});
}

jQuery( document ).ready( function() {
	doOpenReady();
} );

jQuery( document ).ajaxComplete( function() { openDoElManip(); });