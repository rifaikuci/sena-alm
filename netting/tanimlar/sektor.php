<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['sektorekleme'])) {

    try {
        $ad = $_POST['ad'];
        $kisakod = $_POST['kisakod'];
        $seo = seo($ad);
        $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;


        $sql = "INSERT INTO tblsektor (ad, kisakod, seo, operatorId) VALUES ('$ad', '$kisakod', '$seo', '$operatorId')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/sektor/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/sektor/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['sektorsil'])) {
    $id = $_GET['sektorsil'];
    $sql = "DELETE FROM tblsektor where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/sektor/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/sektor/?durumsil=no");
        exit();
    }
}

if (isset($_POST['sektorguncelleme'])) {
    $id = $_POST['id'];
    $ad = $_POST['ad'];
    $kisakod = $_POST['kisakod'];
    $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $seo = seo($ad);
    $sql = "UPDATE tblsektor set 
        ad = '$ad', kisakod = '$kisakod', seo = '$seo', operatorId = '$operatorId' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/sektor/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/sektor/?durumguncelleme=no");
        exit();
    }
}
?>