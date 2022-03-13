<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['paketbaslat'])) {

    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $hurdaAdet = $_POST['hurdaAdet'];
    $hurdaSebep = $_POST['hurdaSebep'];
    $netAdet = $_POST['netAdet'];
    $sepetId = $_POST['sepetId'];
    $baskiId = $_POST['baskiId'];
    $profilId = $_POST['profilId'];
    $satirNo = $_POST['satirNo'];
    $sepetAlinanAdet = $_POST['sepetAlinanAdet'];
    $naylonDurum = tablogetir('tblsiparis', 'satirNo',$satirNo, $db)['naylonDurum'];

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiya = vardiyaBul($vardiya, date("H:i"));
    $zaman = date("d.m.Y H:i");


    $sepetGetir = tablogetir('tblsepet', 'id', $sepetId, $db);
    $icindekiler = rtrim($sepetGetir['icindekiler'], ";");
    $arrayIcinde = explode(";", $icindekiler);

    $adetlerGetir = rtrim($sepetGetir['adetler'], ";");
    $arrayAdet = explode(";", $adetlerGetir);
    $key = array_search($baskiId, $arrayIcinde);

    $adet = $arrayAdet[$key] - $sepetAlinanAdet ;

    if ($adet <= 0) {
        $arrayAdet[$key] = "bitti";
        $arrayIcinde[$key] = "bitti";
    } else {
        $arrayAdet[$key] = $adet;
    }

    for ($j = 0; $j < count($arrayAdet); $j++) {
        $adetTablo = $adetTablo . "" . $arrayAdet[$j] . ";";
        $icindeTablo = $icindeTablo . "" . $arrayIcinde[$j] . ";";
    }

    $adetTablo = str_replace("bitti;", "", $adetTablo);
    $icindeTablo = str_replace("bitti;", "", $icindeTablo);


    if ($adetTablo == "") {
        $sqlSepet = "UPDATE tblsepet set
                        icindekiler = null ,
                        adetler = null ,
                        durum = '0',
                        isTermik = '0'
                    where id = '$sepetId'";


        mysqli_query($db, $sqlSepet);
    } else {
        $sqlSepet = "UPDATE tblsepet set
                        icindekiler = '$icindeTablo',
                        adetler = '$adetTablo',
                        isTermik = '0'
                    where id = '$sepetId'";
        mysqli_query($db, $sqlSepet);
    }

    $sqlSepet = "UPDATE tblsepet set
                        icindekiler = '$icindeTablo',
                        adetler = '$adetTablo',
                        isTermik = '0'
                    where id = '$sepetId'";
    mysqli_query($db, $sqlSepet);

    if ($hurdaAdet > 0) {
        $geciciAdet = -1 * ($hurdaAdet);

        $kilo = kiloBul($baskiId, $hurdaAdet,$db);

        $kiloStok = -1 * $kilo;
        $kiloHurda = $kilo;

        $sqlprofil = "INSERT INTO tblstokprofil (adet, geldigiYer,baskiId, operatorId, kilo) 
                VALUES ( '$geciciAdet', 'paket', '$baskiId', '$operatorId', '$kiloStok')";
        mysqli_query($db, $sqlprofil);

        $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId, geldigiYer, baskiId, kilo) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId', 'paket', '$baskiId', '$kiloHurda')";
        mysqli_query($db, $sqlHurda);
    }

    $sqlpaket = "INSERT INTO tblpaket  (
                        baskiId,
                        hurdaAdet,
                        hurdaSebep,
                        netAdet,
                        zaman,
                        vardiya,
                        naylonDurum,
                        sepetAlinanAdet,
                        operatorId)
                   VALUES  (
                        '$baskiId',
                        '$hurdaAdet',
                        '$hurdaSebep',
                        '$netAdet',
                        '$zaman',
                        '$vardiya',
                        '$naylonDurum',
                        '$sepetAlinanAdet',
                        '$operatorId'
    
                   )";

    mysqli_query($db, $sqlpaket);
    $id = mysqli_insert_id($db);


    $baski = tablogetir("tblbaski", 'id', $baskiId, $db);
    $paketIds = $baski['paketId'];

    if ($paketIds != '0' && $paketIds != '-1') {
        $paketIds = $paketIds . ";" . $id;

        $sqlBaski = "UPDATE tblbaski set
                        paketId = '$paketIds'
                    where id = '$baskiId'";

    } else {

        $paketIds = $id;

        $sqlBaski = "UPDATE tblbaski set
                        paketId = '$paketIds'
                    where id = '$baskiId'";
    }

    // eğer statü bittiyse anbara ekle

    if($baski['naylonId'] == "-1") {
        $anbar = tablogetir("tblanbar", 'baskiId', $baskiId, $db);
        $anbar = $anbar ? $anbar : 0;

        if($anbar != 0) {
            $adet = $netAdet + $anbar['adet'];
            $kalanAdet = $netAdet + $anbar['kalanAdet'];

            $sqlAnbar = "UPDATE tblanbar set
                        kalanAdet = '$kalanAdet',
                        adet = '$adet'
                    where id = '$baskiId'";
        }
        else {

            $sqlAnbar = "INSERT INTO tblanbar  (
                        baskiId,
                        adet,
                        kalanAdet)
                   VALUES  (
                        '$baskiId',
                        '$netAdet',
                        '$netAdet'
    
                   )";
        }
        mysqli_query($db, $sqlAnbar);

        $id = mysqli_insert_id($db);

        $baski = tablogetir("tblbaski", 'id', $baskiId, $db);
        $anbarIds = $baski['anbarId'];

        if ($anbarIds != '0' && $anbarIds != '-1') {
            $anbarIds = $anbarIds . ";" . $id;

            $sqlBaski2 = "UPDATE tblbaski set
                        anbarId = '$anbarIds'
                    where id = '$baskiId'";

        } else {

            $anbarIds = $id;

            $sqlBaski2 = "UPDATE tblbaski set
                        anbarId = '$anbarIds'
                    where id = '$baskiId'";
        }

        mysqli_query($db, $sqlBaski2);
    }

    if (mysqli_query($db, $sqlBaski)) {
        header("Location:../../paket/?durumekle=ok");
        exit();
    } else {
        header("Location:../../paket/?durumekle=no");
        exit();
    }
}

