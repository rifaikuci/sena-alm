<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['alasimekleme'])) {

    try {
        $ad = $_POST['ad'];
        $ozkutle = $_POST['ozkutle'];
        $seo = seo($ad);

        $sql = "INSERT INTO tblalasim (ad, ozkutle,seo) VALUES ('$ad', '$ozkutle','$seo')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/alasim/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/alasim/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['alasimsil'])) {
    $id = $_GET['alasimsil'];
    $sql = "DELETE FROM tblalasim where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/alasim/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/alasim/?durumsil=no");
        exit();
    }
}

if (isset($_POST['alasimguncelleme'])) {
    $id = $_POST['id'];
    $ad = $_POST['ad'];
    $ozkutle = $_POST['ozkutle'];
    $seo = seo($ad);

    $sql = "UPDATE tblalasim set 
        ad = '$ad', ozkutle = '$ozkutle', seo = '$seo' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/alasim/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/alasim/?durumguncelleme=no");
        exit();
    }
}
?>