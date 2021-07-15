<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['malzemelerekleme'])) {

    try {
        $ad = $_POST['ad'];
        $seo = seo($ad);
        $birim = $_POST['birim'];
        $birimMiktari = $_POST['birimMiktari'];
        $kullanildigiAlanlar = $_POST['kullanildigiAlanlar'];

        $sql = "INSERT INTO tblmalzemeler (ad, seo, birim, birimMiktari, kullanildigiAlanlar) 
                VALUES ('$ad', '$seo', '$birim', '$birimMiktari', '$kullanildigiAlanlar')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/malzemeler/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/malzemeler/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['malzemelersil'])) {
    $id = $_GET['malzemelersil'];
    $sql = "DELETE FROM tblmalzemeler where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/malzemeler/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/malzemeler/?durumsil=no");
        exit();
    }
}

if (isset($_POST['malzemelerguncelleme'])) {
    $id = $_POST['id'];
    $ad = $_POST['ad'];
    $seo = seo($ad);
    $birim = $_POST['birim'];
    $birimMiktari = $_POST['birimMiktari'];
    $kullanildigiAlanlar = $_POST['kullanildigiAlanlar'];

    $sql = "UPDATE tblmalzemeler set 
        ad = '$ad', seo = '$seo', birim = '$birim', birimMiktari = '$birimMiktari', kullanildigiAlanlar = '$kullanildigiAlanlar'
            WHERE id='$id'";
    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/malzemeler/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/malzemeler/?durumguncelleme=no");
        exit();
    }
}
?>