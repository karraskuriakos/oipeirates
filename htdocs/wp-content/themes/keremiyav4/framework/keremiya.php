<?php
/**
 * Keremiya Framework
 * Geliştiren Kerem Demirbaş
 * http://www.keremiya.com
 * http://twitter.com/Keremiya
 * ben@keremiya.com
 */

class KeremiyaFramework {
	var $theme_name;
	
	public function __construct($theme_name = 'Tema Ayarları')
	{
		// Temanın tamamı için gerekli olan bilgi vs. tür şeyler
		$this->theme_name = $theme_name;
		
		// Varsayılan seçenek ekle
		$this->default_options();
		
		add_action('init', array($this, 'init'));
		add_action('admin_menu', array($this, 'admin_menu'));
		
		add_action('wp_ajax_keremiya_upload', array($this, 'upload'));
		add_action('wp_ajax_keremiya_save_fields', array($this, 'save_fields'));
		add_action('wp_ajax_keremiya_reset_fields', array($this, 'reset_fields'));
		
	}
	
	public function default_options()
	{
		// Film Bilgileri
		add_option('keremiya_filmbilgi_var', 'On');
		add_option('keremiya_eklenme', 'On');
		add_option('keremiya_konu', 'On');
		add_option('keremiya_duzenle', 'On');
		add_option('keremiya_tur', 'On');
		add_option('keremiya_yapim', 'On');
		add_option('keremiya_imdb', 'On');
		add_option('keremiya_oyuncular', 'On');
		add_option('keremiya_yonetmen', 'On');
		add_option('keremiya_etiketler', 'On');
		add_option('keremiya_feedburner_var', 'On');
		
		// Sosyal Medya
		add_option('keremiya_twitter', 'On');
		add_option('keremiya_facebook', 'On');
		add_option('keremiya_sosyal', 'On');
		
		// Reklamlar
		add_option('keremiya_r_a_g', 'On');
		add_option('keremiya_r_a_s', '15000');
		
		// Gösterilecekler
		add_option('keremiya_sayfa', 'On');
		add_option('keremiya_sayfa_basi', '10');

		// Benzer Filmler
		add_option('keremiya_benzer_var', 'On');
		add_option('keremiya_benzer_filmler', '5');
		
		// Part Sistemi
		add_option('keremiya_part_sistem', 'On');
		add_option('keremiya_part_iki', 'Part');
		add_option('keremiya_part_bir', 'Fragman');
		
		// Slider
		add_option('keremiya_manset_slider', 'On');
		add_option('keremiya_slider_hopla', '2');
		add_option('keremiya_manset_posts', '14');
		add_option('keremiya_slider_auto', 'false');
		add_option('keremiya_slider_step', '8000');
		
		// Sidebar Tavsiye Filmler
		add_option('keremiya_tavsiyesayi', '5');
		add_option('keremiya_tavsiyeisim', 'Tavsiye Filmler');
		
		// Sidebar En Çok izlenenleraa
		add_option('keremiya_encok_var', 'On');
		add_option('keremiya_encoksayi', '5');
		add_option('keremiya_encokisim', 'Δημοφιλέστερες');
		
		// Anasayfa SEO
		add_option('keremiya_seo_home_type', 'sadeceblog');
		add_option('keremiya_seo_home_separate', ' | ');
		add_option('keremiya_seo_single_title', '');
		add_option('keremiya_seo_single_type', 'yazibaslik');
		add_option('keremiya_seo_single_separate', ' | ');
		add_option('keremiya_seo_index_separate', ' | ');
		add_option('keremiya_seo_index_type', 'kategoribaslik');
		add_option('keremiya_seo_field', '');
		add_option('keremiya_seo_canonical', 'On');
		add_option('keremiya_seo_facebook', 'On');
		
		// Single SEO
		add_option('keremiya_seo_single_field_title', 'keremiya_seotitle');
		add_option('keremiya_seo_single_field_description', 'keremiya_seodescription');
		add_option('keremiya_seo_single_field_keywords', 'keremiya_seokeywords');
		
		// Player
		add_option('keremiya_player_backcolor', '020202');
		add_option('keremiya_player_frontcolor', 'C2C2C2');
		add_option('keremiya_player_lightcolor', '557722');
		add_option('keremiya_player_height', '400');
		add_option('keremiya_player_width', '711');

	}
	
