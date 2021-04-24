<!-- Back Button for Web-App Mode -->
<div class="wptouch-icon-reply back-button tappable"><!-- css-button --></div>

<div class="page-wrapper">
	<div id="header-area">
		<div id="header-title-logo"<?php open_header_class(); ?>>
			<?php if ( ( is_front_page() ) && !isset( $wp_query->query_vars[ 'open_feature' ] ) ) { ?>
				<?php if ( foundation_has_logo_image() ) { ?>
					<img id="header-logo" src="<?php foundation_the_logo_image(); ?>" alt="logo image" />
				<?php } else { ?>
					<h1 class="heading-font<?php if ( is_home() || is_front_page() ) { echo ' color'; } ?>" ><?php wptouch_bloginfo( 'site_title' ); ?></h1>
				<?php } ?>
			<?php } else { ?>
				<a href="<?php wptouch_bloginfo( 'url' ); ?>"><h1 class="heading-font"><?php wptouch_bloginfo( 'site_title' ); ?></h1></a>
			<?php } ?>
		</div>

		<?php
		if ( ( is_front_page() ) && !isset( $wp_query->query_vars[ 'open_feature' ] ) ) {
			open_tagline();
		} else {
			echo '<a href="#" id="menu-toggle" class="show-hide-toggle" data-effect-target="menu"><i class="wptouch-icon-reorder"></i></a>';
		}
		?>

		<?php open_header_image(); ?>
	</div>

	<nav id="menu" class="wptouch-menu show-hide-menu">
		<?php if ( wptouch_has_menu( 'primary_menu' ) ) { wptouch_show_menu( 'primary_menu' ); } ?>
	</nav>