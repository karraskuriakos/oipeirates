<?php

// disable srcset on frontend
function disable_wp_responsive_images() {
	return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');

function disable_embeds_code_init() {

 // Remove the REST API endpoint.
 remove_action( 'rest_api_init', 'wp_oembed_register_route' );

 // Turn off oEmbed auto discovery.
 add_filter( 'embed_oembed_discover', '__return_false' );

 // Don't filter oEmbed results.
 remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

 // Remove oEmbed discovery links.
 remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

 // Remove oEmbed-specific JavaScript from the front-end and back-end.
 remove_action( 'wp_head', 'wp_oembed_add_host_js' );
 add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

 // Remove all embeds rewrite rules.
 add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

 // Remove filter of the oEmbed result before any HTTP requests are made.
 remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}




function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
} 
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );


add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}




function my_alm_cache_array(){
   $array = array(      
      array(
         'url' => 'https://oipeirates.pro/',
         'id' 	=> 'cache-movies',
         'max' => 45
      ),
         array(
         'url' => 'https://oipeirates.pro/genre/tainiesonline/2019',
         'id' 	=> 'cache-2019',
         'max' => 30
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/tainiesonline/2018',
         'id' 	=> 'cache-2018',
         'max' => 30
      ),
      array(
         'url' => 'https://oipeirates.pro/viral-movies',
         'id' 	=> 'cache-viral',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/seires',
         'id' 	=> 'cache-seires',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/animes',
         'id' 	=> 'cache-anime',
         'max' => 15
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/drasis',
         'id' 	=> 'cache-drasis',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/komodies',
         'id' 	=> 'cache-komodies',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/thriller',
         'id' 	=> 'cache-thriller',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/tromou',
         'id' 	=> 'cache-tromou',
         'max' => 15
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/ep-fantasias',
         'id' 	=> 'cache-ep-fantasias',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/fantasias',
         'id' 	=> 'cache-fantasias',
         'max' => 15
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/egklima',
         'id' 	=> 'cache-egklima',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/mystery',
         'id' 	=> 'cache-mystery',
         'max' => 15
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/war',
         'id' 	=> 'cache-war',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/western',
         'id' 	=> 'cache-western',
         'max' => 5
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/romantikes',
         'id' 	=> 'cache-romantikes',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/documentary',
         'id' 	=> 'cache-documentary',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/music',
         'id' 	=> 'cache-music',
         'max' => 1
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/xoreftikes',
         'id' 	=> 'cache-xoreftikes',
         'max' => 1
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/x-mas',
         'id' 	=> 'cache-x-mas',
         'max' => 13
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/filmography',
         'id' 	=> 'cache-filmography',
         'max' => 13
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/collection',
         'id' 	=> 'cache-collection',
         'max' => 6
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/ell-tainies',
         'id' 	=> 'cache-ell-tainies',
         'max' => 19
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/tainiesonline/2017',
         'id' 	=> 'cache-2017',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/2016',
         'id' 	=> 'cache-2016',
         'max' => 20
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/kin-sxedia',
         'id' 	=> 'cache-kin-sxedia',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/kin-sxedia-subs',
         'id' 	=> 'cache-kin-sxedia-subs',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/animation',
         'id' 	=> 'cache-animation',
         'max' => 10
      ),
      array(
         'url' => 'https://oipeirates.pro/genre/animemovies',
         'id' 	=> 'cache-animemovies',
         'max' => 5
      ),
   );  
   return $array;
}
add_filter('alm_cache_array', 'my_alm_cache_array');



function add_custom_script(){
if(is_single ( )){
echo '<script type="text/javascript"> function myFunction() {
   var sticky = document.getElementById("my_header");
   sticky.classList.remove("sticky");
}
</script>';
}
else  {
echo '<script type="text/javascript">
window.onscroll = function() {myFunction()};
var navbar = document.getElementById("my_header");
var sticky = navbar.offsetTop;
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>';

}
}
add_action('wp_footer', 'add_custom_script');


// add_filter('alm_seo_leading_slash', '__return_true');
// add_filter('alm_seo_remove_trailing_slash', '__return_true');

function my_custom_function() {
    if(is_front_page()){ 
    }else{ 
        add_filter('alm_seo_leading_slash', '__return_true'); 
    }
}
add_action( 'wp_head', 'my_custom_function' );





add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );



function sdt_remove_ver_css_js( $src, $handle ) 

{

    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!



    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )

        $src = remove_query_arg( 'ver', $src );



    return $src;

}

// Function to change email address



