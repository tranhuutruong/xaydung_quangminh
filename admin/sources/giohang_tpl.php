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
			if($q>0 && $q<=999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			else{
				$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
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
	
	function goBack()
	  {
	  window.history.back()
	  }
</script>
<div class="tieude_giua">Giỏ hàng</div>
<div class="box_containerlienhe"> 
	<div class="content">
    
			<form name="form1" method="post">
<input type="hidden" name="pid" />
<input type="hidden" name="command" /> 
				<table id="giohang" border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
    	<?
			if(is_array($_SESSION['cart'])){
            	echo '<tr bgcolor="#075992" height="25px" style="font-weight:bold;color:#FFF"><td align="center">STT</td><td>Tên</td><td align="center">Giá</td><td align="center">Số lượng</td><td align="center">Thành tiền</td><td align="center">Xóa</td></tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];					
					$pname=get_product_name($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF"><td width="10%" align="center"><?=$i+1?></td>
            		<td width="29%"><?=$pname?></td>
                    <td width="17%" align="center"><?=number_format(get_price($pid),0, ',', '.')?>&nbsp;VNĐ</td>
                    <td width="15%" align="center"><input type="text" name="product<?=$pid?>" value="<?=$q?>" maxlength="3" size="2" style="text-align:center; border:1px solid #F0F0F0" />&nbsp;</td>                    
                    <td width="18%" align="center"><?=number_format(get_price($pid)*$q,0, ',', '.') ?>&nbsp;VNĐ</td>
                    <td width="10%" align="center"><a href="javascript:del(<?=$pid?>)"><img src="images/delete.gif" border="0" /></a></td>
            		</tr>
            <?					
				}
			?>
				<tr><td colspan="6" style="background:#E6E6E6">
                <h3 style="color:#FF1F00; margin:5px 0px;">Tổng giá trị đơn  hàng: <?=number_format(get_order_total(),0, ',', '.')?>&nbsp;VNĐ</h3>
                </td></tr>
                <tr>
                	<td colspan="6" align="right">
                     <input class="btn button" type="button" value="Mua tiếp" onclick="window.location='http://<?=$config_url?>/san-pham.html'" style="float:left;" >
                <input class="btn button" type="button" value="Xóa tất cả" onclick="clear_cart()" style="float:right;" >
                <input class="btn button" type="button" value="Đặt hàng" onclick="update_cart()"  style="margin-right:80px;">
                <input class="btn button" type="button" value="Thanh toán" onclick="window.location='http://<?=$config_url?>/thanh-toan.html'" style="margin-right:80px;" >
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
         </div></div>
   <style>
   table#giohang input
   {
	   margin:5px 0px;}
   table#giohang input.btn
   {
	   
	  background:#075992;
	  color:#ffffff;
	  padding:3px 10px;
	  border:none;
	  margin:5px 3px;}
	
   </style>