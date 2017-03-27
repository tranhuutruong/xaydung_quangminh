<?php
	include ("ajax_config.php");
	
	$act = magic_quote(trim(strip_tags($_POST['act'])));
	
	switch($act){
		case "dathang":
			order();
			break;
		case "dangnhap":
			check_user();
			break;
		default:
			break;
	}

function order()
{
	global $d;
	$id = intval($_POST['id']);
	$size = magic_quote(trim(strip_tags($_POST['size'])));
	$mausac = magic_quote(trim(strip_tags($_POST['mausac'])));
	$soluong = intval($_POST['soluong']);
	
	//addtocart($id,$size,$mausac,$soluong);
	
	$return['thongbao'] = _sanphamduocthemvaogiohang;
	$return['ok'] = '';
	echo json_encode($return);
}
?>   