if (isset($_GET['paketsil'])) {

    $id = $_GET['paketsil'];

    $paket = tablogetir("tblpaket", 'id', $id, $db);
    $satirNo = $paket['satirNo'];
    $adet = $paket['hurdaAdet'];
    $aciklama = $paket['hurdaSebep'];
    $rutusAdet = $paket['rutusAdet'];
    $rutusSebep = $paket['rutusSebep'];
    $operatorId = $paket['operatorId'];
    $boyaId = $paket['boyaId'];
    $geciciAdet = -1 * $adet;


    #TODO kapatıldı olmaması daha iyi olur
    /*
    $sqlprofil = "DELETE FROM tblstokprofil where toplamAdet = '$geciciAdet' AND gelisAmaci = 'paket' AND siparis = '$satirNo'  ";
    mysqli_query($db, $sqlprofil);

    $sqlHurda = "DELETE FROM tblhurda where adet = '$adet' AND aciklama = '$aciklama'
                       AND  geldigiYer = 'paket' AND operatorId = '$operatorId'  ";
    mysqli_query($db, $sqlHurda);



    $sqlRutus = "DELETE FROM tblrutusprofil where adet = '$rutusAdet' AND sebep = '$rutusSebep' ";
    mysqli_query($db, $sqlRutus);
    */

    $sqlboya = "UPDATE tblboya set
                     isPaket = '0'
                    where id = '$boyaId'";
    mysqli_query($db, $sqlboya);


    $sqlpaket = "DELETE FROM tblpaket where id = '$id' ";

    if (mysqli_query($db, $sqlpaket)) {
        header("Location:../../paket/?durumsil=ok");
        exit();
    } else {
        header("Location:../../paket/?durumsil=no");
        exit();
    }

}