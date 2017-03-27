<div class="tieude_giua"><div><?=$title_cat?></div><span></span></div>
<div class="box_container">
   <div class="content">
   		<div class="tt_lh">
        <?=$company_contact['noidung'];?> 
		<div class="frm_lienhe">
        	<form method="post" name="frm" class="frm" action="ajax/contact.php" enctype="multipart/form-data">
            	<div class="loicapcha thongbao"></div>
            	<div class="item_lienhe"><p><?=_hovaten?>:<span>*</span></p><input name="ten_lienhe" type="text" id="ten_lienhe" /></div>
                
                <div class="item_lienhe"><p><?=_diachi?>:<span>*</span></p><input name="diachi_lienhe" type="text" id="diachi_lienhe" /></div>
                
                <div class="item_lienhe"><p><?=_dienthoai?>:<span>*</span></p><input name="dienthoai_lienhe" type="text" id="dienthoai_lienhe" /></div>
                
                <div class="item_lienhe"><p>Email:<span>*</span></p><input name="email_lienhe" type="text" id="email_lienhe" /></div>
                
                <div class="item_lienhe"><p><?=_chude?>:<span>*</span></p><input name="tieude_lienhe" type="text" id="tieude_lienhe" /></div>
                
                <div class="item_lienhe"><p><?=_noidung?>:<span>*</span></p><textarea name="noidung_lienhe" id="noidung_lienhe" rows="5"></textarea></div>
                
                <div class="item_lienhe"><p><?=_mabaove?>:<span>*</span></p>
                <img src="sources/captcha.php" id="hinh_captcha">
                       	<a href="#reset_capcha" id="reset_capcha" title="<?=_doimakhac?>"><img src="images/refresh.png" alt="reset_capcha" /></a></div>

                <div class="item_lienhe"><p>&nbsp;</p><input name="capcha" type="text" id="capcha" /></div>
                
                <div class="item_lienhe" >
                	<p>&nbsp;</p>
                	<input type="button" value="<?=_gui?>" class="click_ajax" />
                    <input type="button" value="<?=_nhaplai?>" onclick="document.frm.reset();" />
                </div>
            </form>
        </div><!--.frm_lienhe-->   
        </div>     
      
        <div class="bando">        
           <div id="map_canvas"></div> 
        </div><!--.bando-->          
   </div><!--.content--> 
</div><!--.box_container--> 