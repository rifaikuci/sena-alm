<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['boyaekleme'])) {

    try {
        $ad = $_POST['ad'];
        $kod = $_POST['kod'];
        $seo = seo($ad);
        $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;


        $sql = "INSERT INTO tblprboya (ad, kod, seo, operatorId) VALUES ('$ad', '$kod', '$seo', '$operatorId')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/boya/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/boya/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['boyasil'])) {
    $id = $_GET['boyasil'];
    $sql = "DELETE FROM tblprboya where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/boya/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/boya/?durumsil=no");
        exit();
    }
}

if (isset($_POST['boyaguncelleme'])) {
    $id = $_POST['id'];
    $ad = $_POST['ad'];
    $kod = $_POST['kod'];
    $operatorId = $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $seo = seo($ad);

    $sql = "UPDATE tblprboya set 
        ad = '$ad', kod = '$kod', seo = '$seo', operatorId = '$operatorId' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/boya/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/boya/?durumguncelleme=no");
        exit();
    }
}
?>