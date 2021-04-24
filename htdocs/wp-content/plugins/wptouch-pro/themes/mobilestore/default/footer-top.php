
	<?php if ( wptouch_has_menu( 'footer_menu' ) ) {
		echo '<div class="footer-menu clearfix">';
		wptouch_show_menu( 'footer_menu' );
		echo '</div>';
	} ?>