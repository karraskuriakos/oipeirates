<div id="sidebar">
<?php if(get_option('keremiya_feedburner_var') == 'On'): ?>
<div class="sidebarborder">
	<div class="sidebar-right">
		<?php include(TEMPLATEPATH.'/feedburner.php'); ?>
	</div>
</div>
<?php endif; ?>

<?php if(get_option('keremiya_encok_var') == 'On'): ?>
<div class="sidebarborder">
	<div class="sidebar-right">
		<h2>Most Viewed Movies</h2>
		<div class="fimanaortala">
		<?php $encoksayi = get_option('keremiya_encoksayi');?>
		<?php query_posts('showposts='.$encoksayi.'&v_sortby=views&v_orderby=desc') ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="filmana">
			<div class="filmsol">
			<?php keremiya_resim('80px', '70px', 'izlenen-resim'); ?>
			</div>
			<div class="filmsag">
				<div class="filmsagbaslik">
				<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				</div>
				<div class="filmsagicerik">
				<?php if(function_exists('the_views')) { the_views(); echo ""; } ?>
				<p><?php nezaman_yazildi(); ?></p>
				</div>
				<div class="filmizleme">
				<a href="<?php the_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/images/filmizle.png" alt="tainies online movies" height="21" width="61" /></a>
				</div>
			</div>
		</div>
	<?php endwhile; else: ?>
	<?php endif; ?>
	<?php wp_reset_query(); ?>
		</div>
	</div>
</div>
<?php endif; ?>


<?php if(is_active_sidebar('sidebar')) { dynamic_sidebar('sidebar'); ?>
<?php } else { ?>
<div class="sidebarborder">
	<div class="sidebar-right">
		<h2>Κατηγορίες</h2>
		<ul>
		<?php wp_list_categories('show_option_all&orderby=name&title_li=&depth=0'); ?>
		</ul>
	</div>
</div>
<?php } ?>
</div>