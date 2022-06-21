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
    $sepet1Adet = $_POST['sepet1Adet'] ? $_POST['sepet1Adet'] : 0;
    $sepet2Adet = $_POST['sepet2Adet'] ? $_POST['sepet2Adet'] : 0;
    $sepet3Adet = $_POST['sepet3Adet'] ? $_POST['sepet3Adet'] : 0;
    $sepet1 = $_POST['sepet1'];
    $sepet2 = $_POST['sepet2'] == "" ? 0 : $_POST['sepet2'];
    $sepet3 = $_POST['sepet3'] == "" ? 0 : $_POST['sepet3'];


    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiyaKod = vardiyaBul($vardiya, date("H:i"));
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;

    $netAdet = $_POST['netAdet'];
    $satirNo = $_POST['satirNo'];
    $baskiId = $_POST['baskiId'];
    $siparisTur = $_POST['siparisTur'];
    $kesilenBoy = $_POST['kesilenBoy'];
    $basilanNetAdet = $_POST['basilanNetAdet'];
    $istenilenTermik = $_POST['istenilenTermik'];
    $hurdaSebep = $_POST['hurdaSebep'];
    $siparisId = $_POST['siparisId'];
    $hurdaAdet = $_POST['hurdaAdet'];
    $naylonDurum = tablogetir("tblsiparis", 'id', $siparisId, $db)['naylonDurum'];


    $sqlKesim = "INSERT INTO tblkesim (baskiId, kesilenBoy, operatorId, sepetId1, sepetId2, sepetId3, hurdaSebep, 
                      hurdaAdet, netAdet, vardiyaKod, sepet1Adet, sepet2Adet, sepet3Adet) 
                VALUES ('$baskiId', '$kesilenBoy', '$operatorId', '$sepet1', '$sepet2', '$sepet3', '$hurdaSebep', 
                        '$hurdaAdet', '$netAdet', '$vardiyaKod', '$sepet1Adet', '$sepet2Adet', '$sepet3Adet')";
    mysqli_query($db, $sqlKesim);

    $kesimId = mysqli_insert_id($db);


    $sqlBaski = "UPDATE tblbaski set
                        kesimId = '$kesimId'
                    where id = '$baskiId'";
    mysqli_query($db, $sqlBaski);



    if ($sepet1 > 0) {

        $sepet1getir = tablogetir('tblsepet', 'id', $sepet1, $db);
        $icindekiler1 = $sepet1getir['icindekiler'];
        $adetler1 = $sepet1getir['adetler'];
        $sepet1Icındekiler = $icindekiler1 . $baskiId . ";";
        $sepet1Adetler = $adetler1 . $sepet1Adet . ";";


        $sqlsepet1 = "UPDATE tblsepet set
                        icindekiler = '$sepet1Icındekiler',
                        adetler = '$sepet1Adetler',
                        durum = '$isSepet1Dolu'
                    where id = '$sepet1'";
        mysqli_query($db, $sqlsepet1);
    }

    if ($sepet2 > 0) {

        $sepet2getir = tablogetir('tblsepet', 'id', $sepet2, $db);
        $icindekiler2 = $sepet2getir['icindekiler'];
        $adetler2 = $sepet2getir['adetler'];
        $sepet2Icındekiler = $icindekiler2 . $baskiId . ";";
        $sepet2Adetler = $adetler2 . $sepet2Adet . ";";


        $sqlsepet2 = "UPDATE tblsepet set
                        icindekiler = '$sepet2Icındekiler',
                        adetler = '$sepet2Adetler',
                        durum = '$isSepet2Dolu'
                    where id = '$sepet2'";
        mysqli_query($db, $sqlsepet2);
    }

    if ($sepet3 > 0) {

        $sepet3getir = tablogetir('tblsepet', 'id', $sepet3, $db);
        $icindekiler3 = $sepet3getir['icindekiler'];
        $adetler3 = $sepet3getir['adetler'];
        $sepet3Icındekiler = $icindekiler3 . $baskiId . ";";
        $sepet3Adetler = $adetler3 . $sepet3Adet . ";";


        $sqlsepet3 = "UPDATE tblsepet set
                        icindekiler = '$sepet3Icındekiler',
                        adetler = '$sepet3Adetler',
                        durum = '$isSepet3Dolu'
                    where id = '$sepet3'";
        mysqli_query($db, $sqlsepet3);
    }


    $guncelGr = tablogetir('tblbaski', 'id', $baskiId, $db)['guncelGr'];
    $adet = -1 * ($hurdaAdet);
    $kilo = $adet * $guncelGr * $kesilenBoy;
    $kilo = $kilo / 1000000;
    $kilo = sayiFormatla($kilo);
    $sqlprofil = "INSERT INTO tblstokprofil (kilo, adet, geldigiYer,baskiId) 
                VALUES ('$kilo', '$adet', 'kesim', '$baskiId')";

    $hurdaKilo = $hurdaAdet * $guncelGr * $kesilenBoy;
    $hurdaKilo = $hurdaKilo / 1000000;
    $hurdaKilo = sayiFormatla($hurdaKilo);
    $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kilo) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'kesim', '$hurdaKilo')";
    mysqli_query($db, $sqlHurda);


    if (mysqli_query($db, $sqlprofil)) {
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


    /* # HURDA VE STOK PROFİLE GİDENİN DÖNÜŞÜ OLMAMALI
    $sqlHurda = "DELETE FROM tblhurda where baskiId = '$id'";
    mysqli_query($db, $sqlHurda);


    $hurdaAdet = -1 * ($kesim['hurdaAdet']);

    $sqlstokprofil = "DELETE FROM tblstokprofil where adet = '$hurdaAdet' AND geldigiYer = 'kesim' AND baskiId = '$baskiId'";
    mysqli_query($db, $sqlstokprofil);
    */

    if ($kesim['sepetId1'] > 0) {
        $sepet1 = $kesim['sepetId1'];
        $sepet1getir = tablogetir('tblsepet', 'id', $sepet1, $db);
        $icindekiler1 = $sepet1getir['icindekiler'];
        $adetler1 = $sepet1getir['adetler'];
        $sepet1Icındekiler = str_replace($id . ";", "", $icindekiler1);
        $sepet1Adetler = str_replace($id . ";", "", $adetler1);


        $sqlsepet1 = "UPDATE tblsepet set
                        icindekiler = '$sepet1Icındekiler',
                        adetler = '$sepet1Adetler',
                        durum = '0'
                    where id = '$sepet1'";
        mysqli_query($db, $sqlsepet1);
    }

    if ($kesim['sepetId2'] > 0) {
        $sepet2 = $kesim['sepetId2'];
        $sepet2getir = tablogetir('tblsepet', 'id', $sepet2, $db);
        $icindekiler2 = $sepet2getir['icindekiler'];
        $adetler2 = $sepet2getir['adetler'];
        $sepet2Icındekiler = str_replace($id . ";", "", $icindekiler2);
        $sepet2Adetler = str_replace($id . ";", "", $adetler2);


        $sqlsepet2 = "UPDATE tblsepet set
            icindekiler = '$sepet2Icındekiler',
            adetler = '$sepet2Adetler',
            durum = '0'
            where id = '$sepet2'";
        mysqli_query($db, $sqlsepet2);
    }

    if ($kesim['sepetId3'] > 0) {
        $sepet3 = $kesim['sepetId3'];
        $sepet3getir = tablogetir('tblsepet', 'id', $sepet3, $db);
        $icindekiler3 = $sepet3getir['icindekiler'];
        $adetler3 = $sepet3getir['adetler'];
        $sepet3Icındekiler = str_replace($id . ";", "", $icindekiler3);
        $sepet3Adetler = str_replace($id . ";", "", $adetler3);


        $sqlsepet3 = "UPDATE tblsepet set
            icindekiler = '$sepet3Icındekiler',
            adetler = '$sepet3Adetler',
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

if (isset($_POST['kesimguncelle'])) {
    $isSepet1Dolu = strval($_POST['isSepet1Dolu']) == "true" ? 1 : 0;
    $isSepet2Dolu = strval($_POST['isSepet2Dolu']) == "true" ? 1 : 0;
    $isSepet3Dolu = strval($_POST['isSepet3Dolu']) == "true" ? 1 : 0;
    $kesimId = $_POST['kesimId'];
    $sepet1Adet = $_POST['sepet1Adet'];
    $sepet2Adet = $_POST['sepet2Adet'];
    $sepet3Adet = $_POST['sepet3Adet'];
    $sepetId1 = $_POST['sepet1'];
    $sepetId2 = $_POST['sepet2'] == "" ? 0 : $_POST['sepet2'];
    $sepetId3 = $_POST['sepet3'] == "" ? 0 : $_POST['sepet3'];

    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;

    $netAdet = $_POST['netAdet'];
    $satirNo = $_POST['satirNo'];
    $baskiId = $_POST['baskiId'];
    $siparisTur = $_POST['siparisTur'];
    $kesilenBoy = $_POST['kesilenBoy'];
    $basilanNetAdet = $_POST['basilanNetAdet'];
    $istenilenTermik = $_POST['istenilenTermik'];
    $hurdaSebep = $_POST['hurdaSebep'];
    $siparisId = $_POST['siparisId'];
    $hurdaAdet = $_POST['hurdaAdet'];
    $eskiHurdaAdet = $_POST['eskiHurdaAdet'];
    $eskiHurdaAdet = -1 * $eskiHurdaAdet;


    $sqlKesim = "UPDATE tblkesim set
    kesilenBoy = '$kesilenBoy',
    operatorId = '$operatorId',
    sepetId1 = '$sepetId1',
    sepetId2 = '$sepetId2',
    sepetId3 = '$sepetId3',
    hurdaAdet = '$hurdaAdet',
    hurdaSebep = '$hurdaSebep',
    netAdet = '$netAdet',
    sepet1Adet = '$sepet1Adet',
    sepet2Adet = '$sepet2Adet',
    sepet3Adet = '$sepet3Adet'
    where id = '$kesimId'";





    $guncelGr = tablogetir('tblbaski', 'id', $baskiId, $db)['guncelGr'];
    $adet = -1 * ($hurdaAdet);
    $kilo = $adet * $guncelGr * $kesilenBoy;
    $hurdaKilo = $hurdaAdet * $guncelGr * $kesilenBoy;

    $sqlprofil = "INSERT INTO tblstokprofil (kilo, adet, geldigiYer,baskiId) 
                VALUES ('$kilo', '$adet', 'kesim', '$baskiId')";

    $sqlHurda = "UPDATE tblhurda set
    adet = '$hurdaAdet',
    aciklama = '$hurdaSebep',
    operatorId = '$operatorId',
    kilo = '$hurdaKilo'
    where baskiId = '$baskiId'";

    mysqli_query($db, $sqlHurda);

    mysqli_query($db, $sqlprofil);

    if ($sepetId1 > 0) {

        $sqlsepet1 = "UPDATE tblsepet set
                        durum = '$isSepet1Dolu'
                    where id = '$sepetId1'";
        mysqli_query($db, $sqlsepet1);
    }

    if ($sepetId2 > 0) {

        $sqlsepet2 = "UPDATE tblsepet set
                        durum = '$isSepet2Dolu'
                    where id = '$sepetId2'";
        mysqli_query($db, $sqlsepet2);
    }

    if ($sepetId3 > 0) {


        $sqlsepet3 = "UPDATE tblsepet set
                        durum = '$isSepet3Dolu'
                    where id = '$sepetId3'";
        mysqli_query($db, $sqlsepet3);
    }


    if (mysqli_query($db, $sqlKesim)) {
        header("Location:../../kesim/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../kesim/?durumguncelleme=no");
        exit();
    }
}