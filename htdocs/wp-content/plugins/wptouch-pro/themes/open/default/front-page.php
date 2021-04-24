<?php get_header(); ?>

<?php
	if ( isset( $wp_query->query_vars[ 'open_feature' ] ) ) {
		switch ( $wp_query->query_vars[ 'open_feature' ] ) {
			case 'hours':
				require( 'hours.php' );
				break;
			case 'location':
				require( 'location.php' );
				break;
		}
	} else {
?>

	<?php
		$open_settings = open_get_settings();
		if ( $open_settings->show_hours ) {
	?>
	<aside id="openclosed">
		<?php
			$today = date( 'l', current_time( 'timestamp' ) );
			$translated_today = __( $today, 'wptouch-pro' );
			$todays_hours = $open_settings->{ 'hours_' . strtolower( $today ) };
			if ( $todays_hours ) {
				echo sprintf( __( 'We&lsquo;re <em>open</em> every %s %s.', 'wptouch-pro' ), $translated_today, $todays_hours );
			} else {
				echo sprintf( __( 'Sorry, we&lsquo;re <em>closed</em> every %s.', 'wptouch-pro' ), $translated_today );
			}

		?>
	</aside>
	<?php
		}
	?>

	<div id="content">
		<?php open_homepage_content(); ?>

		<?php if ( $open_settings->open_show_menu_on_homepage && wptouch_has_menu( 'primary_menu' ) ) { ?>
			<nav id="homepage-menu-list" class="homepage-menu show-hide-menu">
				<?php wptouch_show_menu( 'primary_menu' ); ?>
			</nav>
		<?php } elseif ( open_add_menu_links( '' ) ) { ?>
			<nav id="homepage-menu-list" class="homepage-menu show-hide-menu">
				<ul class="menu-tree">
					<?php echo open_add_menu_links( '' ); ?>
				</ul>
			</nav>
		<?php } ?>

	</div><!-- #content -->

<?php
	}
?>

<?php get_footer(); ?>