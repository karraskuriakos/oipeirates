<?php
add_action('widgets_init', 'keremiya_kategori_widgets');

function keremiya_kategori_widgets()
{
	register_widget('Keremiya_Kategoriler');
}

class Keremiya_Kategoriler extends WP_Widget {
	
	function Keremiya_Kategoriler()
	{
		$widget_ops = array('classname' => 'kategoriler', 'description' => 'Kategorileri isteğinize göre listeler.');

		$control_ops = array('id_base' => 'keremiya-kategoriler');

		$this->WP_Widget('keremiya-kategoriler', '+ Keremiya Kategoriler', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$number = $instance['number'];
		
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		?>
		<?php if($number) { ?>
		<?php wp_list_categories('orderby=name&hide_empty=0&title_li=&depth=1&child_of='.$number.''); ?>
		<?php } else { ?>
		<?php wp_list_categories('show_option_all&orderby=name&title_li=&depth=0'); ?>
		<?php } ?>
		<?php 
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Kategoriler', 'number' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Başlık:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Kategori ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
			<span>Ana kategorinin ID 'ini girdiğinizde Alt Kategoriler Listelenecektir. Boş bıraktığınızda tüm kategoriler listelenir.</span>
		</p>
	<?php
	}
}
?>