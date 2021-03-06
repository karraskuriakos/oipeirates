<?php

class KeremiyaFrameworkOptions {
	
	public function __construct()
	{
		include_once('keremiya/theme_options/index.php');
	}
	
	public function upload($id, $label, $desc)
	{ ?>
		<div class='field upload'>
			<label for='keremiya_<?php echo $id; ?>_label'><?php echo $label; ?></label>
			<div class='input'>
				<input class='keremiya_upload' name='keremiya_<?php echo $id; ?>' id='keremiya_<?php echo $id; ?>_label' type='text' value='<?php echo get_option('keremiya_' . $id); ?>' />
				<div id='keremiya_<?php echo $id; ?>' class='upload_button'>Upload</div>
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function textfield($id, $label, $desc)
	{ ?>
		<div class='field upload'>
			<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			<div class='input'>
				<textarea name='keremiya_<?php echo $id; ?>' style="height:50px;" id='keremiya_<?php echo $id; ?>'><?php echo get_option('keremiya_' . $id); ?></textarea>
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function textarea($id, $label, $desc)
	{ ?>
		<div class='field upload'>
			<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			<div class='input'>
				<textarea name='keremiya_<?php echo $id; ?>' id='keremiya_<?php echo $id; ?>'><?php echo get_option('keremiya_' . $id); ?></textarea>
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function text($id, $label, $desc)
	{ ?>
		<div class='field text'>
			<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			<div class='input'>
				<input name='keremiya_<?php echo $id; ?>' type='text' id='keremiya_<?php echo $id; ?>' value='<?php echo get_option('keremiya_' . $id); ?>' />
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function checkbox($id, $label, $desc)
	{ ?>
		<?php
		if(get_option('keremiya_' . $id) == 'On') {
			$checked = 'checked="checked"';
		}
		?>
		<div class='field checkbox'>
			<div class='input'>
				<input name='keremiya_<?php echo $id; ?>' type='hidden' value='Off' />
				<input <?php echo $checked; ?> name='keremiya_<?php echo $id; ?>' type='checkbox' id='keremiya_<?php echo $id; ?>' value='On' />
				<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			</div>
			<?php if($desc): ?>
			<p class='desc_checkbox'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function select($id, $options = array(), $label = '', $desc = '')
	{ ?>
		<div class='field select'>
			<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			<div class='input'>
				<select name='keremiya_<?php echo $id; ?>' id='keremiya_<?php echo $id; ?>'>
					<?php foreach($options as $key => $value): ?>
					<?php
					if(get_option('keremiya_' . $id) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					?>
					<option <?php echo $selected; ?> value='<?php echo $key; ?>'><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function checkboxes($ids = array(), $title = '') { ?>
		<div class='field checkbox'>
			<p style='margin-top: 0;'><strong><?php echo $title; ?></strong></p>
			<?php foreach($ids as $id => $label): ?>
				<?php
				if(get_option('keremiya_' . $id) == 'On') {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
				?>
				<div class='input'>
					<input name='keremiya_<?php echo $id; ?>' type='hidden' value='Off' />
					<input <?php echo $checked; ?> name='keremiya_<?php echo $id; ?>' type='checkbox' id='keremiya_<?php echo $id; ?>' value='On' />
					<label for='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
				</div>
			<?php endforeach; ?>
		</div>
	<?php }
	
	public function skins($id, $images = array(), $label, $desc = '') { ?>
		<div class='field skins'>
			<label><?php echo $label; ?></label>
			<div class='input'>
				<?php foreach($images as $name => $image): ?>
				<?php
				if(get_option('keremiya_' . $id) == $name) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				?>
				<img data-background='<?php echo $image['bg_color']; ?>' data-pattern='<?php echo $image['pattern']; ?>' data-link='<?php echo $image['link_color']; ?>' src='<?php echo $image['thumb']; ?>' class='<?php echo $selected; ?>' id='<?php echo $name; ?>' alt='<?php echo ucwords(str_replace('_', ' ', $id)); ?>' title='<?php echo ucwords(str_replace('_', ' ', $id)); ?>' />
				<?php endforeach; ?>
				<input type='hidden' name='keremiya_<?php echo $id; ?>' value='<?php echo get_option('keremiya_' . $id); ?>' />
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function images($id, $images = array(), $label, $desc = '') { ?>
		<div class='field images'>
			<label><?php echo $label; ?></label>
			<div class='input'>
				<?php foreach($images as $name => $image): ?>
				<?php
				if(get_option('keremiya_' . $id) == $name) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				?>
				<img src='<?php echo $image ?>' class='<?php echo $selected; ?>' id='<?php echo $name; ?>' alt='<?php echo ucwords(str_replace('_', ' ', $id)); ?>' title='<?php echo ucwords(str_replace('_', ' ', $id)); ?>' />
				<?php endforeach; ?>
				<input type='hidden' name='keremiya_<?php echo $id; ?>' value='<?php echo get_option('keremiya_' . $id); ?>' />
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
	public function colorpicker($id, $label, $desc = '') { ?>
		<script type='text/javascript'>
		jQuery(document).ready(function() {
			// Colorpicker
			jQuery('#colorpicker_<?php echo $id; ?> .colorSelector').ColorPicker({
				color: '#<?php echo get_option('keremiya_' . $id); ?>',
				onShow: function (colpkr) {
					jQuery(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					jQuery(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					jQuery('#colorpicker_<?php echo $id; ?> .colorSelector div').css('backgroundColor', '#' + hex);
					jQuery('#colorpicker_<?php echo $id; ?> input').val(hex);
				}
			});
		});
		</script>
		<div class='field colorpicker_wrapper' id='colorpicker_<?php echo $id; ?>'>
			<label name='keremiya_<?php echo $id; ?>'><?php echo $label; ?></label>
			<div class='input'>
				<input type='text' value='<?php echo get_option('keremiya_' . $id); ?>' name='keremiya_<?php echo $id; ?>' id='keremiya_<?php echo $id; ?>' />
				<div class="colorSelector"><div style='background-color: #<?php echo get_option('keremiya_' . $id); ?>;'></div></div>
			</div>
			<?php if($desc): ?>
			<p class='desc'><?php echo $desc; ?></p>
			<?php endif; ?>
		</div>
	<?php }
	
}