<?php	if(!defined('_source')) die("Error");

	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	$urlcu = "";
	$urlcu .= (isset($_REQUEST['id_danhmuc'])) ? "&id_danhmuc=".addslashes($_REQUEST['id_danhmuc']) : "";
	$urlcu .= (isset($_REQUEST['id_list'])) ? "&id_list=".addslashes($_REQUEST['id_list']) : "";
	$urlcu .= (isset($_REQUEST['id_cat'])) ? "&id_cat=".addslashes($_REQUEST['id_cat']) : "";
	$urlcu .= (isset($_REQUEST['id_item'])) ? "&id_item=".addslashes($_REQUEST['id_item']) : "";
	$urlcu .= (isset($_REQUEST['type'])) ? "&type=".addslashes($_REQUEST['type']) : "";
	$urlcu .= (isset($_REQUEST['p'])) ? "&p=".addslashes($_REQUEST['p']) : "";

switch($act){

	case "man":
		get_items();
		$template = "product/items";
		break;		
	case "add":				
		$template = "product/item_add";
		break;
	case "edit":		
		get_item();		
		$template = "product/item_add";
		break;
	case "save":
		save_item();
		break;
	case "delete":
		delete_item();
		break;
	#===================================================	
	case "man_item":
		get_loais();
		$template = "product/loais";
		break;
	case "add_item":		
		$template = "product/loai_add";
		break;
	case "edit_item":		
		get_loai();
		$template = "product/loai_add";
		break;
	case "save_item":
		save_loai();
		break;
	case "delete_item":
		delete_loai();
		break;
	#===================================================	
	case "man_cat":
		get_cats();
		$template = "product/cats";
		break;
	case "add_cat":		
		$template = "product/cat_add";
		break;
	case "edit_cat":		
		get_cat();
		$template = "product/cat_add";
		break;
	case "save_cat":
		save_cat();
		break;
	case "delete_cat":
		delete_cat();
		break;
	#===================================================	
	case "man_list":
		get_lists();
		$template = "product/lists";
		break;
	case "add_list":		
		$template = "product/list_add";
		break;
	case "edit_list":		
		get_list();
		$template = "product/list_add";
		break;
	case "save_list":
		save_list();
		break;
	case "delete_list":
		delete_list();
		break;
	default:
		$template = "index";
		
	#===================================================	
	case "man_danhmuc":
		get_danhmucs();
		$template = "product/danhmucs";
		break;
		
	case "add_danhmuc":		
		$template = "product/danhmuc_add";
		break;
		
	case "edit_danhmuc":		
		get_danhmuc();
		$template = "product/danhmuc_add";
		break;
		
	case "save_danhmuc":
		save_danhmuc();
		break;
	case "delete_danhmuc":
		delete_danhmuc();
		break;
	default:
		$template = "index";
}

#====================================
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;	
	}

function get_items(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}	
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$where.=" and id_danhmuc=".(int)$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
		$where.=" and id_list=".(int)$_REQUEST['id_list']."";
	}
	if((int)$_REQUEST['id_cat']!='')
	{
		$where.=" and id_cat=".(int)$_REQUEST['id_cat']."";
	}
	if((int)$_REQUEST['id_item']!='')
	{
		$where.=" and id_item=".(int)$_REQUEST['id_item']."";
	}
	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.= " order by id_danhmuc,id_list,id_cat,id_item,stt asc,id desc";

	$sql="SELECT count(id) AS numrows FROM #_product where id<>0 $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	
	$pageSize=20;
	$offset=10;
						
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	
	$sql = "select * from #_product where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=product&act=man".$urlcu;
}

function get_item(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=productact=man".$urlcu);
	
	$sql = "select * from #_product where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=product&act=man".$urlcu);
	$item = $d->fetch_array();
	
}

