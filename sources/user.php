<?php  if(!defined('_source')) die("Error");	

	$title_cat = "Thêm username";	
	$title = "Thêm username";	
	
	if(!empty($_POST)){
		if($_POST['capcha'] != $_SESSION['key'])
		{
			$loicapcha = 'Nhập mã bảo vệ sai !!!';
		}
		else
		{
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$sql = "INSERT INTO  table_user (username,password,role) VALUES ('$username','$password',3)";	
			if(mysql_query($sql)==true)
			{
				transfer("Thêm user thành công, cảm ơn !!!", "index.html");
			}
			else
			{
				transfer("Đã xảy ra lỗi !!!", "add-user.html");
			}
		}
	}
		
?>