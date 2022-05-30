<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['termikekle'])) {

    $sepetler = $_POST['sepetler'];
    $baslaOperator = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $sepetTermik = "";
    $baskilar = "";
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaTarih = date("d.m.Y H:i");

    for ($i = 0; $i < count($sepetler); $i++) {
        $sepetId = trim($sepetler[$i]);
        $sepetTermik = $sepetTermik . $sepetId . ",";
        $baskilar = $baskilar . trim(tablogetir('tblsepet', 'id', $sepetId, $db)['icindekiler']) . ";";
    }


    $baskilar = str_replace(";;", ";", $baskilar);
    $baskilar = rtrim($baskilar, ";");
    $sepetTermik = rtrim($sepetTermik, ",");

    $sqlSepetUpdate = "Update tblsepet set isTermik = 1 where id in($sepetTermik)";

    mysqli_query($db, $sqlSepetUpdate);


    $sepetTermik = str_replace(",", ";", $sepetTermik);
    $sqlTermik = "Insert Into tbltermik (baslaOperator,sepetler,baskilar,baslaVardiya, baslaTarih) VALUES ('$baslaOperator', '$sepetTermik', '$baskilar','$baslaVardiya', '$baslaTarih')";


    if (mysqli_query($db, $sqlTermik)) {
        header("Location:../../termik/?durumekle=ok");
        exit();
    } else {
        header("Location:../../termik/?durumekle=no");
        exit();
    }

}

if (isset($_GET['termiksil'])) {

    $id = $_GET['termiksil'];
    $sepetler = tablogetir('tbltermik', 'id', $id, $db)['sepetler'];
    $sepetler = str_replace(";", ",", $sepetler);

    $sqlSepetUpdate = "Update tblsepet set isTermik = 0 where id in($sepetler)";
    mysqli_query($db, $sqlSepetUpdate);


    $sql = deleteRow('tbltermik', $id);
    if (mysqli_query($db, $sql)) {
        header("Location:../../termik/?durumsil=ok");
        exit();
    } else {
        header("Location:../../termik/?durumsil=no");
        exit();
    }
}

if (isset($_POST['termikbitir'])) {

    $termikId = $_POST['id'];
    $bitisOperator = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $bitisVardiya = vardiyaBul($vardiya, date("H:i"));
    $bitisTarih = date("d.m.Y H:i");


    $baskilar = explode(",", $_POST['baskilar']);
    $tur = explode(",", $_POST['tur']);

    for ($i = 0; $i < count($baskilar); $i++) {
        $baskiId = trim($baskilar[$i]);
        $termikSonuc = $_POST['baski' . $baskiId];
        $termikIds = tablogetir("tblbaski", 'id', $baskiId, $db)['termikId'];

        if ($termikIds != '0' && $termikIds != '-1') {
            $termikId = trim($termikId);
            $termikIds = $termikIds . ";" . $termikId;

            $sqlTermikUpdate = "UPDATE tblbaski set
                        termikSonuc = '$termikSonuc', termikId = '$termikIds'
                    where id = '$baskiId'";

        } else {

            $kromatIds = $termikId;

            $sqlTermikUpdate = "UPDATE tblbaski set
                        termikSonuc = '$termikSonuc', termikId = '$termikIds'
                    where id = '$baskiId'";
        }

        mysqli_query($db, $sqlTermikUpdate);
    }


    $sepetler = tablogetir('tbltermik', 'id', $termikId, $db)['sepetler'];
    $sepetler = str_replace(";", ",", $sepetler);


    // durum 2 olduğunda termik işlemi bitirildi.
    $sqlSepetUpdate = "Update tblsepet set isTermik = 0, durum = 2 where id in($sepetler)";
    mysqli_query($db, $sqlSepetUpdate);


    $sqlUpdateTermik = "UPDATE tbltermik set bitisTarih = '$bitisTarih', bitisOperator = '$bitisOperator', bitisVardiya = '$bitisVardiya'  where  id = '$termikId'";

    if (mysqli_query($db, $sqlUpdateTermik)) {
        header("Location:../../termik/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../termik/?durumguncelleme=no");
        exit();
    }
    exit();

}


?>