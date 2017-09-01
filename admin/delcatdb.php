<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$companys = array();


if (isset($_POST['companys']) && count($_POST['companys']) > 0) {
    $companys = $_POST['companys'];
    $parameter = implode(',', $companys);

    $query = "DELETE FROM cooperations WHERE cooperationId in (" . $parameter . ")";

    $result = $conn->query($query);
    if ($conn->affected_rows < 0) {
        echo '删除失败，系统错误!';
        $url = 'admincompany.php';
        header('Refresh: 1; url=' . $url);
        exit;
    } else if ($conn->affected_rows > 0) {
        echo '删除成功';
        $url = 'admincompany.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }

}

ob_end_flush();
?>