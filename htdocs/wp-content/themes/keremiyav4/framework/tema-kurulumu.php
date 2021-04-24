<?php

/*-----------------------------------------------------------------------------------

SAYFADA BULUNANLAR

- Aktivasyon
- Kurulum
- Sayfa Kurulumları

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Aktivasyon */
/*-----------------------------------------------------------------------------------*/

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action('init', 'keremiya_v4_kurulum', 1);

/*-----------------------------------------------------------------------------------*/
/* Kurulum */
/*-----------------------------------------------------------------------------------*/

function keremiya_v4_kurulum() {
	
	global $wp_rewrite;
		
	keremiya_v4_sayfa_kurulum();
	
	/* Kayıt Ayarı */
	update_option('users_can_register', 1);
	
	$wp_rewrite->flush_rules();
}

/*-----------------------------------------------------------------------------------*/
/* Sayfa Kurulumları */
/*-----------------------------------------------------------------------------------*/

function keremiya_v4_sayfa_kurulum() {

	global $wpdb;
    
    $page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'viral-movies';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'viral-movies',
	        'post_title' => __('Viral Movies', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'viral.php');
        update_option('keremiya_encokizlenenler_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'viral.php');
    	update_option('keremiya_encokizlenenler_page_id', $page_id);
    }
    
    $page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'new-movies-2018';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'new-movies-2018',
	        'post_title' => __('New Movies 2018', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'newmovies2018.php');
        update_option('keremiya_encokyorumlananlar_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'newmovies2018.php');
    	update_option('keremiya_encokyorumlananlar_page_id', $page_id);
    }
	   
   	$page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'seires';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'seires',
	        'post_title' => __('ΞΕΝΕΣ ΣΕΙΡΕΣ', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'seires.php');
        update_option('keremiya_encokbegenilenler_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'seires.php');
    	update_option('keremiya_encokbegenilenler_page_id', $page_id);
    }
    
   	$page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'animes';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'animes',
	        'post_title' => __('Animes', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'animes.php');
        update_option('keremiya_animes_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'animes.php');
    	update_option('keremiya_animes_page_id', $page_id);
    }

	
	
    $page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'sas';");


    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'uye-girisi',
	        'post_title' => __('Login Member', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'login-member.php');
        update_option('keremiya_uyegirisi_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'login-member.php');
    	update_option('keremiya_uyegirisi_page_id', $page_id);
    }
    
    $page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'uye-ol';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'uye-ol',
	        'post_title' => __('Register Member', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'register.php');
        update_option('keremiya_uyeol_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'register.php');
    	update_option('keremiya_uyeol_page_id', $page_id);
    }
	
    $page_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = 'contact';");

    if (!$page_id) {
    
        $my_page = array(
	        'post_status' => 'publish',
	        'post_type' => 'page',
	        'post_author' => 1,
	        'post_name' => 'contact',
	        'post_title' => __('Contact us', 'keremiya')
        );
		$page_id = wp_insert_post($my_page);

        update_post_meta($page_id, '_wp_page_template', 'contactus.php');
        update_option('keremiya_bizeyazin_page_id', $page_id);

    } else {
   		update_post_meta($page_id, '_wp_page_template', 'contactus.php');
    	update_option('keremiya_bizeyazin_page_id', $page_id);
    }

}