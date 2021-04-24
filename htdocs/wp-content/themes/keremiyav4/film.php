<div class="moviefilm">
<a href="<?php the_permalink() ?>">
<?php keremiya_afis_sistemi('afisbilgi'); ?>
<?php keremiya_resim('125px', '119px', 'like_this'); ?>
</a>
<div class="movief"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
<div class="movies"><?php if(function_exists('the_views')) { echo "<small>"; the_views(); echo keremiya_izlenme; echo "</small>"; } ?></div>
</div>