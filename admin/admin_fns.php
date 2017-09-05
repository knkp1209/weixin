<?php
// This file contains functions used by the admin interface
// for the house-O-Rama shopping cart.
// 


function check_admin_user()
{
// see if somebody is logged in and notify them if not

    if (isset($_SESSION['customer'])) {
        return true;
    } else {
        return false;
    }
}

function display_login_form()
{
    // dispaly form asking for name and password
    ?>
    <div class="container">
        <form method="post" action="admin.php">
            <table bgcolor="#cccccc">
                <tr>
                    <td>用户名:</td>
                    <td><input type="text" name="username"/></td>
                </tr>
                <tr>
                    <td>密码:</td>
                    <td><input type="password" name="passwd"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="登录"/></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}

function display_admin_nav($acpage)
{
    $pages = array('index.php' => '主页', 'admin.php' => '管理页面', 'logout.php' => '注销');

    foreach ($pages as $key => $value) {
        if ($key == $acpage)
            echo '<li class="active"><a href="' . $key . '">' . $value . '</a></li>';
        else
            echo '<li><a href="' . $key . '">' . $value . '</a></li>';
    }

}


function display_password_form()
{
// displays html change password form
    ?>
    <br/>
    <div class="container">
        <form action="change_password.php" method="post">
            <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
                <tr>
                    <td>密码:</td>
                    <td><input type="password" name="old_passwd" size="16" maxlength="16"/></td>
                </tr>
                <tr>
                    <td>新密码:</td>
                    <td><input type="password" name="new_passwd" size="16" maxlength="16"/></td>
                </tr>
                <tr>
                    <td>确认密码:</td>
                    <td><input type="password" name="new_passwd2" size="16" maxlength="16"/></td>
                </tr>
                <tr>
                    <td colspan=2 align="center"><input type="submit" value="修改管理员密码">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <br/>
    <?php
}

function insert_house($district, $price, $area, $type, $floor, $layout, $toward, $address, $date, $bulidtime, $title, $images, $name, $phone)
{
// insert a new house into the database

    $conn = db_connect();

    // insert new linkman
    $query = "select linkmanid from linkman where name='" . $name . "' and phone='" . $phone . "'";
    $result = $conn->query($query);
    if ((!$result) || ($result->num_rows > 0)) {
        $linkman = $result->fetch_object();
        $linkmanid = $linkman->linkmanid;
    } else {
        $query = "insert into linkman (name,phone) values ('" . $name . "','" . $phone . "')";
        $result = $conn->query($query);
        if (!$result) {
            return false;
        }
        $linkmanid = $conn->insert_id;
    }


    // select house
    $query = "select houseid from houses where district='" . $district . "' and price='"
        . $price . "' and area='" . $area . "' and type='" . $type . "' and floor='" . $floor . "' and layout='" . $layout . "' and toward='" . $toward . "' and images='" . $images . "' and address='" . $address . "' and linkmanid='" . $linkmanid . "' and bulidtime='" . $bulidtime . "' and title='" . $title . "'";

    // insert house
    $result = $conn->query($query);
    if ($result->num_rows > 0 || !$result) {
        return false;
    } else {
        $query = "insert into houses(district, price, area, type, floor, layout, toward, images, address, linkmanid, date, bulidtime, title) values('" . $district . "','" . $price . "','" . $area . "','" . $type . "','" . $floor . "','" . $layout . "','" . $toward . "','" . $images . "','" . $address . "'," . $linkmanid . ",'" . $date . "','" . $bulidtime . "','" . $title . "')";

        $result = $conn->query($query);
        if (!$result) {
            return false;
        }
        return true;
    }


}


