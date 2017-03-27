<?php
if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
	else if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=intval($_REQUEST['product'.$pid]);
			if($q>0 && $q<=99999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 99999';
			}
		}
	}
?>
<script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
		document.form1.submit();
	}
	function quaylai()
	{
		history.go(-1);
	}

</script>

<div class="tieude_giua" style="margin-bottom:12px;">Giỏ hàng</div>
<div class="box_containerlienhe"> 
	<div class="content">
    
			<form name="form1" method="post">
<input type="hidden" name="pid" />
<input type="hidden" name="command" /> 
				<table id="giohang" border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;color:#000000;" width="100%">
    	   <?php
			if(is_array($_SESSION['cart'])){
            	echo '<tr bgcolor="#FA276C " height="25px" style="font-weight:bold;color:#FFF"><td align="center">STT</td> <td align="center" class="gh_an">Mã sp</td> <td style="text-align:center;">Tên</td><td style="text-align:center;" class="gh_an">Hình ảnh</td><td align="center">Giá</td><td align="center">Số lượng</td><td align="center" class="gh_an">Tổng giá</td><td align="center">Xóa</td></tr>';
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
                    <td width="15%" style="text-align:center;" class="gh_an"><img src="<?=_upload_sanpham_l.$pphoto?>" style="max-width:70px;" /></td>
                    <td width="17%" align="center"><?=number_format(get_price($pid),0, ',', '.')?>&nbsp;VNĐ</td>
                    <td width="15%" align="center"><input onblur="update_cart()" type="text" name="product<?=$pid?>" value="<?=$q?>" maxlength="5" size="2" style="text-align:center; border:1px solid #F0F0F0" />&nbsp;</td>                    
                    <td width="18%" align="center" class="gh_an"><?=number_format(get_price($pid)*$q,0, ',', '.') ?>&nbsp;VNĐ</td>
                    <td width="10%" align="center"><a href="javascript:del(<?=$pid?>)"><img src="images/delete.gif" border="0" /></a></td>
            		</tr>
            <?					
				}
			?>
				<tr><td colspan="8" style="background:#FA276C; padding-left:15px;" >
                <h3 style="color:#ffffff; margin:5px 0px;">Tổng giá: <?=number_format(get_order_total(),0, ',', '.')?>&nbsp;vnđ</h3>
                </td></tr>
                <tr>
                	<td colspan="8" align="right">
                <input class="btn button" type="button" value="Mua tiếp" onclick="quaylai();" />
                <input class="btn button" type="button" value="Xóa tất cả" onclick="clear_cart()" >
                <input class="btn button" type="button" value="Đặt hàng" onclick="window.location='http://<?=$config_url?>/thanh-toan.html'" >
                    </td>
                </tr>
			<?
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>Không có sản phẩm nào trong giỏ hàng!</td>";
			}
		?>
        </table>			
  </form>
         </div>
</div>