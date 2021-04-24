<?php
/*

Template Name: Animes

*/
get_header();
	echo '<div id="content">';
	if (get_option('keremiya_manset_slider') == 'On'): 
	include(TEMPLATEPATH . '/slide.php'); // Manşet Sistemi
	endif;
	echo '<div class="leftC1">'; 
	echo '<div class="filmborder1"><h1  align="center" style="font-family: Arial;"><strong>ANIMES</strong></h1>';
	echo '<div class="filmcontent1">';
	// Gerekli Ayarlar
	$izlenenler = get_option('keremiya_encokizlenenler_page_id');
	$yorumlananlar = get_option('keremiya_encokyorumlananlar_page_id');
	$begenilenler = get_option('keremiya_encokbegenilenler_page_id');
	$animes = get_option('keremiya_animes_page_id');  
	?>
	<h1 class="yazitip">
		<ul>
		<li <?php if ( is_front_page() ) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_option('home'); ?>/"><?php echo keremiya_yeniler; ?></a></li>
		<?php if ( $izlenenler>0 ) : ?><li <?php if (is_page($izlenenler)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($izlenenler) ?>"><?php echo get_the_title($izlenenler) ?></a></li><?php endif; ?>
		<?php if ( $yorumlananlar>0 ) : ?><li <?php if (is_page($yorumlananlar)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($yorumlananlar) ?>"><?php echo get_the_title($yorumlananlar) ?></a></li><?php endif; ?>
		<?php if ( $begenilenler>0 ) : ?><li <?php if (is_page($begenilenler)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($begenilenler) ?>"><?php echo get_the_title($begenilenler) ?></a></li><?php endif; ?>
		<?php if ( $animes>0 ) : ?><li <?php if (is_page($animes)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($animes) ?>"><?php echo get_the_title($animes) ?></a></li><?php endif; ?>
		</ul>
	</h1>
	<?php
		echo do_shortcode('[ajax_load_more seo="true" cache_id="cache-anime" id="animes" cache="true" preloaded="true" preloaded_amount="10" posts_per_page="10" button_label="More Movies" category="anime"]');
			echo '&nbsp;';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '<div style="clear:both;"></div>';
	echo '<div class="footborder"></div>';
	get_footer(); 
?>