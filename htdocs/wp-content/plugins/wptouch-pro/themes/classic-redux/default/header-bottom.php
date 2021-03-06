<!-- Back Button for Web-App Mode -->
<div class="wptouch-icon-reply back-button tappable"><!-- css-button --></div>

<div class="page-wrapper clearfix"><!-- tag closed in foundation's footer.php -->

	<?php $settings = classic_get_settings(); ?>
	<?php $foundation_settings = foundation_get_settings(); ?>

	<div id="header">
		<?php if ( foundation_has_logo_image() ) { ?>
			<div class="logo tappable">
				<a href="<?php wptouch_bloginfo( 'url' ); ?>">
					<img id="header-logo" src="<?php foundation_the_logo_image(); ?>" alt="tainies online greek subs - oipeirates" />
				</a>
			</div>
		<?php } else { ?>
			<h2 class="site-title heading-font"><a href="<?php wptouch_bloginfo( 'url' ); ?>" class="tappable"><?php wptouch_bloginfo( 'site_title' ); ?></a></h2>
		<?php } ?>

		<?php if ( wptouch_has_menu( 'primary_menu' ) ) { ?>
			<div class="<?php if ( !classic_show_menu_button_text() ) echo 'wptouch-icon-list-ul'; ?> tappable menu-drop show-hide-toggle" data-effect-target="menu">
				<?php if ( classic_show_menu_button_text() ) { ?>
					<span><?php _e( 'Menu', 'wptouch-pro' ); ?></span>
				<?php } ?>
			</div>
		<?php } ?>
	</div>

	<?php if ( wptouch_has_menu( 'primary_menu' ) ) { ?>

		<div id="menu" class="default-menu show-hide-menu">
			<?php if ( $settings->show_tab_bar ) { ?>
				<ul class="tab-menu clearfix">
					<li><a href="#" class="wptouch-icon-list-ul no-ajax" data-section="menu" title="<?php _e( 'Menu', 'wptouch-pro' ); ?>"></a></li>

					<?php if ( $settings->tab_bar_cat_tags == 'categories' || $settings->tab_bar_cat_tags == 'categories_and_tags' ) { ?>
						<li><a href="#" class="wptouch-icon-th no-ajax" data-section="categories" title="<?php _e( 'Categories', 'wptouch-pro' ); ?>"></a></li>
					<?php } ?>

					<?php if ( $settings->tab_bar_cat_tags == 'tags' || $settings->tab_bar_cat_tags == 'categories_and_tags' ) { ?>
						<li><a href="#" class="wptouch-icon-tags no-ajax" data-section="tags" title="<?php _e( 'Tags', 'wptouch-pro' ); ?>"></a></li>
					<?php } ?>

					<li><a href="#" class="wptouch-icon-search no-ajax needsclick" data-section="search" title="<?php _e( 'Search', 'wptouch-pro' ); ?>"></a></li>

					<?php if ( get_option( 'comment_registration' ) ) { ?>
						<?php if ( !is_user_logged_in() ) { ?>
							<li><a href="<?php echo wp_login_url( esc_url_raw( $_SERVER['REQUEST_URI'] ) ); ?>" class="login-button login-toggle wptouch-icon-key no-ajax" title="<?php _e( 'Login', 'wptouch-pro' ); ?>"></a></li>
						<?php } else { ?>
							<li><a href="<?php echo wp_logout_url( esc_url_raw( $_SERVER['REQUEST_URI'] ) ); ?>" class="login-button wptouch-icon-user" title="<?php _e( 'Logout', 'wptouch-pro' ); ?>"></a>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>

			<?php if ( $settings->tab_bar_cat_tags == 'categories' || $settings->tab_bar_cat_tags == 'categories_and_tags' ) { ?>
				<div class="tab-section cat-tag categories wptouch-menu">
					<h4><?php _e( 'Categories', 'wptouch-pro' ); ?></h4>
					<?php wptouch_fdn_ordered_cat_list( $settings->tab_bar_max_cat_tags, true ); ?>
				</div>
			<?php } ?>

			<?php if ( $settings->tab_bar_cat_tags == 'tags' || $settings->tab_bar_cat_tags == 'categories_and_tags' ) { ?>
				<div class="tab-section cat-tag tags wptouch-menu">
					<h4><?php _e( 'Tags', 'wptouch-pro' ); ?></h4>
					<?php wptouch_fdn_ordered_tag_list( $settings->tab_bar_max_cat_tags ); ?>
				</div>
			<?php } ?>

			<div class="tab-section search clearfix">
				<form method="get" id="searchform" action="<?php wptouch_bloginfo( 'search_url' ); ?>/">
					<div>
						<input type="text" name="s" id="search-text" placeholder="<?php _e( 'Search this website', 'wptouch-pro' ); ?>&hellip;" />
						<button name="submit" type="submit" id="search-submit" class="button-dark">
							<?php _e( 'Search', 'wptouch-pro' ); ?>
						</button>
					</div>
				</form>
			</div>

			<?php if ( $foundation_settings->twitter_account != 'none' && defined( 'WORDTWIT_WPTOUCH_PRO_EXT' ) ) { ?>
				<?php $accounts = wordtwit_wptouch_get_accounts(); ?>
				<?php $twitter_account = $foundation_settings->twitter_account; ?>
				<div class="tab-section twitter wptouch-menu">
					<h4><?php _e( 'Tweets', 'wptouch-pro' ); ?></h4>
					<p class="author-link">
						<img src="<?php echo $accounts[ $twitter_account ]->profile_image_url; ?>" alt="twitter avatar">
						<span>
							<?php echo sprintf( __( 'Follow %s on Twitter', 'wptouch-pro' ), '<a href="https://twitter.com/' . $twitter_account . '" target="_blank">@' . $twitter_account . '</a>' ); ?>
							</span>
					</p>
					<ul>
						<?php $tweets = wordtwit_wptouch_get_tweets_for_account( $twitter_account ); ?>
						<?php foreach( $tweets as $tweet ) { ?>
							<li>
							<a href="<?php echo 'https://twitter.com/' . $twitter_account . '/status/' . $tweet['id']; ?>" rel="external-tweet-link" target="_blank" class="no-ajax">
							<p class="tweet-time"><?php foundation_twitter_pretty_time( foundation_twitter_get_tweet_time( $tweet['created_at'] ) ); ?></p>
							<p class="tweet-text"><?php echo foundation_twitter_pretty_text( $tweet['text'] ); ?></p>
							</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
		<?php } // if show tab bar ?>

			<div class="tab-section wptouch-menu menu">
				<?php if ( $settings->show_tab_bar ) { ?>
				<h4><?php _e( 'Menu', 'wptouch-pro' ); ?></h4>
				<?php } ?>

				<?php wptouch_show_menu( 'primary_menu' ); ?>
			</div>
		</div><!-- menu -->

	<?php } ?>

	<?php do_action( 'wptouch_advertising_top' ); ?>

	<?php if ( function_exists( 'foundation_featured_slider' ) ) { ?>
		<?php if ( featured_should_show_slider() ) { // On homepage and blog load the slider ?>
			<?php foundation_featured_slider(); ?>
		<?php } ?>
	<?php } ?>