function save_item(){
	global $d,$config,$urlcu;
	$file_name=$_FILES['file']['name'];
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
		
	if($id){
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], 220, 180, _upload_sanpham,$file_name,2);									
			$d->setTable('product');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_sanpham.$row['photo']);	
				delete_file(_upload_sanpham.$row['thumb']);								
			}
		}

		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];		
		$data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];	
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_nhasanxuat'] = (int)$_POST['id_nhasanxuat'];		
		$data['tenkhongdau'] = changeTitle($_POST['ten']);			
		$data['masp'] = $_POST['masp'];			
		$data['gia'] = $_POST['gia'];
		$data['giacu'] = $_POST['giacu'];
		$data['nhasanxuat'] = $_POST['nhasanxuat'];
		$data['size'] = trim($_POST['size']);
		$data['mausac'] = trim($_POST['mausac']);				
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['spmoi'] = isset($_POST['spmoi']) ? 1 : 0;
		$data['tieubieu'] = isset($_POST['tieubieu']) ? 1 : 0;
		$data['spbanchay'] = isset($_POST['spbanchay']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}		
		$d->setTable('product');
		$d->setWhere('id', $id);
		if($d->update($data))
		{
				if (isset($_FILES['files'])) {
				 $arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
				 $arr_chuoi = str_replace('[','',$arr_chuoi);
				 $arr_chuoi = str_replace(']','',$arr_chuoi);
				 $arr_file_del = explode(',',$arr_chuoi);
	            for($i=0;$i<count($_FILES['files']['name']);$i++){
	            	if($_FILES['files']['name'][$i]!=''){
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							//dump(in_array(($_FILES['files']['name'][$i]),$arr));
							$file['name'] = $_FILES['files']['name'][$i];
							$file['type'] = $_FILES['files']['type'][$i];
							$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
							$file['error'] = $_FILES['files']['error'][$i];
							$file['size'] = $_FILES['files']['size'][$i];
							$file_name = images_name($_FILES['files']['name'][$i]);
							$photo = upload_photos($file, _format_duoihinh, _upload_hinhthem,$file_name);
							$data1['photo'] = $photo;
							$data1['thumb'] = create_thumb($data1['photo'], 230, 230, _upload_hinhthem,$file_name,1);	
							$data1['stt'] = $_POST['stthinh'][$i];
							$data1['type'] = 'sanpham';	
							$data1['id_hinhanh'] = $id;
							$data1['hienthi'] = 1;
							$d->setTable('hinhanh');
							$d->insert($data1);
						}
					}
				}
	        }
			redirect("index.php?com=product&act=man".$urlcu);
		}
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man".$urlcu);
	}else{

		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name))
		{
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], 220, 180, _upload_sanpham,$file_name,2);	
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];		
		$data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];	
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_nhasanxuat'] = (int)$_POST['id_nhasanxuat'];		
		$data['tenkhongdau'] = changeTitle($_POST['ten']);			
		$data['masp'] = $_POST['masp'];			
		$data['gia'] = $_POST['gia'];
		$data['giacu'] = $_POST['giacu'];
		$data['nhasanxuat'] = $_POST['nhasanxuat'];				
		$data['stt'] = $_POST['stt'];
		$data['size'] = trim($_POST['size']);
		$data['mausac'] = trim($_POST['mausac']);
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['spmoi'] = isset($_POST['spmoi']) ? 1 : 0;
		$data['tieubieu'] = isset($_POST['tieubieu']) ? 1 : 0;
		$data['spbanchay'] = isset($_POST['spbanchay']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['type'] = $_POST['type'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		$d->setTable('product');
		if($d->insert($data))
		{
			$id=mysql_insert_id();
				if (isset($_FILES['files'])) {
				 $arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
				 $arr_chuoi = str_replace('[','',$arr_chuoi);
				 $arr_chuoi = str_replace(']','',$arr_chuoi);
				 $arr_file_del = explode(',',$arr_chuoi);
	            for($i=0;$i<count($_FILES['files']['name']);$i++){
	            	if($_FILES['files']['name'][$i]!=''){
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							//dump(in_array(($_FILES['files']['name'][$i]),$arr));
							$file['name'] = $_FILES['files']['name'][$i];
							$file['type'] = $_FILES['files']['type'][$i];
							$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
							$file['error'] = $_FILES['files']['error'][$i];
							$file['size'] = $_FILES['files']['size'][$i];
							$file_name = images_name($_FILES['files']['name'][$i]);
							$photo = upload_photos($file, _format_duoihinh, _upload_hinhthem,$file_name);
							$data1['photo'] = $photo;
							$data1['thumb'] = create_thumb($data1['photo'], 230, 230, _upload_hinhthem,$file_name,1);	
							$data1['stt'] = $_POST['stthinh'][$i];
							$data1['type'] = 'sanpham';	
							$data1['id_hinhanh'] = $id;
							$data1['hienthi'] = 1;
							$d->setTable('hinhanh');
							$d->insert($data1);
						}
					}
				}
	        }
			redirect("index.php?com=product&act=man".$urlcu);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man".$urlcu);
	}
}


