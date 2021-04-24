<?php get_header(); ?>
<?php
if(isset($_GET['author_name'])) :
$profil = get_userdatabylogin($author_name);
get_userdatabylogin(get_the_author_login());
(get_the_author_login());
else :
$profil = get_userdata(intval($author));
endif;
?>
<div id="content">

<div class="leftC">
	
	<div class="filmborder">
		<div class="filmcontent">
		<div class="user-options-message">
			<h1 class="yazitip"><?php global $current_user; get_currentuserinfo(); echo $profil->display_name; ?></h1>
		</div>
		<div class="user-left">
			<div class="profile-avatar">
				<?php echo get_avatar($profil->ID, '130', $default=get_template_directory_uri().'/images/author.png'); ?>
			</div>
			<?php if($profil->ID == $user_ID) { ?>
				<ul>
				<li><a href="<?php bloginfo('url') ?>/wp-admin/">Αρχή</a></li>
				<?php if ( $user_level >= 1 ) { ?><li><a href="<?php bloginfo('url') ?>/wp-admin/post-new.php">Προσθέστε νέα ταινία</a></li><?php } ?>
				<li><a href="<?php bloginfo('url') ?>/wp-admin/profile.php">Επεξεργασία προφίλ</a></li>
				
			<?php } ?>
		</div>
		<div class="user-right">
			<div class="profile-options">
			<div class="user-bas"><?php echo keremiya_hakkimda; ?></div>
				<ul>
				<?php if($profil->user_description) { ?><li><?php echo $profil->user_description; ?></a></li><?php }else { ?><?php echo keremiya_biyografi; ?><?php } ?>
				<li><span><strong><?php echo keremiya_kayit_tarihi; ?></strong> <?php echo $profil->user_registered; ?></span></li>
				</ul>
			</div>
		</div>
		<div class="user-comment">
		<div class="user-bas"><?php echo keremiya_yorum_yaptim; ?></div>
		<?php
		$thisauthor = get_userdata(intval($author));
		$querystr = "SELECT comment_ID, comment_post_ID, post_title, comment_content
		FROM $wpdb->comments, $wpdb->posts
		WHERE user_id = $thisauthor->ID
		AND comment_post_id = ID
		AND comment_approved = 1
		ORDER BY comment_ID DESC
		LIMIT 10";
		$comments_array = $wpdb->get_results($querystr, OBJECT); if ($comments_array): ?>
		<ul>
		<?php foreach ($comments_array as $comment):setup_postdata($comment); ?>
		<li>
		<div class="user-basl"><a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><strong><?php echo($comment->post_title) ?></strong></a></div>
		<p><?php comment_excerpt($comment->comment_ID); ?></p>
		</li>
		<?php endforeach; ?>
		</ul>
		<?php else : ?>
		<ul>
		<li>
		<div class="user-basl">?????</div>
		<p>Δεν έχετε κάνει κάποιο σχόλιο μέχρι στιγμής.</p>
		</li>
		</ul>
		<?php endif; ?>
		</div>
		</div>
	</div>
</div>
<?php include ('sidebar-cat.php'); ?>
</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer();?>