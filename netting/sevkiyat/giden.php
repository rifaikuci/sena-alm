<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

if (isset($_POST['sevkiyatcikisekle'])) {

    $personelId1 = $_POST['personelId1'];
    $personelId2 = $_POST['personelId2'];
    $plaka = $_POST['plaka'];
    $sevkiyatarih = $_POST['sevkiyatarih'];
    $sevkiyasaat = $_POST['sevkiyasaat'];
    $balyalaArray = $_POST['balyalaArray'];
    $balyaNoArray = $_POST['balyaNoArray'];
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $aciklama = $_POST['aciklama'];
    $tarih = $sevkiyatarih . " " . $sevkiyasaat;
    $date = new DateTime(date('Y-m-d'));
    $hafta = $date->format("W");
    $hafta = str_pad($hafta, 2, "0", STR_PAD_LEFT);
    $yil = date('y');
    $rand = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    $kod = "SVK-" . $yil . $hafta . $rand;

    $sql = "INSERT INTO tblsevkiyatcikis (kod, personelId1, personelId2, plaka, sevkiyatTarih, aciklama, operatorId, balyaId, balyaNo
        ) VALUES ('$kod', '$personelId1', '$personelId2', '$plaka', '$tarih', '$aciklama', '$operatorId', '$balyalaArray', '$balyaNoArray')";


    mysqli_query($db, $sql);
    $id = mysqli_insert_id($db);

    $balyalaArray = str_replace(";", ",", $balyalaArray);
    $sqlBalyala = "UPDATE tblbalyalama SET sevkiyatId = '$id' where id in (" . $balyalaArray . ")";


    $array = explode(",", $balyalaArray);
    $textBaskilar = "";
    for ($i = 0; $i < count($array); $i++) {

        $baskilar = tablogetir('tblbalyalama', 'id', $array[$i], $db)['baskiId'];
        $textBaskilar = $textBaskilar . $baskilar . ";";
    }

    $textBaskilar = rtrim($textBaskilar, ";");

    $baskilarTemp = explode(";", $textBaskilar);

    $baskilarTemp = array_unique($baskilarTemp);

    $baskilar = array();
    for ($i = 0; $i < count($baskilarTemp); $i++) {
        if ($baskilarTemp[$i]) {
            array_push($baskilar, $baskilarTemp[$i]);
        }
    }

    for ($i = 0; $i < count($baskilarTemp); $i++) {

        $baskiId = $baskilar[$i];
        $sevkiyatIds = tablogetir("tblbaski", 'id', $baskiId, $db)['sevkiyatId'];

        if ($sevkiyatIds != '0' && $sevkiyatIds != '-1') {
            $sevkiyatIds = $sevkiyatIds . ";" . $id;

            $sqlBaski = "UPDATE tblbaski set
                        sevkiyatId = '$sevkiyatIds'
                    where id = '$baskiId'";

        } else {

            $sevkiyatIds = $id;

            $sqlBaski = "UPDATE tblbaski set
                        sevkiyatId = '$sevkiyatIds'
                    where id = '$baskiId'";
        }
        mysqli_query($db, $sqlBaski);
    }


    if (mysqli_query($db, $sqlBalyala)) {
        header("Location:../../sevkiyat/giden/?durumekle=ok");
        exit();

    } else {
        header("Location:../../sevkiyat/giden/?durumekle=no");
        exit();
    }
}

?>