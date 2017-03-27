<!-- my-js -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- slick -->
<script type="text/javascript" src="js/slick.min.js"></script>
<script type="text/javascript" src="js/my_script.js"></script>
<script src="js/plugins-scroll.js" type="text/javascript" ></script>





<!-- Cloud Zoom -->
<script type="text/javascript" src="js/cloudzoom.js"></script>

<!-- Slider Jssor -->
<script type="text/javascript" src="js/jssor.js"></script>
<script type="text/javascript" src="js/jssor.slider.js"></script>
<script type="text/javascript" src="js/js_jssor_slider.js"></script>

<!-- mmenu -->
<script type="text/javascript" src="js/jquery.mmenu.min.all.js"></script>

<!--Tim kiem-->
<script language="javascript"> 
    function doEnter(evt){
	var key;
	if(evt.keyCode == 13 || evt.which == 13){
		onSearch(evt);
	}
	}
	function onSearch(evt) {			
	
			var keyword = document.getElementById("keyword").value;
			if(keyword=='' || keyword=='<?=_nhaptukhoatimkiem?>...')
			{
				alert('<?=_chuanhaptukhoa?>');
			}
			else{
				location.href = "tim-kiem.html&keyword="+keyword;
				loadPage(document.location);			
			}
		}		
</script>   


<!--danhmuc-->
<script type='text/javascript' src='js/jquery.cookie.js'></script>
<script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='js/jquery.dcjqaccordion.2.7.min.js'></script>
<script type="text/javascript">
	$(document).ready(function($){
		$('#accordion-1').dcAccordion({
			eventType: 'hover',//Sự kiện click hoặc hover
			autoClose: true,//Tự động đóng lại khi chuyển trang
			saveState: true,
			disableLink: false,
			speed:'slow',
			showCount: false,
			autoExpand: true,
			cookie	: 'dcjq-accordion-1',
			classExpand	 : 'dcjq-current-parent'
		});	
	});
</script>


<!--Thêm alt cho hình ảnh-->
<script type="text/javascript">
	$(document).ready(function(e) {
        $('img').each(function(index, element) {
			if(!$(this).attr('alt') || $(this).attr('alt')=='')
			{
				$(this).attr('alt','<?=$company['ten']?>');
			}
        });
    });
</script>


<!--lazyload-->
<script type="text/javascript" src="js/jquery.lazyload.pack.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $(".item img").lazyload({
        //placeholder : "images/load.gif",
        effect : "fadeIn",
      }); 
  });
</script>

<!-- slick -->
<script type="text/javascript">
    $(document).ready(function(){
		$('.slick2').slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: false,
			  asNavFor: '.slick'
			 
		});
		$('.slick').slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  asNavFor: '.slick2',
			  dots: false,
			  centerMode: false,
			  focusOnSelect: true
		});
		 return false;


    });
</script>
<!-- slick -->

<!-- Cloud Zoom -->
<script type = "text/javascript">
    CloudZoom.quickStart();
</script>


<script src="js/jquery.swipebox.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $('.swipebox').swipebox({
            beforeOpen: function() {}, // called before opening
            afterOpen: function() {}, // called after opening
            afterClose: function() {}, // called after closing
            loopAtEnd: false // true will return to the first image after the last image is reached
        });
  });
</script>

<!-- mmenu mobi -->
<!--Tim kiem-->
<script language="javascript"> 
    function doEnter2(evt){
	var key;
	if(evt.keyCode == 13 || evt.which == 13){
		onSearch(evt);
	}
	}
	function onSearch2(evt) {			
	
			var keyword2 = document.getElementById("keyword2").value;
			if(keyword2=='' || keyword2=='Nhập từ khóa tìm kiếm...')
			{
				alert('Bạn chưa nhập từ khóa tìm kiếm!');
			}
			else{
				location.href = "tim-kiem.html&keyword="+keyword2;
				loadPage(document.location);			
			}
		}		
</script>   
<!--Tim kiem-->



<script type="text/javascript">
	$(function() {
		$('.hien_menu').click(function(){
			$('nav#menu_mobi').css({height: "auto"});
		});
		$('nav#menu_mobi').mmenu({
			extensions	: [ 'effect-slide-menu', 'pageshadow' ],
			searchfield	: true,
			counters	: true,
			navbar 		: {
				title		: 'Menu'
			},
			navbars		: [
				{
					position	: 'top',
					content		: [ 'searchfield' ]
				}, {
					position	: 'top',
					content		: [
						'prev',
						'title',
						'close'
					]
				}, {
					position	: 'bottom',
					content		: [
						'<a>Online : <?php $count=count_online();echo $tong_xem=$count['dangxem'];?></a>',
						'<a>Tổng : <?php $count=count_online();echo $tong_xem=$count['daxem'];?></a>'
					]
				}
			]
		});
	});
