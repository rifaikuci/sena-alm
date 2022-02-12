<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['firinlamaekle'])) {

    $boyalar = $_POST['ids'];
    $baslaOperator = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaTarih = date("d.m.Y H:i");

    $sqlFirinlama = "Insert Into tblfirinlama (baslaOperator,boyalar,baslaVardiya, baslaTarih) 
                        VALUES 
                    ( '$baslaOperator', '$boyalar','$baslaVardiya', '$baslaTarih')";

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