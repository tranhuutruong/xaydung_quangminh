<?php
	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	$d = new database($config['database']);
	
	#Thông tin seo web title + Keyword + Description
	$sql_seo = "select title,keywords,description from #_meta limit 0,1";
	$d->query($sql_seo);
	$seo= $d->fetch_array();	
	
	#Thông tin công ty
	$sql_company = "select *,ten$lang as ten,diachi$lang as diachi from #_company limit 0,1";
	$d->query($sql_company);
	$company= $d->fetch_array();
	
	switch($com)
	{
		case 'gioi-thieu':
			$type = "about";
			$title = _gioithieu;
			$title_cat = _gioithieu;
			$source = "about";
			$template = "about";
			break;
			
		case 'tin-tuc':
			$type = "tintuc";
			$title = _tintuc;
			$title_cat = _tintuc;
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "news";
			break;
			
		case 'dich-vu':
			$type = "dichvu";
			$title = _dichvu;
			$title_cat = _dichvu;
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "news";
			break;
			
		case 'tuyen-dung':
			$type = "tuyendung";
			$title = _tuyendung;
			$title_cat = _tuyendung;
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "news";
			break;
			
		case 'lien-he':
			$type = "lienhe";
			$title = _lienhe;
			$title_cat = _lienhe;
			$source = "contact";
			$template = "contact";
			break;

		case 'tim-kiem':
			$type = "sanpham";
			$title = _ketquatimkiem;
			$title_cat = _ketquatimkiem;
			$source = "search";
			$template = "product";
			break;
						
		case 'san-pham':
			$type = "sanpham";
			$title = _sanpham;
			$title_cat = _sanpham;
			$source = "product";
			$template = isset($_GET['id']) ? "product_detail" : "product";
			break;
			
		case 'video':
			$title = 'Video Clip';
			$title_cat = "Video Clip";
			$source = "video";
			$template = "video";
			break;
		
		case 'gio-hang':
			$type = "giohang";
			$title = _giohang;
			$title_cat = _giohang;
			$source = "giohang";
			$template = "giohang";
			break;	
			
		case 'thanh-toan':
			$type = "thanhtoan";
			$title = _thanhtoan;
			$title_cat = _thanhtoan;
			$source = "thanhtoan";
			$template = "thanhtoan";
			break;
			
		case 'dang-ky':
			$type = "dangky";
			$title = _dangky;
			$title_cat = _dangky;
			$source = "dangky";
			$template = "dangky";
			break;
			
		case 'dang-nhap':
			$type = "dangnhap";
			$title = _dangnhap;
			$title_cat = _dangnhap;
			$source = "dangnhap";
			$template = "dangnhap";
			break;
		
		case 'quen-mat-khau':
			$type = "quenmatkhau";
			$title = _quenmatkhau;
			$title_cat = _quenmatkhau;
			$source = "quenmatkhau";
			$template = "quenmatkhau";
			break;
			
		case 'thay-doi-thong-tin':
			$type = "thaydoithongtin";
			$title = _thaydoithongtin;
			$title_cat = _thaydoithongtin;
			$source = "thaydoithongtin";
			$template = "thaydoithongtin";
			break;
			
		case 'dang-xuat':
			logout();
			break;
				
		case 'add-user':
			$source = "user";
			$template = "user";
			break;
			
		case 'ngonngu':
			if(isset($_GET['lang']))
			{
				switch($_GET['lang'])
					{
						case '':
							$_SESSION['lang'] = '';
							break;
						case 'en':
							$_SESSION['lang'] = 'en';
							break;
						default: 
							$_SESSION['lang'] = '';
							break;
					}
			}
			else{
				$_SESSION['lang'] = '';
			}
		redirect($_SERVER['HTTP_REFERER']);
		break;	
										
		default: 
			$source = "index";
			$template = "index";
			break;
	}
	
	if($source!="") include _source.$source.".php";	
	if($_REQUEST['com']=='logout')
	{
		session_unregister($login_name);
		header("Location:index.php");
	}

	$arr_animate =array("bounce","flash","pulse","rubberBand","shake","swing","tada","wobble","jello","bounceIn","bounceInDown","bounceInLeft","bounceInRight","bounceInUp","bounceOut","bounceOutDown","bounceOutLeft","bounceOutRight","bounceOutUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft","fadeInLeftBig","fadeInRight","fadeInRightBig","fadeInUp","fadeInUpBig","fadeOut","fadeOutDown","fadeOutDownBig","fadeOutLeft","fadeOutLeftBig","fadeOutRight","fadeOutRightBig","fadeOutUp","fadeOutUpBig","flip","flipInX","flipInY","flipOutX","flipOutY");	
?>