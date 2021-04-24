<div id="sidebar">
<?php if(get_option('keremiya_feedburner_var') == 'On'): ?>
<div class="sidebarborder">
	<div class="sidebar-right">
		<?php include(TEMPLATEPATH.'/feedburner.php'); ?>
	</div>
</div>
<?php endif; ?>

<?php if(is_active_sidebar('kategori')) { ?>
<?php dynamic_sidebar('kategori'); ?>
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