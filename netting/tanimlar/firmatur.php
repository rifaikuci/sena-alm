<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['firmaturekleme'])) {

    try {
        $ad = $_POST['ad'];
        $seo = seo($ad);
        $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;


        $sql = "INSERT INTO tblfirmatur (ad, seo, operatorId) VALUES ('$ad', '$seo', '$operatorId')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/firmatur/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/firmatur/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['firmatursil'])) {
    $id = $_GET['firmatursil'];
    $sql = "DELETE FROM tblfirmatur where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/firmatur/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/firmatur/?durumsil=no");
        exit();
    }
}

if (isset($_POST['firmaturguncelleme'])) {
    $id = $_POST['id'];
    $ad = $_POST['ad'];
    $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $seo = seo($ad);

    $sql = "UPDATE tblfirmatur set 
        ad = '$ad', seo = '$seo', operatorId = '$operatorId' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/firmatur/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/firmatur/?durumguncelleme=no");
        exit();
    }
}
?>