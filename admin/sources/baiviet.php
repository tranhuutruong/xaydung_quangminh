<?php	if(!defined('_source')) die("Error");

	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	$duongdan=$_SERVER['HTTP_REFERER'];
	$id=$_REQUEST['id'];

switch($act){

	case "man":
		get_items();
		$template = "baiviet/items";
		break;
		
	case "add":				
		$template = "baiviet/item_add";
		break;
	case "edit":		
		get_item();		
		$template = "baiviet/item_add";
		break;
	case "save":
		save_item();
		break;
	case "savestt":
		savestt_item();
		break;
	case "delete":
		delete_item();
		break;
	#===================================================	
	case "man_item":
		get_loais();
		$template = "baiviet/loais";
		break;
	case "add_item":		
		$template = "baiviet/loai_add";
		break;
	case "edit_item":		
		get_loai();
		$template = "baiviet/loai_add";
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
		$template = "baiviet/cats";
		break;
	case "add_cat":		
		$template = "baiviet/cat_add";
		break;
	case "edit_cat":		
		get_cat();
		$template = "product/cat_add";
		break;
	case "save_cat":
		save_cat();
		break;
	case "savestt_cat":
		savestt_cat();
		break;
	case "delete_cat":
		delete_cat();
		break;
	#===================================================	
	case "man_list":
		get_lists();
		$template = "baiviet/lists";
		break;
	case "add_list":		
		$template = "baiviet/list_add";
		break;
	case "edit_list":		
		get_list();
		$template = "baiviet/list_add";
		break;
	case "save_list":
		save_list();
		break;
	case "savestt_list":
		savestt_list();
		break;
	case "delete_list":
		delete_list();
		break;
	default:
		$template = "index";
		
	#===================================================	
	case "man_danhmuc":
		get_danhmucs();
		$template = "baiviet/danhmucs";
		break;
		
	case "add_danhmuc":		
		$template = "baiviet/danhmuc_add";
		break;
		
	case "edit_danhmuc":		
		get_danhmuc();
		$template = "baiviet/danhmuc_add";
		break;
		
	case "save_danhmuc":
		save_danhmuc();
		break;
		
	case "savestt_danhmuc":
		savestt_danhmuc();
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
	global $d, $items, $paging;	
	
	
	//Check sản phẩm nỗi bật
	if($_REQUEST['noibat']!='')
	{
		$id_up = $_REQUEST['noibat'];
		$sql_sp = "SELECT id,noibat FROM table_baiviet where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$noibat=$cats[0]['noibat'];
		
		if($noibat==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet SET noibat =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}
		else
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet SET noibat =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}	
	}
	
	//Check hiển thị sản phẩm
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$sql_sp = "SELECT id,hienthi FROM table_baiviet where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$hienthi=$cats[0]['hienthi'];
		
		if($hienthi==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet SET hienthi =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}
		else
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet SET hienthi =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}	
	}
	#-------------------------------------------------------------------------------
	$sql = "select * from #_baiviet where id<>0 and type='".$_GET['type']."' ";	
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$sql.=" and id_danhmuc=".(int)$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
		$sql.=" and id_list=".(int)$_REQUEST['id_list']."";
	}
	if((int)$_REQUEST['id_cat']!='')
	{
		$sql.=" and id_cat=".(int)$_REQUEST['id_cat']."";
	}
	if((int)$_REQUEST['id_item']!='')
	{
		$sql.=" and id_item=".(int)$_REQUEST['id_item']."";
	}
	if($_REQUEST['key']!='')
	{
		$sql.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$sql.= " order by id_danhmuc,id_list,id_cat,id_item,stt asc,id desc";
	
	
	$d->query($sql);
	$items = $d->result_array();
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=baiviet&act=man&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_GET['id_list']."&id_cat=".$_GET['id_cat']."&id_item=".$_GET['id_item']."&type=".$_GET['type'];
	$maxR=20;
	$maxP=20;
	$paging=paging($items, $url, $curPage, $maxR, $maxP);
	$items=$paging['source'];
}

function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	
	$sql = "select * from #_baiviet where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	$item = $d->fetch_array();	
}

