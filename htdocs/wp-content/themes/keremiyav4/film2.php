<div class="moviefilm1">
<a href="<?php the_permalink() ?>">
<?php keremiya_afis_sistemi('afisbilgi'); ?>
<?php keremiya_resim('210px', '290px', 'anasayfa-resim'); ?>
</a>
<div class="movief1"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
<?php if(function_exists('the_views')) { echo "<small>"; the_views(); echo keremiya_izlenme; echo "</small>"; } ?>
</div>