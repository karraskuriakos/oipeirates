<?php if ( foundation_is_theme_using_module( 'custom-latest-posts' ) && wptouch_fdn_is_custom_latest_posts_page() ) { ?>

	<?php wptouch_fdn_custom_latest_posts_query(); ?>
	<?php get_template_part( 'index' ); ?>

<?php } else { ?>

	<?php get_header(); ?>

	<div id="content">
		<?php if ( wptouch_have_posts() ) { ?>
			<?php wptouch_the_post(); ?>
			<div class="<?php wptouch_post_classes(); ?>">
				<div class="post-head-area">
					<h2 class="post-title heading-font"><?php the_title(); ?></h2>
				</div>
				<div class="post-content">
					<?php wptouch_the_content() ; ?>
				</div>
			</div>
		<?php } ?>
	</div> <!-- content -->

	<?php get_footer(); ?>

<?php } ?>