function save_item(){
	global $d;
	$file_name=$_FILES['file']['name'];
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
		
	if($id){
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;	
			$data['thumb'] = create_thumb($data['photo'], 220, 180, _upload_tintuc,$file_name,2);									
			$d->setTable('baiviet');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);	
				delete_file(_upload_tintuc.$row['thumb']);								
			}
		}

		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];		
		$data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];	
		$data['id_item'] = (int)$_POST['id_item'];
		$data['id_nhasanxuat'] = (int)$_POST['id_nhasanxuat'];	
			
		$data['ten_vi'] = $_POST['ten_vi'];	
		$data['ten_en'] = $_POST['ten_en'];	
		$data['tenkhongdau'] = changeTitle($_POST['ten_vi']);			;
		$data['mota_vi'] = $_POST['mota_vi'];
		$data['mota_en'] = $_POST['mota_en'];
		$data['noidung_vi'] = $_POST['noidung_vi'];
		$data['noidung_vi'] = $_POST['noidung_vi'];			
		$data['stt'] = $_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();

		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		
		$d->setTable('baiviet');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=baiviet&act=man&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']."&id_danhmuc=".$_REQUEST['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&id_cat=".$_REQUEST['id_cat']."&id_item=".$_REQUEST['id_item']."");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	}else{

		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name))
		{
			$data['photo'] = $photo;		
			$data['thumb'] = create_thumb($data['photo'], 220, 180, _upload_tintuc,$file_name,2);	
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];		
		$data['id_list'] = (int)$_POST['id_list'];	
		$data['id_cat'] = (int)$_POST['id_cat'];	
		$data['id_item'] = (int)$_POST['id_item'];
	
			
		$data['ten_vi'] = $_POST['ten_vi'];	
		$data['ten_en'] = $_POST['ten_en'];	
		$data['tenkhongdau'] = changeTitle($_POST['ten']);			
		$data['mota_en'] = $_POST['mota_en'];
		$data['mota_vi'] = $_POST['mota_vi'];
		$data['noidung_vi'] = $_POST['noidung_vi'];
		$data['noidung_en'] = $_POST['noidung_en'];			
		$data['stt'] = $_POST['stt'];
		
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$data['title'] = $_POST['title'];
		$data['type'] = $_GET['type'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		
		$d->setTable('baiviet');
		if($d->insert($data))
			redirect("index.php?com=baiviet&act=man&type=".$_GET['type']."");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	}
}

//===========================================================
function savestt_item(){
	global $d;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $duongdan);
	
	for($i=0; $i<20; $i++)
	{
		$id = $_POST['sttan'.$i];
		if($id!='')
		{
			$data['stt'] = $_POST['stt'.$i];
			$d->reset();
			$d->setTable('baiviet');
			$d->setWhere('id', $id);
			if(!$d->update($data)) transfer("Cập nhật dữ liệu bị lỗi", $duongdan);	
		}
	}
	redirect("index.php?com=baiviet&act=man&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&id_cat=".$_REQUEST['id_cat']."&curPage=".$_REQUEST['curPage']);
}

//===========================================================
function delete_item(){
	global $d;
	if($_REQUEST['id_danhmuc']!='')
	{ $id_catt="&id_danhmuc=".$_REQUEST['id_danhmuc'];
	}
	if($_REQUEST['id_list']!='')
	{ $id_catt="&id_list=".$_REQUEST['id_list'];
	}
	if($_REQUEST['id_cat']!='')
	{ $id_catt="&id_cat=".$_REQUEST['id_cat'];
	}
	if($_REQUEST['id_item']!='')
	{ $id_catt="&id_item=".$_REQUEST['id_item'];
	}
	if($_REQUEST['curPage']!='')
	{ $id_catt.="&curPage=".$_REQUEST['curPage'];
	}
		
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$sql = "delete from table_baiviet_lang where id_baiviet= ".$id."";
		$d->query($sql);
		
		$d->reset();
		$sql = "select id,thumb, photo from #_baiviet where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);			
			}
		$sql = "delete from #_baiviet where id='".$id."'";
		$d->query($sql);
		}
		if($d->query($sql))
			redirect("index.php?com=baiviet&act=man&type=".$_GET['type']."".$id_catt."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=baiviet&act=man&type=".$_GET['type']."");
	}elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
		//Xóa tất cả ngôn ngữ của danh mục đó
		$sql = "delete from table_baiviet_lang where id_baiviet= ".$id."";
		$d->query($sql);	
			
		$sql = "select id,thumb, photo from #_baiviet where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);
			}
			$sql = "delete from #_baiviet where id='".$id."'";
			$d->query($sql);
		}
			
		} redirect("index.php?com=baiviet&act=man&type=".$_GET['type']."");} else transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man&type=".$_GET['type']."");		
}

