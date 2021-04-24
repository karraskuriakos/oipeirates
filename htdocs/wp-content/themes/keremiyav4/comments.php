<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Bu satırları silmeyin
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php echo keremiya_yorum_koruma; ?></p>
	<?php
		return;
	}
?>

<!-- Düzenlemeye buradan başlayın. -->

<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><b><?php echo keremiya_yorum_giris; ?></b></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>
<div style="margin-left:10px;float:right;background:#111111;border-radius:5px;width:240px;padding:5px;">
<div class="left" style="width:170px;">
<p style="font-size:14px;font-family:oswald;">Γεια σας <a href="<?php echo get_option('siteurl'); ?>/profil/<?php the_author_meta(user_nicename,$user_ID); ?>" style="color:#C6E633;margin-right:10px;"><?php echo $user_identity; ?></a><br /><small style="color:#515151;">Γράψτε ένα σχόλιο για την ταινία.</small></p>

<p style="margin-top:20px;"><a href="<?php echo wp_logout_url(get_permalink()); ?>"> (<?php echo keremiya_cikis; ?>)</a></p></p>
</div>
<div style="float:right;background:#333333;border-radius:5px;height:60px;width:60px;padding:2px;border:2px solid #111111;"><?php echo get_avatar( $comment->comment_author_email, '60', $default=get_template_directory_uri().'/images/gravatar.gif'); ?></div>
</div>
<?php else : ?>
<div style="margin-left:10px;float:right;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td class="yborder" align="left" valign="top">
	<label for="name"><?php echo keremiya_yorum_isim; ?></label>
<input name="author" id="name" value="" size="50" tabindex="1" type="text">
    </td>
  </tr>
    <tr>

    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>

    <td class="yborder"align="left" valign="top">
<label for="email"><?php echo keremiya_yorum_email; ?></label>
<input name="email" id="email" value="" size="50" tabindex="2" type="text">
    </td>

  </tr>
</tbody></table>
</div>
<?php endif; ?>
<div style="margin-left:10px;float:left;margin-bottom:5px;">

<p><textarea name="comment" id="comment" cols="40" rows="3" tabindex="4"></textarea></p>
</div>
<div style="margin-left:10px;float:right;">
<input name="submit" type="submit" id="gonder" tabindex="5" value="<?php echo keremiya_yorum_gonder; ?>" />
<?php comment_id_fields(); ?>
</div>

</form>


<?php endif; // Kayıt gerekli ve giriş yapılmaması halinde ?>

<div style="margin-left:10px;float:left;clear:both;">
	<?php if ( have_comments() ) : ?>
	<b>&#8220;<?php the_title(); ?>&#8221; <?php echo keremiya_yorum_filminde; ?> <?php comments_number('0 Σχόλια', '1 Σχόλια', '% Σχόλια' );?> bulunuyor.</b>
	<ol class="commentlist">
	<?php wp_list_comments('type=comment&avatar_size=30&callback=keremiya_comment'); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

 <?php else : ?>

	<?php if ('open' == $post->comment_status) : ?>

	 <?php else : // yorumlar kapalı ?>
		<p class="nocomments"><?php echo keremiya_yorum_kapali; ?></p>
	<?php endif; ?>
<?php endif; ?>

</div>
</div>
<?php endif; // Bu silerseniz gözyüzü başınıza düşecek ?>