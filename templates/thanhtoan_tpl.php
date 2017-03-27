<script type="text/javascript">
function a(id)
	{	
		var loadajax = "ajax/quan.php?id="+id;
		setTimeout(function(){$('#quan').load(loadajax)},0);
	}
	
function validEmail(obj) {
	var s = obj.value;
	for (var i=0; i<s.length; i++)
		if (s.charAt(i)==" "){
			return false;
		}
	var elem, elem1;
	elem=s.split("@");
	if (elem.length!=2)	return false;
	if (elem[0].length==0 || elem[1].length==0)return false;
	if (elem[1].indexOf(".")==-1)	return false;
	elem1=elem[1].split(".");
	for (var i=0; i<elem1.length; i++)
		if (elem1[i].length==0)return false;
	return true;
}//Kiem tra dang email
function IsNumeric(sText)
{
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++) 
	{ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsNumber = false;
		}
	}
	return IsNumber;
}//Kiem tra dang so

function check()
		{	
			var frm = document.frm_order;
			if(frm.hoten.value=='') 
			{ 
				alert( "Bạn chưa điền họ tên." );
				frm.hoten.focus();
				return false;
			}
			if(frm.dienthoai.value=='') 
			{ 
				alert( "Bạn chưa điền số điện thoại." );
				frm.dienthoai.focus();
				return false;
			}
			
			sodienthoai = frm.dienthoai.value.length;
			
			if((sodienthoai==11 && (frm.dienthoai.value.substr(0,2)==01)) || (sodienthoai==10 && (frm.dienthoai.value.substr(0,2)==09))) 
			{
				
			}
			else
			{
				alert("Số điện thoại không đúng" );
					frm.dienthoai.focus();
					return false;
			}			
			
			if(frm.thanhpho.value=='') 
			{ 
				alert( "Bạn chưa chọn tỉnh/thành phố." );
				frm.thanhpho.focus();
				return false;
			}	
			
			if(frm.quan.value=='') 
			{ 
				alert( "Bạn chưa chọn quân/huyện." );
				frm.quan.focus();
				return false;
			}
					
			if(frm.diachi.value=='') 
			{ 
				alert( "Bạn chưa điền địa chỉ." );
				frm.diachi.focus();
				return false;
			}										
			frm.submit();	
		}
</script>

<div class="tieude_giua"><div>Thanh toán</div></div>
<div class="box_container"> 
	<div class="content">
           <table id="giohang" border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;color:#000000;" width="100%">
    	   <?php
			if(is_array($_SESSION['cart'])){
            	echo '<tr bgcolor="#FA276C " height="25px" style="font-weight:bold;color:#FFF"><td align="center">STT</td> <td align="center" class="gh_an">Mã sp</td> <td style="text-align:center;">Tên</td><td style="text-align:center;" class="gh_an">Hình ảnh</td><td align="center">Giá</td><td align="center" class="gh_an">Tổng giá</td><td align="center">Xóa</td></tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pmasp=get_code($pid);					
					$pname=get_product_name($pid);
					$pphoto=get_product_photo($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF" style="color:#000000;"><td width="6%" align="center"><?=$i+1?></td>
                    <td width="10%" class="gh_an"><?=$pmasp?></td>
            		<td width="20%"><?=$pname['ten']?></td>
                    <td width="15%" style="text-align:center;" class="gh_an"><img src="<?=_upload_sanpham_l.$pphoto?>" height="50px;" width="50px;" /></td>
                    <td width="17%" align="center"><?=number_format(get_price($pid),0, ',', '.')?>&nbsp;VNĐ</td>                   
                    <td width="18%" align="center" class="gh_an"><?=number_format(get_price($pid)*$q,0, ',', '.') ?>&nbsp;VNĐ</td>
                    <td width="10%" align="center"><a href="javascript:del(<?=$pid?>)"><img src="images/delete.gif" border="0" /></a></td>
            		</tr>
            <?					
				}
			?>
				<tr><td colspan="8" style="background:#FA276C; padding-left:15px;" >
                <h3 style="color:#ffffff; margin:5px 0px;">Tổng giá: <?=number_format(get_order_total(),0, ',', '.')?>&nbsp;vnđ</h3>
                </td></tr>
               
			<?
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>Không có sản phẩm nào trong giỏ hàng!</td>";
			}
		?>
        </table>
        
     <div class="frm_lienhe">
     <h3 style="margin-top:20px; margin-bottom:10px;">Thông tin khách hàng</h3>
    <form method="post" name="frm_order" id="frm_order" action="" enctype="multipart/form-data" onsubmit="return check();">
    
    <div class="item_lienhe"><p class="no">Hình thức thanh toán:<span>*</span></p>
    <select name="httt" id="httt">
        <option value="Nhận hàng giao tiền">Nhận hàng giao tiền</option>
        <option value="Qua thẻ ngân hàng">Qua thẻ ngân hàng</option>
    </select></div>
    
    	<div class="item_lienhe"><p>Họ và tên:<span>*</span></p><input name="hoten" type="text" id="hoten" value="<?php if($_POST['hoten']!='')echo $_POST['hoten'];else echo $thongtin_user['ten']?>" /></div>
        
        <div class="item_lienhe"><p class="no">Điện thoại:<span>*</span></p><input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="dienthoai" id="dienthoai" value="<?php if($_POST['dienthoai']!='')echo $_POST['dienthoai'];else echo $thongtin_user['dienthoai']?>" type="text"  /></div>
        
        <div class="item_lienhe"><p class="no">Tỉnh/Thành phố:<span>*</span></p>
            	<select name="thanhpho" id="thanhpho" onchange="a(this.value);" >
                	<option value="">Chọn Tỉnh/Thành phố</option>
                	<?php for($i = 0, $count_thanhpho = count($thanhpho); $i < $count_thanhpho; $i++){ ?>
                		<option value="<?=$thanhpho[$i]['id']?>"><?=$thanhpho[$i]['ten']?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="item_lienhe"><p class="no">Quận/Huyện:<span>*</span></p>
            	<select name="quan" id="quan" onchange="b(this.value);">
                    <option value="">Chọn Quận/Huyện</option>
                </select>
            </div>
            
        
        <div class="item_lienhe"><p>Địa chỉ:<span>*</span></p><input name="diachi" type="text" id="diachi" value="<?php if($_POST['diachi']!='')echo $_POST['diachi'];else echo $thongtin_user['diachi']?>" /></div>
        
        <div class="item_lienhe"><p>E-mail:</p><input name="email" type="text" id="email" value="<?php if($_POST['email']!='')echo $_POST['email'];else echo $thongtin_user['email']?>" /></div>
        
        <div class="item_lienhe"><p class="no">Ghi chú:</p><textarea name="noidung"  cols="50" rows="4" ><?=$_POST['noidung']?></textarea></div>

    
	<div class="clear"></div>
    <div style="text-align: right; padding-top:20px;">
      	
         <input title='Hoàn tất đặt hàng' type="submit" name="next" value="Hoàn tất đặt hàng" style="background:#DF0049;border:none;padding:5px 13px; color:#ffffff; margin-right:30px;cursor:pointer;"  />  
         
       
    </div>
      </form>
      </div>
      
     
   
            
         </div>  

</div>
