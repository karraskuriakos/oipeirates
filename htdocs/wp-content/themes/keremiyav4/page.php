<?php get_header(); ?>
<div id="content">
	<div class="leftC">
		<div class="filmborder">
			<div class="filmcontent">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<h1 class="yazitip"><?php the_title(); ?></h1>
			<div class="filmicerik2">
			<?php the_content(); ?>
			</div>
			
			<?php endwhile; else: ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php get_sidebar(); ?>
</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer(); ?>
