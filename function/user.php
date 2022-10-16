<?php

include('../db.php');


if (isset($_POST['create'])) {
    create();
}

if (isset($_POST['delete'])) {
    delete();
}

if (isset($_POST['update'])) {
    update();
}

if (isset($_POST['login'])) {
    login();
}


function getuser()
{
    $sql = "SELECT * FROM user";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}

function get_user_by_id($user_id)
{
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}


function login()
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);
        $_SESSION['login'] = true;
        $_SESSION['username'] =  $user['username'];

        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['login'] = false;
        $_SESSION['type'] = 'danger';
        $_SESSION['msg'] = "يوجد خطأ في أسم المستخدم أو كلمة المرور";
        return null;
    }
}




// <!-- user_id	username	password -->
function create()
{
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "INSERT INTO `user`(`username`, `password`) 
            VALUES ('$username','$password')";

    if (mysqli_query($GLOBALS['con_db'], $sql)) {
        $_SESSION['type'] = 'success';
        $_SESSION['msg'] = "تمت عملية الإضافة بنجاح";
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['msg'] = "حصل خطأ أثناء عملية الإضافة";
    }
}


function update()
{
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "UPDATE `user` SET `username`='$username',`password`='$password' WHERE  user_id= $user_id";

    if (mysqli_query($GLOBALS['con_db'], $sql)) {
        $_SESSION['type'] = 'success';
        $_SESSION['msg'] = "تمت عملية التعديل بنجاح";
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['msg'] = "حصل خطأ أثناء عملية التعديل";
    }
}


function delete()
{
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM user WHERE user_id = $user_id";

    if (mysqli_query($GLOBALS['con_db'], $sql)) {
        $_SESSION['type'] = 'success';
        $_SESSION['msg'] = "تمت عملية الحذف بنجاح";
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['msg'] = "حصل خطأ أثناء عملية الحذف";
    }
}