	public function init()
	{
	}
	
	// Admin paneline yeni seçenekler ekle
	public function admin_menu()
	{
		$object = add_object_page('Tema Ayarları', $this->theme_name, 'manage_options', 'keremiya_framework', array($this, 'options_panel'), get_bloginfo('template_directory') . '/framework/keremiya/theme_options/images/themeoptions-icon.png');
		
		add_action('admin_print_styles-'.$object, array($this, 'admin_scripts'));
	}
	
	public function admin_scripts()
	{
		wp_enqueue_style($this->theme_name, get_bloginfo('template_url').'/framework/keremiya/theme_options/style.css', '', '1');
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('ajaxupload', get_bloginfo('template_url').'/framework/keremiya/theme_options/js/ajaxupload.js');
		wp_enqueue_script('color-picker', get_bloginfo('template_url').'/framework/keremiya/theme_options/js/colorpicker.js');
	}
	
	// Geri arama fonksiyonu panel desteği
	public function options_panel()
	{
		$options = new KeremiyaFrameworkOptions;
	}
	
	public function upload()
	{
		$clickedID = $_POST['data'];
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		
		$upload_tracking[] = $clickedID;
		update_option($clickedID, $uploaded_file['url']);
		
		if(!empty($uploaded_file['error'])) {
			echo 'Could not load file: ' . $uploaded_file['error'];
		}	
		else {
			echo $uploaded_file['url'];
		}
		
		die();
	}
	
	public function save_fields()
	{
		unset($_POST['action']);
		
		foreach($_POST as $key => $value) {
			update_option($key, stripslashes($value));
		}
		
		die();
	}
	
	public function reset_fields()
	{
		// General Settings
		update_option('keremiya_logo', '');
		update_option('keremiya_favicon', '');
		update_option('keremiya_feedburner', '');
		update_option('keremiya_feedburner_var', 'On');
		update_option('keremiya_email', '');
		update_option('keremiya_analytics', '');
		update_option('keremiya_twitter_id', '');
		update_option('keremiya_facebook_id', '');
		
		// Home setup
		update_option('keremiya_manset_slider', 'On');
		update_option('keremiya_slider_hopla', '2');
		update_option('keremiya_manset_posts', '14');
		update_option('keremiya_manset_kategori', '');
		update_option('keremiya_slider_auto', 'false');
		update_option('keremiya_slider_step', '8000');
		update_option('keremiya_slider_effect', '');
		update_option('keremiya_tavsiyekat', '');
		update_option('keremiya_tavsiyesayi', '3');
		update_option('keremiya_encoksayi', '3');
		update_option('keremiya_yeni', '');
		update_option('keremiya_ex_kategori', '');
		
		// İÇERİK AYARLARI
		update_option('keremiya_benzer_var', 'On');
		update_option('keremiya_benzer_filmler', '5');
		update_option('keremiya_footer_left', '');
		update_option('keremiya_footer_right', '');
		
		// REKLAMLAR
		update_option('keremiya_r_a', '');
		update_option('keremiya_r_b', '');
		update_option('keremiya_r_c', '');
		update_option('keremiya_r_d', '');
		update_option('keremiya_r_e', '');
		update_option('keremiya_r_a_a', '');
		update_option('keremiya_r_b_b', '');
		update_option('keremiya_r_c_c', '');
		update_option('keremiya_r_d_d', '');
		update_option('keremiya_r_e_e', '');
		
		// SEO
		update_option('keremiya_seo_home_type', 'sadeceblog');
		update_option('keremiya_seo_single_type', 'yazibaslik');
		update_option('keremiya_seo_index_type', 'kategoribaslik');
		update_option('keremiya_seo_home_separate', ' | ');
		update_option('keremiya_seo_single_separate', ' | ');
		update_option('keremiya_seo_index_separate', ' | ');
		update_option('keremiya_seo_home_title', '');
		update_option('keremiya_seo_single_title', '');
		update_option('keremiya_seo_home_titletext', '');
		update_option('keremiya_seo_home_description', '');
		update_option('keremiya_seo_index_description', '');
		update_option('keremiya_seo_single_description', '');
		update_option('keremiya_seo_home_keywords', '');
		update_option('keremiya_seo_single_keywords', '');
		update_option('keremiya_seo_canonical', 'On');
		update_option('keremiya_seo_facebook', 'On');
		
		// Seo Paneli Ayarları
		update_option('keremiya_seo_field', '');
		update_option('keremiya_seo_single_field_title', 'keremiya_seotitle');
		update_option('keremiya_seo_single_field_description', 'keremiya_seodescription');
		update_option('keremiya_seo_single_field_keywords', 'keremiya_seokeywords');
		
		// Player
		update_option('keremiya_phpkodu', '');
		update_option('keremiya_player_backcolor', '020202');
		update_option('keremiya_player_frontcolor', 'C2C2C2');
		update_option('keremiya_player_lightcolor', '557722');
		update_option('keremiya_player_height', '400');
		update_option('keremiya_player_width', '711');
		
		die();
	}

}

