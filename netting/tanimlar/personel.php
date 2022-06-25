<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['personelekleme'])) {
    try {
        $adsoyad = $_POST['adsoyad'];
        $isegiristarih = $_POST['isegiristarih'];
        $isecikistarih = $_POST['isecikistarih'] ? $_POST['isecikistarih'] : "0000-00-00 00:00:00";
        $adres = $_POST['adres'];
        $tc = $_POST['tc'];
        $telefon = $_POST['telefon'];
        $mail = $_POST['mail'];
        $bedentshirt = $_POST['bedentshirt'];
        $bedenpantalon = $_POST['bedenpantalon'];
        $bedenayakkabi = $_POST['bedenayakkabi'];
        $password = $_POST['password'];
        $rolId = $_POST['rolId'];
        $sql = "INSERT INTO tblpersonel (adsoyad, isegiristarih, isecikistarih, adres, tc, telefon,
                                      mail, bedentshirt, bedenpantalon, bedenayakkabi, rolId, password)
                VALUES ('$adsoyad', '$isegiristarih','$isecikistarih', '$adres','$tc', '$telefon',
                        '$mail', '$bedentshirt','$bedenpantalon', '$bedenayakkabi','$rolId', '$password')";
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
    $isecikistarih = $_POST['isecikistarih'] ? $_POST['isecikistarih'] : "0000-00-00 00:00:00";
    $adres = $_POST['adres'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $mail = $_POST['mail'];
    $bedentshirt = $_POST['bedentshirt'];
    $bedenpantalon = $_POST['bedenpantalon'];
    $bedenayakkabi = $_POST['bedenayakkabi'];
    $password = $_POST['password'];
    $rolId = $_POST['rolId'];

    $sql = "UPDATE tblpersonel set 
        adsoyad = '$adsoyad', isegiristarih = '$isegiristarih', isecikistarih = '$isecikistarih', adres = '$adres',
        tc = '$tc', telefon = '$telefon', mail = '$mail', bedentshirt = '$bedentshirt', 
                       bedenpantalon = '$bedenpantalon', bedenayakkabi ='$bedenayakkabi', rolId = '$rolId', password = '$password' 
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