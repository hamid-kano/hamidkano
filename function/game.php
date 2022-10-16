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

function getgame()
{
    $sql = "SELECT * FROM game";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}

function get_game_by_id($game_id)
{
    $sql = "SELECT * FROM game WHERE game_id = $game_id";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}


function get_game_by_search($search)
{
    $sql = "SELECT * FROM game WHERE  title LIKE '%" . $search . "%' or description LIKE '%" . $search . "%'";
    $result = mysqli_query($GLOBALS['con_db'], $sql);
    if ($result  && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}



// <!-- game_id	title	developer	score	image	description	 -->
function create()
{
    $title = $_POST['title'];
    $developer = $_POST['developer'];
    $score = $_POST['score'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');

    $milliseconds = "";
    $extension = "";

    if (isset($_FILES['image'])) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $milliseconds = floor(microtime(true) * 1000);
        move_uploaded_file($file_tmp, '../image/' . $milliseconds . '.' . $extension);
    }

    $image = $milliseconds . '.' . $extension;


    if (isset($_FILES['file_game'])) {
        $file_tmp = $_FILES['file_game']['tmp_name'];
        $extension = pathinfo($_FILES['file_game']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($file_tmp, '../files/' . $milliseconds . '.' . $extension);

        if (!file_exists('../files/' . $milliseconds)) {
            mkdir('../files/' . $milliseconds, 0777, true);
        }

        $unzip = new ZipArchive;
        $out = $unzip->open('../files/' . $milliseconds . '.zip');
        if ($out === TRUE) {
            $unzip->extractTo('../files/' . $milliseconds . '/');
            $unzip->close();
            //echo 'File unzipped';
        } else {
            //echo 'Error';
        }
    }

    $sql = "INSERT INTO `game`(`title`, `developer`, `score`, `image`, `description`,`date` ) 
            VALUES ('$title','$developer','$score ','$image','$description','$date' )";

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
    $game_id = $_POST['game_id'];

    $game =  get_game_by_id($game_id);
    $date = date('Y-m-d H:i:s');

    if ($game) {
        $game_row = mysqli_fetch_assoc($game);

        $name_file_zip = substr($game_row['image'], 0, 13);

        if (isset($_FILES['file_game'])) {
            $file_tmp = $_FILES['file_game']['tmp_name'];
            $extension = pathinfo($_FILES['file_game']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($file_tmp, '../files/' .  $name_file_zip . '.' . $extension);



            if (!file_exists('../files/' .  $name_file_zip)) {
                mkdir('../files/' .  $name_file_zip, 0777, true);
            }

            $unzip = new ZipArchive;
            $out = $unzip->open('../files/' . $name_file_zip  . '.zip');
            if ($out === TRUE) {
                $unzip->extractTo('../files/' . $name_file_zip . '/');
                $unzip->close();
                //echo 'File unzipped';
            } else {
                //echo 'Error';
            }

            $sql = "UPDATE game set date='$date' where game_id=$game_id;";
            if (mysqli_query($GLOBALS['con_db'], $sql)) {
                $_SESSION['type'] = 'success';
                $_SESSION['msg'] = "تمت عملية رفع نسخة جديدة بنجاح";
            }
        } else {
            $_SESSION['type'] = 'danger';
            $_SESSION['msg'] = "حصل خطأ أثناء عملية رفع نسخة جديدة";
        }
    }
}


function delete()
{
    $game_id = $_POST['game_id'];

    $sql = "DELETE FROM game WHERE game_id = $game_id";

    if (mysqli_query($GLOBALS['con_db'], $sql)) {
        $_SESSION['type'] = 'success';
        $_SESSION['msg'] = "تمت عملية الحذف بنجاح";
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['msg'] = "حصل خطأ أثناء عملية الحذف";
    }
}
