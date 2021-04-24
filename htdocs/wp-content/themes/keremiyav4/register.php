<?php
/*
Template Name: Register
*/
?>
<?php get_header(); ?>
<div id="content">
	<?php global $user_ID, $user_identity, $user_level ?>
		<?php if ( $user_ID ) : ?>
			<div class="olmayansayfa">
			<span style="font-size:40px;"><?php echo keremiya_giris_onay; ?></span>
			<p><?php echo keremiya_yonlendiriliyorsun; ?></p>
			<SCRIPT LANGUAGE="JavaScript">
			window.location="<?php echo get_option('siteurl'); ?>/profil/<?php the_author_meta(user_nicename,$user_ID); ?>";
			</script>
			</div>
		<?php else : ?>
			<div class="leftC">
			<div class="filmborder">
			<div class="filmcontent">
			<?php $register = $_GET['register']; if ($register == true) { ?>

			<h1 class="yazitip">Συγχαρητήρια !</h1>
			<div class="filmicerik2">
			<p style="background:#C6E633;border-radius:3px;color:#3A3A3A;padding:5px;font-weight:bold;"><?php echo keremiya_uye_onay; ?></p>
			<form action="<?php bloginfo('url') ?>/wp-login.php" method="post">
				<p><label for="log" id="user"><?php echo keremiya_kullanici_adi; ?></label>
				<br/><input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="22" /></p>
				
				<p><label for="pwd" id="pwd"><?php echo keremiya_sifre; ?></label><br/>
				<input type="password" name="pwd" id="pwd" size="22" /></p>
				
				<p><input type="submit" name="submit" value="<?php esc_attr_e('Σύνδεση'); ?>" class="button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php echo keremiya_beni_hatirla; ?></label></p>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			</div>
		<?php } else { ?>
			<h1 class="yazitip"><?php the_title(); ?></h1>
			<div class="filmicerik2">
			<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
				<p><label for="user_login" id="user"><?php echo keremiya_kullanici_adi; ?></label></br>
				<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="22" /></p>
				
				<p><label for="user_email" id="mail"><?php echo keremiya_e_posta; ?></label></br>
				<input type="text" name="user_email" id="user_email" class="input" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="22" /></p>
				
				<?php do_action('register_form'); ?>
				<p><?php echo keremiya_posta_sifre_gonder; ?></p>
				<?php do_action('register_form'); ?>
				<input type="submit" name="user-submit" value="<?php _e('Εγγραφή'); ?>" class="button" style="margin-bottom:10px;" tabindex="103" />
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
				<input type="hidden" name="user-cookie" value="1" />
			</form>
			</div>
		<?php } ?>
			</div>
			</div>
			</div>
			<?php include ('sidebar-cat.php'); ?>
		<?php endif; ?>
</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer(); ?>