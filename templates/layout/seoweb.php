<link rel="canonical" href="http://<?=$config_url?>/" />
<link rel=”amphtml”  href="http://<?=$config_url?>/"  />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="SHORTCUT ICON" href="<?=_upload_hinhanh_l.$company['faviconthumb']?>" type="image/x-icon" />
<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW" />
<meta name="author" content="<?=$company['ten']?>" />
<meta name="copyright" content="<?=$company['ten']?> [<?=$company['email']?>]" />
<!--Meta Geo-->
<meta name="DC.title" content="<?php if($title!='')echo $title;else echo $seo['title'];?>" />
<meta name="geo.region" content="VN" />
<meta name="geo.placename" content="<?=$company['diachi']?>" />
<meta name="geo.position" content="<?=str_replace(',',':',$company['toado'])?>" />
<meta name="ICBM" content="<?=$company['toado']?>" />
<meta name="DC.identifier" content="http://<?=$config_url?>/" />
<!--Meta Geo-->
<!--Meta Ngôn ngữ-->
<meta name="language" content="Việt Nam">
<meta http-equiv="content-language" content="vi" />
<meta content="VN" name="geo.region" />
<meta name="DC.language" scheme="utf-8" content="vi" />
<meta property="og:locale" content="vi_VN" />
<!--Meta Ngôn ngữ-->
<!--Meta seo web-->
<title><?php if($title!='')echo $title;else echo $seo['title'];?></title>
<meta name="keywords" content="<?php if($keywords!='')echo $keywords;else echo $seo['keywords'];?>" />
<meta name="description" content="<?php if($description!='')echo $description;else echo $seo['description'];?>" />
<!--Meta seo web-->
<!--Meta facebook-->
<meta property="og:image" content="<?=$images_facebook?>" />
<meta property="og:title" content="<?=$title_facebook?>" />
<meta property="og:url" content="<?=$url_facebook?>" />
<meta property="og:site_name" content="http://<?=$config_url?>/" />
<meta property="og:description" content="<?=$description_facebook?>" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?=$company['ten']?>" /> 
<!--Meta facebook-->
<!-- Twitter Card: -->
<meta name="twitter:card" content="sumary" />
<meta name="twitter:site" content="<?php echo $config_url ?>" />
<meta name="twitter:creator" content="<?php echo $company['ten'] ?>" />
<meta name="twitter:title" content="<?=$title_facebook?>" />
<meta property="twitter:description" content="<?=$description_facebook?>" />
<meta property="twitter:image" content="<?=$images_facebook?>" />
<!-- /Twitter Card -->

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51d3c996345f1d03" async="async"></script>
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-550a87e8683b580f" async="async"></script>-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php if($lang=='en')echo 'en_EN';else echo 'vi_VN' ?>/sdk.js#xfbml=1&version=v2.4&appId=1530017217324091";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--Meta facebook-->