//function wpb_sender_email( $original_email_address ) {
//    return 'oipeiratesgr@gmail.com';
//}

 

// Function to change sender name
//
//function wpb_sender_name( $original_email_from ) {
//
//    return 'Οι Πειρατές';
//}

 

// Hooking up our functions to WordPress filters 
//add_filter( 'wp_mail_from', 'wpb_sender_email' );
//add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

// 24.9.17

// // Disable W3TC footer comment for all users

add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );

function parallelize_hostnames($url, $id) {

 $hostname = par_get_hostname($url);

 $url =  str_replace(parse_url(get_bloginfo('url'), PHP_URL_HOST), $hostname, $url);

 return $url;

}


function par_get_hostname($name) {
 //add your subdomains below, as many as you want.
 $subdomains = array('img.oipeirates.pro');
 $host = abs(crc32(basename($name)) % count($subdomains));
 $hostname = $subdomains[$host];
 return $hostname;
}
add_filter('wp_get_attachment_url', 'parallelize_hostnames', 10, 2);


function auto_featured_image() {

    global $post;



    if (!has_post_thumbnail($post->ID)) {

        $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );

        

	  if ($attached_image) {

              foreach ($attached_image as $attachment_id => $attachment) {

                   set_post_thumbnail($post->ID, $attachment_id);

              }

         }

    }

}

// Use it temporary to generate all featured images

add_action('the_post', 'auto_featured_image');

// Used for new posts

add_action('save_post', 'auto_featured_image');

add_action('draft_to_publish', 'auto_featured_image');

add_action('new_to_publish', 'auto_featured_image');

add_action('pending_to_publish', 'auto_featured_image');

add_action('future_to_publish', 'auto_featured_image');



remove_action('wp_head', 'print_emoji_detection_script', 7);

remove_action('wp_print_styles', 'print_emoji_styles');





function register_my_menus( )

{

    register_nav_menus( array( "header-nav" => __( "Keremiya Header Menüsü" ) ) );

}



function keremiya_afis_sistemi( $meta )

{

    global $post;

    if ( get_option( "keremiya_yeni" ) == "On" )

    {

        $dil = get_post_meta( $post->ID, "".$meta."", true );

        if ( $dil == "Girilmedi" )

        {

            echo "";

        }

        if ( $dil == "Turkce Dublaj" )

        {

            echo "<span class=\"tr-dublaj\"></span>";

        }

        if ( $dil == "Turkce Altyazi" )

        {

            echo "<span class=\"tr-altyazi\"></span>";

        }

    }

}



function keremiya_meta( $isim, $alan, $sonra )

{

    global $post;

    $ozel = get_post_meta( $post->ID, "".$alan."", true );

    if ( $ozel != "" )

    {

        echo "<p><span>".$isim."</span>: ".$ozel."</p>";

    }

    else

    {

        echo "".$sonra."";

    }

}



function keremiya_resim( $uzunluk, $genislik, $hasresim )

{

    global $post;

    $resim = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "".$hasresim."" );

    $resmim = get_post_meta( $post->ID, "resim", true );

    $resim_bul = keremiya_resim_bulucu( );

    if ( has_post_thumbnail( ) )

    {

        echo "<img src=\"".$resim[0]."\" alt=\"".get_the_title( $post->ID )."\" height=\"".$uzunluk."\" width=\"".$genislik."\" title=\"".get_the_title( $post->ID )."\" />";

    }

    else if ( $resmim != "" )

    {

        echo "<img src=\"".$resmim."\" alt=\"".get_the_title( $post->ID )."\" height=\"".$uzunluk."\" width=\"".$genislik."\" title=\"".get_the_title( $post->ID )."\" />";

    }

    else

    {

        echo "<img src=\"".$resim_bul."\" alt=\"".get_the_title( $post->ID )."\" height=\"".$uzunluk."\" width=\"".$genislik."\" title=\"".get_the_title( $post->ID )."\" />";

    }

}



function toplamfilm( $ilk = "Sitemizde şuan toplam", $son = "film bulunmaktadır." )

{

    $toplam_film = wp_count_posts( "post" );

    $toplam_film = $toplam_film->publish;

    $b = " ";

    echo "<div class=\"toplamfilm\">".$ilk.$b.$toplam_film.$b.$son."</div>";

}



function keremiya_zaman( $type = "post" )

{

    $d = "comment" == $type ? "get_comment_time" : "get_post_time";

    return human_time_diff( $d( "U" ), current_time( "timestamp" ) )." ".__( "", "keremiya" );

}



function nezaman_yazildi( )

