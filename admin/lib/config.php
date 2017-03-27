<?php if(!defined('_lib')) die("Error");

	error_reporting(E_ALL & ~E_NOTICE & ~8192);
	$config_url=$_SERVER["SERVER_NAME"].':82/xaydung_quangminh';	
	
	$config['database']['servername'] = 'localhost';
	$config['database']['username'] = 'root';
	$config['database']['password'] = '';
	$config['database']['database'] = 'xaydung_quangminh';
	$config['database']['refix'] = 'table_';
	
	$ip_host = '127.0.0.1';
	$mail_host = 'contact@demo40.ninavietnam.org';
	$pass_mail = '1234qwer!@#$';

	$config['lang']=array(''=>'Tiếng Việt','en'=>'Tiếng Anh');#Danh sách ngôn ngữ hỗ trợ
	
	$config['author']['name'] = 'Châu Vủ Phương';
	$config['author']['email'] = 'phuongvunina@gmail.com';
	$config['author']['timefinish'] = '06/09/2013';
	
	date_default_timezone_set('Asia/Ho_Chi_Minh');

?>