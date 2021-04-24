<?php function keremiya_breadcrumbs() {
  $delimiter = '>';
  $home = 'Tainies Online'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
  
	echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" class="Breadcrumbx">';
    global $post;
	$kategori = get_the_category();
    $homeLink = get_bloginfo('url');
    echo '<b><span typeof="v:Breadcrumb" ><a href="' . $homeLink . '" rel="v:url" property="v:title">' . $home . '</a></span> ' . $delimiter . ' ';
	echo '<span  typeof="v:Breadcrumb"><a style="color:#515151" href="' . get_category_link( $kategori[0]->term_id ) . '" rel="v:url" property="v:title">'.$kategori[0]->name.'</a>  <a style="color:#515151" href="' . get_category_link( $kategori[1]->term_id ) . '" rel="v:url" property="v:title">'.$kategori[1]->name.'</a>  <a style="color:#515151" href="' . get_category_link( $kategori[2]->term_id ) . '" rel="v:url" property="v:title">'.$kategori[2]->name.'</a>  <a style="color:#515151" href="' . get_category_link( $kategori[3]->term_id ) . '" rel="v:url" property="v:title">'.$kategori[3]->name.'</a></span></b>';
	echo '</div>';
} // end keremiya_breadcrumbs() ?>
