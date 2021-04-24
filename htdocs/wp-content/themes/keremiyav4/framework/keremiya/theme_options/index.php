<?php include_once('header.php'); ?>

<form action='' enctype='multipart/form-data'>
	<div class='top_button'>
		<img class='save_tip' style='display: none;' src='<?php bloginfo('template_directory'); ?>/framework/keremiya/theme_options/images/save_tip.png' alt='' />
		<input name="save" class="save_changes" type="submit" value="" />
		<input type="hidden" name="action" value="save" />
	</div>
	<div style='clear: both;'></div>
	<div id='general_settings' class='mainTab'>
		<div id='general'>
			<?php $this->upload('logo', 'Logo', 'Αν θέλετε να αλλάξετε το λογότυπο, μπορείτε να επιλέξετε το νέο λογότυπό σας, κάνοντας κλικ στο κουμπί Λήψη. </ Br> Συνιστώμενο μέγεθος logo 230px x 55 εικ. '); ?>
			<?php $this->upload('favicon', 'Favicon', 'Αν θέλετε να αλλάξετε favicon, κάνοντας κλικ στο κουμπί Εγκατάσταση, μπορείτε να επιλέξετε νέο faviconu σας. </ Br> 16px 16px x συνιστώμενο μέγεθος'); ?>
			<?php $this->checkbox('feedburner_var', 'FeedBurner Ενεργοποίηση ενότητα', 'Για να ενεργοποιήσετε ή να απενεργοποιήσετε πρέπει να κάνετε είναι να κάνετε κλικ στο πλαίσιο ελέγχου.'); ?>
			<?php $this->text('feedburner', 'Feedburner ID', 'Προσθέσετε ταινίες για τους χρήστες σας μέσω e-mail για να σας αφήσει να ανοίξετε και των χρηστών των μελών Feedburner Feedburner να εισάγετε το όνομά σας στο επόμενο πλαίσιο.'); ?>
		</div>
		<div id='analytics' style='display: none;'>
			<?php $this->textarea('analytics', 'Analaytics Code', 'Google έχουν προσφέρει δωρεάν στα μέλη των συστημάτων analytics google για να αντιμετωπίσει αυτήν την ενότητα μπορείτε να εισάγετε τον κωδικό σας.'); ?>
		</div>
		<div id='email' style='display: none;'>
			<?php $this->text('email', 'E-Mail Adresi', 'Bir e-posta adresi giriniz. Boş bırakırsanız mesajlar admin hesabının  e-posta adresine gider.'); ?>
		</div>
		<div id='social_media' style='display: none;'>
			<?php $this->checkbox('sosyal', 'Sosyal Medya Bölümünü Etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
			<?php $this->text('twitter_id', 'Twitter', 'Twitter Sayfanızı yandaki kutucuğa giriniz. </br> Adresin önünde mutlaka <code>http://</code> bulunmalıdır.'); ?>
			<?php $this->text('facebook_id', 'Facebook', 'Facebook sayfa adresinizi buraya girebilirsiniz.</br><code>http://www.facebook.com/coca/784</code>'); ?>
		</div>
		<div id='player' style='display: none;'>
			<?php $this->text('phpkodu', 'Facebook PHP Adresi', 'Facebook videolarını çalıştırmak için kullandığınız PHP adresinizi giriniz. '); ?>
			<?php $this->text('player_height', 'Uzunluk', 'Flash player için uzunluk değeri.'); ?>
			<?php $this->text('player_width', 'Genişlik', 'Flash player için genişlik değeri.'); ?>
			<?php $this->colorpicker('player_backcolor', 'Menü Rengi'); ?>
			<?php $this->colorpicker('player_frontcolor', 'Yazı ve Buton'); ?>
			<?php $this->colorpicker('player_lightcolor', 'Yüklenme Çubuğu'); ?>	
			</div>
	</div>
	<div id='homepage_settings' style='display: none;' class='mainTab'>
		<div id='anasayfa'>
		<?php $this->checkbox('sayfa', 'Sayfalamayı (wp-pagenavi) etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->text('sayfa_basi', 'Gösterilecek Film Sayısı', 'Anasayfa, En çok izlenenler, animes, yorumlananlar ve beğenilenler bölümünde göstermek istediğiniz film sayısını girebilirsiniz. '); ?>
		<?php $this->text('ex_kategori', 'Gösterilmeyecek Kategori', 'Anasayfada göstermek istemediğiniz kategorinin ID ini giriniz.'); ?>
		<?php $this->checkbox('yeni', 'Afiş Sistemini etkinleştir. ', '<img style="float:right;" src="/wp-content/themes/keremiya/images/yeni.png" /> Etkinleştirme veya pasit hale getirmek için kutucuğa tıklayın.'); ?>
		</div>
		<div id='slider' style='display: none;'>
			<?php $this->checkbox('manset_slider', 'Manşet bölümünü etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
			<?php $this->text('manset_posts', 'Manşet Film Adeti', 'Manşet bölümünde toplam kaç film göstermek istiyorsanız rakam ile belirtin.'); ?>
			<?php $this->text('manset_kategori', 'Manşet Kategori ID', 'Manşet bölümünde göstermek istediğiniz <strong>kategorinin ID</strong> ini soldaki kutucuğa giriniz.</br> Boş bırakırsanız sitedeki tüm içeriği kullanır.'); ?>
			<?php $this->select('slider_effect', array(
				'' => 'En Yeniler',
				'rand' => 'Rastgele',
			),
			'Manşet Gösterim', 'Size en uygun olanı seçip, gösterimi ona göre yaptırabilirsiniz.'); ?>
			<?php $this->select('slider_hopla', array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'Manşet Geçiş', 'Sağ ve sol yön oklarını tıkladığınız otomatik olarak 2 film atlanır. Yandan kaç film atlanacağını seçebilirsiniz.'); ?>
			<?php $this->select('slider_auto', array(
				'true' => 'Aktif',
				'false' => 'Devre Dışı Bırak',
			),
			'Otomatik Geçiş', 'Slayt şeklinde bir görünüm kazandırır.'); ?>
			<?php $this->select('slider_step', array(
				'1000' => '1 Saniye',
				'2000' => '2 Saniye',
				'3000' => '3 Saniye',
				'4000' => '4 Saniye',
				'5000' => '5 Saniye',
				'6000' => '6 Saniye',
				'7000' => '7 Saniye',
				'8000' => '8 Saniye',
				'9000' => '9 Saniye',
				'10000' => '10 Saniye',
				'15000' => '15 Saniye',
				'20000' => '20 Saniye',
			),
			'Otomatik Geçiş', 'Geçişin ne kadar süre sonra olmasını ayarlayabilirsiniz.'); ?>
		</div>
		<div id='theme_footer' style='display: none;'>
			<?php $this->textarea('footer_left', 'Footer Yazı Sol', 'Footer sol bölüme eklemek istediğiniz linkleri veya yazıları bu bölüme girebilirsiniz. </br> Eklediğiniz herşey görünür.'); ?>
			<?php $this->textarea('footer_right', 'Footer Yazı Sağ', 'Bu bölüme <strong>göstermek istemediğiniz sayaç link</strong>lerinizi yerleştirebilirsiniz.</br> Ekledikleriniz sadece kaynak kodda görünür. Google ve Sayaç siteniz bunu görür ve çalıştırır.'); ?>
		</div>
		<div id='tavsiye_filmler' style='display: none;'>
			<?php $this->checkbox('tavsiye_var', 'Sidebar Tavsiye Filmler bölümünü etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
			<?php $this->text('tavsiyeisim', 'Tavsiye Filmler Bölümü İsmi', 'Tavsiye Filmler bölümünün ismini değiştirebilirsiniz.'); ?>
			<?php $this->text('tavsiyesayi', 'Tavsiye Film Adeti', 'Tavsiye Filmler bölümünde göstermek istediğiniz film sayısı'); ?>
			<?php $this->text('tavsiyekat', 'Tavsiye Film Kategori ID', 'Bu bölüme tavsiye filmlerin listelenmesi için gereken kategoriyi girmelisiniz. </br>Örneğin <strong>Tavsiye Filmler</strong> isminde bir kategori açıp, bu kategoriye göstermek istediğiniz filmleri ekleyebilirsiniz. Bu bölüme kategorinin id adresini yazmanız yeterlidir.'); ?>
		</div>
		<div id='encok_filmler' style='display: none;'>
			<?php $this->checkbox('encok_var', 'Sidebar En Çok İzlenenler bölümünü etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
			<?php $this->text('encokisim', 'En Çok İzlenen Filmler İsmi', 'En Çok İzlenen Filmler bölümünün ismini değiştirebilirsiniz.'); ?>
			<?php $this->text('encoksayi', 'Film Adeti', 'Tavsiye Filmler bölümünde göstermek istediğiniz film sayısı'); ?>
		</div>
	</div>
	<div id='posts_settings' style='display: none;' class='mainTab'>
		<div id='partlar'>
		<?php $this->text('part_iki', 'Otomatik İsim', 'Vereceğiniz isim göre listelenecektir. </br><code>Ör: Part 1, Part 2, Part 3</code>'); ?>
		<?php $this->text('part_bir', 'Manuel İlk Part İsmi', 'İlk Part ismi sistem tarafından <code>Fragman</code> olarak ayarlanmıştır. İsterseniz, <strong>ilk partı kendiniz isimlendirebilirsiniz.</strong>'); ?>
		</div>
		<div id='benzerfilm' style='display: none;'>
		<?php $this->checkbox('benzer_var', 'Benzer Filmler Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->text('benzer_filmler', 'Benzer Filmler Sayısı', '<code>Varsayılan Ayar: 5</code> </br> Daha fazla benzer film göstermek veya daha az göstermek istiyorsanız yandaki kutucuğa rakam giriniz.'); ?>
		</div>
		<div id='filmbilgileri' style='display: none;'>
		<?php $this->checkbox('filmbilgi_var', 'Film Bilgileri Bölümü Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->checkboxes(array(
			'eklenme' => 'Ne Zaman Eklendi',
			'konu' => 'Konu Bölümü',
			'duzenle' => 'Filmi Düzenle Butonu',
			'tur' => 'Tür',
			'yapim' => 'Yapım',
			'imdb' => 'IMDB Puanı',
			'yonetmen' => 'Yönetmen',
			'oyuncular' => 'Oyuncular',
			'etiketler' => 'Etiketler',
		),
		'Film Bilgileri Bölümü İçeriği'); ?>
		</div>
	</div>
	<div id='seo_settings' style='display: none;' class='mainTab'>
		<div id='seohome'>
		<?php $this->checkbox('seo_home_title', 'Anasayfa başlığını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textfield('seo_home_titletext', 'Anasayfa Başlığı', 'Bu bölüm ile anasayfanıza yeni bir başlık verebilirsiniz. Boş bırakırsanız wordpress kurulumu yaparken verdiğiniz başlık aktif olur.'); ?>
		<?php $this->textfield('seo_home_description', 'Anasayfa Açıklaması', 'Anasayfa için bir açıklama girebilirsiniz. Bu bölümü boş bırakırsanız wordpress tarafından otomatik belirlenmiş açıklamanız aktif hale gelir.'); ?>
		<?php $this->textfield('seo_home_keywords', 'Anasayfa Anahtar Kelimeleri', 'Anahtar kelimeleri girerken virgül ile ayırmayı unutmayın. Örneğin; <br /><code>keremiya, wordpress, temaları</code>'); ?>
		<?php $this->select('seo_home_type', array(
			'blogisim' => 'Blog ismi | Blog açıklaması',
			'blogaciklama' => 'Blog açıklaması | Blog ismi',
			'sadeceblog' => 'Sadece Blog ismi',
		),
		'Başlık Kalıpları', 'Yukarıda anasayfa başlığı aktif halde değilse buradan bir kalıp aktif olacaktır. Size uygun olanı seçmelisiniz.'); ?>
		<?php $this->text('seo_home_separate', 'Ayırma İşareti', 'Ayırma işaretinin başına ve sonuna mutlaka <strong><span style="color:#DD4B39">boşluk</span></strong> bırakın. Varsayılan ayraç: <code> | </code>'); ?>
		</div>
		<div id='seosingle' style='display: none;'>
		<?php $this->checkbox('seo_field', 'SEO özel alanlarını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->text('seo_single_field_title', 'Yazı Başlığı Özel Alan Adı', 'Buraya gireceğiniz özel alan ismi ile yazı başlığını yeniden isimlendirebilirsiniz.'); ?>
		<?php $this->text('seo_single_field_description', 'Yazı Açıklaması Özel Alan Adı', 'Ekleyeceğiniz yazılara <strong>meta description</strong> girmenizi sağlayan özel alan ismidir.'); ?>
		<?php $this->text('seo_single_field_keywords', 'Yazı Anahtar Kelimeleri Özel Alan Adı', 'Ekleyeceğiniz yazılara <strong>meta keywords</strong> girmenizi sağlayan özel alan ismidir.'); ?>
		<?php $this->select('seo_single_type', array(
			'yazibaslik' => 'Yazı Başlığı | Blog ismi',
			'yaziblog' => 'Blog ismi | Yazı Başlığı',
			'sadeceyazi' => 'Sadece Yazı Başlığı',
		),
		'Başlık Kalıpları', 'Yukarıda anasayfa başlığı aktif halde değilse buradan bir kalıp aktif olacaktır. Size uygun olanı seçmelisiniz.'); ?>
		<?php $this->text('seo_single_separate', 'Ayırma İşareti', 'Ayırma işaretinin başına ve sonuna mutlaka <strong><span style="color:#DD4B39">boşluk</span></strong> bırakın. Varsayılan ayraç: <code> | </code>'); ?>
		</div>
		<div id='seokategori' style='display: none;'>
		<?php $this->checkbox('seo_index_description', 'Kategori Açıklamalarını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->select('seo_index_type', array(
			'kategoribaslik' => 'Kategori Başlığı | Blog ismi',
			'kategoriblog' => 'Blog ismi | Kategori Başlığı',
			'sadecekategori' => 'Sadece Kategori Başlığı',
		),
		'Başlık Kalıpları', 'Yukarıda anasayfa başlığı aktif halde değilse buradan bir kalıp aktif olacaktır. Size uygun olanı seçmelisiniz.'); ?>
		<?php $this->text('seo_index_separate', 'Ayırma İşareti', 'Ayırma işaretinin başına ve sonuna mutlaka <strong><span style="color:#DD4B39">boşluk</span></strong> bırakın. Varsayılan ayraç: <code> | </code>'); ?>
		</div>
		<div id='seogenel' style='display: none;'>
		<?php $this->checkbox('seo_facebook', 'Facebook Meta Bilgileri Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->checkbox('seo_canonical', 'Canonical (Standart Url) Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		</div>
	</div>
	<div id='appearence_settings' style='display: none;' class='mainTab'>
		<div id='reklam_a'>
		<?php $this->checkbox('r_a', 'Video Önü Reklam Alanını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textarea('r_a_a', 'Reklam Kodu', 'Video önünde belli bir süre gösterim yapılan reklam alanıdır. </br> <code>336x250, 300x250, 250x250</code>'); ?>
		<?php $this->select('r_a_s', array(
			'5000' => '5 Saniye',
			'10000' => '10 Saniye',
			'15000' => '15 Saniye',
			'20000' => '20 Saniye',
			'25000' => '25 Saniye',
			'30000' => '30 Saniye',
			'60000' => '60 Saniye',
			'120000' => '120 Saniye',
		),
		'Gösterim Süresi', 'Size en uygun olanı seçip, gösterimi ona göre yaptırabilirsiniz.'); ?>
		<?php $this->checkbox('r_a_g', 'Reklam Geç Butonunu Etkinleştir.', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		</div>
		<div id='reklam_b' style='display: none;'>
		<?php $this->checkbox('r_b', '728x90 Reklam Alanını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textarea('r_b_b', 'Reklam Kodu', 'İçerik bölümünde video izleme bölümünün altında bulunan reklam alanıdır. </br> <code>728x90</code>'); ?>
		</div>
		<div id='reklam_c' style='display: none;'>
		<?php $this->checkbox('r_c', 'Sol Reklam Alanını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textarea('r_c_c', 'Reklam Kodu', 'Footer sol bölüme eklemek istediğiniz linkleri veya yazıları bu bölüme girebilirsiniz. </br> <code>1024x768 çözünürlüklü ekranlarda  küçük bir kısmı görünür</code>'); ?>
		</div>
		<div id='reklam_d' style='display: none;'>
		<?php $this->checkbox('r_d', 'Sağ Reklam Alanını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textarea('r_d_d', 'Reklam Kodu', 'Footer sol bölüme eklemek istediğiniz linkleri veya yazıları bu bölüme girebilirsiniz. </br> <code>1024x768 çözünürlüklü ekranlarda  küçük bir kısmı görünür</code>'); ?>
		</div>
		<div id='reklam_e' style='display: none;'>
		<?php $this->checkbox('r_e', 'Splash Reklam Alanını Etkinleştir', 'Etkinleştirmek veya pasifleştirmek için yapmanız gereken kutucuğu tıklamak.'); ?>
		<?php $this->textarea('r_e_e', 'Reklam Kodu', 'Ekranın tam ortasında çıkan reklam alanıdır. </br> <code>336x250, 300x250, 250x250</code>'); ?>
		</div>
	</div>
	<div class='reset_save'>
		<div class='reset_button'>
			<INPUT onClick="return confirm('Ayarlayı sıfırlamak istediğinizden emin misiniz?')" type='submit' name='reset' value='' class='reset_btn' />
			<img class='reset_tip' style='display: none;' src='<?php bloginfo('template_directory'); ?>/framework/keremiya/theme_options/images/reset_tip.png' alt='' />
		</div>
		<div class='bottom_button'>
			<img class='save_tip' style='display: none;' src='<?php bloginfo('template_directory'); ?>/framework/keremiya/theme_options/images/save_tip.png' alt='' />
			<input type='submit' name='save_changes' value='' class='save_changes' />
		</div>
		<div style='clear: both;'></div>
	</div>
	<div style='clear: both;'></div>
</form>

<?php include_once('footer.php'); ?>