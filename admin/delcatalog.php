<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <script src="../js/my.js"></script>
    </head>

    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend>删除分类</legend>
                <div class="layui-field-box">
<?php
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");
$conn->query("set names utf8");
?>
<?php

$rid = $_SESSION['customer']['rid'];
$query = "select * from catalog where rid = $rid";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {
    echo '<div style="width:40%; margin:0 auto; text-align:center"><h1>删除分类</h1></div>';
    echo '<form method="post"
        action="delcatdb.php" enctype="multipart/form-data">';
    $result = db_result_to_array($result);
    for ($i = 0; $i < count($result); $i++) {

        echo <<<caselayout
         <img src="$imgcat{$result[$i]['image']}"  alt=" "/>
         <p><a>{$result[$i]['catname']}</a></p>
         <p><input type="checkbox" name="cats[]" value="{$result[$i]['catalogID']}" />删除</p>
     

caselayout;

    }
    echo '</div>' . "<div style=\"text-align:center;\" >全选/全不选<input type=\"checkbox\" name=\"all\" onclick=\"check_all(this,'cats[]')\" /></div>
      <br />
     <input type=\"submit\" value=\"删除\" />
    </form>";


} 

?>


<?php

$conn->close();
?>