#====================================

function get_loais(){
	global $d, $items, $paging;
	
	$sql = "select * from #_baiviet_item id<>0 and type='".$_GET['type']."'";
	if((int)$_REQUEST['id_danhmuc']!='')
	{
	$sql.=" and id_danhmuc=".$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
	$sql.=" and id_list=".$_REQUEST['id_list']."";
	}
	if((int)$_REQUEST['id_cat']!='')
	{
	$sql.=" and id_cat=".$_REQUEST['id_cat']."";
	}
	$sql.=" order by stt";
	
	$d->query($sql);
	$items = $d->result_array();
	
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=baiviet&act=man_item&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_GET['id_list']."&id_cat=".$_GET['id_cat'];
	$maxR=20;
	$maxP=10;
	$paging=paging($items, $url, $curPage, $maxR, $maxP);
	$items=$paging['source'];
}

function get_loai(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	
	$sql = "select * from #_baiviet_item where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	$item = $d->fetch_array();
}

function save_loai(){
	global $d;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){	
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;		
			$d->setTable('baiviet_item');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);	
				//delete_file(_upload_tintuc.$row['thumb']);				
			}
		}
		$data['ten_vi'] = $_POST['ten_vi'];
		$data['ten_en'] = $_POST['ten_en'];
		$data['mota_vi'] = $_POST['mota_vi'];
		$data['mota_en'] = $_POST['mota_en'];
		$data['tenkhongdau'] = changeTitle($_POST['ten_vi']);
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];	
		$data['id_cat'] = $_POST['id_cat'];			
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('baiviet_item');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=baiviet&act=man_item&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']."");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	}else{		
		 if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;			
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = $_POST['id_list'];
		$data['id_cat'] = $_POST['id_cat'];
		$data['ten_vi'] = $_POST['ten_vi'];
		$data['ten_en'] = $_POST['ten_en'];
		$data['mota_vi'] = $_POST['mota_vi'];
		$data['mota_en'] = $_POST['mota_en'];
		$data['tenkhongdau'] = changeTitle($_POST['ten_vi']);
		$data['stt'] = $_POST['stt'];
		$data['type'] = $_GET['type'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('baiviet_item');
		if($d->insert($data))
			redirect("index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	}
}

function delete_loai(){
	global $d;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);		
		$d->reset();
		//Xóa tất cả ngôn ngữ của danh mục đó
		$sql = "delete from table_baivietitem_lang where id_item = ".$id."";
		$d->query($sql);	
		//Xóa danh mục cấp 4
			$sql = "delete from #_baiviet_item where id='".$id."'";
			$d->query($sql);
			//Xóa sản phẩm thuộc loại đó
			$sql = "select id,thumb,photo from #_baiviet where id_item='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet where id_item='".$id."'";
				$d->query($sql);
			}
			
		
		
		if($d->query($sql))
			redirect("index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			
				$sql = "delete from table_baivietitem_lang where id_item = ".$id."";
				$d->query($sql);			
			
				$sql = "delete from #_baiviet_item where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet where id_item='".$id."'";
				$d->query($sql);
				
				$sql = "delete from table_baivietitem_lang where id_item = ".$id."";
				$d->query($sql);
			
		} redirect("index.php?com=baiviet&act=man_item&type=".$_GET['type']."");} else transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_item&type=".$_GET['type']."");
}

