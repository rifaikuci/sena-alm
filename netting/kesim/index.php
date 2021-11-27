<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');


if (isset($_POST['kesimekle'])) {
    $isSepet1Dolu = strval($_POST['isSepet1Dolu']) == "true" ? 1 : 0;
    $isSepet2Dolu = strval($_POST['isSepet2Dolu']) == "true" ? 1 : 0;
    $isSepet3Dolu = strval($_POST['isSepet3Dolu']) == "true" ? 1 : 0;
    $sepet1Adet = $_POST['sepet1Adet'];
    $sepet2Adet = $_POST['sepet2Adet'];
    $sepet3Adet = $_POST['sepet3Adet'];
    $sepet1 = $_POST['sepet1'];
    $sepet2 = $_POST['sepet2'] == "" ? 0 : $_POST['sepet2'];
    $sepet3 = $_POST['sepet3'] == "" ? 0 : $_POST['sepet3'];

    $vardiya = ayarSqlBul(1, $db, 'vardiya');
    $vardiyaKod = vardiyaBul($vardiya, date("H:i"));
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;

    $netAdet = $_POST['netAdet'];
    $satirNo = $_POST['satirNo'];
    $baskiId = $_POST['baskiId'];
    $siparisTur = $_POST['siparisTur'];
    $kesilenBoy = $_POST['kesilenBoy'];
    $basilanNetAdet = $_POST['basilanNetAdet'];
    $istenilenTermik = $_POST['istenilenTermik'];
    $aciklama = $_POST['aciklama'];
    $siparisId = $_POST['siparisId'];
    $hurdaAdet = $_POST['hurdaAdet'];

    $konum = "termik";
    if ($istenilenTermik == "Termikli" || $istenilenTermik == "Yarı Termikli") {
        $konum = "termik";
    } else {
        if ($siparisTur = "Boyalı") {
            $konum = "kromat";
        } else {
            $konum = "paketleme";
        }
    }

    $sqlKesim = "INSERT INTO tblkesim (baskiId, kesilenBoy, operatorId, sepetId1, sepetId2, sepetId3, 
                      hurdaAdet, netAdet, vardiyaKod, sepet1Adet, sepet2Adet, sepet3Adet, durum) 
                VALUES ('$baskiId', '$kesilenBoy', '$operatorId', '$sepet1', '$sepet2', '$sepet3',
                        '$hurdaAdet', '$netAdet', '$vardiyaKod', '$sepet1Adet', '$sepet2Adet', '$sepet3Adet', '$konum')";

    mysqli_query($db, $sqlKesim);

    $kesimId = mysqli_insert_id($db);


    $sqlBaski = "UPDATE tblbaski set
                        kesimId = '$kesimId'
                    where id = '$baskiId'";
    mysqli_query($db, $sqlBaski);


    $sqlHurda = "INSERT INTO tblhurda (toplamKg, aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ('$hurdaAdet', '$aciklama', '$operatorId','$baskiId', 'kesim', '$kesimId')";
    mysqli_query($db, $sqlHurda);

    $guncelGr = baskiBul($baskiId, $db, 'guncelGr');
    $adet = -1 * ($hurdaAdet);
    $kilo = $adet * $guncelGr * $kesilenBoy;
    $sqlprofil = "INSERT INTO tblstokprofil (toplamKg, toplamAdet, gelisAmaci,siparis) 
                VALUES ('$kilo', '$adet', 'kesim', '$satirNo')";
    mysqli_query($db, $sqlprofil);

    if ($sepet1 > 0) {

        $icindekiler1 = sepetbul($sepet1, $db, 'icindekiler');
        $sepet1Icındekiler = $icindekiler1 . $kesimId . ";";


        $sqlsepet1 = "UPDATE tblsepet set
                        icindekiler = '$sepet1Icındekiler',
                        durum = '$isSepet1Dolu'
                    where id = '$sepet1'";
        mysqli_query($db, $sqlsepet1);
    }

    if ($sepet2 > 0) {

        $icindekiler2 = sepetbul($sepet2, $db, 'icindekiler');
        $sepet2Icındekiler = $icindekiler2 . $kesimId . ";";


        $sqlsepet2 = "UPDATE tblsepet set
                        icindekiler = '$sepet2Icındekiler',
                        durum = '$isSepet2Dolu'
                    where id = '$sepet2'";
        mysqli_query($db, $sqlsepet2);
    }

    if ($sepet3 > 0) {

        $icindekiler3 = sepetbul($sepet3, $db, 'icindekiler');
        $sepet3Icındekiler = $icindekiler3 . $kesimId . ";";


        $sqlsepet3 = "UPDATE tblsepet set
                        icindekiler = '$sepet3Icındekiler',
                        durum = '$isSepet3Dolu'
                    where id = '$sepet3'";
        mysqli_query($db, $sqlsepet3);
    }


    $sqlsiparis = "UPDATE tblsiparis set
                        konum = '$konum'
                    where id = '$siparisId'";


    if (mysqli_query($db, $sqlsiparis)) {
        header("Location:../../kesim/?durumekle=ok");
        exit();
    } else {
        header("Location:../../kesim/?durumekle=no");
        exit();
    }
}

