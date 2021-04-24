<div class="<?php wptouch_post_classes(); ?>">
	<div class="post-head-area">
		<?php prose_header_image( get_the_ID() ); ?>
		<h2 class="post-title heading-font"><?php wptouch_the_title(); ?></h2>
	</div>
	<div class="post-content">
		<?php wptouch_the_content(); ?>
	</div>
</div>