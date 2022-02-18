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
    $kesimId = $_POST['kesimId'];
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
        $sqlprofil = "INSERT INTO tblstokprofil (toplamAdet, gelisAmaci,siparis) 
                VALUES ( '$geciciAdet', 'boyapaket', '$satirNo')";
        mysqli_query($db, $sqlprofil);

        $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'boyapaket', '$kesimId')";
        mysqli_query($db, $sqlHurda);
    }

    if ($rutusAdet > 0) {
        $sqlrutusprofil = "INSERT INTO tblrutusprofil (adet,kalan,sebep,profilId) 
                VALUES ( '$rutusAdet', '$rutusAdet', '$rutusSebep', '$profilId')";
        mysqli_query($db, $sqlrutusprofil);
    }


    $sqlboya = "UPDATE tblboya set
                     isPaket = '1'
                    where id = '$boyaId'";
    mysqli_query($db, $sqlboya);
    $sqlboyapaket = "INSERT INTO tblboyapaket  (
                        boyaId,
                        kesimId,
                        hurdaAdet,
                        hurdaSebep,
                        netAdet,
                        satirNo,
                        rutusAdet,
                        rutusSebep,
                        zaman,
                        vardiya,
                        naylonDurum,
                        operatorId)
                   VALUES  (
                        '$boyaId',
                        '$kesimId',
                        '$hurdaAdet',
                        '$hurdaSebep',
                        '$netAdet',
                        '$satirNo',
                        '$rutusAdet',
                        '$rutusSebep',
                        '$zaman',
                        '$vardiya',
                        '$naylonDurum',
                        '$operatorId'
    
                   )";

    if (mysqli_query($db, $sqlboyapaket)) {
        header("Location:../../boyapaket/?durumekle=ok");
        exit();
    } else {
        header("Location:../../boyapaket/?durumekle=no");
        exit();
    }

}

if (isset($_GET['boyapaketsil'])) {

    $id = $_GET['boyapaketsil'];

    $boyapaket = tablogetir("tblboyapaket", 'id', $id, $db);
    $satirNo = $boyapaket['satirNo'];
    $adet = $boyapaket['hurdaAdet'];
    $aciklama = $boyapaket['hurdaSebep'];
    $rutusAdet = $boyapaket['rutusAdet'];
    $rutusSebep = $boyapaket['rutusSebep'];
    $operatorId = $boyapaket['operatorId'];
    $boyaId = $boyapaket['boyaId'];
    $geciciAdet = -1 * $adet;

    $sqlprofil = "DELETE FROM tblstokprofil where toplamAdet = '$geciciAdet' AND gelisAmaci = 'boyapaket' AND siparis = '$satirNo'  ";
    mysqli_query($db, $sqlprofil);

    $sqlHurda = "DELETE FROM tblhurda where adet = '$adet' AND aciklama = '$aciklama'
                       AND  geldigiYer = 'boyapaket' AND operatorId = '$operatorId'  ";
    mysqli_query($db, $sqlHurda);



    $sqlRutus = "DELETE FROM tblrutusprofil where adet = '$rutusAdet' AND sebep = '$rutusSebep' ";
    mysqli_query($db, $sqlRutus);

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