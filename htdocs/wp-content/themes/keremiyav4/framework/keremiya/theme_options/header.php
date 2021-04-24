<script type='text/javascript'>
jQuery(document).ready(function() {
	//AJAX Upload
	jQuery('.upload_button').each(function(){
		
		var clickedObject = jQuery(this);
		var clickedID = jQuery(this).attr('id');
		
		new AjaxUpload(clickedID, {
			  action: '<?php echo admin_url("admin-ajax.php"); ?>',
			  name: clickedID, // Dosya ismi
			  data: { // Ek veri gönder
					action: 'keremiya_upload',
					type: 'upload',
					data: clickedID },
			  autoSubmit: true, // Seçimden sonra dosya gönder
			  responseType: false,
			  onChange: function(file, extension){},
			  onSubmit: function(file, extension){
				  this.disable(); // Sadece 1 dosya yükleme izin vermek istiyorsanız, düğmesine yükleme devre dışı bırakabilirsiniz.
			  },
			  onComplete: function(file, response) {
				  this.enable();

				  jQuery('[name="'+clickedID+'"]').val(response);

				  jQuery('.save_tip').fadeIn(400).delay(5000).fadeOut(400);
			  }
		});
	
	});

	// Save Changes
	jQuery('.save_changes').click(function(e) {
		e.preventDefault();

		var form = jQuery(this).parents('form');
		
		jQuery.ajax({
			url: '<?php echo admin_url("admin-ajax.php"); ?>',
			data: jQuery(form).serialize()+'&action=keremiya_save_fields',
			type: 'POST',
			success: function() {
				jQuery('.save_tip').fadeIn(400).delay(5000).fadeOut(400);
			}
		});
	});

	// Reset Changes
	jQuery('.reset_btn').click(function(e) {
		e.preventDefault();

		var form = jQuery(this).parents('form');
		
		jQuery.ajax({
			url: '<?php echo admin_url("admin-ajax.php"); ?>',
			data: 'action=keremiya_reset_fields',
			type: 'POST',
			success: function() {
				jQuery('.reset_tip').fadeIn(400).delay(5000).fadeOut(400);
				setTimeout('location.reload(true);', 1200)
			}
		});
	});

	// Main tabs
	jQuery('.main_tabs a').click(function(e) {
		e.preventDefault();

		var href = jQuery(this).attr('href')
		var parent = jQuery(href).parent();
		var name = href.replace('#', '');
		
		jQuery(this).parents('ul').find('li').removeClass('selected');
		jQuery(this).parent().addClass('selected');

		jQuery('.sub_tabs ul').fadeOut();
		jQuery('.sub_tabs').find('.'+name).fadeIn();

		jQuery(parent).find('> div.mainTab').slideUp();
		jQuery(href).slideDown();
	});
	
	// Sub tabs
	jQuery('.sub_tabs a').click(function(e) {
		e.preventDefault();

		var href = jQuery(this).attr('href')
		var parent = jQuery(href).parent();

		jQuery(this).parents('ul').find('li').removeClass('selected');
		jQuery(this).parent().addClass('selected');
		
		jQuery(parent).find('> div').slideUp();
		jQuery(href).slideDown();
	});

	// Skins
	jQuery('.skins img').live('click', function(e) {
		e.preventDefault();

		var id = jQuery(this).attr('id');
		var bg_color = jQuery(this).data('background');
		var pattern = jQuery(this).data('pattern');
		var link_color = jQuery(this).data('link');
		
		jQuery(this).parent().find('img').removeClass('selected');
		jQuery(this).addClass('selected');

		jQuery('[name=keremiya_pattern]').parent().find('img').removeClass('selected');
		jQuery('#' + pattern).addClass('selected');
		
		jQuery(this).parent().find('input').val(id);

		jQuery('#keremiya_bg_color').val(bg_color);
		jQuery('#colorpicker_bg_color .colorSelector').ColorPickerSetColor(bg_color);
		jQuery('#colorpicker_bg_color .colorSelector div').css('background-color', '#' + bg_color);
		
		jQuery('[name=pyre_pattern]').val(pattern);
		
		jQuery('#keremiya_link_color').val(link_color);
		jQuery('#colorpicker_link_color .colorSelector').ColorPickerSetColor(link_color);
		jQuery('#colorpicker_link_color .colorSelector div').css('background-color', '#' + link_color);
	});
	
	// Images
	jQuery('.images img').live('click', function(e) {
		e.preventDefault();

		var id = jQuery(this).attr('id');

		jQuery(this).parent().find('img').removeClass('selected');
		jQuery(this).addClass('selected');
		
		jQuery(this).parent().find('input').val(id);
	});
	
	jQuery('.images img.selected').live('click', function(e) {
		e.preventDefault();

		jQuery(this).removeClass('selected');
		jQuery(this).parent().find('input').val('');
	});
});
</script>
<div class='keremiya'>
	<div class='keremiya_header'>
		<a href='https://oipeirates.tv/' target='_blank'><img class='logo' src='<?php bloginfo('template_directory'); ?>/framework/keremiya/theme_options/images/logo.png' alt='' /></a>
	
	<ul class='main_tabs'>
		<li class='selected'><a class='general' href='#general_settings'>General Settings</a></li>
		<li><a class='homepage' href='#homepage_settings'>Home Settings</a></li>
		<li><a class='posts' href='#posts_settings'>Content Settings</a></li>
		<li><a class='seo' href='#seo_settings'>SEO Settings</a></li>
		<li style="border:none;"><a class='appearence' href='#appearence_settings'>ADVERTISEMENT</a></li>
	</ul>
	</div>
	
	<div class='keremiya_container'>
		<div class='sub_tabs'>
			<ul class='general_settings selected'>
				<li class='selected'><a href='#general'>General</a></li>
				<li><a href='#analytics'>Analytics Settings</a></li>
				<li><a href='#email'>Communication Settings</a></li>
				<li><a href='#social_media'>Social Media Settings</a></li>
				<li><a href='#player'>Player Settings</a></li>
			</ul>
			<ul class='homepage_settings selected'>
			<li class='selected'><a href='#anasayfa'>Reading Settings</a></li>
			<li><a href='#slider'>jQuery Slider Settings</a></li>
			<li><a href='#theme_footer'>Footer Settings</a></li>
			<li><a href='#tavsiye_filmler'>Recommended Movies</a></li>
			<li><a href='#encok_filmler'>Most Viewed</a></li>
			</ul>
			<ul class='posts_settings selected'>
				<li class='selected'><a href='#partlar'>Part System Settings</a></li>
				<li><a href='#benzerfilm'>Similar Films Settings</a></li>
				<li><a href='#filmbilgileri'>Movie Settings</a></li>
			</ul>
			<ul class='seo_settings selected'>
				<li class='selected'><a href='#seohome'>Home Settings</a></li>
				<li><a href='#seosingle'>Text Settings</a></li>
				<li><a href='#seokategori'>Category Settings</a></li>
				<li><a href='#seogenel'>General Settings</a></li>
			</ul>
			<ul class='appearence_settings selected'>
				<li class='selected'><a href='#reklam_a'>Video Advertising Front</a></li>
				<li><a href='#reklam_b'>728x90 ads</a></li>
				<li><a href='#reklam_c'>Left Scrolling </a></li>
				<li><a href='#reklam_d'>Right Scrolling</a></li>
				<li><a href='#reklam_e'>Splash </a></li>
			</ul>
		</div>