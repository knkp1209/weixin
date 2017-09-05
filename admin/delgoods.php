<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <script src="../js/my.js"></script>
    </head>
    <style type="text/css">
        #tb{
            text-align:center;
        }
        table{
            border-style: solid;
            border-color: #999999;
        }
        .tbtitle{
            background: #996699;
        }
        .odd{
            background: #339966;
        }
        .even{
            background: #CCCCCC;
        }
        .gdname .catname .simg .dimg .spr .pr .nb .del{
        }
        .gdname {
            width:7%;
        }
        .catname{
            width:7%;
        }
        .simg{
            width:35%            
        }
        .dimg{
            width:35%
        }
        .spr{
            width:4%;   
        }
        .pr{
            width:4%;
        }
        .nb{
            width:4%;
        }
        .del{
            width:4%;
        }

    </style>
    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend>删除商品</legend>
                <div class="layui-field-box">
<?php
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");
$conn->query("set names utf8");
?>
<?php

$rid = $_SESSION['customer']['rid'];
$query = "select * from goods where rid = $rid ORDER BY goodsID DESC";
$result = @$conn->query($query);
if (!$result) {
    exit;
}

$num = @$result->num_rows;
if ($num > 0) {

    echo '<form method="post"
        action="delcatdb.php" enctype="multipart/form-data">';
    echo "<div style=\"text-align:center;\" >全选/全不选<input type=\"checkbox\" name=\"all\" onclick=\"check_all(this,'cats[]')\" /></div>
      <br />
     <input type=\"submit\" value=\"删除\" />";
    $result = db_result_to_array($result);
    echo "<div id=\"tb\"><table width=\"100%\" ><tr class=\"tbtitle\">
        <td class=\"gdname\">商品名称</td>
        <td class=\"catname\">商品分类</td>
        <td class=\"simg\">展示图片</td>
        <td class=\"dimg\">详情图片</td>
        <td class=\"spr\">原价</td>
        <td class=\"pr\">现价</td>
        <td class=\"nb\">库存</td>
        <td class=\"del\">删除</td>
    </tr>";
    for ($i = 0; $i < count($result); $i++) {
        $result[$i]['catalogID'] = idcvrname($result[$i]['catalogID']);
        $result[$i]['gdswpimg'] = idcvrimg($result[$i]['gdswpimg']);
        if($i % 2 == 1)
            echo '<tr class="odd">';
        else
            echo '<tr class="even">';
        echo <<<php_table
        <td class="gdname">{$result[$i]['gdname']}</td>
        <td class="catname">{$result[$i]['catalogID']}</td>
        <td class="simg">展示图片</td>
        <td class="dimg">详情图片</td>
        <td class="spr">{$result[$i]['sprice']}</td>
        <td class="pr">{$result[$i]['price']}</td>
        <td class="nb">{$result[$i]['gdnumber']}</td>
        <td class="del"><input type="checkbox" name="cats[]" value="{$result[$i]['catalogID']}" /></td>
        </tr>

php_table;
    }

    echo "</table></div></form>";


} 

?>


<?php

$conn->close();
?>