{

    $gun = get_the_date( "d" );

    $ay = get_the_date( "m" );

    $yil = get_the_date( "Y" );

    $bugun = date( "d" );

    $buay = date( "m" );

    $buyil = date( "Y" );

    if ( $yil == $buyil )

    {

        if ( $ay == $buay )

        {

            if ( $gun == $bugun )

            {

                echo "Προστέθηκε σήμερα.";

            }

            else

            {

                $gunonce = $bugun - $gun;

                if ( 6 < $gunonce )

                {

                    $haftaonce = round( $gunonce / 7 );

                    echo $haftaonce." Προστέθηκε πριν μια βδομάδα.";

                }

                else

                {

                    if ( $gunonce == 1 )

                    {

                        echo "Προστέθηκε τελευταία.";

                    }

                    else

                    {

                        echo $gunonce." ημέρες πριν.";

                    }

                }

            }

        }

        else

        {

            $ayonce = $buay - $ay;

            echo $ayonce." μήνες πριν.";

        }

    }

    else

    {

        $yilonce = $buyil - $yil;

        if ( $yilonce < 2 )

        {

            $ayonce = 12 - $ay + $buay;

            echo $ayonce." μήνες πριν.";	

		}

        else

        {

            echo $yilonce." πριν ένα χρόνο..";	

		}

    }

}



function keremiya_resim_bulucu( )

{

    global $post;

    global $posts;

    $first_img = "";

    ob_start( );

    ob_end_clean( );

    $output = preg_match_all( "/<img.+src=['\"]([^'\"]+)['\"][^>]*>/i", $post->post_content, $matches );

    $first_img = $matches[1][0];

    $adres = get_bloginfo( "template_url" );



    {

        $first_img = "{$adres}/images/no-thumbnail.png";

    }

    return $first_img;

}



function bilgi_part( $args = "" )

