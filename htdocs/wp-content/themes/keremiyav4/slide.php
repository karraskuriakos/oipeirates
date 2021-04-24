<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scroll.js"></script>

<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'mygallery',
	beltclass: 'belt',
	panelclass: 'panel',
	autostep: {enable:<?php echo get_option('keremiya_slider_auto'); ?>, moveby:3, pause:<?php echo get_option('keremiya_slider_step'); ?>},
	panelbehavior: {speed:500, wraparound:true, persist:true},
	defaultbuttons: {enable: true, moveby: <?php echo get_option('keremiya_slider_hopla'); ?>, leftnav: ['<?php bloginfo('template_url'); ?>/images/scar1.png', -12, 4], rightnav: ['<?php bloginfo('template_url'); ?>/images/scar2.png', -9, 4]},
	statusvars: ['statusA', 'statusB', 'statusC'],
	contenttype: ['external']
})
</script>

<div class="filmslayt">

	<div class="filmslaytc">
		<div id="myslides">
			<div id="mygallery" class="stepcarousel">
				<div class="belt">
				<?php // Gerekli Ayarlar
				if(get_option('keremiya_manset_kategori')) { $katego = get_option('keremiya_manset_kategori'); } else { };
				$yazi = get_option('keremiya_manset_posts');
				$tip = get_option('keremiya_slider_effect');
				$keremiya_slide = new WP_Query('cat='. $katego .'&showposts='. $yazi .'&orderby='. $tip .''); ?>
				<?php while ($keremiya_slide->have_posts()) : $keremiya_slide->the_post();?>
				
				<div class="panel">
				<a href="<?php the_permalink() ?>">
				<?php keremiya_resim('138px', '110px', 'slide-resim'); ?>
				</a>
				<?php if(function_exists('the_views')) { echo '<div class="ozet">'; the_views(); echo keremiya_izlenme; echo '</div>'; } ?>
				</div>

				<?php endwhile; ?>
				<?php wp_reset_query(); ?>

				</div>

			</div>
		</div>
	</div>
</div>
