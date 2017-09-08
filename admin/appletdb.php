<?php
ob_start();
require_once('admin_include_fns.php');

$upload_path = $imglogo;
$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$parameter = null;

$upload_path = $imglogo;
$rid = $_SESSION['customer']['rid'];
// $img = true;

if (!empty($_FILES['logo']['tmp_name'])){
    $logo = uploadimage($_FILES['logo'], $upload_path);
}else{
    $logo = false;
}

if(@$_POST['appname'])
    $parameter = "appname='{$_POST['appname']}',";
if(@$_POST['appID'])
    $parameter .= "appID='{$_POST['appID']}',";
if(@$_POST['logo'])
    $parameter .= "logo='{$_POST['logo']}',";
if(@$_POST['introduce'])
    $parameter .= "introduce='{$_POST['introduce']}',";
if(@$_POST['phone'])
    $parameter .= "phone='{$_POST['phone']}',";
if($logo){
    $parameter .= "logo='$logo',";
}


$parameter = substr($parameter,0,-1);

$query = "UPDATE tenant SET $parameter WHERE rid = $rid";
$conn->query($query);
if ($conn->affected_rows == 1) {
    echo '小程序信息已成功更改';
    $url = 'applet.php';
    header('Refresh: 1; url=' . $url);
    exit;
} else{
    echo '小程序信息更改失败，请联系管理员';
    $url = 'applet.php';
    header('Refresh: 1; url=' . $url);
    exit;
}
?>