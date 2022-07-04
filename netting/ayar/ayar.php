<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);


if (isset($_POST['ayarguncelleme'])) {

    $vardiya = $_POST['vardiya'];
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $sql = "UPDATE tblayar set 
       vardiya = '$vardiya', operatorId = '$operatorId'
WHERE id='1'";

    mysqli_query($db, $sql);

    if (mysqli_query($db, $sql)) {
        header("Location:/sena/ayar/?ayarok=ok" );
        exit();
    } else {
        header("Location:/sena/ayar/?ayarok=no" );
        exit();
    }
}