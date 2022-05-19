<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_GET['takimId']) &&  isset($_GET['oldProcess']) && isset($_GET['newProcess'])) {
    $oldProcess = $_GET['oldProcess'];
    $takimId = $_GET['takimId'];
    $newProcess = $_GET['newProcess'];
    $description = isset($_GET['description']) ? $_GET['description'] : '';
    $operatorId= isset($_GET['operatorId']) ? $_GET['operatorId'] : '';

    echo $description;
    exit();

    $sqlTakim = "UPDATE tbltakim SET konum = '$newProcess' WHERE id = $takimId";
    mysqli_query($db, $sqlTakim);

    $sql = "INSERT INTO tblkaliphane (takimId, oldProcess, newProcess, description, operatorId) VALUES ('$takimId', '$oldProcess', '$newProcess', '$description', '$operatorId')";

    if (mysqli_query($db, $sql)) {
        header("Location:".base_url()."kaliphane/?durum=ok");
        exit();
    } else {
        header("Location:".base_url()."kaliphane/?durum=no");
        exit();
    }

}


?>