{

if ( in_category( '2016' )) {

    echo '<span><b><a style="color:white "href="/genre/2016">2016</a></b></span> ';

} 

if ( in_category( '2017' )) {

    echo '<span><b><a style="color:white "href="/genre/2017">2017</a></b></span> ';

} 

if ( in_category( '2018' )) {

    echo '<span><b><a style="color:white "href="/genre/2018">2018</a></b></span> ';

} 

if ( in_category( 'Animation' )) {

    echo '<span><b><a style="color:white "href="/genre/animation">Animations</a></b></span> ';

} 

if ( in_category( 'Reviews' )) {

    echo '<span><b><a style="color:white "href="/genre/reviews">Reviews</a></b></span> ';

} 

if ( in_category( 'AnimeMovies' )) {

    echo '<span><b><a style="color:white "href="/genre/animemovies">Anime movies</a></b></span> ';

} 

if ( in_category( 'Bollywood' )) {

    echo '<span><b><a style="color:white "href="/genre/bollywood">Bollywood</a></b></span> ';

} 

if ( in_category( 'Collection' )) {

    echo '<span><b><a style="color:white "href="/genre/Collection">Συλλογές</a></b></span> ';

} 

if ( in_category( 'New.Good' )) {

    echo '<span><b><a style="color:white "href="/genre/new-good">2013-2015</a></b></span> ';

} 

if ( in_category( 'Western' )) {

    echo '<span><b><a style="color:white "href="/genre/western">Western</a></b></span> ';

} 

if ( in_category( 'X-mas' )) {

    echo '<span><b><a style="color:white "href="/genre/x-mas">X-mas</a></b></span> ';

} 

if ( in_category( 'Δράμα' )) {

    echo '<span><b><a style="color:white "href="/genre/drama">Δράμα</a></b></span> ';

} 

if ( in_category( 'Ιστορική' )) {

    echo '<span><b><a style="color:white "href="/genre/Istoriki">Ιστορική</a></b></span> ';

} 



if ( in_category( 'Δράσης' )) {

    echo '<span><b><a style="color:white "href="/genre/drasis">Δράσης</a></b></span> ';

} 

if ( in_category( 'Έγκλημα' )) {

    echo '<span><b><a style="color:white "href="/genre/egklima">Έγκλημα</a></b></span> ';

} 

if ( in_category( 'Μουσική' )) {

    echo '<span><b><a style="color:white "href="/genre/music">Μουσική</a></b></span> ';

} 

if ( in_category( 'Ελλ.Ταινίες' )) {

    echo '<span><b><a style="color:white "href="/genre/ell-tainies">Ελλ.Ταινίες</a></b></span> ';

} 

if ( in_category( 'Επ.Φαντασίας' )) {

    echo '<span><b><a style="color:white "href="/genre/ep-fantasias">Επ. Φαντασίας</a></b></span> ';

} 

if ( in_category( 'Θρίλερ' )) {

    echo '<span><b><a style="color:white "href="/genre/thriller">Θρίλερ</a></b></span> ';

} 

if ( in_category( 'Κιν.Σχέδια' )) {

    echo '<span><b><a style="color:white "href="/genre/kin-sxedia">Κινούμενα Σχέδια</a></b></span> ';

} 

if ( in_category( 'Κιν.Σχέδια.Subs' )) {

    echo '<span><b><a style="color:white "href="/genre/kin-sxedia-subs">Κινούμενα Σχέδια με υπότιτλους</a></b></span> ';

} 

if ( in_category( 'Κωμωδίες' )) {

    echo '<span><b><a style="color:white "href="/genre/komodies">Κωμωδίες</a></b></span> ';

} 

if ( in_category( 'Μυστήριο' )) {

    echo '<span><b><a style="color:white "href="/genre/mystery">Μυστήριο</a></b></span> ';

} 

if ( in_category( 'Ντοκιμαντέρ' )) {

    echo '<span><b><a style="color:white "href="/genre/documentary">Ντοκιμαντέρ</a></b></span> ';

} 

if ( in_category( 'Ξένες.Σειρές' )) {

    echo '<span><b><a style="color:white "href="/genre/seires">Ξένες Σειρές</a></b></span> ';

} 

if ( in_category( 'Πολέμου' )) {

    echo '<span><b><a style="color:white "href="/genre/war">Πολέμου</a></b></span> ';

} 

if ( in_category( 'Ρομαντικές' )) {

    echo '<span><b><a style="color:white "href="/genre/romantikes">Ρομαντικές</a></b></span> ';

} 

if ( in_category( 'Τρόμου' )) {

    echo '<span><b><a style="color:white "href="/genre/tromou">Τρόμου</a></b></span> ';

} 

if ( in_category( 'Φαντασίας' )) {

    echo '<span><b><a style="color:white "href="/genre/fantasias">Φαντασίας</a></b></span> ';

} 

if ( in_category( 'Φιλμογραφίες' )) {

    echo '<span><b><a style="color:white "href="/genre/filmography">Φιλμογραφίες</a></b></span> ';

} 

if ( in_category( 'Χορευτικές' )) {

    echo '<span><b><a style="color:white "href="/genre/xoreftikes">Χορευτικές</a></b></span> ';

} 

if ( in_category( 'Anime' )) {

    echo '<span><b><a style="color:white "href="/genre/anime">Anime</a></b></span> ';

} 

if ( in_category( 'viral' )) {

    echo '<span><b><a style="color:white "href="/genre/viral">Viral</a></b></span> ';

} 

}



function keremiya_part_sistemi( $args = "" )

{

    $defaults = array( "before" => "".__( "".$bilgi."" ), "after" => "<span class=\"keros\"><a href=\"#respond\">Yorum yap</a></span>", "link_before" => "<span>", "link_after" => "</span>", "echo" => 1 );

    $r = wp_parse_args( $args, $defaults );

    extract( $r, EXTR_SKIP );

    global $page;

    global $numpages;

    global $multipage;

    global $more;

    global $pagenow;

    global $pages;

    $bilgi_bir = get_option( "keremiya_part_bir" );

    $output = "";

    if ( $multipage )

    {

        $output .= $before;

        $i = 1;

        while ( $i < $numpages + 1 )

        {

            $part_content = $pages[$i - 1];

            $has_part_title = strpos( $part_content, "<!--baslik:" );

            if ( 0 === $has_part_title )

            {

                $end = strpos( $part_content, "-->" );

                $title = trim( str_replace( "<!--baslik:", "", substr( $part_content, 0, $end ) ) );

            }

            $output .= " ";

            if ( $i != $page || !$more && $page == 1 )

            {

                $output .= _wp_link_page( $i );

            }



            $output .= $link_before.$title.$link_after;

            if ( $i != $page || !$more && $page == 1 )

            {

                $output .= "</a>";

            }

            $i = $i + 1;

        }

        $output .= $after;

    }

    if ( $echo )

    {

        echo $output;

    }

    return $output;

}



function keremiya_comment( $comment, $args, $depth )