// Yönlendirme
if (is_admin() && $_GET['activated'] == 'true') {
header("Location: admin.php?page=keremiya_framework");
}

// Sidebar Kayıt Silme
function unregister_default_wp_widgets(){
    unregister_widget( "WP_Widget_Calendar" );
    unregister_widget( "WP_Widget_Links" );
    unregister_widget( "WP_Widget_Meta" );
    unregister_widget( "WP_Widget_Search" );
    unregister_widget( "WP_Widget_Recent_Comments" );
    unregister_widget( "WP_Widget_RSS" );
}

	add_action( "widgets_init", "unregister_default_wp_widgets", 1 );
	remove_action( "wp_head", "wlwmanifest_link" );
	remove_action( "wp_head", "wp_generator" );
	remove_action( "wp_head", "rsd_link" );
	remove_action( "wp_head", "start_post_rel_link" );
	remove_action( "wp_head", "index_rel_link" );
	remove_action( "wp_head", "adjacent_posts_rel_link" );

// Site Meta Başlıkları
function keremiya_titles() {
	$shortname = 'keremiya';
	
	#Anasayfa Başlığı
	if (is_home() || is_front_page()) {
		if (get_option($shortname.'_seo_home_title') == 'On') echo get_option($shortname.'_seo_home_titletext');  
		else { 
			if (get_option($shortname.'_seo_home_type') == 'blogisim') echo get_bloginfo('name').get_option($shortname.'_seo_home_separate').get_bloginfo('description'); 
			if ( get_option($shortname.'_seo_home_type') == 'blogaciklama') echo get_bloginfo('description').get_option($shortname.'_seo_home_separate').get_bloginfo('name');
			if ( get_option($shortname.'_seo_home_type') == 'sadeceblog') echo get_bloginfo('name');
		}
	}
	#İçerik ve Sayfa Başlığı
	if (is_single() || is_page()) { 
		global $wp_query; 
		$postid = $wp_query->post->ID; 
		$key = get_option($shortname.'_seo_single_field_title');
		$exists3 = get_post_meta($postid, ''.$key.'', true);
				if (get_option($shortname.'_seo_field') == 'On' && $exists3 !== '' ) echo $exists3.get_option($shortname.'_seo_single_separate').get_bloginfo('name'); 
				else { 
					if (get_option($shortname.'_seo_single_type') == 'yazibaslik') echo trim(wp_title('',false,'')).get_option($shortname.'_seo_single_separate').get_bloginfo('name');
					if (get_option($shortname.'_seo_single_type') == 'yaziblog') echo get_bloginfo('name').get_option($shortname.'_seo_single_separate').trim(wp_title('',false,'')); 
					if (get_option($shortname.'_seo_single_type') == 'sadeceyazi') echo trim(wp_title('',false,''));
			    }
					
	}
	#Kategori, Arşiv ve Arama Başlıkları
	if (is_category() || is_archive() || is_search()) { 
		if (get_option($shortname.'_seo_index_type') == 'kategoribaslik') echo trim(wp_title('',false,'')).get_option($shortname.'_seo_index_separate').get_bloginfo('name');
		if (get_option($shortname.'_seo_index_type') == 'kategoriblog') echo get_bloginfo('name').get_option($shortname.'_seo_index_separate').trim(wp_title('',false,'')); 
		if (get_option($shortname.'_seo_index_type') == 'sadecekategori') echo trim(wp_title('',false,''));
		}
} 

