<?php 
ob_start();
	session_start();
	require_once('admin_fns.php');
	if(!check_admin_user()){
	  $indexurl =  $_SERVER['HTTP_HOST']."/index.php";
	  header('Location: http://'.$indexurl);
	  exit;
	}
	require_once('../db_fns.php');
	$imgcase = '../images/case/';
	$imgcompanylogo = '../images/companylogo/';
	$imggold = '../images/gold/';
	$imggoldsilde = '../images/gold/slide/';
	$imgindex = '../data/swpimg/';
	$imgnews = '../images/news/';
	$imgpeople = '../images/people/';
ob_end_flush();
?>