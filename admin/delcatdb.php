<?php
ob_start();
require_once('admin_include_fns.php');

$conn = db_connect();
$companys = array();

$rid = $_SESSION['customer']['rid'];
if (isset($_POST['cats']) && count($_POST['cats']) > 0) {
    $cats = $_POST['cats'];
    $parameter = implode(',', $cats);

    
    $query = "SELECT catalogID FROM catalog  WHERE rid = $rid AND (catalogID in ($parameter) ) ";

    $result = $conn->query($query);
    if ($result->num_rows < 0) {
        echo '删除失败，系统错误!';
        $url = 'delcatalog.php';
        header('Refresh: 1; url=' . $url);
        exit;
    } else if ($result->num_rows > 0) {
        $parameter = '';
        $catsID = db_result_to_array($result);
        for($i = 0; $i < count($catsID); $i++){
            $parameter .= $catsID[$i]['catalogID'] . ",";
        }
        $parameter = substr($parameter,0,-1);
        $query = "DELETE FROM catalog WHERE catalogID in (" . $parameter . ")";
        $conn->query($query);
        if($conn->affected_rows > 0)
            echo '删除成功';
        else
            echo '删除失败，系统错误!';
        $url = 'delcatalog.php';
        header('Refresh: 1; url=' . $url);
        exit;
    }

}
echo "请选择要删除的分类";
$url = 'delcatalog.php';
header('Refresh: 1; url=' . $url);
exit;

ob_end_flush();
?>