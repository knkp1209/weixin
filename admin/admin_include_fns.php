<?php 
ob_start();
	session_start();
	require_once('admin_fns.php');
	if(!check_admin_user()){
	  echo "你没有该权限";
	  exit;
	}
	require_once('../db_fns.php');
	$imgindex = '../data/swpimg/';
	$imgcat = '../data/catimg/';
	$imggoods= '../data/goodsimg/';
	$imglogo= '../data/logo/';
	$imggoldsilde = '../images/gold/slide/';
	
	$imgnews = '../images/news/';
	$imgpeople = '../images/people/';
ob_end_flush();
?>