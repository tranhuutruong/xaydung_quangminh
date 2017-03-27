<div class="tieude_giua"><div><?=$row_detail['ten']?></div><span></span></div>
<div class="box_container">
	<div class="wap_pro">
        <div class="zoom_slick">    
         	<div class="slick2">                
                <a class="fancybox-buttons images_main swipebox" data-fancybox-group="button" href="<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>"><img class='cloudzoom' src="<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>" data-cloudzoom ="zoomSizeMode:'image',autoInside: 550 ,zoomImage: '<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>' " ></a>
                
                <?php for($j=0,$count_hinhthem=count($hinhthem);$j<$count_hinhthem;$j++){?>
                	<a class="fancybox-buttons images_main swipebox" data-fancybox-group="button" href="<?php if($hinhthem[$j]['photo']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['photo']; else echo 'images/noimage.gif';?>"><img class='cloudzoom' src="<?php if($hinhthem[$j]['photo']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['photo']; else echo 'images/noimage.gif';?>" data-cloudzoom ="zoomSizeMode:'image',autoInside: 550 ,zoomImage: '<?php if($hinhthem[$j]['photo']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['photo']; else echo 'images/noimage.gif';?>' " ></a>	
                <?php } ?>
            </div><!--.slick-->
            
         
         	<?php $count=count($hinhthem); if($count>0) {?>
            <div class="slick">                
                <img class='cloudzoom-gallery' src="timthumb.php?src=<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>&h=100&w=100&zc=1&q=100" data-cloudzoom ="useZoom:'.cloudzoom', image:'<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>' ,zoomImage: '<?php if($row_detail['photo'] != NULL)echo _upload_sanpham_l.$row_detail['photo'];else echo 'images/noimage.gif';?>'" >
                
                <?php for($j=0,$count_hinhthem=count($hinhthem);$j<$count_hinhthem;$j++){?>
                	<img class='cloudzoom-gallery' src="<?php if($hinhthem[$j]['thumb']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['thumb']; else echo 'images/noimage.gif';?>" data-cloudzoom ="useZoom:'.cloudzoom', image:'<?php if($hinhthem[$j]['photo']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['photo']; else echo 'images/noimage.gif';?>' ,zoomImage: '<?php if($hinhthem[$j]['photo']!=NULL) echo _upload_hinhthem_l.$hinhthem[$j]['photo']; else echo 'images/noimage.gif';?>'" >
                <?php } ?>
            </div><!--.slick-->
            <?php } ?>
        </div><!--.zoom_slick--> 
        
        <ul class="product_info">
                <li class="ten"><?=$row_detail['ten']?></li>
                 <?php if($row_detail['masp'] != '') { ?><li><b>Mã sản phẩm:</b> <?=$row_detail['masp']?></span></li><?php } ?>
                 <?php if($row_detail['giacu'] != 0) { ?><li class="giacu">Giá cũ: <?=number_format($row_detail['giacu'],0, ',', '.').' <sup>đ</sup>';?></li><?php } ?>
                 <li class="gia">Giá: <?php if($row_detail['gia'] != 0)echo number_format($row_detail['gia'],0, ',', '.').' <sup>đ</sup>';else echo 'Liên hệ'; ?></li>
                   
                 <?php if($row_detail['size'] != '') { ?>
                 <li><b>Chọn size:</b> 
				  	<?php 
						$arr_size = explode(',',$row_detail['size']);
						foreach($arr_size as $key=>$value)
						{
							echo '<span class="size">'.$value.'</span>';
						}
					?>
                 </li>
				 <?php } ?> 
                 
                 <?php if($row_detail['mausac'] != '') { ?>
                 <li><b style="float:left;">Chọn màu:</b> 
				  	<?php 
						$arr_mausac = explode(',',$row_detail['mausac']);
						foreach($arr_mausac as $key=>$value)
						{
						  echo '<span class="mausac" style="background:'.$value.'">'.$value.'</span>';
						}
					?>
                 <div class="clear"></div>
                 </li>
				 <?php } ?>
                 <li><b>Số lượng:</b> <input type="text" value="1" class="soluong" /> </li>  
                            
                 <li><b>Lượt xem:</b> <span><?=$row_detail['luotxem']?> lượt</span></li>
                 <?php if($row_detail['mota'] != '') { ?><li><?=$row_detail['mota']?></li><?php } ?>
                 <li><a class="dathang">Đặt hàng</a></li>
                 <li><div class="addthis_native_toolbox"></div></li>          
        </ul>
        <div class="clear"></div>  
  </div><!--.wap_pro-->
        
        <div id="tabs">   
            <ul id="ultabs">				 
                <li data-vitri="0">Chi tiết sản phẩm</li>
                <li data-vitri="1">Bình luận</li>      
            </ul>
            <div style="clear:both"></div>
                            
            <div id="content_tabs">               
                <div class="tab">
                    <?=$row_detail['noidung']?>            
                </div> 
                
                <div class="tab">
                    <div class="fb-comments" data-href="<?=getCurrentPageURL()?>" data-numposts="5" data-width="100%"></div>
                </div>  
            </div><!---END #content_tabs-->
        </div><!---END #tabs-->	
<div class="clear"></div>
</div><!--.box_containerlienhe-->


<div class="tieude_giua"><div>Sản phẩm cùng loại</div><span></span></div>
<div class="wap_item">
<?php for($i=0,$count_product=count($product);$i<$count_product;$i++){	?>
    <div class="item">
            <p class="sp_img"><a href="san-pham/<?=$product[$i]['tenkhongdau']?>-<?=$product[$i]['id']?>.html" title="<?=$product[$i]['ten']?>">
            <img src="<?php if($product[$i]['thumb']!=NULL) echo _upload_sanpham_l.$product[$i]['thumb']; else echo 'images/noimage.png';?>" alt="<?=$product[$i]['ten']?>" /></a></p>
            <h3 class="sp_name"><a href="san-pham/<?=$product[$i]['tenkhongdau']?>-<?=$product[$i]['id']?>.html" title="<?=$product[$i]['ten']?>"><?=$product[$i]['ten']?></a></h3>
            <p class="sp_gia"><?=_gia?>: <span><?php if($product[$i]['gia'] != 0)echo number_format($product[$i]['gia'],0, ',', '.').' <sup>đ</sup>';else echo _lienhe; ?></span></p>
    </div><!---END .item-->
<?php } ?>
<div class="clear"></div>
<div class="pagination"><?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?></div>
</div><!---END .wap_item-->
