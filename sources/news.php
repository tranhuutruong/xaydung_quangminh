<?php  if(!defined('_source')) die("Error");

	@$id_item =   trim(strip_tags(addslashes($_GET['id_danhmuc'])));
	@$id =   trim(strip_tags(addslashes($_GET['id'])));	
	
	#Chi tiết tin tức
	if($id!='')
	{
		#Chi tiết tin tức
		$sql = "select ten$lang as ten,mota$lang as mota,noidung$lang as noidung,title,keywords,description,photo from #_news where id='".$id."' limit 0,1";
		$d->query($sql);
		$tintuc_detail = $d->fetch_array();
		
		#Thông tin seo web
		$title_cat = $tintuc_detail['ten'];		
		$title = $tintuc_detail['title'];
		$keywords = $tintuc_detail['keywords'];
		$description = $tintuc_detail['description'];
		
		#Thông tin share facebook
		$images_facebook = "http://".$config_url._upload_tintuc_l.$tintuc_detail['photo'];
		$title_facebook = $tintuc_detail['ten'];
		$description_facebook = trim(strip_tags($tintuc_detail['mota']));
		
		#Các tin cũ hơn		
		$where = " type='".$type."' and hienthi=1 and id<'".$id."' order by stt,id desc";		
	}
	#Danh mục tin tức
	elseif($id_item!='')
	{		
		$sql = "select id,ten$lang as ten,title,keywords,description from #_news_item where hienthi=1 and id='".$id_item."' limit 0,1";
		$d->query($sql);
		$title_new = $d->fetch_array();
		
		#Thông tin seo web
		$title_cat = $title_new['ten'];		
		$title = $title_new['title'];
		$keywords = $title_new['keywords'];
		$description = $title_new['description'];
		
		#Điều kiện lấy danh mục
		$where = " type='".$type."' and id_item='".$id_item."' and hienthi=1 order by stt,id desc";	
		
	}
	#Tất cả Tin tức có type là $type
	else{	
		$where = " type='".$type."' and hienthi=1 order by stt,id desc";	
	}
	
	#Lấy tin tức và phân trang
	$d->reset();
	$sql = "SELECT count(id) AS numrows FROM #_news where $where";
	$d->query($sql);	
	$dem = $d->fetch_array();
	
	$totalRows = $dem['numrows'];
	$page = $_GET['p'];
	$pageSize = 7;//Số item cho 1 trang
	$offset = 5;//Số trang hiển thị				
	if ($page == "")$page = 1;
	else $page = $_GET['p'];
	$page--;
	$bg = $pageSize*$page;		
	
	$d->reset();
	$sql = "select id,ten$lang as ten,tenkhongdau,mota$lang as mota,thumb,ngaytao from #_news where $where limit $bg,$pageSize";		
	$d->query($sql);
	$tintuc = $d->result_array();	
	$url_link = getCurrentPageURL();
?>