</script>


<!-- Begin Jquery tabs-->
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$('#content_tabs .tab').hide();
		$('#content_tabs .tab:first').show();
		$('#ultabs li:first').addClass('active');
		
		$('#ultabs li').click(function(){
			var vitri = $(this).data('vitri');
			$('#ultabs li').removeClass('active');
			$(this).addClass('active');
			
			$('#content_tabs .tab').hide();
			$('#content_tabs .tab:eq("'+vitri+'")').show();
			return false;
		});	
	});
</script>
<!--End Jquery tabs-->


<!-- ajax -->
<script type="text/javascript">
	$(document).ready(function(e) {
		$('.size').click(function(){
			$('.size').removeClass('active_size');
			$(this).addClass('active_size');
		});
		$('.mausac').click(function(){
			$('.mausac').removeClass('active_mausac');
			$(this).addClass('active_mausac');
		});
		$('a.dathang').click(function(){
			if($('.active_size').length)
			{
				if($('.mausac').length && $('.active_mausac').length==false)
				{
					alert('Vui lòng chọn màu sắc');
					return false;
				}
				if($('.active_mausac').length)
				{
					var mausac = $('.active_mausac').html();
				}
				else
				{
					var mausac = '';
				}
					var act = "dathang";
					var id = "<?=$row_detail['id']?>";
					var size = $('.active_size').html();
					var mausac = $('.active_mausac').html();
					var soluong = $('.soluong').val();
					if(soluong>0)
					{
						$.ajax({
							type:'post',
							url:'ajax/cart.php',
							dataType:'json',
							data:{id:id,size:size,mausac:mausac,soluong:soluong,act:act},
							beforeSend: function() {
								$('.thongbao').html('<p><img src="images/loader_p.gif"></p>');  
							},
							error: function(){
								add_popup('<?=_hethongloi?>');
							},
							success:function(kq){
								add_popup(kq.thongbao);
								console.log(kq);
							}
						});
					}
					else
					{
						alert('Vui lòng nhập lại số lượng');
					}
			}
			else
			{
				alert('Vui lòng chọn size');
			}
			return false;
		});
	});
</script>


<!-- contact -->
<script type="text/javascript">
	$(document).ready(function(e) {
		$('.click_ajax').click(function(){
			if(isEmpty($('#ten_lienhe').val(), "<?=_nhaphoten?>"))
			{
				$('#ten_lienhe').focus();
				return false;
			}
			if(isEmpty($('#diachi_lienhe').val(), "<?=_nhapdiachi?>"))
			{
				$('#diachi_lienhe').focus();
				return false;
			}
			if(isEmpty($('#dienthoai_lienhe').val(), "<?=_nhapsodienthoai?>"))
			{
				$('#dienthoai_lienhe').focus();
				return false;
			}
			if(isPhone($('#dienthoai_lienhe').val(), "<?=_nhapsodienthoai?>"))
			{
				$('#dienthoai_lienhe').focus();
				return false;
			}
			if(isEmpty($('#email_lienhe').val(), "<?=_emailkhonghople?>"))
			{
				$('#email_lienhe').focus();
				return false;
			}
			if(isEmail($('#email_lienhe').val(), "<?=_emailkhonghople?>"))
			{
				$('#email_lienhe').focus();
				return false;
			}
			if(isEmpty($('#tieude_lienhe').val(), "<?=_nhapchude?>"))
			{
				$('#tieude_lienhe').focus();
				return false;
			}
			if(isEmpty($('#noidung_lienhe').val(), "<?=_nhapnoidung?>"))
			{
				$('#noidung_lienhe').focus();
				return false;
			}
			if(isEmpty($('#capcha').val(), "<?=_nhapmabaove?>"))
			{
				$('#capcha').focus();
				return false;
			}
			$.ajax({
				type:'post',
				url:$(".frm").attr('action'),
				data:$(".frm").serialize(),
				dataType:'json',
				beforeSend: function() {
					$('.thongbao').html('<p><img src="images/loader_p.gif"></p>');     
				},
				error: function(){
					$('.thongbao').html("<?=_guilienhethatbai?>");
				},
				success:function(kq){
					add_popup(kq.thongbao);
					if(kq.nhaplai=='1')
					{
						$(".frm")[0].reset();
					}
					$('#capcha').val('');
					console.log(kq);
				}
			});
		});    
    });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#reset_capcha").click(function() {
			$("#hinh_captcha").attr("src", "sources/captcha.php?"+Math.random());
			return false;
		});
	});
