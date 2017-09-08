<?php 
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$conn->query("set character set utf8");//读库
$conn->query("set names utf8");//写库
$rid = $_SESSION['customer']['rid'];


$query = "select * from tenant where rid = $rid";

$result = $conn->query($query);
if(!$result){
	echo "失败";
}else{
	if($result->num_rows == 1){
		$row = $result->fetch_assoc();
        $phone = $row['phone'];
		$appname = $row['appname'];
		$appID = $row['appID'];
		$logo = $row['logo'];
		$introduce = $row['introduce'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/my.css">
    <script src="js/my.js"></script>
    <script type="text/javascript">
    function btnAction(){
        document.getElementById("logo").click();
    }
    </script>
</head>

<body>
    <div class="admin-main">
        <fieldset class="layui-elem-field">
            <legend>添加商品分类</legend>
            <div class="layui-field-box">
                <div class="applet">
                <form method="post" action="appletdb.php" enctype="multipart/form-data">
                    <p>
                        <label for="appname">小程序名称：</label>
                        <input id="appname" type="text" name="appname" placeholder="<?php echo $appname ?>" />
                    </p>
                    <p>
                        <label for="appID">&nbsp;&nbsp; APPID：</label>
                        <input id="appID" type="text" name="appID" placeholder="<?php echo $appID ?>" />
                    </p>
                    <p>
                        <label for="logo">小程序LOGO：</label><input type="button" class="button logo"  value="选择图片" onclick="btnAction()">
                        <input id="logo" type="file" class="file" name="logo"  onchange="readAsDataURL(this.files,'prelogo')"/>
                        <div id="prelogo" class="prelogo">
                            <?php if($logo) echo "<img src=\"$imglogo$logo\" />" ?>
                        </div>
                    </p>
                    <p>
                        <label for="introduce">小程序简介：</label>
                        <input id="introduce" type="text" name="introduce" placeholder="<?php echo $introduce ?>" />
                    </p>
                    <p>
                        <label for="phone">&nbsp;&nbsp;&nbsp;电话：</label>
                        <input id="phone" type="text" name="phone" placeholder="<?php echo $phone ?>" />
                    </p>
                    <p>
                        <input type="submit" class="button" value="更改"> </p>
                </form>
                </div>
            </div>
        </fieldset>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>