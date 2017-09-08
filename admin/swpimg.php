<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="css/main.css" />
		<script src="js/my.js"></script>
		<link rel="stylesheet" href="css/my.css" />
	</head>

	<body>
		<div class="admin-main">
<!-- 			<blockquote class="layui-elem-quote">
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
				<legend>修改更新</legend>
				<div class="layui-field-box">
				<?php
require_once('admin_include_fns.php');
$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$rid = $_SESSION['customer']['rid'];
$query = "SELECT image FROM swpimg WHERE rid = $rid";
$result = @$conn->query($query);
if (!$result) {
    exit;
}
$num_cats = @$result->num_rows;
if ($num_cats > 0) {


    $result = db_result_to_array($result);
    echo '<p style="text-align:center; font-size:1.2em">修改首页轮播图，轮播图尺寸必须一致(建议尺寸 宽：1920px; 高：300-500px)，文件名不可以是中文或符号</p>';
    echo '<form method="post"
        action="updateslideshow.php" enctype="multipart/form-data">';
    for ($i = 0; $i < count($result); $i++) {
        echo '<div id="oldimgdy' . $i . '">';
        if (@file_exists($imgindex . $result[$i]['image'])) {
            $size = GetImageSize($imgindex . $result[$i]['image']);
            if (($size[0] > 0) && ($size[1] > 0)) {
                echo '<img id="vi' . $i . '"src="' . $imgindex . $result[$i]['image'] . '" 
                  style="height="150px" width="250px" />
                    <input id="bn' . $i . '" type="button" onclick="delimg(' . $i . ')" value="删除图片" />';
                echo '<input id="val' . $i . '" type="hidden" name="oldimg[]" value="' . $result[$i]['image'] . '"/></div>';
            }
        }
    }
    echo '<div id="picInput"><input type="file" name="imagefile[]" /></div>';
    echo '<input id="addBtn" type="button" onclick="addPic1()" value="继续添加图片" />';
    echo '<input type="submit" value="更新" /><div style="text-align:center">点击更新才会生效</div>';
    echo '</form>';
} else {
?>
   <p style="text-align:center; font-size:1.2em">添加首页轮播图，轮播图尺寸必须一致(建议尺寸)，文件名不可以是中文或符号</p>
   <form method="post"
        action="updateslideshow.php?table=slideshows" enctype="multipart/form-data">
    <p><label for="agdimg">详情图片(最多十张)<img src="images/uploadfile.png" /></label><input type="file" id="agdimg" name="imagefile[]" multiple="true" onchange="readAsDataURL(this.files,'preagd')" /></p>
    <div id="preagd" class="prediv"></div>
   <input type="submit" value="更新" />
   </form>


<?php
}
$conn->close();
?>
				</div>
			</fieldset>
		</div>
	</body>

</html>