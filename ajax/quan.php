<?php
	error_reporting(E_ALL & ~E_NOTICE & ~8192);
	session_start();
	$session=session_id();
	@define ( '_template' , '../templates/');
	@define ( '_source' , '../sources/');
	@define ( '_lib' , '../admin/lib/');

	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."functions.php";	
	include_once _lib."class.database.php";
	include_once _lib."functions_giohang.php";
	include_once _lib."file_requick.php";	
	
	$id = $_REQUEST['id'];	
	
	$d->reset();
	$sql_quan="select id,ten from #_thanhpho where hienthi=1 and id_item='$id' order by stt,id desc";
	$d->query($sql_quan);
	$quan=$d->result_array();

?>  
	<option value="">Chọn Quận/Huyện</option>
<?php for($i = 0, $count_quan = count($quan); $i < $count_quan; $i++){ ?>
    <option value="<?=$quan[$i]['id']?>"><?=$quan[$i]['ten']?></option>
<?php } ?> 
