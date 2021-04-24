<a href="<?php the_permalink(); ?>" class="post-head" style="background-image: url(<?php mobilestore_full_image_url(); ?>);">
	<!-- This is intentionally H2 for the blog page -->
	<h2><?php the_title(); ?></h2>
	<p><span class="date"><?php echo date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ); ?></p>
	<!-- <p><a href="<?php the_permalink(); ?>">Read This Post</a></p> -->
</a>
<div class="content">
	<?php the_excerpt(); ?>
	<p><a href="<?php the_permalink(); ?>"><?php _e( 'Read This Post &rsaquo;', 'wptouch-pro' ); ?></a></p>

</div>
