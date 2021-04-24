<div id="content">
	<div class="post section post-701 post-name-front-page post-author-2 not-single page no-thumbnail">
<!--
		<div class="post-head-area">
			<h2 class="post-title heading-font"><?php _e( 'Our Hours', 'wptouch-pro' ); ?></h2>
		</div>
-->
		<dl id="hours">
<?php
	$open_settings = open_get_settings();
	$days = array(
		array( 'common' => 'sunday', 'full' => __( 'Sunday', 'wptouch-pro' ) ),
		array( 'common' => 'monday', 'full' => __( 'Monday', 'wptouch-pro' ) ),
		array( 'common' => 'tuesday', 'full' => __( 'Tuesday', 'wptouch-pro' ) ),
		array( 'common' => 'wednesday', 'full' => __( 'Wednesday', 'wptouch-pro' ) ),
		array( 'common' => 'thursday', 'full' => __( 'Thursday', 'wptouch-pro' ) ),
		array( 'common' => 'friday', 'full' => __( 'Friday', 'wptouch-pro' ) ),
		array( 'common' => 'saturday', 'full' => __( 'Saturday', 'wptouch-pro' ) )
	);

	$weekstart = intval( get_option( 'start_of_week' ) );

	$day_total = 6 + $weekstart; // we will be skipping $weekstart days, so let us go back to them. 6 not 7 because array indices start at 0.

	for ( $day_count = 0; $day_count <= $day_total; $day_count++ ) {

		if ( $day_count >= $weekstart ) {
			$day = $days[ $day_count % 7 ]; // If the week starts after Sunday we must skip back by mod 7 to do so.
			$class = '';
			$hours = $open_settings->{ 'hours_' . $day[ 'common' ] };

			if ( $hours == '' ) {
				$class = ' class="closed"';
				$hours = __( 'Closed', 'wptouch-pro' );
			}

			echo '<dt>' . $day[ 'full' ] . '</dt><dd' . $class . '>' . $hours . '</dd>';
		}
	}
?>
		</dl>

<?php
		if ( $open_settings->hours_note ) {
			echo '<p class="note">' . $open_settings->hours_note . '</p>';
		}
?>
	</div>
</div>