//===========================================================
function delete_item(){
	global $d,$urlcu;
	if($_REQUEST['id_cat']!='')
	{
		 $id_catt="&id_cat=".$_REQUEST['id_cat'];
	}
	if($_REQUEST['p']!='')
	{ 
	$id_catt.="&p=".$_REQUEST['p'];
	}
		
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);
		$d->reset();
		$sql = "select id,thumb, photo from #_product where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_sanpham.$row['photo']);
				delete_file(_upload_sanpham.$row['thumb']);			
			}
		$sql = "delete from #_product where id='".$id."'";
		$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=product&act=man".$id_catt."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man".$urlcu);
	}elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
		$sql = "select id,thumb, photo from #_product where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_sanpham.$row['photo']);
				delete_file(_upload_sanpham.$row['thumb']);
			}
			$sql = "delete from #_product where id='".$id."'";
			$d->query($sql);
		}
		} 
		redirect("index.php?com=product&act=man".$urlcu);
		} 
		else 
		transfer("Không nhận được dữ liệu", "index.php?com=product&act=man".$urlcu);	

}

#====================================

function get_loais(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}	
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$where.=" and id_danhmuc=".$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
		$where.=" and id_list=".$_REQUEST['id_list']."";
	}
	if((int)$_REQUEST['id_cat']!='')
	{
		$where.=" and id_cat=".$_REQUEST['id_cat']."";
	}
	$where.=" order by stt,id desc";

	
	$sql="SELECT count(id) AS numrows FROM #_product_item where id<>0 $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	
	$pageSize=20;
	$offset=10;
						
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	
	$sql = "select * from #_product_item where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=product&act=man_item".$urlcu;
}

function get_loai(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item".$urlcu);
	
	$sql = "select * from #_product_item where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_item".$urlcu);
	$item = $d->fetch_array();
}

function save_loai(){
	
	global $d,$config,$urlcu;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){	
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;		
			$d->setTable('product_item');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_sanpham.$row['photo']);	
				delete_file(_upload_sanpham.$row['thumb']);				
			}
		}
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];	
		$data['id_cat'] = $_POST['id_cat'];			
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_item');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=product&act=man_item".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_item".$urlcu);
	}else{		
		 if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;			
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];
		$data['id_cat'] = $_POST['id_cat'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['type'] = $_POST['type'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_item');
		if($d->insert($data))
			redirect("index.php?com=product&act=man_item".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_item".$urlcu);
	}
}
//===========================================================

function delete_loai(){
	global $d,$urlcu;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);		
		$d->reset();		
			//Xóa danh mục cấp 4
			$sql = "delete from #_product_item where id='".$id."'";
			$d->query($sql);
			//Xóa sản phẩm thuộc loại đó
			$sql = "select id,thumb,photo from #_product where id_item='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product where id_item='".$id."'";
				$d->query($sql);
			}
			
		
		
		if($d->query($sql))
			redirect("index.php?com=product&act=man_item".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_item".$urlcu);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			
				$sql = "delete from #_product_item where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product where id_item='".$id."'";
				$d->query($sql);
			
		} 
		redirect("index.php?com=product&act=man_item".$urlcu);
	}
	
}

##===================================================
function get_cats(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}		
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$where.=" and id_danhmuc=".(int)$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
		$where.=" and id_list=".(int)$_REQUEST['id_list']."";
	}
	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.=" order by id_danhmuc,id_list,stt,id desc";
	
	$sql="SELECT count(id) AS numrows FROM #_product_cat where id<>0 $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	
	$pageSize=20;
	$offset=10;
						
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	
	$sql = "select * from #_product_cat where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=product&act=man_cat".$urlcu;

}

function get_cat(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat".$urlcu);
	
	$sql = "select * from #_product_cat where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_cat".$urlcu);
	$item = $d->fetch_array();	
}

function save_cat(){
	global $d,$config,$urlcu;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";

	if($id)
	{	
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;						
			$d->setTable('product_cat');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_sanpham.$row['photo']);				
			}
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_cat');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=product&act=man_cat".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_cat".$urlcu);
	}
	else{				
		 if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;						
		}
		
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['type'] = $_POST['type'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}		
		$d->setTable('product_cat');
		if($d->insert($data))
			redirect("index.php?com=product&act=man_cat".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_cat".$urlcu);
	}
}
//===========================================================
function delete_cat(){
	global $d,$urlcu;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);		
		$d->reset();		
			
			//Xóa danh mục cấp 3
			$sql = "select id,thumb,photo from #_product_cat where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_product_item where id_cat='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_item where id_cat='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_product where id_cat='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product where id_cat='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=product&act=man_cat".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_cat".$urlcu);

	

	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			
				$sql = "delete from #_product_cat where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_item where id_cat='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product where id_cat='".$id."'";
				$d->query($sql);
			
		} redirect("index.php?com=product&act=man_cat".$urlcu);
	}
							
}

