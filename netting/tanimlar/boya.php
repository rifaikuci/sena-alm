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

        $sql = "INSERT INTO tblboya (ad, kod, seo) VALUES ('$ad', '$kod', '$seo')";

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
    $sql = "DELETE FROM tblboya where id = '$id' ";

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
    $seo = seo($ad);

    $sql = "UPDATE tblboya set 
        ad = '$ad', kod = '$kod', seo = '$seo' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/boya/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/boya/?durumguncelleme=no");
        exit();
    }
}
?>