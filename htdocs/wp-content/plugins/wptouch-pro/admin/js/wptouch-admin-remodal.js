function wptouchHandleLicensePanel() {

	// Hide the modal statuses to start
	jQuery( '.remodal .status' ).hide();

	// Animation to start the progressbar
	function wptouchProgressBarStart( barElement ){
		jQuery( barElement ).animate({ width: '20%' }, 550 );
	}

	// Animation for an error response
	function wptouchProgressBarError( barElement ){
		jQuery( barElement ).animate({ width: '100%' }, 500, function(){ jQuery( barElement ).addClass( 'bar-fail' ); } );
	}

	// Animation for an issue response
	function wptouchProgressBarIssue( barElement ){
		jQuery( barElement ).animate({ width: '100%' }, 500, function(){ jQuery( barElement ).addClass( 'bar-issue' ); } );
	}

	// Animation for a response related to license issues
	function wptouchProgressBarLicense( barElement ){
		jQuery( barElement ).animate({ width: '100%' }, 500, function(){ jQuery( barElement ).addClass( 'bar-license' ); } );
	}

	// Animation for a success response
	function wptouchProgressBarSuccess( barElement ){
		jQuery( barElement ).animate({ width: '100%' }, 500, function(){ jQuery( barElement ).addClass( 'bar-success' ); } );
	}

	// Reset progressbar for new animations when license modals are closed
	function wptouchProgressBarReset( barElement ){
		jQuery( barElement ).css( 'width', '0%' ).removeClass( 'bar-fail bar-issue bar-license bar-success' );
		jQuery( barElement ).parent().removeClass( 'complete' );
		jQuery( '.license-activation h1' ).show();
	}

	// Check to make sure the panel exists
	if ( jQuery( '#license-settings-area' ).length ) {

		// See if we have a license already
		if ( typeof bncHasLicense == 'undefined' || bncHasLicense == 0 ) {

			var activateDiv = jQuery( '#activate-license' );

			// check to see if the e-mail address and license key conforms properly before showing action buttons
			jQuery( '#license_email, #license_key' ).on( 'keyup', function(){
				if ( /(.+)@(.+){2,}\.(.+){2,}/.test( jQuery( '#license_email' ).val().trim() ) && jQuery( '#license_key' ).val().trim().length == 23 ){
					activateDiv.css( 'opacity', '1' );
				} else {
					activateDiv.css( 'opacity', '.3' );
				}
			}).keyup();

			// The main license activation JavaScript
			jQuery( '#activate-license' ).on( 'click', 'a.activate', function( e ) {

				e.preventDefault();

				// Setup AJAX params
				var licenseEmail = jQuery( '#license_email' ).val();
				var licenseKey = jQuery( '#license_key' ).val().trim();

				var ajaxParams = {
					email: licenseEmail,
					key: licenseKey
				};

				// Our progress bar element
				var progressBar = jQuery( '#progress-license' ).find( '.bar' );

				// Cache objects we'll be using
				var modal = jQuery('[data-remodal-id=modal-license]').remodal();

				var progressArea = jQuery( '.license-activation' );

				jQuery( document ).on( 'closed', '.remodal', function ( e ) {
					wptouchProgressBarReset( progressBar );
					jQuery( '.status' ).hide();
					progressArea.show();
				});

				wptouchProgressBarStart( progressBar );

				wptouchAdminAjax( 'activate-license-key', ajaxParams, function( result ) {

					var progressItem = jQuery( '.progress' );
					var activationHead = jQuery( '.license-activation h1' );
					if ( result == '1' ) {

						// license success
						modal.open();
						jQuery( document ).one( 'opened', '.remodal', function () {
							wptouchProgressBarSuccess( progressBar );
							setTimeout( function(){
								activationHead.slideUp();

								if ( !jQuery( '#upgrade-area' ).length ) {
									progressItem.addClass( 'complete' );
									jQuery( '.license-success' ).slideDown();
									jQuery( document ).on( 'closed', '.remodal', function() {
											wptouchAdminTriggerReload();
									});
								} else {
									jQuery( '.license-free-upgrade-text' ).show();
									wptouchAdminAjax( 'go-pro', ajaxParams, function( finished ) {
										if ( finished == '1' ) {
											progressItem.addClass( 'complete' );
											jQuery( '.license-free-upgrade-text' ).hide();
											jQuery( '.license-free-upgrade' ).slideDown();
											jQuery( document ).on( 'closed', '.remodal', function () {
												wptouchAdminTriggerReload();
											});
										} else {
											jQuery( progressBar ).removeClass( 'bar-success' ).addClass( 'bar-issue' );
											jQuery( '.license-free-upgrade-failed' ).slideDown();
										}
									});									
								}
								
							}, 1500 );
						});

					} else if ( result == '2' ) {

						// rejected license
						modal.open();
						jQuery( document ).one( 'opened', '.remodal', function () {
							wptouchProgressBarLicense( progressBar );
							setTimeout( function(){
								progressItem.addClass( 'complete' );
								activationHead.slideUp();
								jQuery( '.license-failed' ).slideDown();
							}, 1500 );
						});

					} else if ( result == '3' ) {

						// no licenses remaining
						modal.open();
						jQuery( document ).one( 'opened', '.remodal', function () {
							wptouchProgressBarLicense( progressBar );
							jQuery( '.manage-licenses' ).on( 'click', function( e ){
								modal.close();
								e.preventDefault();
								window.location.href = '//www.wptouch.com/account/';
							});
							jQuery( '.visit-pricing' ).on( 'click', function( e ){
								modal.close();
								e.preventDefault();
								window.location.href = '//www.wptouch.com/pricing/';
							});							setTimeout( function(){
								progressItem.addClass( 'complete' );
								activationHead.slideUp();
								jQuery( '.license-no-activations' ).slideDown();
							}, 1500 );
						});

					} else if ( result == '4' ) {

						// server issue license
						modal.open();
						jQuery( document ).one( 'opened', '.remodal', function () {
							wptouchProgressBarError( progressBar );

							jQuery( '.email-support' ).on( 'click', function( e ){
								modal.close();
								e.preventDefault();
								window.location.href = 'mailto:support@wtouch.com?subject=Cannot%20Reach%20WPtouch%20Server';
							});

							setTimeout( function(){
								progressItem.addClass( 'complete' );
								activationHead.slideUp();
								jQuery( '.license-no-connection' ).slideDown();
							}, 1500 );
						});

					} else if ( result == '5' ) {
						// license expired
						modal.open();
						jQuery( document ).one( 'opened', '.remodal', function () {
							wptouchProgressBarIssue( progressBar );

							jQuery( '.renew-license' ).on( 'click', function( e ){
								modal.close();
								e.preventDefault();
								window.location.href = '//www.wptouch.com/renew/?utm_campaign=renew-from-license-area&utm_source=wptouch&utm_medium=web';
							});

							setTimeout( function(){
								progressItem.addClass( 'complete' );
								activationHead.slideUp();
								jQuery( '.license-expired' ).slideDown();
							}, 1500 );
						});
					}
				});
			});
		} else {
			jQuery( activate ).hide();
			jQuery( success ).show()
		}

		// Clear license button (resets the license settings independent of the rest of WPtouch's settings)
		jQuery( 'a.clear-license' ).click( function ( e ) {
			if ( confirm( WPtouchCustom.remove_license ) ) {
				var ajaxParams = {};

				wptouchAdminAjax( 'reset-license-info', ajaxParams, function( result ) {
					document.location.href = document.location.href;
				});
			}

			e.preventDefault();
		});
	}
}

