<?php
include('db.php');


// asc
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





function getgame_alphapitlacy()
{
    // $sql = "SELECT * FROM game order by title";
    // $result = mysqli_query($GLOBALS['con_db'], $sql);
    // if ($result  && mysqli_num_rows($result) > 0) {
    //     return $result;
    // } else {
    //     return null;
    // }
}


function getgame_recently()
{
//     $sql = "SELECT * FROM game order by date DESC";
//     $result = mysqli_query($GLOBALS['con_db'], $sql);
//     if ($result  && mysqli_num_rows($result) > 0) {
//         return $result;
//     } else {
//         return null;
//     }
}

function getgame_desc()
{
    $sql = "SELECT * FROM game order by game_id desc";
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
