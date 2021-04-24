<?php
/*
Plugin Name: Like This
Plugin URI: http://lifeasrose.ca/2011/03/wordpress-plugin-i-like-this/
Description: Integrates a "Like This" option for posts, similar to the facebook Like button.  For visitors who want to let the author know that they enjoyed the post, but don't want to go to the effort of commenting.
Version: 1.1
Author: Rose Pritchard
Author URI: http://lifeasrose.ca
License: GPL2

Copyright 2011  Rose Pritchard  (email : me@rosepritchard.ca)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function likeThis($post_id,$action = 'get') {

	if(!is_numeric($post_id)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	} //if

	switch($action) {
	
	case 'get':
		$data = get_post_meta($post_id, '_likes');
		
		if(!is_numeric($data[0])) {
			$data[0] = 0;
			add_post_meta($post_id, '_likes', '0', true);
		} //if
		
		return $data[0];
	break;
	
	
	case 'update':
		if(isset($_COOKIE["like_" . $post_id])) {
			return;
		} //if
		
		$currentValue = get_post_meta($post_id, '_likes');
		
		if(!is_numeric($currentValue[0])) {
			$currentValue[0] = 0;
			add_post_meta($post_id, '_likes', '1', true);
		} //if
		
		$currentValue[0]++;
		update_post_meta($post_id, '_likes', $currentValue[0]);
		
		setcookie("like_" . $post_id, $post_id,time()*20);
	break;

	} //switch

} //likeThis

function printLikes($post_id) {
	$likes = likeThis($post_id);
	
	if(isset($_COOKIE["like_" . $post_id])) {
	print '<span class="likeThis done" id="like-'.$post_id.'">'.$likes.'</span>';
		return;
	} //if

	print '<span class="likeThis" id="like-'.$post_id.'">'.$likes.'</span>';
} //printLikes

function keremiyaLikes($post_id) {
	
	$likes = likeThis($post_id);
	print '<span class="likeThis">'.$likes.' Likes</span>';
}

function setUpPostLikes($post_id) {
	if(!is_numeric($post_id)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	} //if
	
	
	add_post_meta($post_id, '_likes', '0', true);

} //setUpPost


function checkHeaders() {
	if(isset($_POST["likepost"])) {
		likeThis($_POST["likepost"],'update');
	} //if

} //checkHeaders

add_action ('publish_post', 'setUpPostLikes');
add_action ('init', 'checkHeaders');
?>