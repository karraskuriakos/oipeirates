<?php
ob_start ();
/*
Template Name: Contact us
*/
?>
<?php get_header();
if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Παρακαλώ εισάγετε το όνομά σας.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		if(trim($_POST['contactSubject']) === '') {
			$subjectError = 'Παρακαλώ εισάγετε το θέμα.';
			$hasError = true;
		} else {
			$subject = trim($_POST['contactSubject']);
		}
		if(trim($_POST['email']) === '')  {
			$emailError = 'Παρακαλώ εισάγετε τη διεύθυνση e-mail σας.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'Άκυρη Διεύθυνση E-mail.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		if(trim($_POST['comments']) === '') {
			$commentError = 'Πληκτρολογήστε το μήνυμά σας.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		if(!isset($hasError)) {
			$emailTo = get_option('keremiya_email');
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}

			$subject = '['.$subject.']'.' Gönderenin Adı: '.$name;
			$body = "Ad: $name \n\nE-Posta: $email \n\nMesaj: $comments";
			$headers = 'Gönderen: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			//mail('keremiya@gmail.com', $subject, $body, $headers);
			$emailSent = true;
		}
	
} ?>
<div id="content">
	<div class="leftC">
		<div class="filmborder">
			<div class="filmcontent">
			<h1 class="yazitip"><?php the_title(); ?></h1>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<div class="filmicerik2">
            <?php if(isset($emailSent) && $emailSent == true) { ?>
			<p style="background:#C6E633;border-radius:3px;color:#3A3A3A;padding:5px;font-weight:bold;">Teşekkürler, e-postanız başarıyla gönderildi. Anasayfaya yönlendiriliyorsunuz...</p>
            <?php $anadres = get_bloginfo('url'); ?>
			<?php header ( "Refresh:3; url=$anadres" );?>
            <?php } else { ?>
			
            <?php if(isset($hasError) || isset($captchaError)) { ?>
			<p style="background:#A82C10;border-radius:3px;color:#fff;padding:5px;font-weight:bold;">Üzgünüz, bir hata ile karşılaştık. Formu eksiksiz doldurduğunuzdan emin olun.</p>
            <?php } ?>
			
            <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
              <div class="contactform">
				<p>
				<label for="contactName" id="user">name </label></br>
				<input type="text" name="contactName" id="user_login" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
				<?php if($nameError != '') { ?>
					<span class="error">
					<?=$nameError;?>
					</span>
				<?php } ?>
				</p>
				
				<p>
				<label for="email" id="user">E-mail</label></br>
				<input type="text" name="email" id="user_email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
				<?php if($emailError != '') { ?>
					<span class="error">
					<?=$emailError;?>
					</span>
				<?php } ?>
				</p>

				<p>
				<label for="contactName" id="user">Θέμα</label></br>
				<input type="text" name="contactSubject" id="contactSubject" value="<?php if(isset($_POST['contactSubject'])) echo $_POST['contactSubject'];?>" class="required requiredField" />
				<?php if($subjectError != '') { ?>
					<span class="error">
					<?=$subjectError;?>
					</span>
				<?php } ?>
				</p>
				</div>
				<div class="textarea">
				<label for="contactName" id="user">Πείτε ότι θέλετε</label></br>
				<textarea name="comments" id="commentsText" rows="20" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
				<p class="buttons">
				<input type="hidden" name="submitted" id="submitted" value="true" />
				<button type="submit" id="btn-send">Υποβολή E-Mail</button>
				</p>
				<?php if($commentError != '') { ?>
					<br />
					<span class="error">
					<?=$commentError;?>
					</span>
				<?php } ?>
				
				</div>
            <?php } ?>    
			</div>			
			<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
<div id="sidebar">
<div class="sidebarborder">
	<div class="sidebar-right">
		<h2>Kategoriler</h2>
		<ul class="arrow">
		<?php wp_list_categories('show_option_all&orderby=name&title_li=&depth=0'); ?>
		</ul>
	</div>
</div>
</div>
</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer(); ?>