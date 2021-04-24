<?php wp_footer(); ?>
<div id="footer">
        	<div class="footer clearfix">
		<div class="footerleft">
			<?php if(get_option('keremiya_footer_left')) { echo get_option('keremiya_footer_left'); } else { echo 'Copyright &copy; '.date('Y').' <a href="'.get_settings('home').'">Tainies Online Greek Subs - OiPeirates</a>'; echo "</br>";  } if(get_option('keremiya_analytics')) { echo get_option('keremiya_analytics'); } ?>
		</div> 
<!-- '.get_bloginfo('name').' -->
		<div class="footeright">     
</div>
</div>
</div>
</div>

<!-- <script type="text/javascript">
    var ad_idzone = "651",
    ad_popup_fallback = false,
    ad_popup_force = true,
    ad_new_tab = true,
    ad_frequency_period = 60,
    ad_frequency_count = 2,
    ad_trigger_method = 1;
</script>
<script type="text/javascript" src="https://a.optimizesrv.com/popunder1000.js">
</script> -->


</body>
</html>