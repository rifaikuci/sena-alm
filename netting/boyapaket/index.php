<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['boyapaketbaslat'])) {

    $boyaId = $_POST['boyaId'];
    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $hurdaAdet = $_POST['hurdaAdet'];
    $hurdaSebep = $_POST['hurdaSebep'];
    $netAdet = $_POST['netAdet'];
    $baskiId = $_POST['baskiId'];
    $profilId = $_POST['profilId'];
    $satirNo = $_POST['satirNo'];
    $rutusAdet = $_POST['rutusAdet'];
    $rutusSebep = $_POST['rutusSebep'];
    $naylonDurum = tablogetir('tblsiparis', 'satirNo',$satirNo, $db)['naylonDurum'];

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiya = vardiyaBul($vardiya, date("H:i"));
    $zaman = date("d.m.Y H:i");


    if ($hurdaAdet > 0) {
        $geciciAdet = -1 * ($hurdaAdet);
        $sqlprofil = "INSERT INTO tblstokprofil (adet, geldigiYer,baskiId, operatorId) 
                VALUES ( '$geciciAdet', 'boyapaket', '$baskiId', '$operatorId')";
        mysqli_query($db, $sqlprofil);

        $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'boyapaket')";
        mysqli_query($db, $sqlHurda);
    }

    if ($rutusAdet > 0) {
        $sqlrutusprofil = "INSERT INTO tblrutusprofil (adet,kalan,sebep,profilId, operatorId) 
                VALUES ( '$rutusAdet', '$rutusAdet', '$rutusSebep', '$profilId', '$operatorId')";
        mysqli_query($db, $sqlrutusprofil);
    }


    $sqlboya = "UPDATE tblboya set
                     isPaket = '1'
                    where id = '$boyaId'";
    mysqli_query($db, $sqlboya);

    $sqlboyapaket = "INSERT INTO tblboyapaket  (
                        boyaId,
                        baskiId,
                        hurdaAdet,
                        hurdaSebep,
                        netAdet,
                        rutusAdet,
                        rutusSebep,
                        zaman,
                        vardiya,
                        naylonDurum,
                        operatorId)
                   VALUES  (
                        '$boyaId',
                        '$baskiId',
                        '$hurdaAdet',
                        '$hurdaSebep',
                        '$netAdet',
                        '$rutusAdet',
                        '$rutusSebep',
                        '$zaman',
                        '$vardiya',
                        '$naylonDurum',
                        '$operatorId'
    
                   )";

    mysqli_query($db, $sqlboyapaket);
    $id = mysqli_insert_id($db);

    $boyaPaketIds = tablogetir("tblbaski", 'id', $baskiId, $db)['boyaPaketId'];

    if ($boyaPaketIds != '0' && $boyaPaketIds != '-1') {
        $boyaPaketIds = $boyaPaketIds . ";" . $id;

        $sqlBaski = "UPDATE tblbaski set
                        boyaPaketId = '$boyaPaketIds'
                    where id = '$baskiId'";

    } else {

        $boyaPaketIds = $id;

        $sqlBaski = "UPDATE tblbaski set
                        boyaPaketId = '$boyaPaketIds'
                    where id = '$baskiId'";
    }


    if (mysqli_query($db, $sqlBaski)) {
        header("Location:../../boyapaket/?durumekle=ok");
        exit();
    } else {
        header("Location:../../boyapaket/?durumekle=no");
        exit();
    }

}

#Kullanılmamasında fayda var
if (isset($_GET['boyapaketsil'])) {

    $id = $_GET['boyapaketsil'];

    $boyapaket = tablogetir("tblboyapaket", 'id', $id, $db);
    $adet = $boyapaket['hurdaAdet'];
    $aciklama = $boyapaket['hurdaSebep'];
    $rutusAdet = $boyapaket['rutusAdet'];
    $rutusSebep = $boyapaket['rutusSebep'];
    $operatorId = $boyapaket['operatorId'];
    $boyaId = $boyapaket['boyaId'];
    $geciciAdet = -1 * $adet;


    $sqlboya = "UPDATE tblboya set
                     isPaket = '0'
                    where id = '$boyaId'";
    mysqli_query($db, $sqlboya);


    $sqlboyapaket = "DELETE FROM tblboyapaket where id = '$id' ";

    if (mysqli_query($db, $sqlboyapaket)) {
        header("Location:../../boyapaket/?durumsil=ok");
        exit();
    } else {
        header("Location:../../boyapaket/?durumsil=no");
        exit();
    }

}