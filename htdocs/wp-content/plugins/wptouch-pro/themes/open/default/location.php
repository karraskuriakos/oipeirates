<div id="content">
	<div class="post section post-701 post-name-front-page post-author-2 not-single page no-thumbnail">
<!--
		<div class="post-head-area">
			<h2 class="post-title heading-font"><?php _e( 'Our Location', 'wptouch-pro' ); ?></h2>
		</div>
-->
		<?php
			$open_settings = open_get_settings();

			if ( $open_settings->map_address ) {
				echo '<iframe style="width: 100%; height: 300px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="//maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&ie=UTF8&z=16&t=m&iwloc=near&output=embed&q=' . $open_settings->map_address . '"></iframe>';
			}
		?>
	</div>
</div>