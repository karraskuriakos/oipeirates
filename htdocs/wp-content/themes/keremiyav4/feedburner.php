<h2><?php echo keremiya_feedburner_baslik; ?></h2>

<div class="newsletter">
			
<form id="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo get_option('keremiya_feedburner'); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
<input type="text" id="subbox" name="email" value="<?php echo keremiya_feedburner_mesaj; ?>" onfocus="if (this.value == '<?php echo keremiya_feedburner_mesaj; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo keremiya_feedburner_mesaj; ?>';}"/>
<input type="hidden" value="<?php echo get_option('keremiya_feedburner'); ?>" name="uri"/>
<input type="hidden" name="loc" value="en_US"/>
<input type="submit" id="subbutton" value="" />
</form>

</div>