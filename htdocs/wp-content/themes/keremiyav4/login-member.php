<?php
/*
Template Name: Login Member
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
			window.location="<?php bloginfo('url') ?>/profil/<?php the_author_meta(user_nicename,$user_ID); ?>";
			</script>
			</div>
		<?php else : ?>
		<div class="leftC">
		<div class="filmborder">
		<div class="filmcontent">
		<h1 class="yazitip"><?php the_title(); ?></h1>
		<div class="filmicerik2">
			<form action="<?php bloginfo('url') ?>/wp-login.php" method="post">
				<p><label for="log" id="user"><?php echo keremiya_kullanici_adi; ?></label>
				<br/><input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="22" /></p>
				<p><label for="pwd" id="pwd"><?php echo keremiya_sifre; ?></label><br/>
				<input type="password" name="pwd" id="pwd" size="22" /></p>
				<p><input type="submit" name="submit" value="<?php esc_attr_e('Σύνδεση'); ?>" class="button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php echo keremiya_beni_hatirla; ?></label></p>
				<input type="hidden" name="redirect_to" value="<?php bloginfo('url') ?>"/>
			</form>
			<p><a href="<?php bloginfo('url') ?>/register"><?php echo keremiya_uye_ol; ?></a> | <a href="<?php bloginfo('url') ?>/wp-login.php?action=lostpassword"><?php echo keremiya_sifre_unutma; ?></a><p>
		</div>
		</div>
		</div>
		</div>
		<?php include ('sidebar-cat.php'); ?>
		<?php endif; ?>
</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer();?>