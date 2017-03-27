<?php	if(!defined('_source')) die("Error");

	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	$urlcu = "";
	$urlcu .= (isset($_REQUEST['p'])) ? "&p=".addslashes($_REQUEST['p']) : "";

switch($act){
	case "man":
		get_items();
		$template = "phanquyen/items";
		break;
	case "add":
		$template = "phanquyen/item_add";
		break;
	case "edit":
		get_item();
		$template = "phanquyen/item_add";
		break;
	case "save":
		save_item();
		break;
	case "delete":
		delete_item();
		break;
	default:
		$template = "index";
}

function get_items(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;

	if($_REQUEST['key']!='')
	{
		$where.=" and ten like '%".$_REQUEST['key']."%'";
	}
	$where.=" order by stt,id desc";	
	
	
	$sql="SELECT count(id) AS numrows FROM #_phanquyen where id<>0 $where";
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
	
	$sql = "select * from #_phanquyen where id<>0 $where limit $bg,$pageSize";		
	$d->query($sql);
	$items = $d->result_array();	
	$url_link="index.php?com=phanquyen&act=man".$urlcu;

}

function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=phanquyen&act=man".$urlcu);
	
	$sql = "select * from #_phanquyen where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=phanquyen&act=man".$urlcu);
	$item = $d->fetch_array();
}

function save_item(){
	global $d;
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=phanquyen&act=man".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		
		$data['ten'] = $_POST['ten'];
		$data['soluong'] = $_POST['soluong'];
		$data['mausac'] = $_POST['mausac'];
		if($_POST['id_danhmuc']!=''){
			$data['id_danhmuc'] = json_encode($_POST['id_danhmuc']);			
		} else {
			$data['id_danhmuc'] = '';
		}
		if($_POST['id_list']!=''){
			$data['id_list'] = json_encode($_POST['id_list']);
		} else {
			$data['id_list'] = '';
		}
		if($_POST['id_cat']!=''){ 
			$data['id_cat'] = json_encode($_POST['id_cat']);
		} else {
			$data['id_cat'] = '';
		}
		if($_POST['id_item']!=''){
			$data['id_item'] = json_encode($_POST['id_item']);
		} else {
			$data['id_item'] = '';
		}
		
		if($_POST['xem']!=''){
		$data['xem'] = json_encode($_POST['xem']);
		} else {
			$data['xem'] = '';
		}
		if($_POST['xoa']!=''){
		$data['xoa'] = json_encode($_POST['xoa']);
		} else {
			$data['xoa'] = '';
		}
		if($_POST['sua']!=''){
		$data['sua'] = json_encode($_POST['sua']);
		} else {
			$data['sua'] = '';
		}
		if($_POST['them']!=''){
		$data['them'] = json_encode($_POST['them']);
		} else {
			$data['them'] = '';
		}
		
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaysua'] = time();
		
		$d->setTable('phanquyen');
		$d->setWhere('id', $id);
		if($d->update($data))
			transfer("Dữ liệu đã được cập nhật", "index.php?com=phanquyen&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=phanquyen&act=man");
	}else{
		$data['ten'] = $_POST['ten'];
		$data['soluong'] = $_POST['soluong'];
		$data['mausac'] = $_POST['mausac'];
		if($_POST['id_danhmuc']!=''){
			$data['id_danhmuc'] = json_encode($_POST['id_danhmuc']);
		} else {
			$data['id_danhmuc'] = '';
		}
		if($_POST['id_list']!=''){
			$data['id_list'] = json_encode($_POST['id_list']);
		} else {
			$data['id_list'] = '';
		}
		if($_POST['id_cat']!=''){ 
			$data['id_cat'] = json_encode($_POST['id_cat']);
		} else {
			$data['id_cat'] = '';
		}
		if($_POST['id_item']!=''){
			$data['id_item'] = json_encode($_POST['id_item']);
		} else {
			$data['id_item'] = '';
		}
		
		if($_POST['xem']!=''){
		$data['xem'] = json_encode($_POST['xem']);
		} else {
			$data['xem'] = '';
		}
		if($_POST['xoa']!=''){
		$data['xoa'] = json_encode($_POST['xoa']);
		} else {
			$data['xoa'] = '';
		}
		if($_POST['sua']!=''){
		$data['sua'] = json_encode($_POST['sua']);
		} else {
			$data['sua'] = '';
		}
		if($_POST['them']!=''){
		$data['them'] = json_encode($_POST['them']);
		} else {
			$data['them'] = '';
		}
		
		$data['stt'] = $_POST['stt'];
		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
		$data['ngaytao'] = time();
		
		$d->setTable('phanquyen');
		if($d->insert($data))
			transfer("Dữ liệu đã được lưu", "index.php?com=phanquyen&act=man".$urlcu);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=phanquyen&act=man".$urlcu);
	}
}

function delete_item(){
	global $d;
	
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$sql = "delete from #_phanquyen where id='".$id."'";
		if($d->query($sql))
			transfer("Dữ liệu đã được xóa", "index.php?com=phanquyen&act=man".$urlcu);
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=phanquyen&act=man".$urlcu);
	}
	elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
		$sql = "select * from #_phanquyen where id='".$id."'";
		$d->query($sql);
		if($d->num_rows()>0){
			
			$sql = "delete from #_phanquyen where id='".$id."'";
			$d->query($sql);
		}
			
		} redirect("index.php?com=phanquyen&act=man");}
	else transfer("Không nhận được dữ liệu", "index.php?com=phanquyen&act=man".$urlcu);
}


?>