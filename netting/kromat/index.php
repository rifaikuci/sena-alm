<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);


if (isset($_POST['kromatbaslat'])) {

    $sepetler = isset($_POST['arraysepet']) ? $_POST['arraysepet'] : []; // sepetler
    $kesimler = isset($_POST['arraykesim']) ? $_POST['arraykesim'] : []; // sepetler
    $adetler = isset($_POST['arrayadet']) ? $_POST['arrayadet'] : []; // sepetler
    $hurdalar = isset($_POST['arrayhurda']) ? $_POST['arrayhurda'] : []; // sepetler
    $sebepler = isset($_POST['arraysebep']) ? $_POST['arraysebep'] : []; // sepetler
    $kromatsepet = isset($_POST['kromatSepet']) ? $_POST['kromatSepet'] : 0;




    $sepetler = explode(",", $sepetler[0]);
    $kesimler = explode(",", $kesimler[0]);
    $adetler = explode(",", $adetler[0]);
    $hurdalar = explode(",", $hurdalar[0]);
    $sebepler = explode(",", $sebepler[0]);
    $uzunluk = count($sepetler);

    $kromatAdetler = "";
    $kromatHurdalar = "";
    $kromatSebepler = "";
    $kromatSepetler = "";
    $kromatIcındekiler = "";
    for ($j = 0; $j < count($adetler); $j++) {
        $kromatAdetler = $kromatAdetler . "" . $adetler[$j] . ";";
        $kromatIcındekiler = $kromatIcındekiler . "" . $kesimler[$j] . ";";
        $kromatSebepler = $kromatSebepler . "" . $sebepler[$j] . ";";
        $kromatHurdalar = $kromatHurdalar . "" . $hurdalar[$j] . ";";
        $kromatSepetler = $kromatSepetler . "" . $sepetler[$j] . ";";
    }


    $sqlSepetKromat = "UPDATE tblsepet set
                        icindekiler = '$kromatIcındekiler',
                        adetler = '$kromatAdetler',
                        durum = '1'
                    where id = '$kromatsepet'";
    mysqli_query($db, $sqlSepetKromat);


    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $asitHavuz = tablogetir("tblhavuz", "id", '1', $db)['logHavuzId'];
    $kromatHavuz = tablogetir("tblhavuz", "id", '2', $db)['logHavuzId'];


    for ($i = 0; $i < $uzunluk; $i++) {

        $sepetGetir = tablogetir('tblsepet', 'id', $sepetler[$i], $db);
        $icindekiler = rtrim($sepetGetir['icindekiler'], ";");
        $arrayIcinde = explode(";", $icindekiler);

        $adetlerGetir = rtrim($sepetGetir['adetler'], ";");
        $arrayAdet = explode(";", $adetlerGetir);

        $key = array_search($kesimler[$i], $arrayIcinde);

        $adet = $arrayAdet[$key] - $adetler[$i] - $hurdalar[$i];

        if ($adet <= 0) {
            $arrayAdet[$key] = "bitti";
            $arrayIcinde[$key] = "bitti";
        } else {
            $arrayAdet[$key] = $adet;
        }

        $adetTablo = "";
        $icindeTablo = "";

        for ($j = 0; $j < count($arrayAdet); $j++) {
            $adetTablo = $adetTablo . "" . $arrayAdet[$j] . ";";
            $icindeTablo = $icindeTablo . "" . $arrayIcinde[$j] . ";";
        }

        $adetTablo = str_replace("bitti;", "", $adetTablo);
        $icindeTablo = str_replace("bitti;", "", $icindeTablo);

        $kesimId = $kesimler[$i];
        $baskiId = tablogetir("tblkesim", 'id', $kesimler[$i], $db)['baskiId'];
        $siparisId = tablogetir('tblbaski', 'id', $baskiId, $db)['siparisId'];
        $satirNo = tablogetir('tblsiparis', 'id', $siparisId, $db)['satirNo'];

        if ($hurdalar[$i] != "" && 0 <= $hurdalar[$i]) {
            $hurdaStok = -1 * ($hurdalar[$i]);
            $sqlprofil = "INSERT INTO tblstokprofil ( toplamAdet, gelisAmaci,siparis) 
                VALUES ('$hurdaStok', 'kromat', '$satirNo')";

           mysqli_query($db, $sqlprofil);

            $sebep = $sebepler[$i];
            $sqlHurda = "INSERT INTO tblhurda ( aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ( '$sebep', '$operatorId','$baskiId', 'kromat', '$kesimId')";

            mysqli_query($db, $sqlHurda);

        }


        $sepetId = $sepetler[$i];

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
    }



    $zaman = date("Y-m-d H:i:s");

    $sqlKromat = "INSERT INTO tblkromat (baslaVardiya, baslaZaman, sepetId,havuzKromatId, havuzAsitId, adetler, hurdalar, sebepler, sepetler ) 
                VALUES ('$baslaVardiya','$zaman', '$kromatsepet', '$kromatHavuz', '$asitHavuz', '$kromatAdetler', '$kromatHurdalar', '$kromatSebepler', '$kromatSepetler')";
    if (mysqli_query($db, $sqlKromat)) {
        header("Location:../../kromat/?durumekle=ok");
        exit();
    } else {
        header("Location:../../kromat/?durumekle=no");
        exit();
    }

}

if(isset($_POST['kromatbitir'])) {
    $id = $_POST['kromatbitir'];

    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $bitisVardiya = vardiyaBul($vardiya, date("H:i"));
    $zaman = date("Y-m-d H:i:s");

    $sepetId = tablogetir('tblkromat', 'id', $id, $db)['sepetId'];

    $sqlsepet = "UPDATE tblsepet set
                     finishedKromat = '1'
                    where id = '$sepetId'";

    mysqli_query($db, $sqlsepet);

    $sqlKromat = "UPDATE tblkromat set
                        bitisVardiya = '$bitisVardiya',
                     bitisZaman = '$zaman'
                    where id = '$id'";
    if (mysqli_query($db, $sqlKromat)) {
        header("Location:../../kromat/?durumdevam=ok");
        exit();
    } else {
        header("Location:../../kromat/?durumdevam=no");
        exit();
    }
}


?>