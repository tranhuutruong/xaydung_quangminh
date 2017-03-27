<?php
	session_start();
	$session=session_id();
	@define ( '_source' , '../sources/');
	if(!isset($_SESSION['lang']))
		$_SESSION['lang']='';
	$lang=$_SESSION['lang'];	
	require_once _source."lang$lang.php";	
?>
<HTML>
<HEAD>
<TITLE><?=_dangchuyentrang?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="REFRESH" content="4; url=<?=$page_transfer?>">
</HEAD>
<style>
	*{ margin:0; padding:0;}
	body{ background:#000; font-family:Arial, Helvetica, sans-serif; font-size:13px;}
	.transfer{width: 300px;background: #fff;text-align: center;border: 1px solid #D0CFCF;font-size: 13px; margin-top:100px; position:relative; cursor:pointer;}
	.chuyentrang{ position:absolute; top:0px; right:5px; background:url(images/i_chuyentrang.png) center no-repeat; width:24px; height:24px;}
	.transfer_tb{background: #E80019;padding: 7px;color: #fff;text-transform: uppercase;font-weight: bold;}
	.transfer_text{padding: 10px;  font-weight: bold;color: #4C4C4C;}
	.transfer_link{ color:#00F; display:block ; padding-bottom:10px;}
</style>
<BODY>
  <center>
  		<div class="transfer">
        	<a href="<?=$page_transfer?>" title="<?=_clickvaodayneukhongmuondoilau?>"><p class="chuyentrang"></p></a>
        	<p class="transfer_tb"><?=_thongbao?></p>
        	<p class="transfer_text"><?=$showtext?></p>
            <a href="<?=$page_transfer?>" class="transfer_link"><?=_clickvaodayneukhongmuondoilau?></a>
        </div>
  </center>
</BODY>
</HTML>