<script language="javascript" src="admin/media/scripts/my_script.js"></script>
<script language="javascript">
function js_submit(){
	if(isEmpty(document.getElementById('username'), "Nhập username")){
		document.getElementById('username').focus();
		return false;
	}
	
	if(isEmpty(document.getElementById('password'), "Nhập password")){
		document.getElementById('password').focus();
		return false;
	}
	if(isEmpty(document.getElementById('capcha'), "Nhập mã bảo vệ")){
		document.getElementById('capcha').focus();
		return false;
	}

	document.frm.submit();
}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#reset_capcha").click(function() {
			$("#hinh_captcha").attr("src", "sources/captcha.php?"+Math.random());
			return false;
		});    
		
	});
</script>

<div class="tieude_giua"><?=$title_cat?></div>
<div class="box_container">
   <div class="content">
         <?=$company_contact['noidung_lienhe'];?> 

        <div class="box_contact_r">
        	<form method="post" name="frm" action="add-user.html">
            	<span style="color:red; font-size:20px; font-weight:bold;"><?=$loicapcha;?></span>
  				<table width="100%" cellpadding="5" cellspacing="0" border="0">
                    <tr>
                        <td>Username:<span>*</span></td>
                        <td><input name="username" type="text" id="username" /></td>
                    </tr> 
                                           
                    <tr>
                        <td>Password<span>*</span></td>
                        <td><input name="password" id="password" type="text"  /></td>
                    </tr>
                   
                     <tr>
                        <td>Mã bảo vệ<span>*</span></td>
                        <td>
                        <input name="capcha" type="text" id="capcha" style="width:100px; float:left;"  />
                        <img src="sources/captcha.php" border="0" alt="CAPTCHA!" id="hinh_captcha">
                       	<a href="#reset_capcha" id="reset_capcha" title="Đổi mã khác"><img src="images/refresh.png" alt="reset_capcha" /></a></td>
                    </tr>
                    <tr>
                         <td>&nbsp;</td>
                         <td> 
                        <input class="button" type="button" value="Gửi" onclick="js_submit();" />
                        <input class="button" type="button" value="Nhập lại" onclick="document.frm.reset();" /></td>
                    </tr>
                  </table>   
               </form>
            </div>          
   </div>
</div>