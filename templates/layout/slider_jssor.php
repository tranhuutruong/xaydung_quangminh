<?php

	$d->reset();
	$sql_slider = "select ten$lang as ten,link,photo from #_slider where hienthi=1 and type='slider' order by stt,id desc";
	$d->query($sql_slider);
	$slider=$d->result_array();
	
?>
<div id="slider1_container" style="position: relative;width: 1366px; height: 450px;">
    <!-- Slides Container -->
    <div u="slides" style="cursor: move;width: 1366px; height: 450px;overflow: hidden;">
        <?php for($i=0,$count_slider=count($slider);$i<$count_slider;$i++){ ?>
        <div>
            <img u="image" src="<?php if($slider[$i]['photo']!='')echo _upload_hinhanh_l.$slider[$i]['photo'];else echo 'images/noimage.png' ?>" alt="<?=$$slider[$i]['ten']?>" />
        </div>
        <?php } ?>                
    </div>
    <!-- Trigger -->
             
    <!-- Arrow Left -->
    <span u="arrowleft" class="jssora05l" style="top:40%;"></span>
    <!-- Arrow Right -->
    <span u="arrowright" class="jssora05r" style="top:40%;"></span>
</div><!-- Jssor Slider End -->
        

    
 