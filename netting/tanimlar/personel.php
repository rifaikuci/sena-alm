<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['personelekleme'])) {
    try {
        $adsoyad = $_POST['adsoyad'];
        $isegiristarih = $_POST['isegiristarih'];
        $isecikistarih = $_POST['isecikistarih'];
        $adres = $_POST['adres'];
        $tc = $_POST['tc'];
        $telefon = $_POST['telefon'];
        $mail = $_POST['mail'];
        $bedentshirt = $_POST['bedentshirt'];
        $bedenpantalon = $_POST['bedenpantalon'];
        $bedenayakkabi = $_POST['bedenayakkabi'];
        $rolId = $_POST['rolId'];
        $sql = "INSERT INTO tblpersonel (adsoyad, isegiristarih, isecikistarih, adres, tc, telefon,
                                      mail, bedentshirt, bedenpantalon, bedenayakkabi, rolId)
                VALUES ('$adsoyad', '$isegiristarih','$isecikistarih', '$adres','$tc', '$telefon',
                        '$mail', '$bedentshirt','$bedenpantalon', '$bedenayakkabi','$rolId')";
        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/personel/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/personel/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['personelsil'])) {
    $id = $_GET['personelsil'];
    $sql = "DELETE FROM tblpersonel where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/personel/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/personel/?durumsil=no");
        exit();
    }
}

if (isset($_POST['personelguncelleme'])) {
    $id = $_POST['id'];
    $adsoyad = $_POST['adsoyad'];
    $isegiristarih = $_POST['isegiristarih'];
    $isecikistarih = $_POST['isecikistarih'];
    $adres = $_POST['adres'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $mail = $_POST['mail'];
    $bedentshirt = $_POST['bedentshirt'];
    $bedenpantalon = $_POST['bedenpantalon'];
    $bedenayakkabi = $_POST['bedenayakkabi'];
    $rolId = $_POST['rolId'];

    $sql = "UPDATE tblpersonel set 
        adsoyad = '$adsoyad', isegiristarih = '$isegiristarih', isecikistarih = '$isecikistarih', adres = '$adres',
        tc = '$tc', telefon = '$telefon', mail = '$mail', bedentshirt = '$bedentshirt', 
                       bedenpantalon = '$bedenpantalon', bedenayakkabi ='$bedenayakkabi', rolId = '$rolId' 
            WHERE id='$id'";
    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/personel/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/personel/?durumguncelleme=no");
        exit();
    }
}
?>