##===================================================
function get_cats(){
	global $d, $items, $paging;
	
	##===================================================
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$sql_sp = "SELECT id,hienthi FROM table_baiviet_cat where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$hienthi=$cats[0]['hienthi'];
		if($hienthi==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_cat SET hienthi =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}
	else
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_cat SET hienthi =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}	
	}
	##===================================================
	if($_REQUEST['noibat']!='')
	{
		$id_up = $_REQUEST['noibat'];
		$sql_sp = "SELECT id,noibat FROM table_baiviet_cat where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$noibat=$cats[0]['noibat'];
		if($noibat==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_cat SET noibat =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}
	else
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_cat SET noibat =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}	
	}
	
	$sql = "select * from #_baiviet_cat where id<>0 and type='".$_GET['type']."'";	
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$sql.=" and id_danhmuc=".(int)$_REQUEST['id_danhmuc']."";
	}
	if((int)$_REQUEST['id_list']!='')
	{
		$sql.=" and id_list=".(int)$_REQUEST['id_list']."";
	}
	if($_REQUEST['key']!='')
	{
		$sql.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$sql.=" order by id_danhmuc,id_list,stt,id desc";
	
	$d->query($sql);
	$items = $d->result_array();
	
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_GET['id_list'];
	$maxR=20;
	$maxP=10;
	$paging=paging($items, $url, $curPage, $maxR, $maxP);
	$items=$paging['source'];
}

function get_cat(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
	
	$sql = "select * from #_baiviet_cat where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
	$item = $d->fetch_array();	
}

function save_cat(){
	global $d;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){	
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;						
			$d->setTable('baiviet_cat');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);				
			}
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();

		
		$d->setTable('baiviet_cat');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
	}else{				
		 if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;						
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['id_list'] = (int)$_POST['id_list'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();

		
		$d->setTable('baiviet_cat');
		if($d->insert($data))
			redirect("index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
	}
}

//===========================================================
function savestt_cat(){
	global $d;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $duongdan);
	
	for($i=0; $i<20; $i++)
	{
		$id = $_POST['sttan'.$i];
		if($id!='')
		{
			$data['stt'] = $_POST['stt'.$i];
			$d->reset();
			$d->setTable('baiviet_cat');
			$d->setWhere('id', $id);
			if(!$d->update($data)) transfer("Cập nhật dữ liệu bị lỗi", $duongdan);	
		}
	}
	redirect("index.php?com=baiviet&act=man_cat&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&id_list=".$_REQUEST['id_list']."&curPage=".$_REQUEST['curPage']);
}

//===========================================================
function delete_cat(){
	global $d;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);		
		$d->reset();
		//Xóa tất cả ngôn ngữ của danh mục đó
		$sql = "delete from table_baivietcat_lang where id_cat = ".$id."";
		$d->query($sql);	
		//Xóa danh mục cấp 3
		$d->reset();
			$sql = "select id,thumb,photo from #_baiviet_cat where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_baiviet_item where id_cat='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_item where id_cat='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_baiviet where id_cat='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet where id_cat='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=baiviet&act=man_cat&type=".$_GET['type']."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=baiviet&act=man_cat&type=".$_GET['type']."");

	

	}elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
				//Xóa tất cả ngôn ngữ của danh mục đó
				$sql = "delete from table_baivietcat_lang where id_cat = ".$id."";
				$d->query($sql);
							
				$sql = "delete from #_baiviet_cat where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet_item where id_cat='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet where id_cat='".$id."'";
				$d->query($sql);
			
		} redirect("index.php?com=baiviet&act=ma_catn&type=".$_GET['type']."");} else transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_cat&type=".$_GET['type'].""	    );
							
}

##====================================================
function get_lists(){
	global $d, $items, $paging;
	
	##====================================================
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$sql_sp = "SELECT id,hienthi FROM table_baiviet_list where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$hienthi=$cats[0]['hienthi'];
		if($hienthi==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_list SET hienthi =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}
		else
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_list SET hienthi =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}	
	}
	##====================================================
	if($_REQUEST['noibat']!='')
	{
		$id_up = $_REQUEST['noibat'];
		$sql_sp = "SELECT id,noibat FROM table_baiviet_list where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$noibat=$cats[0]['noibat'];
		if($noibat==0)
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_list SET noibat =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}
		else
		{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_list SET noibat =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
		}	
	}
	
	$sql = "select * from #_baiviet_list where id<>0 and type='".$_GET['type']."'";	
	if((int)$_REQUEST['id_danhmuc']!='')
	{
		$sql.=" and id_danhmuc=".$_REQUEST['id_danhmuc']."";
	}
	if($_REQUEST['key']!='')
	{
		$sql.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$sql.=" order by id_danhmuc,stt,id desc";
	
	$d->query($sql);
	$items = $d->result_array();
	
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc'];
	$maxR=20;
	$maxP=10;
	$paging=paging($items, $url, $curPage, $maxR, $maxP);
	$items=$paging['source'];
}