function update_house($houseid, $linkmanid, $district, $price, $area, $type, $floor, $layout, $toward, $address, $date, $bulidtime, $title, $images, $name, $phone)
{
// change details of house stored under $oldisbn in
// the database to new details in arguments

    $conn = db_connect();
    $query = "select linkmanid from linkman where name='" . $name . "' AND phone='" . $phone . "'";
    $result = @$conn->query($query);
    if (@$result->num_rows > 0) {
        $linkman = $result->fetch_object();
        $linkmanid = $linkman->linkmanid;
    } else {
        $query = "update linkman
              set name='" . $name . "',
              phone='" . $phone . "'
              where linkmanid='" . $linkmanid . "';";
    }

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $query = "update houses
             set district= '" . $district . "',
             price = '" . $price . "',
             area = '" . $area . "',
             type = '" . $type . "',
             floor = '" . $floor . "',
             layout = '" . $layout . "',
             toward = '" . $toward . "',
             address = '" . $address . "',
             bulidtime = '" . $bulidtime . "',
             title = '" . $title . "',
             images = '" . $images . "',
             linkmanid = '" . $linkmanid . "'
             where houseid = '" . $houseid . "'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}


function delete_house($houseid)
{
// Deletes the house identified by $isbn from the database.

    $conn = db_connect();
    $conn->autocommit(FALSE);
    $query = "select linkmanid from houses where houseid='" . $houseid . "'";
    $result = @$conn->query($query);
    if (@$result->num_rows > 0) {
        $linkman = $result->fetch_object();
        $linkmanid = $linkman->linkmanid;
    } else {
        return false;
    }

    $query = "delete from collections where houseid='" . $houseid . "'";
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }

    $query = "delete from houses where houseid=" . $houseid;
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }

    $query = "select houseid from houses where linkmanid='" . $linkmanid . "'";
    $result = @$conn->query($query);
    if (@$result->num_rows > 0) {
        $conn->commit();
        $conn->autocommit(TRUE);
    } else {
        $query = "delete from linkman where linkmanid='" . $linkmanid . "'";
        $result = @$conn->query($query);
        if (!$result || !($conn->affected_rows > 0)) {
            return false;
        }
        $conn->commit();
        $conn->autocommit(TRUE);
    }


    return true;
}


?>

<?php
function uploadimage($file, $upload_path = "images/")
{

    $name = $file['name'];      //得到文件名称，以数组的形式
    $images = array();      // 上传图片的文件名
    //当前位置

    foreach ($name as $k => $names) {
        $type = strtolower(substr($names, strrpos($names, '.') + 1));//得到文件类型，并且都转化成小写
        $allow_type = array('jpg', 'jpeg', 'gif', 'png'); //定义允许上传的类型
        //把非法格式的图片去除
        if (!in_array($type, $allow_type)) {
            unset($name[$k]);
        }
    }

    
    foreach ($name as $k => $item) {
        $rname = getRandOnlyId() . '.png';
        $type = strtolower(substr($item, strrpos($item, '.') + 1));//得到文件类型，并且都转化成小写
        if (move_uploaded_file($file['tmp_name'][$k], $upload_path . $rname )) {
            $images[] = $rname;
        } else {
            return false;
        }
    }

    return $images;
}


function getRandOnlyId() {
    //新时间截定义,基于世界未日2012-12-21的时间戳。
    $endtime=1356019200;//2012-12-21时间戳
    $curtime=time();//当前时间戳
    $newtime=$curtime-$endtime;//新时间戳
    $rand=rand(0,99);//两位随机
    $all=$rand.$newtime;
    $onlyid=base_convert($all,10,36);//把10进制转为36进制的唯一ID
    return $onlyid;
}


function idcvrname($id){

    $conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT catname FROM catalog WHERE catalogID = $id";
    $result = $conn->query($query);
    $cat = $result->fetch_object();
    if(empty($cat->catname))
        exit;
    return $cat->catname;

}

function idcvrimg($id){

    echo $id;
    

    exit;
    $conn = db_connect();
    $conn->query("set character set utf8");
    $conn->query("set names utf8");
    $query = "SELECT catname FROM catalog WHERE catalogID = $id";
    $result = $conn->query($query);
    $cat = $result->fetch_object();
    if(empty($cat->catname))
        exit;
    return $cat->catname;

}


?>