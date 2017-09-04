<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="css/main.css" />
        <script src="../js/my.js"></script>
    </head>
<style>
#addcp p {
    text-align:  left;
    padding-top: 2px;
    padding-bottom: 2px;
}
#addcp {
    width: 100%;
}
h1{
    font-size: 1.5em;
    font-weight: bold;
    padding-bottom: 5px;
}
span{
    color: red;
}
</style>
    <body>
        <div class="admin-main">
            <fieldset class="layui-elem-field">
                <legend>添加商品分类</legend>
                <div class="layui-field-box">

    <div style="width:40%; margin:0 auto; text-align:center"><h1>添加商品分类</h1>
    <span>图片必须是宽度：135px 高度：45px</span>
    <form method="post" action="addcatdb.php" enctype="multipart/form-data" onsubmit="return getElements()" id="addcp">
<div id="picInput">
<p>
<label>分类图标：</label><input type="file" class="forminline"  name="imagefile[]" />
</p>
<p>
<label>分类名称：</label><input class="forminline"  type="text" name="cat[]" />
</p>
</div>
<br /><br />
<input id="addBtn" type="button" onclick="addcat()" value="继续添加商品分类" />
<input type="submit" value="提交"  />
</div>
<br />
<br />
    </form>
                </div>
            </fieldset>
        </div>
    </body>

</html>