##====================================================
function get_detaillist_lang($id,$lang='vi'){
	
	global $d;
	if(!$id)
		return NULL;
	$sql = "select * from #_baivietlist_lang where id_list='$id' and lang = '$lang' ";
	$d->query($sql);
	if($d->num_rows()==0) return NULL;
	$item = $d->fetch_array();	
	return $item;

}

function get_list(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	
	$sql = "select * from #_baiviet_list where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	$item = $d->fetch_array();	
}
##====================================================
function save_list(){
	global $d,$config;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){		
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;			
			$d->setTable('baiviet_list');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);				
			}
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaysua'] = time();

		
		$d->setTable('baiviet_list');
		$d->setWhere('id', $id);
		if($d->update($data)){
			//Xử lý đa ngôn ngữ
			foreach ($config['lang'] as $key => $value) {							
				$d->reset();
				$data_lang['ten'] = $_POST['ten_'.$key];
				$data_lang['tenkhongdau'] = changeTitle($_POST['ten_'.$key]);
				$data_lang['mota'] = $_POST['mota_'.$key];
				$data_lang['title'] = $_POST['title_'.$key];
				$data_lang['keywords'] = $_POST['keyword_'.$key];
				$data_lang['description'] = $_POST['des_'.$key];							
				$data_lang['des_char'] = $_POST['des_char_'.$key];							
	
				
				$tmp = get_detail_lang($id,$key);
				if($tmp==NULL) {
					$data_lang['lang'] = $key;
					$data_lang['id_list'] = $id;			
					$d->setTable('baivietlist_lang');
					$d->insert($data_lang);						
				}else{
					$d->setTable('baivietlist_lang');
					$d->setWhere('lang', $key);
					$d->setWhere('id_list', $id);
					$d->update($data_lang);	
				}
			}						
			redirect("index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
		
		}else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	}else{		
		 if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;		
			
		}
		$data['id_danhmuc'] = (int)$_POST['id_danhmuc'];
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['type'] = $_POST['type'];
		
		$d->setTable('baiviet_list');
		if($d->insert($data))
		{
			$id = mysql_insert_id();

			//Xử lý đa ngôn ngữ			
			foreach ($config['lang'] as $key => $value) {
				$d->reset();
				$data_lang['lang'] = $key;
				$data_lang['id_list'] = $id;
				$data_lang['ten'] = $_POST['ten_'.$key];
				$data_lang['tenkhongdau'] = changeTitle($_POST['ten_'.$key]);
				$data_lang['mota'] = $_POST['mota_'.$key];
				$data_lang['title'] = $_POST['title_'.$key];
				$data_lang['keywords'] = $_POST['keyword_'.$key];
				$data_lang['description'] = $_POST['des_'.$key];							
				$data_lang['des_char'] = $_POST['des_char_'.$key];							
					
				$d->setTable('baivietlist_lang');
				$d->insert($data_lang);	
			}
			redirect("index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
		}else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	}
}

//===========================================================
function savestt_list(){
	global $d;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $duongdan);
	
	for($i=0; $i<20; $i++)
	{
		$id = $_POST['sttan'.$i];
		if($id!='')
		{
			$data['stt'] = $_POST['stt'.$i];
			$d->reset();
			$d->setTable('baiviet_list');
			$d->setWhere('id', $id);
			if(!$d->update($data)) transfer("Cập nhật dữ liệu bị lỗi", $duongdan);	
		}
	}
	redirect("index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
}
//===========================================================
function delete_list(){
	global $d;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);	
			$d->reset();
			//Xóa tất cả ngôn ngữ của danh mục đó
			$sql = "delete from table_baivietlist_lang where id_list = ".$id."";
			$d->query($sql);
					
			$d->reset();		
			//Xóa danh mục cấp 2			
			$sql = "select id,thumb,photo from #_baiviet_list where id='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_list where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 3
			$sql = "select id,thumb,photo from #_baiviet_cat where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_baiviet_item where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_item where id_list='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_baiviet where id_list='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet where id_list='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
				//Xóa tất cả ngôn ngữ của danh mục đó
				$sql = "delete from table_baivietlist_lang where id_list = ".$id."";
				$d->query($sql);
							
				$sql = "delete from #_baiviet_list where id='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet_cat where id_list='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet_item where id_list='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet where id_list='".$id."'";
				$d->query($sql);
			
		} redirect("index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);} else transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_list&type=".$_GET['type']."&id_danhmuc=".$_GET['id_danhmuc']."&curPage=".$_REQUEST['curPage']);
}