if (isset($_GET['kesimsil'])) {
    $id = $_GET['kesimsil'];

    $sqlkesim = "SELECT * FROM tblkesim where id = '$id'";
    $kesim = mysqli_query($db, $sqlkesim)->fetch_assoc();

    $baskiId = $kesim['baskiId'];

    $sqlBaski = "UPDATE tblbaski set
                        kesimId = '0'
                    where id = '$baskiId'";
    mysqli_query($db, $sqlBaski);

    $sqlHurda = "DELETE FROM tblhurda where kesimId = '$id'";
    mysqli_query($db, $sqlHurda);

    $siparisId = baskiBul($baskiId, $db, 'siparisId');
    $satirNo = siparisBul($siparisId, $db, 'satirNo');
    $hurdaAdet = -1 * ($kesim['hurdaAdet']);

    $sqlstokprofil = "DELETE FROM tblstokprofil where toplamAdet = '$hurdaAdet' AND gelisAmaci = 'kesim' AND siparis = '$satirNo'";
    mysqli_query($db, $sqlstokprofil);


    $sqlsiparis = "UPDATE tblsiparis set
                        konum = 'baski'
                    where id = '$siparisId'";

    if ($kesim['sepetId1'] > 0) {
        $sepet1 = $kesim['sepetId1'];
        $icindekiler1 = sepetbul($sepet1, $db, 'icindekiler');
        $sepet1Icındekiler = str_replace($id . ";", "", $icindekiler1);


        $sqlsepet1 = "UPDATE tblsepet set
                        icindekiler = '$sepet1Icındekiler',
                        durum = '0'
                    where id = '$sepet1'";
        mysqli_query($db, $sqlsepet1);
    }

    if ($kesim['sepetId2'] > 0) {
        $sepet2 = $kesim['sepetId2'];
        $icindekiler2 = sepetbul($sepet2, $db, 'icindekiler');
        $sepet2Icındekiler = str_replace($id . ";", "", $icindekiler2);


        $sqlsepet2 = "UPDATE tblsepet set
                        icindekiler = '$sepet2Icındekiler',
                        durum = '0'
                    where id = '$sepet2'";
        mysqli_query($db, $sqlsepet2);
    }

    if ($kesim['sepetId3'] > 0) {
        $sepet3 = $kesim['sepetId3'];
        $icindekiler3 = sepetbul($sepet3, $db, 'icindekiler');
        $sepet3Icındekiler = str_replace($id . ";", "", $icindekiler3);


        $sqlsepet3 = "UPDATE tblsepet set
                        icindekiler = '$sepet3Icındekiler',
                        durum = '0'
                    where id = '$sepet3'";
        mysqli_query($db, $sqlsepet3);
    }

    $sqlkesim = "DELETE FROM tblkesim where id = '$id'";

    if (mysqli_query($db, $sqlkesim)) {
        header("Location:../../kesim/?durumsil=ok");
        exit();
    } else {
        header("Location:../../kesim/?durumsil=no");
        exit();
    }
}