{

    $GLOBALS['comment'] = $comment;

    echo "   <li ";

    comment_class( );

    echo " id=\"li-comment-";

    comment_id( );

    echo "\">\r\n     <div id=\"comment-";

    comment_id( );

    echo "\">\r\n      <div class=\"comment-author vcard\">\r\n         ";

    echo get_avatar( $comment->comment_author_email, "30", $default = get_template_directory_uri( )."/images/gravatar.gif" );

    echo "\r\n         ";

    printf( __( "<cite class=\"fn\">%s</cite> <span class=\"says\"> - </span>" ), get_comment_author_link( ) );

    echo "<s";

    echo "pan class=\"comment-zaman1\">";

    echo keremiya_zaman( "comment" );

    echo " πριν στις:</span>\r\n      </div>\r\n      ";

    if ( $comment->comment_approved == "0" )

    {

        echo "         <em>";

        _e( "Your comment is awaiting moderation." );

        echo "</em>\r\n         <br />\r\n      ";

    }

    echo "\r\n      <div class=\"comment-meta commentmetadata\"><a href=\"";

    echo esc_url( get_comment_link( $comment->comment_ID ) );

    echo "\">";

    printf( __( "%1\$s" ), get_comment_date( __( "F j, Y" ) ) );

    echo "</a>";

    edit_comment_link( __( "(Edit)" ), "  ", "" );

    echo "</div>\r\n\r\n      ";

    comment_text( );

    echo "     </div>\r\n";

}



function keremiya_facebook( )

{

    global $post;

    $fb_resim = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-resim" );

    $fb_resmim = get_post_meta( $post->ID, "resim", true );

    if ( is_single( ) )

    {

        if ( has_post_thumbnail( ) )

        {

            echo "<meta property=\"og:image\" content=\"".$fb_resim[0]."\" />";

        }

        else if ( $fb_resmim != "" )

        {

            echo "<meta property=\"og:image\" content=\"".$fb_resmim."\" />";

        }

        else

        {

            echo "<meta property=\"og:image\" content=\"".keremiya_resim_bulucu( )."\" />";

        }

        echo "\r\n<meta property=\"og:title\" content=\"";

        wp_title( "|", true, "right" );

        bloginfo( "name" );

        echo "\" />\r\n<meta property=\"og:site_name\" content=\"";

        bloginfo( "name" );

        echo "\" />\r\n<meta property=\"og:url\" content=\"";

echo str_replace(array('https://'),'http://',get_permalink());

        echo "\" />\r\n";

    }

}



include_once( "framework/keremiya.php" );

include_once( "framework/tema-dili.php" );

include_once( "framework/likethis.php" );

include_once( "framework/tema-kurulumu.php" );

include_once( "framework/keremiya-yenilikleri.php" );

include_once( "framework/widgets/keremiya-film-kutusu.php" );

include_once( "framework/widgets/keremiya-kategoriler.php" );

include_once( "framework/widgets/facebook-like-widget.php" );



add_action('after_setup_theme', 'remove_admin_bar');

 

function remove_admin_bar() {

if (!current_user_can('administrator') && !is_admin()) {

  show_admin_bar(false);

}

}

// add_filter( "show_admin_bar", "__return_false" );

remove_action( "personal_options", "_admin_bar_preferences" );

remove_action( "wp_head", "rel_canonical" );

global $wp_rewrite;

$wp_rewrite->author_base = "profil";

add_theme_support( "post-thumbnails", array( "post" ) );

add_image_size( "anasayfa-resim", 210, 290, true );
add_image_size( "single-resim", 125, 160, true );
add_image_size( "izlenen-resim", 70, 80, true );
add_image_size( "slide-resim", 110, 138, true );
add_image_size( 'like_this', 119, 125, true );
add_image_size( 'list', 210, 290 );
add_image_size( 'like_this', 119, 125, true );


add_action( "init", "register_my_menus" );

register_sidebar( array( "name" => "Sidebar", "id" => "sidebar", "before_widget" => "<div class=\"sidebarborder\"><div class=\"sidebar-right\">", "after_widget" => "</div></div>", "before_title" => "<h2>", "after_title" => "</h2>" ) );

register_sidebar( array( "name" => "Sidebar (Anasayfa Film Bölümü)", "id" => "anasayfa", "before_widget" => "<div class=\"filmborder\"><div class=\"filmcontent\">", "after_widget" => "</div></div>", "before_title" => "<div class=\"yazitip\">", "after_title" => "</div>" ) );

register_sidebar( array( "name" => "Sidebar (Kategori)", "id" => "kategori", "before_widget" => "<div class=\"sidebarborder\"><div class=\"sidebar-right\">", "after_widget" => "</div></div>", "before_title" => "<h2>", "after_title" => "</h2>" ) );
?>