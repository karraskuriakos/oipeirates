<?php get_header();?>

<div id="content">

	<div class="leftC">

		<div class="filmborder1">

			<div class="filmcontent1">

								<h1 class="yazitip"><?php wp_title("",true); ?></h1>

					<?php if(is_category()){

						$cat = get_query_var('cat');

						$category = get_category ($cat);

						echo do_shortcode('[ajax_load_more seo="true" category="'.$category->slug.'" cache="true" cache_id="cache-'.$category->slug.'" button_label="More Movies" preloaded="true" preloaded_amount="15"]');

											}

											
// tag.php
 


if(is_tag()){ 
   $tag = get_query_var('tag'); 
   						echo do_shortcode('[ajax_load_more seo="true" tag="'.$tag.'" cache="true"  cache_id="cache-tag-'. $tag .'" button_label="More Movies" preloaded="true" preloaded_amount="15"]');
}

?>





					




			
			
			</div>

		</div>

		
	
			
			
		<div class="filmborder1">

			<div class="filmcontent1">

				<h2>Βρίσκεστε στην κατηγορία <font color="red"><?php single_cat_title(''); ?></font> : </h2>

					<ul id="footer_menu">

						<li>

							<div class="dropdown_3columns">

							<div class="col_3"><p>

							<?php echo category_description(); ?></p>

							<p style="text-align: center;">Σας ευχόμαστε καλή διασκέδαση.</p>

							</div>

							</div>

						</li>

					</ul>

			</div>

		</div>

	</div>

</div>

<div style="clear:both;"></div>

<div class="footborder"></div>

<?php get_footer();?>