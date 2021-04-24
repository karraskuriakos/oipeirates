<?php
	$open_settings = open_get_settings();
	if ( $open_settings->show_cta ) {
?>
<div class="footer-action">
	<a href="<?php echo $open_settings->cta_action; ?>"><?php echo $open_settings->cta_label; ?></a>
</div>
<?php
	}
?>