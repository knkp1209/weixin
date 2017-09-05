<?php 
	require_once('../db_fns.php');

	$id = 23;
	$conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT catname FROM catalog WHERE catalogID = $id";
    $result = $conn->query($query);
    $cat = $result->fetch_object();
    echo $cat->catname;
 ?>