##====================================================
function get_lists(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}		
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$where.=" and id_danhmuc=".$_REQUEST['id_danhmuc']."";
	}
	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.=" order by id_danhmuc,stt,id desc";

	$sql="SELECT count(id) AS numrows FROM #_product_list where id<>0 $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	
	$pageSize=20;
	$offset=10;
						
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	
	$sql = "select * from #_product_list where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=product&act=man_list".$urlcu;
}

##====================================================
function get_list(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list".$urlcu);
	
	$sql = "select * from #_product_list where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_list".$urlcu);
	$item = $d->fetch_array();	
}
##====================================================
function save_list(){
	global $d,$config,$urlcu;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){		
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;			
			$d->setTable('product_list');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_sanpham.$row['photo']);				
			}
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();		
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_list');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=product&act=man_list".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_list".$urlcu);
	}else{		
		 if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;		
			
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['type'] = $_POST['type'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_list');
		if($d->insert($data))
			redirect("index.php?com=product&act=man_list".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_list".$urlcu);
	}
}

//===========================================================

function delete_list(){
	global $d,$urlcu;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);		
		$d->reset();		
		
			//Xóa danh mục cấp 2			
			$sql = "select id,thumb,photo from #_product_list where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_list where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 3
			$sql = "select id,thumb,photo from #_product_cat where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_product_item where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_item where id_list='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_product where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product where id_list='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=product&act=man_list".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_list".$urlcu);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			
				$sql = "delete from #_product_list where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_cat where id_list='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_item where id_list='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product where id_list='".$id."'";
				$d->query($sql);
			
		} 
		redirect("index.php?com=product&act=man_list".$urlcu);
	}
}


##==========================================================
function get_danhmucs(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}	
	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.=" order by stt,id desc";

	$sql="SELECT count(id) AS numrows FROM #_product_danhmuc where id<>0 $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	
	$pageSize=20;
	$offset=5;
						
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	
	$sql = "select * from #_product_danhmuc where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link='index.php?com=product&act=man_danhmuc'.$urlcu;
}
//===========================================================
function get_danhmuc(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_danhmuc".$urlcu);
	
	$sql = "select * from #_product_danhmuc where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_danhmuc".$urlcu);
	$item = $d->fetch_array();	
}
//===========================================================
function save_danhmuc(){

	global $d,$config,$urlcu;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_danhmuc".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){		
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;	
			$d->setTable('product_danhmuc');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_sanpham.$row['photo']);	
				//delete_file(_upload_sanpham.$row['thumb']);				
			}
		}
		
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_danhmuc');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=product&act=man_danhmuc".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_danhmuc".$urlcu);
	}else{			
		  if($photo = upload_image("file", _format_duoihinh, _upload_sanpham,$file_name)){
			$data['photo'] = $photo;				
		}
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();	
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['type'] = $_POST['type'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('product_danhmuc');
		if($d->insert($data))
			redirect("index.php?com=product&act=man_danhmuc&".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_danhmuc".$urlcu);
	}
}

//===========================================================

function delete_danhmuc(){
	global $d,$urlcu;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);		
		$d->reset();		
			//Xóa danh mục cấp 1
			$sql = "delete from #_product_danhmuc where id='".$id."'";
			$d->query($sql);
			//Xóa danh mục cấp 2			
			$sql = "select id,thumb,photo from #_product_list where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_list where id_danhmuc='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 3
			$sql = "select id,thumb,photo from #_product_cat where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_product_item where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product_item where id_danhmuc='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_product where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_sanpham.$row['photo']);
					delete_file(_upload_sanpham.$row['thumb']);	
				}
				$sql = "delete from #_product where id_danhmuc='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=product&act=man_danhmuc".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_danhmuc".$urlcu);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			
				$sql = "delete from #_product_danhmuc where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_list where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_cat where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product_item where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_product where id_danhmuc='".$id."'";
				$d->query($sql);
			
		} 
		redirect("index.php?com=product&act=man_danhmuc".$urlcu);
		} 
		else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_danhmuc".$urlcu);
	}
?>