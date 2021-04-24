<?php
// Keremiya SharePi Player
function keremiya_sharepi($atts) {
extract(shortcode_atts(array(
	'resim' => 'http://',
    'file' => 'http://'
  ), $atts));
  $filmifullizle = get_option('keremiya_filmifullizle');
return "
<p>
<embed src=\"http://www.sharepi.com/player_final/player.swf?file=$file&amp;plugins=fbit-1,tweetit-1,sharing-1&amp;dock=true\" quality=\"high\" bgcolor=\"#000000\" name=\"mymovie\" allowfullscreen=\"true\" allowscriptaccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.adobe.com/go/getflashplayer\" align=\"middle\" height=\"400\" width=\"711\">
</p>
";
}
add_shortcode('sharepi', 'keremiya_sharepi');

// Keremiya Normal Player
function keremiya_player($atts) {
extract(shortcode_atts(array(
	'resim' => 'http://',
    'file' => 'http://'
  ), $atts));
  $phpkodu = get_option('keremiya_phpkodu');
  $backcolor = get_option('keremiya_player_backcolor');
  $frontcolor = get_option('keremiya_player_frontcolor');
  $lightcolor = get_option('keremiya_player_lightcolor');
  $height = get_option('keremiya_player_height');
  $width = get_option('keremiya_player_width');
  $adres = get_bloginfo('template_url');
return "
<p>
<embed type=\"application/x-shockwave-flash\" wmode=\"transparent\" scale=\"noscale\" quality=\"high\" allowfullscreen=\"true\" src=\"$adres/jwplayer/plyr.swf?file=$phpkodu$file&amp;autostart=false&amp;backcolor=0x$backcolor&amp;frontcolor=0x$frontcolor&amp;lightcolor=0x$lightcolor&amp;screencolor=0x000000\" height=\"$height\" width=\"$width\">
</p>
";
}
add_shortcode('player', 'keremiya_player');

// Keremiya Normal Player
function keremiya_video($atts) {
extract(shortcode_atts(array(
	'resim' => 'http://',
    'file' => 'http://'
  ), $atts));
  $adres = get_bloginfo('template_url');
return "
<p>
<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\" height=\"400\" width=\"711\"><param value=\"always\" name=\"allowScriptAccess\"><param value=\"true\" name=\"allowFullScreen\"><param name=\"flashvars\" value=\"file=$file&amp;image=$resim&amp;height=400&amp;width=711&amp;autostart=false&amp;displayheight=400&amp;displayNav=false&amp;showicons=true&amp;bgcolor=#000000&amp;backcolor=0x000000&amp;frontcolor=0xCCCCCC&amp;lightcolor=0x557722\"><param value=\"$adres/jwplayer/player.swf\" name=\"movie\"><param value=\"high\" name=\"quality\"><param value=\"#000000\" name=\"bgcolor\"><embed type=\"application/x-shockwave-flash\" src=\"$adres/jwplayer/player.swf\" allowfullscreen=\"true\" flashvars=\"file=$file&amp;$resim&amp;height=400&amp;width=711&amp;autostart=false&amp;displayheight=400&amp;displayNav=false&amp;showicons=true&amp;bgcolor=#000000&amp;backcolor=0x000000&amp;frontcolor=0xCCCCCC&amp;lightcolor=0x557722\" allowscriptaccess=\"always\" height=\"400\" width=\"711\"></object>
</p>
";
}
add_shortcode('fragman', 'keremiya_video');

// Keremiya Youtube Player
function keremiya_youtube($atts) {
extract(shortcode_atts(array(
	'resim' => 'http://',
    'id' => ''
  ), $atts));
return "
<p>
<iframe width=\"711\" height=\"400\" src=\"http://www.youtube.com/embed/$id\" frameborder=\"0\" allowfullscreen></iframe>
</p>
";
}
add_shortcode('youtube', 'keremiya_youtube');

// Keremiya Videozer Player
function keremiya_videozer($atts) {
extract(shortcode_atts(array(
    'id' => 'http://'
  ), $atts));
return "
<p>
<object id=\"player\" width=\"711\" height=\"400\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ><param name=\"movie\" value=\"http://www.videozer.com/embed/$id\" ></param><param name=\"allowFullScreen\" value=\"true\" ></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.videozer.com/embed/$id\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"711\" height=\"400\"></embed></object>
</p>
";
}
add_shortcode('videozer', 'keremiya_videozer');

// Keremiya Videobb Player
function keremiya_videobb($atts) {
extract(shortcode_atts(array(
    'id' => 'http://'
  ), $atts));
return "
<p>
<object id=\"player\" width=\"711\" height=\"400\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ><param name=\"movie\" value=\"http://www.videobb.com/e/$id\" ></param><param name=\"allowFullScreen\" value=\true\" ></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.videobb.com/e/$id\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"711\" height=\"400\"></embed></object>
</p>
";
}
add_shortcode('videobb', 'keremiya_videobb');

?>