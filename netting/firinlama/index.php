<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['firinlamaekle'])) {

    $boyalar = $_POST['ids'];
    $baskilarTemp = $_POST['baskilar'];
    $firinSicaklik = $_POST['firinSicaklik'];
    $kurlenmeDakikasi = $_POST['kurlenmeDakikasi'];
    $baslaOperator = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaTarih = date("d.m.Y H:i");

    $baskilarTemp = rtrim($baskilarTemp, ';');




    $sqlFirinlama = "Insert Into tblfirinlama (baslaOperator,boyalar,baslaVardiya, baslaTarih, baskilar, firinSicaklik, kurlenmeDakikasi) 
                        VALUES 
                    ( '$baslaOperator', '$boyalar','$baslaVardiya', '$baslaTarih', '$baskilarTemp', '$firinSicaklik', '$kurlenmeDakikasi')";

    $boyaArrayreplace = str_replace(";", ",", $boyalar);

    $sqlboya = "UPDATE tblboya set
                     isFirin = '1'
                    where id in ($boyaArrayreplace)";

    mysqli_query($db, $sqlboya);

    if (mysqli_query($db, $sqlFirinlama)) {
        header("Location:../../firinlama/?durumekle=ok");
        exit();
    } else {
        header("Location:../../firinlama/?durumekle=no");
        exit();
    }


}

if ($_GET['firinlamabitir']) {



    $id = $_GET['firinlamabitir'];
    $bitisOperator = $_GET['operator'];
    $bitisTarih = date("d.m.Y H:i");

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $bitisVardiya = vardiyaBul($vardiya, date("H:i"));

    $sqlFirinlama = "UPDATE tblfirinlama set
                     bitisVardiya = '$bitisVardiya',
                     bitisOperator = '$bitisOperator',
                     bitisTarih = '$bitisTarih'
                    where id  = '$id'";


    $baskilarTemp = tablogetir("tblfirinlama", 'id', $id, $db)['baskilar'];

    $baskilarTemp = rtrim($baskilarTemp, ';');
    $baskilarTemp = explode(";", $baskilarTemp);
    $uzunluk = count($baskilarTemp);
    $baskilarTemp = array_unique($baskilarTemp);

    $baskilar = array();
    for($i = 0 ; $i<$uzunluk; $i++) {
        if($baskilarTemp[$i]) {
            array_push($baskilar,$baskilarTemp[$i]);
        }
    }

    for ($i = 0; $i < $uzunluk; $i++) {

        $baskiId = $baskilar[$i];
        $firinlamaIds = tablogetir("tblbaski", 'id', $baskiId, $db)['firinlamaId'];

        if ($firinlamaIds != '0' && $firinlamaIds != '-1') {
            $firinlamaIds = $firinlamaIds . ";" . $id;

            $sqlBaski = "UPDATE tblbaski set
                        firinlamaId = '$firinlamaIds'
                    where id = '$baskiId'";

        } else {

            $firinlamaIds = $id;

            $sqlBaski = "UPDATE tblbaski set
                        firinlamaId = '$firinlamaIds'
                    where id = '$baskiId'";
        }
        mysqli_query($db, $sqlBaski);
    }

    if (mysqli_query($db, $sqlFirinlama)) {
        header("Location:../../firinlama/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../firinlama/?durumguncelleme=no");
        exit();
    }
}

if (isset($_GET['firinlamasil'])) {
    $id = $_GET['firinlamasil'];
    $boyalar = tablogetir("tblfirinlama", 'id',$id,$db)['boyalar'];


    $boyaArrayreplace = str_replace(";", ",", $boyalar);

    $sqlboya = "UPDATE tblboya set
                     isFirin = '0'
                    where id in ($boyaArrayreplace)";
    mysqli_query($db, $sqlboya);

    $sql = "DELETE FROM tblfirinlama where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../firinlama/?durumsil=ok");
        exit();
    } else {
        header("Location:../../firinlama/?durumsil=no");
        exit();
    }
}

?>