<?php get_header(); ?>
<script type="text/javascript"> 
    var adfly_id = 13307935; 
    var adfly_advert = 'int'; 
    var popunder = false; 
    var domains = ['streamcloud.eu', 'vidd.tv', 'vidto.me', 'flashx.tv', 'streamin.to', 'linkbucks.com', 'zettahost.tv', 'exashare.com', 'yourvideohost.com', 'hdvid.tv', 'vidzi.tv', 'openload.io', 'sh.st', 'openload.co', 'greevid.com', 'hdvid.live', 'vidon.club'];
</script> 
<script src="https://cdn.adf.ly/js/link-converter.js"></script> 

<div id="content">
	<?php if ( wptouch_have_posts() ) { ?>
		<?php wptouch_the_post(); ?>
			<h2 class="post-title"><?php the_title(); ?></h2>
			<div class="post-meta">


				<?php if ( classic_should_show_date() ) { ?>
					<div class="time"><i class="wptouch-icon-time"></i> <?php wptouch_the_time(); ?></div>
				<?php } if ( classic_should_show_author() ) { ?>
					<div class="author"><i class="wptouch-icon-user"></i> <?php echo sprintf( __( 'Written by %s', 'wptouch-pro' ), get_the_author() ); ?></div>
				<?php } ?>
		</div>

		<div id="content-area" class="<?php wptouch_post_classes(); ?> box"><div><center><font size="4" color="gray">Follow us on > <a href="https://www.instagram.com/oipeirates/" target="_blank"><font color="red">Instagram</font></a> < </font></center></div>
			<?php wptouch_the_content(); ?>

		</div>

		<?php do_action( 'wptouch_after_post_content' ); ?>
		<?php get_template_part( 'nav-bar' ); ?>

	<?php } ?>
</div>

<?php get_footer(); ?>
