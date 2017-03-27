<script type="text/javascript">		

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
		var a=document.getElementById("id_danhmuc");
		window.location ="index.php?com=product&act=<?php if($_REQUEST['act']=='edit') echo 'edit'; else echo 'add';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&id_danhmuc="+a.value;	
		return true;
	}
	function select_onchange1()
	{				
		var a=document.getElementById("id_danhmuc");
		var b=document.getElementById("id_list");
		window.location ="index.php?com=product&act=<?php if($_REQUEST['act']=='edit') echo 'edit'; else echo 'add';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&id_danhmuc="+a.value+"&id_list="+b.value;	
		return true;
	}
	function select_onchange2()
	{				
		var a=document.getElementById("id_danhmuc");
		var b=document.getElementById("id_list");
		var c=document.getElementById("id_cat");
		window.location ="index.php?com=product&act=<?php if($_REQUEST['act']=='edit') echo 'edit'; else echo 'add';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&id_danhmuc="+a.value+"&id_list="+b.value+"&id_cat="+c.value;	
		return true;
	}	
	
	function stt(x)
		{
			var a=$(x).val();
			
			$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(x).attr("data-val0"),
						bang: $(x).attr("data-val2"),
						type: $(x).attr("data-val3"),
						value:a
					}
				});
				$('.vui').show();
		}
