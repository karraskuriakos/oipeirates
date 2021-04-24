<?php get_header();?>
<div id="content">
	<div class="leftC">
		<div class="filmborder1">
			<div class="filmcontent1">
								<h1 class="yazitip"><?php wp_title("",true); ?></h1>
<?php
$term = $_GET['s'];
if(empty($term)){
   $term = 'WordPress';
}
echo do_shortcode('[ajax_load_more seo="true" preloaded="true" preloaded_amount="5" post_type="post, page, portfolio" search="'.$term.'" cache="true" cache_id="cache-search-'.$term.'" orderby="relevance" posts_per_page="10" css_classes="plain-text" button_label="Show More Results"]');
?>



			</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<div class="footborder"></div>
<?php get_footer();?>