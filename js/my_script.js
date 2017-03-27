<!--Nut Back to top-->
$(document).ready(function() {
   setTimeout(function(){
	   $("#pre-loader").fadeOut(1000);
   },400);
	
   $('body').append('<div id="toptop" title="Lên đầu trang">Back to Top</div>');
   $(window).scroll(function() {
		if($(window).scrollTop() != 0) {
			$('#toptop').fadeIn();
		} else {
			$('#toptop').fadeOut();
		}
   });
   
   $('#toptop').click(function() {
		$('html, body').animate({scrollTop:0},500);
   });
   
   smoothScrolling();
   function smoothScrolling() { 
	  try {$.browserSelector();
		// Adds window smooth scroll on chrome.
		if ($("html").hasClass("chrome")) {
		  $.smoothScroll();
		}
	  }catch (err) {}	
	}
	
   $('#baophu, .close-popup').live('click',function(){
		$('#baophu, .login-popup').fadeOut(300, function(){
			$('#baophu').remove();
			$('.login-popup').remove();
		});			
	});
});
<!--Nut Back to top-->

<!--Kiểm tra liên hệ-->
function isEmpty(str,text){
		if(str != "") return false;
		if(typeof(text) != 'undefined')	alert(text);		
		return true;
}
function isPhone(str,text){
	if((str.length==11 && (str.substr(0,2)==01)) || (str.length==10 && (str.substr(0,2)==09)))
		return false;
	if(typeof(text)!='undefined') alert(text);
	return true;
}
function isEmail(str, text){
	emailRegExp = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.([a-z]){2,4})$/;
	if(emailRegExp.test(str)){		
		return false;
	}
	if(typeof(text)!='undefined') alert(text);	
	return true;
}
function isSpace(str,text){
	for(var i=0; i < str.length; i++)
	{
		if((str.charAt(i)) == " ")
		{
			if(typeof(text)!='undefined') alert(text);
			return true;
			
		}
	}
	return false;
}
function isCharacters(str,text){ 
	if(str=='') return false;
	var searchReg = /^[a-zA-Z0-9-]+$/;
	if(searchReg.test(str)) {
		return false;
	}
	if(typeof(text)!='undefined') alert(text);
	return true;
}
function isRepassword(str,str2,text){
	if(str2=='') return false;
	if(str==str2) return false;
	if(typeof(text)!='undefined') alert(text);
	return true;
}
function isCharacterlimit(str,text,intmin,intmax){
	if(str=='') return false;
	intmin = parseInt(intmin);
	intmax = parseInt(intmax);
	
	if(str.length>=intmin && str.length<=intmax)
	{
		return false;
	}
	if(typeof(text)!='undefined') alert(text);
	return true;
}
function add_popup(str){
	$('body').append('<div class="login-popup"><div class="close-popup"></div><div class="popup_thongbao"><p class="tieude_tb">Thông báo</p><p class="popup_kq">'+str+'</p></div></div>');
	$('.thongbao').html('');
	$('.login-popup').fadeIn(300);
	$('.login-popup').width($('.popup_thongbao').width()+'px')
	var chieurong = $('.login-popup').width() /2;
	$('.login-popup').css({width:$('.popup_thongbao').width()+'px','margin-left':-chieurong,top:-100+'px'});
	$('.login-popup').animate({top:100+'px'},500);
	$('body').append('<div id="baophu"></div>');
	$('#baophu').fadeIn(300);
	return false;
}
<!--Kiểm tra liên hệ-->	
jQuery(document).ready(function($) {
	$("#menu ul li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(300); 
		},function(){ 
		$(this).find('ul:first').css({visibility: "hidden"});
		}); 
	$("#menu ul li").hover(function(){
		$(this).find('>a').addClass('active2'); 
	},function(){ 
		$(this).find('>a').removeClass('active2'); 
	}); 

	/*slick*/
	$('.slick_11').slick({
	  centerMode: true,
	  slidesToShow: 11,
	  responsive: [
	    {
	      breakpoint: 768,
	      settings: {
	        arrows: false,
	        centerMode: true,
	        centerPadding: '40px',
	        slidesToShow: 3
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        arrows: false,
	        centerMode: true,
	        centerPadding: '40px',
	        slidesToShow: 1
	      }
	    }
	  ]
	});
});