function wptouchHandleNewsletterNoticeDismiss() {
    jQuery( '#wpbody-content' ).on( 'click', '.js-free-newsletter-notice .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'disable_newsletter_notice'
            },
            done: function() {
                // Do nothing.
            }
        });
    } );
}

function wptouchHandleThemeIncompatibilityDismiss() {
    jQuery( '#wpbody-content' ).on( 'click', '.js-theme-incompatibility-notice .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'disable_theme_incompatibility_notice'
            },
            done: function() {
                // Do nothing.
            }
        });
    } );
}

function wptouchHandlePluginIncompatibilityDismiss() {
    jQuery( '#wpbody-content' ).on( 'click', '.js-plugin-incompatibility-notice .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'disable_plugin_incompatibility_notice',
                plugin: jQuery( '.js-wptouch-incompatible-plugin-name' ).val()
            },
            done: function() {
                // Do nothing.
            }
        });
    } );
}

function wptouchSitewideAdminReady(){
	wptouchHandleLicensePanel();
    wptouchHandleNewsletterNoticeDismiss();
    wptouchHandleThemeIncompatibilityDismiss();
    wptouchHandlePluginIncompatibilityDismiss();
}

jQuery( document ).ready( function() {
	wptouchSitewideAdminReady();
});

/*
 *  Remodal - v1.0.3
 *  Responsive, lightweight, fast, synchronized with CSS animations, fully customizable modal window plugin with declarative configuration and hash tracking.
 *  http://vodkabears.github.io/remodal/
 *
 *  Made by Ilya Makarov
 *  Under MIT License
 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(c){return b(a,c)}):"object"==typeof exports?b(a,require("jquery")):b(a,a.jQuery||a.Zepto)}(this,function(a,b){"use strict";function c(a){if(w&&"none"===a.css("animation-name")&&"none"===a.css("-webkit-animation-name")&&"none"===a.css("-moz-animation-name")&&"none"===a.css("-o-animation-name")&&"none"===a.css("-ms-animation-name"))return 0;var b,c,d,e,f=a.css("animation-duration")||a.css("-webkit-animation-duration")||a.css("-moz-animation-duration")||a.css("-o-animation-duration")||a.css("-ms-animation-duration")||"0s",g=a.css("animation-delay")||a.css("-webkit-animation-delay")||a.css("-moz-animation-delay")||a.css("-o-animation-delay")||a.css("-ms-animation-delay")||"0s",h=a.css("animation-iteration-count")||a.css("-webkit-animation-iteration-count")||a.css("-moz-animation-iteration-count")||a.css("-o-animation-iteration-count")||a.css("-ms-animation-iteration-count")||"1";for(f=f.split(", "),g=g.split(", "),h=h.split(", "),e=0,c=f.length,b=Number.NEGATIVE_INFINITY;c>e;e++)d=parseFloat(f[e])*parseInt(h[e],10)+parseFloat(g[e]),d>b&&(b=d);return d}function d(){if(b(document.body).height()<=b(window).height())return 0;var a,c,d=document.createElement("div"),e=document.createElement("div");return d.style.visibility="hidden",d.style.width="100px",document.body.appendChild(d),a=d.offsetWidth,d.style.overflow="scroll",e.style.width="100%",d.appendChild(e),c=e.offsetWidth,d.parentNode.removeChild(d),a-c}function e(){var a,c,e=b("html"),f=k("is-locked");e.hasClass(f)||(c=b(document.body),a=parseInt(c.css("padding-right"),10)+d(),c.css("padding-right",a+"px"),e.addClass(f))}function f(){var a,c,e=b("html"),f=k("is-locked");e.hasClass(f)&&(c=b(document.body),a=parseInt(c.css("padding-right"),10)-d(),c.css("padding-right",a+"px"),e.removeClass(f))}function g(a,b,c,d){var e=k("is",b),f=[k("is",u.CLOSING),k("is",u.OPENING),k("is",u.CLOSED),k("is",u.OPENED)].join(" ");a.$bg.removeClass(f).addClass(e),a.$overlay.removeClass(f).addClass(e),a.$wrapper.removeClass(f).addClass(e),a.$modal.removeClass(f).addClass(e),a.state=b,!c&&a.$modal.trigger({type:b,reason:d},[{reason:d}])}function h(a,d,e){var f=0,g=function(a){a.target===this&&f++},h=function(a){a.target===this&&0===--f&&(b.each(["$bg","$overlay","$wrapper","$modal"],function(a,b){e[b].off(r+" "+s)}),d())};b.each(["$bg","$overlay","$wrapper","$modal"],function(a,b){e[b].on(r,g).on(s,h)}),a(),0===c(e.$bg)&&0===c(e.$overlay)&&0===c(e.$wrapper)&&0===c(e.$modal)&&(b.each(["$bg","$overlay","$wrapper","$modal"],function(a,b){e[b].off(r+" "+s)}),d())}function i(a){a.state!==u.CLOSED&&(b.each(["$bg","$overlay","$wrapper","$modal"],function(b,c){a[c].off(r+" "+s)}),a.$bg.removeClass(a.settings.modifier),a.$overlay.removeClass(a.settings.modifier).hide(),a.$wrapper.hide(),f(),g(a,u.CLOSED,!0))}function j(a){var b,c,d,e,f={};for(a=a.replace(/\s*:\s*/g,":").replace(/\s*,\s*/g,","),b=a.split(","),e=0,c=b.length;c>e;e++)b[e]=b[e].split(":"),d=b[e][1],("string"==typeof d||d instanceof String)&&(d="true"===d||("false"===d?!1:d)),("string"==typeof d||d instanceof String)&&(d=isNaN(d)?d:+d),f[b[e][0]]=d;return f}function k(){for(var a=q,b=0;b<arguments.length;++b)a+="-"+arguments[b];return a}function l(){var a,c,d=location.hash.replace("#","");if(d){try{c=b("[data-"+p+"-id="+d.replace(new RegExp("/","g"),"\\/")+"]")}catch(e){}c&&c.length&&(a=b[p].lookup[c.data(p)],a&&a.settings.hashTracking&&a.open())}else n&&n.state===u.OPENED&&n.settings.hashTracking&&n.close()}function m(a,c){var d=b(document.body),e=this;e.settings=b.extend({},t,c),e.index=b[p].lookup.push(e)-1,e.state=u.CLOSED,e.$overlay=b("."+k("overlay")),e.$overlay.length||(e.$overlay=b("<div>").addClass(k("overlay")+" "+k("is",u.CLOSED)).hide(),d.append(e.$overlay)),e.$bg=b("."+k("bg")).addClass(k("is",u.CLOSED)),e.$modal=a.addClass(q+" "+k("is-initialized")+" "+e.settings.modifier+" "+k("is",u.CLOSED)).attr("tabindex","-1"),e.$wrapper=b("<div>").addClass(k("wrapper")+" "+e.settings.modifier+" "+k("is",u.CLOSED)).hide().append(e.$modal),d.append(e.$wrapper),e.$wrapper.on("click."+q,"[data-"+p+'-action="close"]',function(a){a.preventDefault(),e.close()}),e.$wrapper.on("click."+q,"[data-"+p+'-action="cancel"]',function(a){a.preventDefault(),e.$modal.trigger(v.CANCELLATION),e.settings.closeOnCancel&&e.close(v.CANCELLATION)}),e.$wrapper.on("click."+q,"[data-"+p+'-action="confirm"]',function(a){a.preventDefault(),e.$modal.trigger(v.CONFIRMATION),e.settings.closeOnConfirm&&e.close(v.CONFIRMATION)}),e.$wrapper.on("click."+q,function(a){var c=b(a.target);c.hasClass(k("wrapper"))&&e.settings.closeOnOutsideClick&&e.close()})}var n,o,p="remodal",q=a.REMODAL_GLOBALS&&a.REMODAL_GLOBALS.NAMESPACE||p,r=b.map(["animationstart","webkitAnimationStart","MSAnimationStart","oAnimationStart"],function(a){return a+"."+q}).join(" "),s=b.map(["animationend","webkitAnimationEnd","MSAnimationEnd","oAnimationEnd"],function(a){return a+"."+q}).join(" "),t=b.extend({hashTracking:!0,closeOnConfirm:!0,closeOnCancel:!0,closeOnEscape:!0,closeOnOutsideClick:!0,modifier:""},a.REMODAL_GLOBALS&&a.REMODAL_GLOBALS.DEFAULTS),u={CLOSING:"closing",CLOSED:"closed",OPENING:"opening",OPENED:"opened"},v={CONFIRMATION:"confirmation",CANCELLATION:"cancellation"},w=function(){var a=document.createElement("div").style;return void 0!==a.animationName||void 0!==a.WebkitAnimationName||void 0!==a.MozAnimationName||void 0!==a.msAnimationName||void 0!==a.OAnimationName}();m.prototype.open=function(){var a,c=this;c.state!==u.OPENING&&c.state!==u.CLOSING&&(a=c.$modal.attr("data-"+p+"-id"),a&&c.settings.hashTracking&&(o=b(window).scrollTop(),location.hash=a),n&&n!==c&&i(n),n=c,e(),c.$bg.addClass(c.settings.modifier),c.$overlay.addClass(c.settings.modifier).show(),c.$wrapper.show().scrollTop(0),c.$modal.focus(),h(function(){g(c,u.OPENING)},function(){g(c,u.OPENED)},c))},m.prototype.close=function(a){var c=this;c.state!==u.OPENING&&c.state!==u.CLOSING&&(c.settings.hashTracking&&c.$modal.attr("data-"+p+"-id")===location.hash.substr(1)&&(location.hash="",b(window).scrollTop(o)),h(function(){g(c,u.CLOSING,!1,a)},function(){c.$bg.removeClass(c.settings.modifier),c.$overlay.removeClass(c.settings.modifier).hide(),c.$wrapper.hide(),f(),g(c,u.CLOSED,!1,a)},c))},m.prototype.getState=function(){return this.state},m.prototype.destroy=function(){var a,c=b[p].lookup;i(this),this.$wrapper.remove(),delete c[this.index],a=b.grep(c,function(a){return!!a}).length,0===a&&(this.$overlay.remove(),this.$bg.removeClass(k("is",u.CLOSING)+" "+k("is",u.OPENING)+" "+k("is",u.CLOSED)+" "+k("is",u.OPENED)))},b[p]={lookup:[]},b.fn[p]=function(a){var c,d;return this.each(function(e,f){d=b(f),null==d.data(p)?(c=new m(d,a),d.data(p,c.index),c.settings.hashTracking&&d.attr("data-"+p+"-id")===location.hash.substr(1)&&c.open()):c=b[p].lookup[d.data(p)]}),c},b(document).ready(function(){b(document).on("click","[data-"+p+"-target]",function(a){a.preventDefault();var c=a.currentTarget,d=c.getAttribute("data-"+p+"-target"),e=b("[data-"+p+"-id="+d+"]");b[p].lookup[e.data(p)].open()}),b(document).find("."+q).each(function(a,c){var d=b(c),e=d.data(p+"-options");e?("string"==typeof e||e instanceof String)&&(e=j(e)):e={},d[p](e)}),b(document).on("keydown."+q,function(a){n&&n.settings.closeOnEscape&&n.state===u.OPENED&&27===a.keyCode&&n.close()}),b(window).on("hashchange."+q,l)})});
