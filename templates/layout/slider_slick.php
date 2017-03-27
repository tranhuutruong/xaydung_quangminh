<?php
	$d->reset();
	$sql_slider = "select ten$lang as ten,link,photo from #_slider where hienthi=1 and type='slider' order by stt,id desc";
	$d->query($sql_slider);
	$slider=$d->result_array();
?>
<div id="slider_slick">
	<?php  for($i=0,$count_slider=count($slider);$i<$count_slider;$i++){ ?>
        <?php if($slider[$i]['link']!='')echo '<a href="'.$slider[$i]['link'].'" target="_blank">' ?>				            <img src="<?=_upload_hinhanh_l.$slider[$i]['photo'] ?>" title="<?=$slider[$i]['ten']?>" />
		<?php if($slider[$i]['link']!='')echo '</a>' ?>
    <?php } ?>
</div>


