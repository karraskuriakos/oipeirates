<?php // Keremiya Film Kutusu Başlangıçı
add_action('widgets_init', 'post_boxes_widgets');

function post_boxes_widgets() {
	register_widget('Keremiya_Kutu');
}

class Keremiya_Kutu extends WP_Widget {
	function Keremiya_Kutu() {
		$widget_ops = array('classname' => 'keremiya_kutu', 'description' => 'Anasayfada film yayınlamanızı sağlar.');
		$this->WP_Widget( 'keremiya_kutu-widget', '+ Keremiya Film Kutusu', $widget_ops);
	}

	function widget( $args, $instance ) {
		global $post;
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$posts_per_page = $instance['posts_per_page'];
		$pagination = $instance['pagination'];		
		$cat = $instance['cat'];
		$post_sort = $instance['post_sort'];
		$post_order = $instance['post_order'];
		$display = $instance['display'];
		$tumunu_gor = $instance['tumunu_gor'];

		// Widget Başlangıçı
		echo $before_widget; ?>
		
	<?php echo $before_title; ?><?php echo $title; ?><?php if($tumunu_gor) { ?><div class="tumunugor"><div class="tumunugurortala"><a href="<?php echo($tumunu_gor); ?>">Tümünü Gör</a></div></div><?php } ?><?php echo $after_title; ?>	
	
	<?php
		if($pagination == "enable") { $paged = get_query_var('paged'); } else { $paged = 1; }
		query_posts(array('paged' => $paged, 'posts_per_page' => $posts_per_page, 'post_sort' => $post_sort, 'post_order' => $post_order, 'post_status' => 'publish', 'caller_get_posts' => 1, 'post_type' => 'post', 'cat' => $cat)); 
		if (have_posts()) : while (have_posts()) : the_post();
			include (TEMPLATEPATH . '/film.php');
			endwhile;
				echo "\r\t<div class=\"clear\"></div>";
				echo $after_widget;
			if($pagination == "enable") { 
				echo $before_widget;
				wp_pagenavi(); 
				echo $after_widget; 
			} 
			else {
			} 
		else : 
		echo "<p style='margin:2px 0px 4px 5px;'>Keremiya film kutusuna eklediğiniz kategoride film bulamadım.</p>";
		echo $after_widget; 
		endif; wp_reset_query();
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cat'] = strip_tags( $new_instance['cat'] );
		$instance['posts_per_page'] = $new_instance['posts_per_page'];	
		$instance['pagination'] = $_POST['pagination'];
		$instance['post_sort'] = $_POST['post_sort'];
		$instance['post_order'] = $_POST['post_order'];
		$instance['display'] = $_POST['display'];
		$instance['tumunu_gor'] = $new_instance['tumunu_gor'];
		return $instance;
	} 

	function form( $instance ) {
		$defaults = array( 'title' => '', 'cat' => '', 'posts_per_page' => 10, 'pagination' => 'disable', 'post_sort' => 'date', 'post_order' => 'desc', 'display' => 'compact', 'tumunu_gor' => ''); $instance = wp_parse_args( (array) $instance, $defaults ); 
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Başlık:</label>
	<br/><input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'cat' ); ?>">Kategoriye göre listele:</label>
	<br/><input type="text" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" value="<?php echo $instance['cat']; ?>" />
	<br/><small>Lütfen kategori ID'ini girin, virgül ile birbirinden ayırabilirsiniz (ör; 23,51,102,65). Boş bıraktığınızda tüm yazılarınız yayınlanacaktır.</small>
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Yayınlanacak Film Sayısı:</label>
	<input  type="text" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" size="3" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'tumunu_gor' ); ?>">"Tümünü Gör" Adresi:</label>
	<input  type="text" id="<?php echo $this->get_field_id( 'tumunu_gor' ); ?>" name="<?php echo $this->get_field_name( 'tumunu_gor' ); ?>" value="<?php echo $instance['tumunu_gor']; ?>" />
	<br/><small>Anasayfa'da göstereceğiniz kategorinin özel sayfasının adresini yukarıdaki kutucuğa girip, kullanıcılara daha faydalı içerik sunabilirsiniz.</small>
	</p>
		
	<input type="hidden" name="widget-options" id="widget-options" value="1" />
	<?php
	}
} 
// Son ?>