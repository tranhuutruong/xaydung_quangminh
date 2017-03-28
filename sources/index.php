<?php  if(!defined('_source')) die("Error");
	$congtrinh=getAll("select id,tenkhongdau,ten$lang as ten,photo,mota$lang as mota from #_product where hienthi=1 and type='congtrinh' and noibat=1 order stt,id desc limit 0,5");
?>