##==========================================================
function get_danhmucs(){
	global $d, $items, $paging;
		
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$sql_sp = "SELECT id,hienthi FROM table_baiviet_danhmuc where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$hienthi=$cats[0]['hienthi'];
	if($hienthi==0)
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_danhmuc SET hienthi =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}
	else
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_danhmuc SET hienthi =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}	
	}
	##==========================================================	
	if($_REQUEST['noibat']!='')
	{
		$id_up = $_REQUEST['noibat'];
		$sql_sp = "SELECT id,noibat FROM table_baiviet_danhmuc where id='".$id_up."' ";
		$d->query($sql_sp);
		$cats= $d->result_array();
		$noibat=$cats[0]['noibat'];
	if($noibat==0)
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_danhmuc SET noibat =1 WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}
	else
	{
		$sqlUPDATE_ORDER = "UPDATE table_baiviet_danhmuc SET noibat =0  WHERE  id = ".$id_up."";
		$resultUPDATE_ORDER = mysql_query($sqlUPDATE_ORDER) or die("Not query sqlUPDATE_ORDER");
	}	
	}
	
	$sql = "select * from #_baiviet_danhmuc where id<>0 and type='".$_GET['type']."'";
	if($_REQUEST['key']!='')
	{
		$sql.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$sql.=" order by stt,id desc";
	
	$d->query($sql);
	$items = $d->result_array();
	
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."";
	$maxR=20;
	$maxP=10;
	$paging=paging($items, $url, $curPage, $maxR, $maxP);
	$items=$paging['source'];
}
//===========================================================
function get_detail_lang($id,$lang='vi'){
	
	global $d;
	if(!$id)
		return NULL;
	$sql = "select * from #_baivietdanhmuc_lang where id_baiviet_danhmuc='$id' and lang = '$lang' ";
	$d->query($sql);
	if($d->num_rows()==0) return NULL;
	$item = $d->fetch_array();	
	return $item;

}
function get_danhmuc(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	
	$sql = "select * from #_baiviet_danhmuc where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	$item = $d->fetch_array();	
}
//===========================================================