// Site Meta Açıklamaları
function keremiya_description() {
	$shortname = 'keremiya';
	
	#Anasayfa Açıklaması
	if (is_home() && get_option($shortname.'_seo_home_description')) { 
	echo '<meta name="description" content="'.get_option($shortname.'_seo_home_description').'" />'; echo "\n"; 
	}
	
	#İçerik ve Sayfa Açıklaması
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
	$key2 = get_option($shortname.'_seo_single_field_description');
	if (isset($postid)) $exists = get_post_meta($postid, ''.$key2.'', true);
	if (get_option($shortname.'_seo_field') == 'On' && $exists !== '') {
		if (is_single() || is_page()) { echo '<meta name="description" content="'.$exists.'" />'; echo "\n"; }
	}
	
	#İndex Açıklaması
	remove_filter('term_description','wpautop');
	$cat = get_query_var('cat'); 
    $exists2 = category_description($cat);
	if ($exists2 !== '' && get_option($shortname.'_seo_index_description') == 'On') {
		if (is_category()) { echo '<meta name="description" content="'. $exists2 .'" />'; echo "\n"; }
	}
	if (is_archive() && get_option($shortname.'_seo_index_description') == 'On') { echo '<meta name="description" content="Şu anda '. wp_title('',false,'') .' isimli arşivi inceliyorsunuz." />'; echo "\n"; }
	if (is_search() && get_option($shortname.'_seo_index_description') == 'On') { echo '<meta name="description" content="'. wp_title('',false,'') .'" />'; echo "\n"; }
}

// Anahtar Kelimeler
function keremiya_keywords() {
	$shortname = 'keremiya';
	#Anasayfa Anahtar Kelimeler
	if (is_home() && get_option($shortname.'_seo_home_keywords')) { echo '<meta name="keywords" content="'.get_option($shortname.'_seo_home_keywords').'" />'; echo "\n"; }
	
	#Sayfa Anahtar Kelimeler
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
	$key3 = get_option($shortname.'_seo_single_field_keywords');
	if (isset($postid)) $exists4 = get_post_meta($postid, ''.$key3.'', true);
	if (isset($exists4) && $exists4 !== '' && get_option($shortname.'_seo_field') == 'On') {
		if (is_single() || is_page()) { echo '<meta name="keywords" content="'.$exists4.'" />'; echo "\n"; }
	}
}


// Cannonical URL
function keremiya_canonical() {
	$shortname = 'keremiya';
	#anasayfa url
	if (get_option($shortname.'_seo_canonical') == 'On') {
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
		$url = keremiya_aiosp_get_url($wp_query);
		echo '<link rel="canonical" href="'.$url.'" />';	
	}
}

/** Diğer çağırılacak dosyalar **/

// SEO
if (get_option('keremiya_seo_canonical') == 'On') {
include_once('canonical.php');
}

// Tema seçenekleri sayfası
include_once('theme_options.php');

// Shortcodes
include_once('player.php');

// Meta Kutuları
include_once('meta-kutusu.php');

// Bread Crumbs
include_once('breadcrumbs.php');

$keremiya = new KeremiyaFramework('Keremiya Panel');