</script>
<?php
function get_main_danhmuc()
	{
		$sql="select * from table_product_danhmuc order by stt";
		$stmt=mysql_query($sql);
		$str='
			<select id="id_danhmuc" name="id_danhmuc" onchange="select_onchange()" class="main_select select_danhmuc">
			<option>Chọn danh mục</option>			
			';
		while ($row=@mysql_fetch_array($stmt)) 
		{
			if($row["id"]==(int)@$_REQUEST["id_danhmuc"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}

function get_main_list()
	{
		$sql="select * from table_product_list where id_danhmuc=".$_REQUEST['id_danhmuc']."  order by stt";
		$stmt=mysql_query($sql);
		$str='
			<select id="id_list" name="id_list" onchange="select_onchange1()" class="main_select select_danhmuc">
			<option>Chọn danh mục</option>			
			';
		while ($row=@mysql_fetch_array($stmt)) 
		{
			if($row["id"]==(int)@$_REQUEST["id_list"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
	
function get_main_category()
	{
		$sql="select * from table_product_cat where id_list=".$_REQUEST['id_list']." order by stt";
		$stmt=mysql_query($sql);
		$str='
			<select id="id_cat" name="id_cat" onchange="select_onchange2()" class="main_select select_danhmuc">
			<option>Chọn danh mục</option>			
			';
		while ($row=@mysql_fetch_array($stmt)) 
		{
			if($row["id"]==(int)@$_REQUEST["id_cat"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
	
	
function get_main_item()
	{
		$sql_huyen="select * from table_product_item where id_cat=".$_REQUEST['id_cat']." order by id desc ";
		$result=mysql_query($sql_huyen);
		$str='
			<select id="id_item" name="id_item" class="main_select select_danhmuc">
			<option>Chọn danh mục</option>			
			';
		while ($row_huyen=@mysql_fetch_array($result)) 
		{
			if($row_huyen["id"]==(int)@$_REQUEST["id_item"])
				$selected="selected";
			else 
				$selected="";
			$str.='<option value='.$row_huyen["id"].' '.$selected.'>'.$row_huyen["ten"].'</option>';			
		}
		$str.='</select>';
		return $str;
	}
	$d->reset();
	$sql_images="select * from #_hinhanh where id_hinhanh='".$item['id']."' and type='sanpham' order by stt, id desc ";
	$d->query($sql_images);
	$ds_photo=$d->result_array();
?>
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="index.php?com=product&act=add"><span>Thêm sản phẩm</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>


<form name="frm" method="post" action="index.php?com=product&act=save<?php if($_REQUEST['id_danhmuc']!='') echo'&id_danhmuc='.$_REQUEST['id_danhmuc'];?><?php if($_REQUEST['id_list']!='') echo'&id_list='.$_REQUEST['id_list'];?><?php if($_REQUEST['id_cat']!='') echo'&id_cat='.$_REQUEST['id_cat'];?><?php if($_REQUEST['id_item']!='') echo'&id_item='.$_REQUEST['id_item'];?><?php if($_REQUEST['curPage']!='') echo'&curPage='.$_REQUEST['curPage'];?>" enctype="multipart/form-data" class="form">	
	<div class="widget">
		<div class="formRow">
			<label>Chọn danh mục 1</label>
			<div class="formRight">
			<?=get_main_danhmuc()?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Chọn danh mục 2</label>
			<div class="formRight">
			<?=get_main_list()?>
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow none">
			<label>Chọn danh mục 3</label>
			<div class="formRight">
			<?=get_main_category()?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow none">
			<label>Chọn danh mục 4</label>
			<div class="formRight">
			<?=get_main_item()?>
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
        <?php if($_GET['act']=='edit'){?>
		<div class="formRow">
			<label>Hình Hiện Tại :</label>
			<div class="formRight">
			
			<div class="mt10"><img src="<?=_upload_sanpham.$item['thumb']?>"  alt="NO PHOTO" width="100" /></div>

			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
        
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
		</div>
		
		

		<div class="formRow lang_hidden lang_en">
			<label>Tiêu đề (Tiếng anh)</label>
			<div class="formRight">
                <input type="text" name="tenen" title="Nhập tên danh mục" id="ten" class="tipS validate[required]" value="<?=@$item['ten']?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Mã SP</label>
			<div class="formRight">
                <input type="text" name="masp" title="Nhập mã sản phẩm" id="masp" value="<?=@$item['masp']?>" />
			</div>
			<div class="clear"></div>
		</div>

		

<div class="formRow">
			<label>Giá bán</label>
			<div class="formRight">
                <input type="text" name="gia" title="Nhập giá bán" id="gia" class="tipS validate[required]" value="<?=@$item['gia']?>" />
			</div>
			<div class="clear"></div>
		</div>

		 <div class="formRow">
			<label>Giá khuyến mãi</label>
			<div class="formRight">
                <input type="text" name="giacu" title="Nhập giá cũ" id="giacu" class="tipS validate[required]" value="<?=@$item['giacu']?>" />
			</div>
			<div class="clear"></div>
		</div> 

		
		<div class="formRow lang_hidden lang_vi active">
			<label>Mô tả</label>
			<div class="formRight">
                <textarea rows="4" cols="" title="Nhập mô tả . " class="tipS" name="mota"><?=@$item['mota']?></textarea>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow lang_hidden lang_en">
			<label>Mô tả (Tiếng anh)</label>
			<div class="formRight">
                <textarea rows="4" cols="" title="Nhập mô tả . " class="tipS" name="motaen"><?=@$item['motaen']?></textarea>
			</div>
			<div class="clear"></div>
		</div>


		<div class="formRow lang_hidden lang_vi active">
			<label>Nội Dung</label>
			<div class="ck_editor">
                <textarea id="noidung" name="noidung"><?=@$item['noidung']?></textarea>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow lang_hidden lang_en">
			<label>Nội Dung (Tiếng anh)</label>
			<div class="ck_editor">
                <textarea id="noidungen" name="noidungen"><?=@$item['noidungen']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
<div class="formRow">
      <label>Hình ảnh kèm theo: </label>
      <div class="formRight">
          <a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif"><img src="images/image_add.png" alt="" width="100"></a>                
         
     
    <?php if($act=='edit'){?>   
            <?php for($i=0;$i<count($ds_photo);$i++){?>
              <div class="item_trich" id="<?=md5($ds_photo[$i]['id'])?>">
                  <img class="img_trich" width="140px" height="110px" src="<?=_upload_hinhthem.$ds_photo[$i]['photo']?>" />
                  <input data-val0="<?=$ds_photo[$i]['id']?>" data-val2="table_hinhanh" data-val3="stt" onblur="stt(this);" type="text" rel="<?=$ds_photo[$i]['id']?>" value="<?=$ds_photo[$i]['stt']?>" class="update_stt tipS" />
                  <a class="delete_images" data-id="<?=$ds_photo[$i]['id']?>"><img src="images/delete.png"></a>
              </div>
            <?php } ?>

    <?php }?>
      </div>
          <div class="clear"></div>
        </div>

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
            	<a href="index.php?com=product&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</form>        </div>
<script type="text/javascript">
		$('.delete_images').click(function(){
			var id=$(this).data("id");
			$.ajax({
				type: "POST",
				url: "ajax/xuly_admin_dn.php",
				data: {id:id, act: 'remove_image'},
				success:function(data){
					$jdata = $.parseJSON(data);					
					$("#"+$jdata.md5).fadeOut(500);
					setTimeout(function(){
						$("#"+$jdata.md5).remove();
					}, 1000)
				}
			})
		})
	
</script>
<script>
  $(document).ready(function() {
    $('.file_input').filer({
            showThumbs: true,
            templates: {
                box: '<ul class="jFiler-item-list"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\<input type="text" name="stthinh[]" class="stthinh" placeholder="Nhập STT" />\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\<input type="text" name="stthinh[]" class="stthinh" placeholder="Nhập STT" />\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-item-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action',
                }
            },
            addMore: true
        });
  });
</script>






