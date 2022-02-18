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
    $aciklama = $_POST['aciklama'];
    $siparisId = $_POST['siparisId'];
    $hurdaAdet = $_POST['hurdaAdet'];
    $naylonDurum = tablogetir("tblsiparis",'id',$siparisId, $db)['naylonDurum'];
    $konum = "termik";
    if ($istenilenTermik == "Termikli" || $istenilenTermik == "Yarı Termikli") {
        $konum = "termik";
        $termikId = 0;
    } else {
        if ($siparisTur == "Boyalı") {
            $konum = "kromat";
            $termikId = -1;

        } else {
            $konum = "paketleme";
            $termikId = -2;
        }
    }

    $sqlKesim = "INSERT INTO tblkesim (baskiId, kesilenBoy, operatorId, sepetId1, sepetId2, sepetId3, 
                      hurdaAdet, netAdet, vardiyaKod, sepet1Adet, sepet2Adet, sepet3Adet, durum, termikId) 
                VALUES ('$baskiId', '$kesilenBoy', '$operatorId', '$sepet1', '$sepet2', '$sepet3',
                        '$hurdaAdet', '$netAdet', '$vardiyaKod', '$sepet1Adet', '$sepet2Adet', '$sepet3Adet', '$konum', '$termikId')";

    mysqli_query($db, $sqlKesim);

    $kesimId = mysqli_insert_id($db);


    $sqlBaski = "UPDATE tblbaski set
                        kesimId = '$kesimId'
                    where id = '$baskiId'";
    mysqli_query($db, $sqlBaski);


    $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ('$hurdaAdet', '$aciklama', '$operatorId','$baskiId', 'kesim', '$kesimId')";
    mysqli_query($db, $sqlHurda);

    $guncelGr = tablogetir('tblbaski', 'id', $baskiId, $db)['guncelGr'];
    $adet = -1 * ($hurdaAdet);
    $kilo = $adet * $guncelGr * $kesilenBoy;
    $sqlprofil = "INSERT INTO tblstokprofil (toplamKg, toplamAdet, gelisAmaci,siparis) 
                VALUES ('$kilo', '$adet', 'kesim', '$satirNo')";
    mysqli_query($db, $sqlprofil);

    if ($sepet1 > 0) {

        $sepet1getir = tablogetir('tblsepet', 'id', $sepet1, $db);
        $icindekiler1 = $sepet1getir['icindekiler'];
        $adetler1 = $sepet1getir['adetler'];
        $sepet1Icındekiler = $icindekiler1 . $kesimId . ";";
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
        $sepet2Icındekiler = $icindekiler2 . $kesimId . ";";
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
        $sepet3Icındekiler = $icindekiler3 . $kesimId . ";";
        $sepet3Adetler = $adetler3 . $sepet3Adet . ";";


        $sqlsepet3 = "UPDATE tblsepet set
                        icindekiler = '$sepet3Icındekiler',
                        adetler = '$sepet3Adetler',
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

    $siparisId = tablogetir('tblbaski', 'id', $baskiId, $db)['siparisId'];
    $satirNo = tablogetir('tblsiparis', 'id', $siparisId, $db)['satirNo'];
    $hurdaAdet = -1 * ($kesim['hurdaAdet']);

    $sqlstokprofil = "DELETE FROM tblstokprofil where toplamAdet = '$hurdaAdet' AND gelisAmaci = 'kesim' AND siparis = '$satirNo'";
    mysqli_query($db, $sqlstokprofil);


    $sqlsiparis = "UPDATE tblsiparis set
                        konum = 'baski'
                    where id = '$siparisId'";

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
    $aciklama = $_POST['aciklama'];
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
    netAdet = '$netAdet',
    sepet1Adet = '$sepet1Adet',
    sepet2Adet = '$sepet2Adet',
    sepet3Adet = '$sepet3Adet'
    where id = '$kesimId'";


    $sqlHurda = "UPDATE tblhurda set
    adet = '$hurdaAdet',
    aciklama = '$aciklama',
    operatorId = '$operatorId'
    where kesimId = '$kesimId'";

    mysqli_query($db, $sqlHurda);


    $guncelGr = tablogetir('tblbaski', 'id', $baskiId, $db)['guncelGr'];
    $adet = -1 * ($hurdaAdet);
    $kilo = $adet * $guncelGr * $kesilenBoy;


    $sqlprofilrow = "select * from tblstokprofil where profilId = '0'
                              and gelisAmaci = 'kesim' 
                              and toplamAdet = '$eskiHurdaAdet' 
                              and siparis = '$satirNo' LIMIT 1";
    $profil = mysqli_query($db, $sqlprofilrow)->fetch_assoc();
    $profilId = $profil['id'];


    $sqlstokprofil = "UPDATE tblstokprofil set
    toplamKg = '$kilo',
    toplamAdet = '$adet'                    
    where id = '$profilId'";
    mysqli_query($db, $sqlstokprofil);

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