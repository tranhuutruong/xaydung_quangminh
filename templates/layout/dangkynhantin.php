<script type="text/javascript" language="javascript">
	$(document).ready(function(e) {
		$('#email_nhantin').click(function(){
			if($(this).val()=='Nhập email của bạn...')
			{
				$(this).val('');
			}
			return false;
		});
		$('#email_nhantin').blur(function(){
			if($(this).val()=='')
			{
				$(this).val('Nhập email của bạn...');
			}
			return false;
		});
	});
	function nhantin(){
		if(isEmpty($('#email_nhantin').val(), "<?=_nhapemail?>"))
			{
				$('#email_nhantin').focus();
				return false;
			}
			if(isEmail($('#email_nhantin').val(), "<?=_emailkhonghople?>"))
			{
				$('#email_nhantin').focus();
				return false;
			}	
		document.frm_dknt.submit();
	}
</script>

<?php
	if(isset($_POST['email_nhantin']))
	{		
		$email_nhantin = $_POST['email_nhantin'];		
		$d->reset();
		$sql_kt_mail="SELECT email FROM table_newsletter WHERE email='".$email_nhantin."'";
		$d->query($sql_kt_mail);
		$kt_mail=$d->result_array();
		if(count($kt_mail)>0)
			alert('Email của bạn đã đăng ký trước đó !!!');
		else
		{
			$email_nhantin = trim(strip_tags($email_nhantin));
			$email_nhantin = mysql_real_escape_string($email_nhantin);			
			$sql = "INSERT INTO  table_newsletter (email) VALUES ('$email_nhantin')";	
			if($d->query($sql)== true)
				alert('Gửi email đăng ký nhận tin thành công !!!');
			else
				alert('Gửi email đăng ký nhận tin thất bại,đã xảy ra lỗi,vui lòng đăng ký lại sau !!!');
		}		
	}
?>

<form name="frm_dknt" id="frm_dknt" method="post" action="" >
    <input type="text" name="email_nhantin" id="email_nhantin" value="Nhập email của bạn..." />
    <input type="button" name="submit_nhantin" id="submit_nhantin" onclick="nhantin()" value="Gửi" />
</form>


