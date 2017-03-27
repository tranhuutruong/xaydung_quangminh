<?php  if(!defined('_source')) die("Error");	
	
	if(count($_SESSION['cart'])>0)
	{
	
	$d->reset();
	$sql_thanhpho = "select id,ten from #_thanhpho_item where hienthi=1 order by stt,id desc";
	$d->query($sql_thanhpho);
	$thanhpho = $d->result_array();	
	
	$d->reset();
	$sql_thongtin_user = "select * from #_user where id='".$_SESSION['login']['id']."'";
	$d->query($sql_thongtin_user);
	$thongtin_user = $d->fetch_array();

	if(!empty($_POST)){	

		$hoten=$_POST['hoten'];
		$dienthoai=$_POST['dienthoai'];
		$diachi=$_POST['diachi'];
		$email=$_POST['email'];
		$noidung=$_POST['noidung'];
		$httt=$_POST['httt'];
		$thanhpho=$_POST['thanhpho'];
		$quan=$_POST['quan'];
		$ip = 0;
		$id_user = $_SESSION['login']['id'];
		
		//validate dữ liệu
		$hoten = trim(strip_tags($hoten));
		$dienthoai = trim(strip_tags($dienthoai));	
		$diachi = trim(strip_tags($diachi));	
		$email = trim(strip_tags($email));	
		$noidung = trim(strip_tags($noidung));	

		$hoten = mysql_real_escape_string($hoten);
		$dienthoai = mysql_real_escape_string($dienthoai);
		$diachi = mysql_real_escape_string($diachi);
		$email = mysql_real_escape_string($email);
		$noidung = mysql_real_escape_string($noidung);	
		$tonggia = get_order_total();					

		$ngaydangky = date('d/m/Y', time());
		$ngaycapnhat = time();
		$nguongoc = '0';
		
		
		
		$coloi=false;		
		if ($hoten == NULL) { 
			$coloi=true; $error_hoten = "Nhập họ tên<br>";
		} 
		if ($dienthoai == NULL) { 
			$coloi=true; $error_dienthoai = "Nhập số điện thoại<br>";
		}
		if ($thanhpho == NULL) { 
			$coloi=true; $error_thanhpho = "Chọn tỉnh thành phố<br>";
		}
		if ($quan == NULL) { 
			$coloi=true; $error_quan = "Chọn quận huyện<br>";
		}
		if ($diachi == NULL) { 
			$coloi=true; $error_diachi = "Nhập địa chỉ<br>";
		}			
		
		if ($coloi==FALSE) 
		{
		$d->reset();
		$sql5="select id,madonhang from #_donhang where dienthoai='".$dienthoai."' and hoten='".$hoten."' and ngaytao='".$ngaydangky."' limit 0,1";
		$d->query($sql5);
		$donhangtontai=$d->result_array();
		
		if(count($donhangtontai)==1)
		{
			
			
			$mahoadon = $donhangtontai[0]['madonhang'];
			
			$sql_lanxem = "UPDATE #_product SET luotxem=luotxem+1  WHERE id ='".$id."'";
			
			$sql = "UPDATE table_donhang SET diachi='$diachi',email='$email',noidung='$noidung',httt='$httt',thanhpho='$thanhpho',quan='$quan' where madonhang='$mahoadon'";				
		}
		else
		{
			$donhangmau = date('dmY').'GN';
	
			$d->reset();
			$sql_kiemtramax = "select id,madonhang from #_donhang where madonhang like '$donhangmau%' order by id desc limit 0,1";
			$d->query($sql_kiemtramax);
			$kiemtramax = $d->result_array();
			
			$d->reset();
			$sql_thanhpho = "select htgh from #_thanhpho where id='".$_POST['quan']."' limit 0,1";
			$d->query($sql_thanhpho);
			$lay_htgh = $d->fetch_array();
			
			$htgh = $lay_htgh['htgh'];
			
			if(count($kiemtramax)==0)
			{
				$songaunhien = 101;
			}
			else
			{
				(int)$songaunhien =  substr($kiemtramax[0]['madonhang'],10)+1;
			}
			$mahoadon = date('dmY').'GN'.$songaunhien;
			$sql = "INSERT INTO  table_donhang (madonhang,hoten,dienthoai,diachi,email,httt,tonggia,thanhpho,quan,noidung,ngaytao,tinhtrang,nguongoc,ngaycapnhat,htgh,ip,export,id_user) 
			  VALUES ('$mahoadon','$hoten','$dienthoai','$diachi','$email','$httt','$tonggia','$thanhpho','$quan','$noidung','$ngaydangky','1','$nguongoc','$ngaycapnhat','$htgh','$ip','1','$id_user')";	
			
		}		

		if(mysql_query($sql))#Nếu insert bảng đơn hàng thành công
		{
			
			if(is_array($_SESSION['cart']))
			{
				$max = count($_SESSION['cart']);
				$co = true;
				for($i=0;$i<$max;$i++){
					
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pmasp=get_code($pid);					
					$pname=get_product_name($pid);
					
					$pphoto=get_product_photo($pid);
					$pgia = get_price($pid);
					$ptonggia = get_price($pid)*$q;
					
					
					if($q==0) continue;
					
					$sql = "INSERT INTO  table_chitietdonhang (madonhang,masp,ten,size,gia,soluong,tonggia,ngaytao) 
						  VALUES ('$mahoadon','$pmasp','$pname','0','$pgia','$q','$ptonggia','$ngaydangky')";	
						  
						
					if(mysql_query($sql)==true)
					{
						$co = true;
					}	
					else
					{
						transfer("Đơn hàng của bạn chưa được gửi<br>Vui lòng điền đầy đủ thông tin lại<br>Cảm ơn", "thanh-toan.html");
					}
				}
				if($co == true)
				{
					$_SESSION['cart']=0;
					
					#Thông tin công ty
					$sql_company = "select * from #_company limit 0,1";
					$d->query($sql_company);
					$company= $d->fetch_array();	
					
					include_once "phpMailer/class.phpmailer.php";	
					$mail = new PHPMailer();
					$mail->IsSMTP(); 				// Gọi đến class xử lý SMTP
					$mail->Host       = $ip_host;   // tên SMTP server
					$mail->SMTPAuth   = true;       // Sử dụng đăng nhập vào account
					$mail->Username   = $mail_host; // SMTP account username
					$mail->Password   = $pass_mail;  
			
					//Thiết lập thông tin người gửi và email người gửi
					$mail->SetFrom($mail_host,$_POST['ten_lienhe']);
					
					$mail->AddAddress($email, $company['ten']);
					//Thiết lập email nhận email hồi đáp
					//nếu người nhận nhấn nút Reply
					$mail->AddReplyTo($email,'Đơn hàng từ '.$company['ten']);
					/*=====================================
					 * THIET LAP NOI DUNG EMAIL
					*=====================================*/
					//Thiết lập tiêu đề
					$mail->Subject    = "Đơn hàng từ ".$hoten;
					$mail->IsHTML(true);
					//Thiết lập định dạng font chữ
					$mail->CharSet = "utf-8";		
						$body = '<table>';
						$body .= '
							<tr>
								<th colspan="2">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2">Đơn hàng từ website <a href="'.$_SERVER["SERVER_NAME"].'">'.$_SERVER["SERVER_NAME"].'</a></th>
							</tr>
							<tr>
								<th colspan="2">&nbsp;</th>
							</tr>
							<tr>
								<th>Mã đơn hàng :</th><td>'.$mahoadon.'</td>
							</tr>
							<tr>
								<th>Họ tên :</th><td>'.$hoten.'</td>
							</tr>
							<tr>
								<th>Địa chỉ :</th><td>'.$diachi.'</td>
							</tr>
							<tr>
								<th>Email :</th><td>'.$email.'</td>
							</tr>
							<tr>
								<th>Điện thoại :</th><td>'.$dienthoai.'</td>
							</tr>
							<tr>
								<th>Số tiền :</th><td>'.number_format($ptonggia,0, ',', '.').' VNĐ'.'</td>
							</tr>
							<tr>
								<th>Nội dung :</th><td>'.$noidung.'</td>
							</tr>
							';
						$body .= '</table>';
						$body .= $body2;
		
						$mail->Body = $body;
						if($mail->Send())
						{
							transfer("Bạn đã đặt hàng thành công.<br> Chúng tôi sẽ liên hệ với bạn sớm nhất.<br>Mã đơn hàng là: ".$mahoadon, "index.html");
						}
						else
							transfer("Xin lỗi quý khách.<br>Hệ thống bị lỗi, xin quý khách thử lại.", "index.html");
						}
					
					

            }
			else{
				transfer("Đơn hàng của bạn chưa có sản phẩm<br>Vui lòng chọn sản phẩm để đặt hàng<br>Cảm ơn", "index.html");
			}
		}
		else
			transfer("Xin lỗi quý khách.<br>Hệ thống bị lỗi, xin quý khách thử lại.", "index.html");	
		}
	}
	}
	else
	{
		transfer("Bạn chưa mua sản phẩm nào.Vui lòng chọn mua sản phẩm.<br/>Cảm Ơn!!!.", "index.html");
	}

?>

