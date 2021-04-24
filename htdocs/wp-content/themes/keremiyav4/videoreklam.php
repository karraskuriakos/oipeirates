		<script type="text/javascript"> setTimeout('gizle()',<?php echo get_option('keremiya_r_a_s'); ?>); function gizle() { var x=document.getElementById('film').style; var y=document.getElementById('filmoncereklam').style; y.display='none'; x.display='block'; }</script>
		<div id="filmoncereklam" align="center">
		
		<?php echo get_option('keremiya_r_a_a'); ?></br>
		
		<img src="<?php bloginfo('template_directory'); ?>/images/prog-bar.gif" alt="Yükleniyor"/> </br>
		<?php if(get_option('keremiya_r_a_g') == 'On'): ?><a onclick="gizle();return false;" class="reklamgec" href="#">Reklamı Geç</a><?php endif; ?>

		</div>
		
		<div id="film" style="display:none">
 		<?php if ( wp_link_pages('echo=0') ) { ?>
		<div class="begen clearfix"><?php printLikes(get_the_ID()); ?></div>
		<?php if(get_post_meta($post->ID, 'partsistemi', true) == 'Manuel') { ?>
		<div class="keremiya_part"><?php keremiya_part_sistemi(''); ?></div>
		<?php } else { ?>
		<div class="keremiya_part"><?php bilgi_part(); $sayfalama = get_option('keremiya_part_iki'); wp_link_pages('before=&pagelink=<span>'. $sayfalama .' %</span>&after=<span class="keros"><a href="#respond">Κριτική</a></span>'); ?></div>
		<?php } ?> 
		<?php } else {?>
		<?php } ?> 
		<div class="clear"></div>
		<div class="filmicerik">
		<?php the_content(); ?>
		</div>
		</div>