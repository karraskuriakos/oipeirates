<?php get_header(); ?>
	<div id="content">
		<?php if (get_option('keremiya_manset_slider') == 'On'): ?>
		<?php include(TEMPLATEPATH . '/slide.php'); ?>
		<?php endif; ?>
		<div class="leftC1">
		<?php // Gerekli Ayarlar 
		$sayfa = get_option('keremiya_sayfa'); 
		$posts_per_page = get_option('keremiya_sayfa_basi'); 
		$izlenenler = get_option('keremiya_encokizlenenler_page_id'); 
		$yorumlananlar = get_option('keremiya_encokyorumlananlar_page_id'); 
		$begenilenler = get_option('keremiya_encokbegenilenler_page_id'); 
		$animes = get_option('keremiya_animes_page_id'); 
		?>
			<div class="filmborder1">
			<!-- <a class="photo" alt="Xmas Movies" title="Christmas Moivies" href="https://oipeirates.live/genre/x-mas">Οι καλύτερες Χριστουγεννιάτικες ταινίες όλων των εποχών</a> -->
			


				<h1  align="center" style="font-family: Arial;"><strong> <?php keremiya_titles(); ?> </strong></h1> 
<!-- 				<h1  align="center" style="font-family: Arial;"><strong><font color="red">Η ΣΕΛΊΔΑ ΑΛΛΑΞΕ ΔΙΕΥΘΥΝΣΗ ΣΕ: <font color="yellow">https://oipeirates.pro </font></font>   </strong></h1> 
<script async="async" data-cfasync="false" src="//upgulpinon.com/1?z=3379942"></script>
 -->
				
				<h1>
					<center><a href="https://movielab.online" target="_blank"> <img class="aligncenter" src="https://oipeirates.pro/wp-content/uploads/2020/10/PYVldo0XaJP0AfTYWSDkFGmvmwxTNhXuYpDSBE2b.png" alt="MOVIELAB" /></a></center>
	<p style="text-align: center;"><u>Η Καινούρια σελίδα είναι έτοιμη</u></p>
					<center> 	
						>> <span style="color: #ff0000;" style="text-align: center;"> <a style="color: #ff0000;" href="https://movielab.online">movielab.online</a></strong>  </span>  << <br><br>
					
Χωρίς διαφημίσεις, χωρίς VPN, με βάση δεδομένων από όλα τα Ελληνικά sites. <br>
					
					</center>
				</h1>
				
			<h2><center>Follow us: <a href="https://instagram.com/movielab.online">Instagram</a>, <a href="https://facebook.com/movielab.online">Facebook</a> Visit: <a href="https://movielab.online"> Movielab</a></center></h2>

				<div class="tam">
					<ul>
					<li <?php if ( is_front_page() ) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_option('home'); ?>/"><?php echo keremiya_yeniler; ?></a></li>
					<?php if ( $izlenenler>0 ) : ?><li <?php if (is_page($izlenenler)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($izlenenler) ?>"><?php echo get_the_title($izlenenler) ?></a></li><?php endif; ?>
					<?php if ( $yorumlananlar>0 ) : ?><li <?php if (is_page($yorumlananlar)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($yorumlananlar) ?>"><?php echo get_the_title($yorumlananlar) ?></a></li><?php endif; ?>
					<?php if ( $begenilenler>0 ) : ?><li <?php if (is_page($begenilenler)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($begenilenler) ?>"><?php echo get_the_title($begenilenler) ?></a></li><?php endif; ?>
					<?php if ( $animes>0 ) : ?><li <?php if (is_page($animes)) { echo ' class="current-menu-item"'; } else { echo' class="menu-item"'; }?>><a href="<?php echo get_permalink($animes) ?>"><?php echo get_the_title($animes) ?></a></li><?php endif; ?>
					</ul>	
				</div>
			<div class="filmcontent1">
			<?php echo do_shortcode('[ajax_load_more seo="true" cache_id="cache-movies" id="movies" cache="true" preloaded="true" button_label="More Movies"]'); ?>		
			</div>
			</div>
			<div class="filmborder1"><?php if ( !is_paged() ) {
				$home2 = file_get_contents('welcome.html');
				echo $home2; }?>
			</div>
		<?php if($sayfa == "Off") : ?>
		<?php if(function_exists('wp_pagenavi')) : ?>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
		<?php endif; ?>
			</div>
			</div>
	</div>
	

<div style="clear:both;"/>
<div class="footborder"></div>
<?php get_footer(); ?>