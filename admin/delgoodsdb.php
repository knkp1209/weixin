<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$companys = array();

$rid = $_SESSION['customer']['rid'];
if (isset($_POST['goodsID']) && count($_POST['goodsID']) > 0) {
    $goodsID = $_POST['goodsID'];
    $parameter = implode(',', $goodsID);

    
    $query = "DELETE FROM goods WHERE goodsID in ( $parameter )";

    $conn->query($query);
    if($conn->affected_rows > 0)
        echo '删除成功';
    else
        echo '删除失败，系统错误!';
    $url = 'delgoods.php';
    header('Refresh: 1; url=' . $url);
    exit;

}
echo "请勾择要删除的商品";
$url = 'delgoods.php';
header('Refresh: 1; url=' . $url);
exit;

ob_end_flush();
?>