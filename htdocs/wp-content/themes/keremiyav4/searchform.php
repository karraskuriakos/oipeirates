<form id="searchform" method="get" action="<?php echo home_url( '/' ); ?>">
<input type="text" value="<?php echo keremiya_arama; ?>" name="s" id="searchbox" onfocus="if (this.value == '<?php echo keremiya_arama; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo keremiya_arama; ?>';}" />
<input type="submit" id="searchbutton" value="" />
</form>