function save_danhmuc(){
	
	global $d,$config;
	$file_name=$_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){		
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;	
			$d->setTable('baiviet_danhmuc');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);	
				//delete_file(_upload_tintuc.$row['thumb']);				
			}
		}
		
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();

		$d->setTable('baiviet_danhmuc');
		$d->setWhere('id', $id);
		if($d->update($data))
		{
			//Xử lý đa ngôn ngữ
			foreach ($config['lang'] as $key => $value) {							
				$d->reset();
				$data_lang['ten'] = $_POST['ten_'.$key];
				$data_lang['tenkhongdau'] = changeTitle($_POST['ten_'.$key]);
				$data_lang['mota'] = $_POST['mota_'.$key];
				$data_lang['title'] = $_POST['title_'.$key];
				$data_lang['keywords'] = $_POST['keyword_'.$key];
				$data_lang['description'] = $_POST['des_'.$key];							
				$data_lang['des_char'] = $_POST['des_char_'.$key];							
	
				
				$tmp = get_detail_lang($id,$key);
				if($tmp==NULL) {
					$data_lang['lang'] = $key;
					$data_lang['id_baiviet_danhmuc'] = $id;			
					$d->setTable('baivietdanhmuc_lang');
					$d->insert($data_lang);						
				}else{
					$d->setTable('baivietdanhmuc_lang');
					$d->setWhere('lang', $key);
					$d->setWhere('id_baiviet_danhmuc', $id);
					$d->update($data_lang);	
				}
			}						
			redirect("index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']."");
		}
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	}else{			
		  if($photo = upload_image("file", _format_duoihinh, _upload_tintuc,$file_name)){
			$data['photo'] = $photo;				
		}
		$data['stt'] = $_POST['stt'];
		$data['type'] = $_POST['type'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();

		$d->setTable('baiviet_danhmuc');
		if($d->insert($data)){
			$id = mysql_insert_id();

			//Xử lý đa ngôn ngữ			
			foreach ($config['lang'] as $key => $value) {
				$d->reset();
				$data_lang['lang'] = $key;
				$data_lang['id_baiviet_danhmuc'] = $id;
				$data_lang['ten'] = $_POST['ten_'.$key];
				$data_lang['tenkhongdau'] = changeTitle($_POST['ten_'.$key]);
				$data_lang['mota'] = $_POST['mota_'.$key];
				$data_lang['title'] = $_POST['title_'.$key];
				$data_lang['keywords'] = $_POST['keyword_'.$key];
				$data_lang['description'] = $_POST['des_'.$key];							
				$data_lang['des_char'] = $_POST['des_char_'.$key];							
					
				$d->setTable('baivietdanhmuc_lang');
				$d->insert($data_lang);						
		
			}
			redirect("index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	}
}

//===========================================================
function savestt_danhmuc(){
	global $d;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", $duongdan);	
	for($i=0; $i<20; $i++)
	{
		$id = $_POST['sttan'.$i];
		if($id!='')
		{
			$data['stt'] = $_POST['stt'.$i];
			$d->reset();
			$d->setTable('baiviet_danhmuc');
			$d->setWhere('id', $id);
			if(!$d->update($data)) transfer("Cập nhật dữ liệu bị lỗi", $duongdan);	
		}
	}
	redirect("index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
}

//===========================================================
function delete_danhmuc(){
	global $d;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);		
		//$d->reset();
//		//Xóa tất cả ngôn ngữ của danh mục đó
//		$sql = "delete from table_baivietdanhmuc_lang where id_baiviet_danhmuc = ".$id."";
//		$d->query($sql);	
		//Xóa danh mục cấp 1
		$d->reset();
		$sql = "delete from #_baiviet_danhmuc where id='".$id."'";
		$d->query($sql);



			//Xóa danh mục cấp 2			
			$sql = "select id,thumb,photo from #_baiviet_list where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_list where id_danhmuc='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 3
			$sql = "select id,thumb,photo from #_baiviet_cat where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_cat where id='".$id."'";
				$d->query($sql);
			}
			//Xóa danh mục cấp 4			
			$sql = "select id,thumb,photo from #_baiviet_item where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);	
				}
				$sql = "delete from #_baiviet_item where id_danhmuc='".$id."'";
				$d->query($sql);
			}
			//Xóa sản phẩm thuộc loại đó			
			$sql = "select id,thumb,photo from #_baiviet where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);
					
					$sql = "delete from table_baiviet_lang where id_baiviet = ".$id."";
					$d->query($sql);	
				}
				$sql = "delete from #_baiviet where id_danhmuc='".$id."'";
				$d->query($sql);
			}
		
		
		if($d->query($sql))
			redirect("index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			$sql = "select id,thumb,photo from #_baiviet where id_danhmuc='".$id."'";
			$d->query($sql);
			if($d->num_rows()>0)
			{
				while($row = $d->fetch_array())
				{
					delete_file(_upload_tintuc.$row['photo']);
					delete_file(_upload_tintuc.$row['thumb']);
					
					$sql = "delete from table_baiviet_lang where id_baiviet = ".$id."";
					$d->query($sql);	
				}
			}
				//Xóa tất cả ngôn ngữ của danh mục đó
				$sql = "delete from table_baivietdanhmuc_lang where id_baiviet_danhmuc = ".$id."";
				$d->query($sql);
					
				$sql = "delete from #_baiviet_danhmuc where id='".$id."'";
				$d->query($sql);
				
				
				$sql = "delete from #_baiviet_list where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet_cat where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet_item where id_danhmuc='".$id."'";
				$d->query($sql);
				
				$sql = "delete from #_baiviet where id_danhmuc='".$id."'";
				$d->query($sql);
			
		} redirect("index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);} else transfer("Không nhận được dữ liệu", "index.php?com=baiviet&act=man_danhmuc&type=".$_GET['type']."&curPage=".$_REQUEST['curPage']);
}
?>