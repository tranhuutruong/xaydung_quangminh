<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
      <li><a href="index.php?com=meta&act=capnhat"><span>Cập nhật meta cho website</span></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<form name="frm" class="form" action="index.php?com=meta&act=save" method="post" enctype="multipart/form-data">
 <div class="widget">
		<div class="formRow">
			<label>Title</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['title']?>" name="title" title="Nhập title" class="tipS" />
			</div>
			<div class="clear"></div>
		</div> 	
        <div class="formRow">
			<label>Keywords</label>
			<div class="formRight">
                <textarea rows="4" cols="" title="Nhập keywords,các từ hay cụm từ liên quan . " class="tipS" name="keywords"><?=@$item['keywords']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Description</label>
			<div class="formRight">
                <textarea rows="4" cols="" title="Nhập description,độ dài từ 60-170 ký tự (Quan trọng). " class="tipS" name="description"><?=@$item['description']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
       <div class="formRow">
			<div class="formRight">
                <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB"  value="Hoàn tất" />
                <a href="index.php?com=meta&act=capnhat" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
               
			</div>
			<div class="clear"></div>
		</div>        
 </div>
</form>