</script>

<!-- gMap -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		   <script type="text/javascript">
		   var map;
		   var infowindow;
		   var marker= new Array();
		   var old_id= 0;
		   var infoWindowArray= new Array();
		   var infowindow_array= new Array();function initialize(){
			   var defaultLatLng = new google.maps.LatLng(<?=$company['toado']?>);
			   var myOptions= {
				   zoom: 16,
				   center: defaultLatLng,
				   scrollwheel : false,
				   mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);map.setCenter(defaultLatLng);
			    
			   var arrLatLng = new google.maps.LatLng(<?=$company['toado']?>);
			   infoWindowArray[7895] = '<div class="map_description"><div class="map_title"><?=$company['ten']?></div><div><?=_diachi?> : <?=$company['diachi']?><?='<br />'?><?=_dienthoai?>: <?=$company['dienthoai']?></div></div>';
			   loadMarker(arrLatLng, infoWindowArray[7895], 7895);
			   
			   moveToMaker(7895);}function loadMarker(myLocation, myInfoWindow, id){marker[id] = new google.maps.Marker({position: myLocation, map: map, visible:true});
			   var popup = myInfoWindow;infowindow_array[id] = new google.maps.InfoWindow({ content: popup});google.maps.event.addListener(marker[id], 'mouseover', function() {if (id == old_id) return;if (old_id > 0) infowindow_array[old_id].close();infowindow_array[id].open(map, marker[id]);old_id = id;});google.maps.event.addListener(infowindow_array[id], 'closeclick', function() {old_id = 0;});}function moveToMaker(id){var location = marker[id].position;map.setCenter(location);if (old_id > 0) infowindow_array[old_id].close();infowindow_array[id].open(map, marker[id]);old_id = id;}</script>

<!--Code gữ thanh menu trên cùng
<script type="text/javascript">
	$(document).ready(function(){
		$(window).scroll(function(){
			var cach_top = $(window).scrollTop();
			var heaigt_header = $('#header').height();

			if(cach_top >= heaigt_header){
				$('#menu').css({position: 'fixed', top: '0px', zIndex:99});
			}else{
				$('#menu').css({position: 'relative'});
			}
		});
	});
 </script>
<!--Code gữ thanh menu trên cùng-->

<!--lockfixed
<script type="text/javascript" src="js/jquery.lockfixed.min.js"></script>
<script type="text/javascript">
	$(window).load(function(e) {
		(function($) {
				var left_h=$('#left').height();
				var main_h=$('#main').height();
				if(main_h>left_h) 
				{
					$.lockfixed("#scroll-left",{offset: {top: 10, bottom: 400}});
				}
		})(jQuery);
	});
</script>
<!--lockfixed-->



<!--animate hiệu ứng
<link href="css/animate.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript">
 	new WOW().init();
</script>
<!--animate hiệu ứng-->


<!--Cấm click chuột phải
<script type="text/javascript">
	var message="Đây là bản quyền thuộc về Phòng khám sản phụ khoa PHƯỚC NGUYÊN";
	function clickIE() {
	if (document.all) {(message);return false;}
	}
	function clickNS(e) {
	if (document.layers||(document.getElementById&&!document.all)) {
		if (e.which==2||e.which==3) {alert(message);return false;}}}
		if (document.layers) {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;document.onselectstart=clickIE}document.oncontextmenu=new Function("return false")
</script>
<script type="text/javascript">
	function disableselect(e){
		return false 
	}
	function reEnable(){ 
		return true 
	} 
	//if IE4+
	document.onselectstart=new Function ("return false")
	//if NS6
	if (window.sidebar){
		document.onmousedown=disableselect 
		document.onclick=reEnable
	} 
</script>
<!--Cấm click chuột phải-->



<!--Chạy đến vị trí mới
<script type="text/javascript" src ="js/jquery.scrollTo.js"></script>
<script  type="text/javascript">
	$(window).load(function() {
		//$('html, body').animate({scrollTop:500},500);
		$('body').scrollTo('#wapper',1000);
	}); 
</script>
Chạy đến vị trí mới-->	
