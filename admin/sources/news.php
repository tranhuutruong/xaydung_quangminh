<?php	if(!defined('_source')) die("Error");

	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

	$urlcu = "";
	$urlcu .= (isset($_REQUEST['id_item'])) ? "&id_item=".addslashes($_REQUEST['id_item']) : "";
	$urlcu .= (isset($_REQUEST['type'])) ? "&type=".addslashes($_REQUEST['type']) : "";
	$urlcu .= (isset($_REQUEST['p'])) ? "&p=".addslashes($_REQUEST['p']) : "";

//===========================================================
switch($act){
	case "man":
		get_items();
		$template = "news/items";
		break;
	case "add":
		$template = "news/item_add";
		break;
	case "edit":		
		get_item();		
		$template = "news/item_add";
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
//===========================================================	
	case "man_cat":
		get_cats();
		$template = "news/cats";
		break;
	case "add_cat":
		$template = "news/cat_add";
		break;
	case "edit_cat":
		get_cat();
		$template = "news/cat_add";
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
				
	default:
		$template = "index";
}
//===========================================================
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;	
	}
//===========================================================
function get_items(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['type']!='')
	{
		$where.=" and type='".$_REQUEST['type']."'";
	}
	if($_REQUEST['id_item']!='')
	{
		$where.=" and id_item = '".$_REQUEST['id_item']."'";
	}
	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.=" order by stt,id desc";

	$sql="SELECT count(id) AS numrows FROM #_news where id<>0 $where";
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
	
	$sql = "select * from #_news where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=news&act=man".$urlcu;
}
//===========================================================
function get_item(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=news&act=man".$urlcu);
	
	$sql = "select * from #_news where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=news&act=man".$urlcu);
	$item = $d->fetch_array();
}
//===========================================================
function save_item(){
	global $d,$config,$urlcu;
	$file_name = $_FILES['file']['name'];
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=news&act=man".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);		
		if($photo = upload_image("file", _format_duoihinh ,_upload_tintuc,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], 170, 130, _upload_tintuc,$file_name,2);	
			$d->setTable('news');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);
			}
		}
		$data['id_item'] = (int)$_POST['id_item'];
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
		$d->setTable('news');
		$d->setWhere('id', $id);
		if($d->update($data))			
				redirect("index.php?com=news&act=man".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man".$urlcu);
	}else{
		
		if($photo = upload_image("file", _format_duoihinh ,_upload_tintuc,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = create_thumb($data['photo'], 170, 130, _upload_tintuc,$file_name,2);		
		}
		$data['id_item'] = (int)$_POST['id_item'];
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;
		$data['ngaytao'] = time();
		$data['title'] = $_POST['title'];
		$data['type'] = $_POST['type'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}
		
		$d->setTable('news');
		if($d->insert($data))
			redirect("index.php?com=news&act=man".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man".$urlcu);
	}
}
//===========================================================

function delete_item(){
	global $d,$urlcu;	
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);		
		$d->reset();
		$sql = "select * from #_news where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);
			}
			$sql = "delete from #_news where id='".$id."'";
			$d->query($sql);
		}
		
		if($d->query($sql))
			redirect("index.php?com=news&act=man&type=".$_GET['type']."");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man".$urlcu);
	}elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
		$sql = "select * from #_news where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			while($row = $d->fetch_array()){
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);
			}
			$sql = "delete from #_news where id='".$id."'";
			$d->query($sql);
		}
			
		} 
		redirect("index.php?com=news&act=man".$urlcu);
	}
}

//===========================================================
function get_cats(){
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
	
	
	$sql="SELECT count(id) AS numrows FROM #_news_item where id<>0 $where";
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
	
	$sql = "select * from #_news_item where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=news&act=man_cat".$urlcu;
}

//===========================================================
function get_cat(){
	global $d, $item,$urlcu;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
	transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat".$urlcu);
	
	$sql = "select * from #_news_item where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=news&act=man_cat".$urlcu);
	$item = $d->fetch_array();
}
//===========================================================
function save_cat(){
	global $d,$config,$urlcu;
	$file_name_item=$_FILES['file']['name'].fns_Rand_digit(0,9,4);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){		
		$id =  themdau($_POST['id']);		
		if($photo = upload_image("file", _format_duoihinh ,_upload_tintuc,$file_name)){
			$data['photo'] = $photo;	
			$d->setTable('news_item');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_tintuc.$row['photo']);
			}
		}
		$data['ten'] = $_POST['ten'];
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
		$d->setTable('news_item');
		$d->setWhere('id', $id);
		if($d->update($data))
			redirect("index.php?com=news&act=man_cat".$urlcu);
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_cat".$urlcu);
	}else{
		if($photo = upload_image("file", _format_duoihinh ,_upload_tintuc,$file_name)){
			$data['photo'] = $photo;
		}
		$data['tenkhongdau'] = changeTitle($_POST['ten']);
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['noibat'] = isset($_POST['noibat']) ? 1 : 0;			
		$data['ngaytao'] =time();	
		$data['title'] = $_POST['title'];
		$data['type'] = $_POST['type'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
			$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);			
		}		
		$d->setTable('news_item');
		if($d->insert($data))
			redirect("index.php?com=news&act=man_cat".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_cat".$urlcu);
	}
}

//===========================================================

function delete_cat(){
	global $d,$urlcu;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);		
		$d->reset();		
		//Xóa danh mục
		$sql = "delete from #_news_item where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0)
		{
			while($row = $d->fetch_array())
			{
				delete_file(_upload_tintuc.$row['photo']);
			}
			$sql = "delete from #_news_item where id='".$id."'";
			$d->query($sql);
		}
		
		//Xóa sản phẩm thuộc loại đó
		$sql = "select id,thumb,photo from #_news where id_item='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0)
		{
			while($row = $d->fetch_array())
			{
				delete_file(_upload_tintuc.$row['photo']);
				delete_file(_upload_tintuc.$row['thumb']);
			}
			$sql = "delete from #_news where id_item='".$id."'";
			$d->query($sql);
		}

		if($d->query($sql))
			redirect("index.php?com=news&act=man_cat".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_cat".$urlcu);
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();							
				
				$sql = "delete from #_news_item where id='".$id."'";
				$d->query($sql);
				if($d->num_rows()>0)
				{
					while($row = $d->fetch_array())
					{
						delete_file(_upload_tintuc.$row['photo']);
					}
					$sql = "delete from #_news_item where id='".$id."'";
					$d->query($sql);
				}
				
				$sql = "select id,thumb,photo from #_news where id_item='".$id."'";
				$d->query($sql);
				if($d->num_rows()>0)
				{
					while($row = $d->fetch_array())
					{
						delete_file(_upload_tintuc.$row['photo']);
						delete_file(_upload_tintuc.$row['thumb']);
					}
					$sql = "delete from #_news where id_item='".$id."'";
					$d->query($sql);
				}

		} 
		redirect("index.php?com=news&act=man_cat".$urlcu);
		}
		else transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat".$urlcu);
}
?>
