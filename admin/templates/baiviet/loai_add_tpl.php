<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
	$(document).ready(function() {
		$('.chonngonngu li a').click(function(event) {
			var lang = $(this).attr('href');
			$('.chonngonngu li a').removeClass('active');
			$(this).addClass('active');
			$('.lang_hidden').removeClass('active');
			$('.lang_'+lang).addClass('active');
			return false;
		});
	});
</script>

<script language="javascript">				
	function select_onchange()
	{				
		var b=document.getElementById("id_danhmuc");
		window.location ="index.php?com=product&act=<?php if($_REQUEST['act']=='edit_item') echo 'edit_item'; else echo 'add_item';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&id_danhmuc="+b.value;	
		return true;
	}
	function select_onchange1()
	{				
		var a=document.getElementById("id_danhmuc");
		var b=document.getElementById("id_list");
		window.location ="index.php?com=product&act=<?php if($_REQUEST['act']=='edit_item') echo 'edit_item'; else echo 'add_item';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&id_danhmuc="+a.value+"&id_list="+b.value;	
		return true;
	}
	
</script>

<?php	
	function get_main_cat()
	{
		$sql_huyen="select * from table_product_cat where id_list=".$_REQUEST['id_list']." order by stt,id desc ";
		$result=mysql_query($sql_huyen);
		$str='
			<select id="id_cat" name="id_cat" class="main_select select_danhmuc">
			<option value="0">Chọn danh mục</option>
			';
		while ($row_huyen=@mysql_fetch_array($result)) 
		{
			if($row_huyen["id"]==(int)@$_REQUEST["id_cat"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row_huyen["id"].' '.$selected.'>'.$row_huyen["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
	function get_main_list()
	{
		$sql_huyen="select * from table_product_list where id_danhmuc=".$_REQUEST['id_danhmuc']."  order by stt,id desc ";
		$result=mysql_query($sql_huyen);
		$str='
			<select id="id_list" name="id_list" onchange="select_onchange1()" class="main_select select_danhmuc" >
			<option value="0">Chọn danh mục</option>
			';
		while ($row_huyen=@mysql_fetch_array($result)) 
		{
			if($row_huyen["id"]==(int)@$_REQUEST["id_list"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row_huyen["id"].' '.$selected.'>'.$row_huyen["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
	
	function get_main_danhmuc()
	{
		$sql_huyen="select * from table_product_danhmuc order by stt,id desc ";
		$result=mysql_query($sql_huyen);
		$str='
			<select id="id_danhmuc" name="id_danhmuc" onchange="select_onchange()" class="main_select select_danhmuc" >
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

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=product&act=add_list"><span>Thêm Danh mục cấp 4</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=product&act=save_item<?php if($_REQUEST['id_item']!='') echo'&id_item='.$_REQUEST['id_item'];?><?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
	<div class="widget">
	<div class="formRow">
			<label>Chọn danh mục cấp 1 </label>
			<div class="formRight">
			<?=get_main_danhmuc()?>
			</div>
			<div class="clear"></div>
		</div>	
        <div class="formRow">
			<label>Chọn danh mục cấp 2</label>
			<div class="formRight">
			<?=get_main_list()?>
			</div>
			<div class="clear"></div>
		</div>	
        <div class="formRow">
			<label>Chọn danh mục cấp 3</label>
			<div class="formRight">
			<?=get_main_cat()?>
			</div>
			<div class="clear"></div>
		</div>	
		<div class="title chonngonngu">
		<ul>
			<li><a href="vi" class="active tipS validate[required]" title="Chọn tiếng việt "><img src="./images/vi.png" alt="" class="tiengviet" />Tiếng Việt</a></li>
			<li><a href="en" class="tipS validate[required]" title="Chọn tiếng anh "><img src="./images/en.png" alt="" class="tienganh" />Tiếng Anh</a></li>
		</ul>
		</div>	
	        <div class="formRow lang_hidden lang_vi active">
			<label>Tiêu đề</label>
			<div class="formRight">
                <input type="text" name="ten" title="Nhập tên danh mục" id="ten" class="tipS validate[required]" value="<?=@$item['ten']?>" />
			</div>
            <div class="clear"></div>
            <label>Mô tả </label>
            <div class="formRight">
                <textarea rows="4" cols="" title="Nhập mô tả . " class="tipS" name="noidung"><?=@$item['noidung']?></textarea>
			</div>
            <div class="ck_editor none">
             <textarea  id="noidung"  name="noidung1"><?=@$item['noidung']?></textarea>
            </div>
			<div class="clear"></div>
		</div>
		
		

		<div class="formRow lang_hidden lang_en">
			<label>Tiêu đề (Tiếng anh)</label>
			<div class="formRight">
                <input type="text" name="tenen" title="Nhập tên danh mục" id="tenen" class="tipS validate[required]" value="<?=@$item['tenen']?>" />
			</div>
            <div class="clear"></div>
            <label>Mô tả </label>
            <div class="formRight">
                <textarea rows="4" cols="" title="Nhập mô tả . " class="tipS" name="noidungen"><?=@$item['noidungen']?></textarea>
			</div>
            <div class="ck_editor none">
             <textarea  id="noidungen"  name="noidungen1"><?=@$item['noidungen']?></textarea>
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
			
			<div class="mt10"><img src="<?=_upload_product.$item['photo']?>" width="100px" alt="NO PHOTO"  /></div>
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
		
	</div>  
	<div class="widget">
		<div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
			<h6>Nội dung seo</h6>
		</div>
		
		<div class="formRow">
			<label>Title</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['title']?>" name="title" title="Nội dung thẻ meta Title dùng để SEO" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Từ khóa</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['keywords']?>" name="keywords" title="Từ khóa chính cho danh mục" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Description:</label>
			<div class="formRight">
				<textarea rows="4" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS" name="description"><?=@$item['description']?></textarea>
                <input readonly="readonly" type="text" style="width:25px; margin-top:10px; text-align:center;" name="des_char" value="<?=@$item['des_char']?>" /> ký tự <b>(Tốt nhất là 68 - 170 ký tự)</b>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<div class="formRight">
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" value="Hoàn tất" />
            	<a href="index.php?com=product&act=man_list<?php if($_REQUEST['id_item']!='') echo'&id_item='.$_REQUEST['id_item'];?><?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>        </div>


