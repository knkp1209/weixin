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
<!--            <blockquote class="layui-elem-quote">
                <p>本模板基于LayUI实现 ,支持所有LayUI组件.</p>
                LayUI文档地址：
                http://www.layui.com/doc
                <p>项目地址：
                    http://git.oschina.net/besteasyteam/beginner_admin
                </p>
                <p>建议反馈和问题收集地址:
                    http://fly.zhengjinfan.cn/
                </p>
                <p>交流群：248049395</p>
                <br/>
                <p style="color: #01AAED;">子窗体弹出对话框编辑表单的一些建议：如果是处理表单的，建议在子窗口弹出。把背景设置为无，如果只是提示信息，可以在父窗口弹出。</p>
            </blockquote> -->
            <fieldset class="layui-elem-field">
                <legend>删除公司</legend>
                <div class="layui-field-box">
<?php
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");
$conn->query("set names utf8");
?>
<?php
$query = "select * from cooperations";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {
    echo '<div style="width:40%; margin:0 auto; text-align:center"><h1>删除公司</h1></div>';
    echo '<form method="post"
        action="delcp.php" enctype="multipart/form-data">';
    echo '<div class="container-fluid cust" style="background: white">';
    $result = db_result_to_array($result);
    $i = true;
    for ($i = 0; $i < count($result); $i++) {
        echo '<div class="col-lg-6">';
        if ($i % 2 == 0)
            echo '<div class="left">';
        else
            echo '<div class="right">';
        echo <<<caselayout
         <img src="$imgcompanylogo{$result[$i]['logo']}"  alt=" "/>
         <div style="text-align: center">
         <p><a>{$result[$i]['company_name']}</a></p>
         <p><input type="checkbox" name="companys[]" value="{$result[$i]['cooperationId']}" />删除</p>
         </div>
     </div></div>

caselayout;

    }
    echo '</div></div>' . "<div style=\"text-align:center;\" >全选/全不选<input type=\"checkbox\" name=\"all\" onclick=\"check_all(this,'companys[]')\" /></div>
      <br />
      <div style=\"width:40%; margin:0 auto;\"><input type=\"submit\" value=\"删除\" /></div>
    </form>";


} 

?>


<?php

$conn->close();
?>