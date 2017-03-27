
<?php	
	function get_main_danhmuc()
	{
		global $lang_default;
		$sql_huyen="select table_baiviet_danhmuc.id,table_baivietdanhmuc_lang.ten from table_baiviet_danhmuc,table_baivietdanhmuc_lang where table_baiviet_danhmuc.id=table_baivietdanhmuc_lang.id_baiviet_danhmuc and table_baivietdanhmuc_lang.lang='".$lang_default."' order by table_baivietdanhmuc_lang.id asc ";

		$result=mysql_query($sql_huyen);
		$str='
			<select id="id_danhmuc" name="id_danhmuc" class="main_select select_danhmuc">
			<option value="0">Chọn danh mục</option>
			';
		while ($row_huyen=@mysql_fetch_array($result)) 
		{
			if($row_huyen["id"]==(int)@$_REQUEST["id_danhmuc"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row_huyen["id"].' '.$selected.'>'.$row_huyen["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
?>


<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="index.php?com=baiviet&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>bài viết</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
	
</script>
<form name="supplier" id="validate" class="form" action="index.php?com=baiviet&act=save_list<?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">

     <div class="widget">
         <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
            <h6>Nhập dữ liệu</h6>
        </div>
       <ul class="tabs">
           
           <li>
               <a href="#info">Thông tin chung</a>
           </li>
           <?php foreach ($config['lang'] as $key => $value) { ?>
           <li>
               <a href="#content_lang_<?=$key?>"><?=$value?></a>
           </li>
           <?php } ?>


       </ul>

       <div id="info" class="tab_content">
          <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />

         <div class="formRow">
			<label>Chọn danh mục </label>
			<div class="formRight">
			<?=get_main_danhmuc()?>
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Tải hình ảnh:</label>
			<div class="formRight">
            	<input type="file" id="file" name="file" />
				<img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
				<div class="note"> Height:130px | Width:130px  <?=_format_duoihinh_l?> </div>
			</div>
			<div class="clear"></div>
		</div>
         <?php if($_GET['act']=='edit_list'){?>
		<div class="formRow">
			<label>Hình Hiện Tại :</label>
			<div class="formRight">
			
			<div class="mt10"><img src="<?=_upload_tintuc.$item['photo']?>"  width="100px" alt="NO PHOTO" width="100" /></div>

			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
 
           <div class="formRow">
          <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
          <div class="formRight">
         
            <input type="checkbox" name="hienthi" id="check1" value="1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
             <label>Số thứ tự: </label>
              <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="stt" style="width:20px; text-align:center;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" original-title="Số thứ tự của danh mục, chỉ nhập số">
          </div>
          <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="formRight">
                
                <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
                <a href="index.php?com=baiviet&act=man_list<?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
            </div>
            <div class="clear"></div>
        </div>

       </div>
       <!-- End info -->
        <?php foreach ($config['lang'] as $key => $value) {
            $item_lang = get_detaillist_lang($item['id'],$key);
        ?>

       <div id="content_lang_<?=$key?>" class="tab_content">        
            <div class="formRow">
            <label>Tên bài viết</label>
            <div class="formRight">
                <input type="text" name="ten_<?=$key?>" title="Nhập tên bài viết" id="ten_<?=$key?>" class="tipS" value="<?=@$item_lang['ten']?>" />
            </div>
            <div class="clear"></div>
        </div>  

        <div class="formRow">
            <label>Mô tả ngắn:</label>
            <div class="formRight">
                <textarea rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="mota_<?=$key?>" id="mota_<?=$key?>"><?=@$item_lang['mota']?></textarea>
            </div>
            <div class="clear"></div>
        </div>  
         <div class="formRow">
            <label>Title</label>
            <div class="formRight">
                <input type="text" value="<?=@$item_lang['title']?>" name="title_<?=$key?>" title="Nội dung thẻ meta Title dùng để SEO" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="formRow">
            <label>Từ khóa</label>
            <div class="formRight">
                <input type="text" value="<?=@$item_lang['keywords']?>" name="keyword_<?=$key?>" title="Từ khóa chính cho bài viết" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="formRow">
            <label>Description:</label>
            <div class="formRight">
                <textarea rows="8" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS description_input" name="des_<?=$key?>"><?=@$item_lang['description']?></textarea>
                <b>(Tốt nhất là 68 - 170 ký tự)</b>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
                <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
                 <a href="index.php?com=baiviet&act=man_list<?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
            </div>
            <div class="clear"></div>
        </div>

       </div><!-- End content <?=$key?> -->
      
     <?php } ?>
 

    </div>

</form>   






