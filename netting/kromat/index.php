
<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

if (isset($_POST['kromatbaslat'])) {

    $sepetler = isset($_POST['arraysepet']) ? $_POST['arraysepet'] : [];
    $baskilar = isset($_POST['arraybaski']) ? $_POST['arraybaski'] : [];
    $adetler = isset($_POST['arrayadet']) ? $_POST['arrayadet'] : [];
    $hurdalar = isset($_POST['arrayhurda']) ? $_POST['arrayhurda'] : [];
    $sebepler = isset($_POST['arraysebep']) ? $_POST['arraysebep'] : [];
    $kromatsepet = isset($_POST['kromatSepet']) ? $_POST['kromatSepet'] : 0;

    $sepetler = explode(",", $sepetler[0]);
    $baskilar = explode(",", $baskilar[0]);
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
        if ($adetler[$j] != "" && $adetler[$j] > 0) {
            $kromatAdetler = $kromatAdetler . "" . $adetler[$j] . ";";
        }

        if ($baskilar[$j] != "" || $baskilar[$j] > 0) {
            $kromatIcındekiler = $kromatIcındekiler . "" . $baskilar[$j] . ";";
        }

        if ($hurdalar[$j] != "" || $hurdalar[$j] > 0) {
            $kromatHurdalar = $kromatHurdalar . "" . $hurdalar[$j] . ";";
            $kromatSebepler = $kromatSebepler . "" . $sebepler[$j] . ";";
        }

        if ($sepetler[$j] != "" && $sepetler[$j] > 0) {
            $kromatSepetler = $kromatSepetler . "" . $sepetler[$j] . ";";
        }

    }



    $sqlSepetKromat = "UPDATE tblsepet set
                        icindekiler = '$kromatIcındekiler',
                        adetler = '$kromatAdetler',
                        durum = '1'
                    where id = '$kromatsepet'";
    mysqli_query($db, $sqlSepetKromat);


    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] != "" ? $_POST['operatorId'] : 0;

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

        $key = array_search($baskilar[$i], $arrayIcinde);

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

        $baskiId = $baskilar[$i];

        if ($hurdalar[$i] != "" && 0 < $hurdalar[$i]) {
            $hurdaStok = -1 * ($hurdalar[$i]);
            $kilo = kiloBul($baskiId, $hurdalar[$i],$db);

            $kiloStok = -1 * $kilo;
            $kiloHurda = $kilo;

            $kiloHurda = $kiloHurda / 1000000;
            $kiloHurda = sayiFormatla($kiloHurda);
            $kiloStok  = $kiloStok / 1000000;
            $kiloStok = sayiFormatla($kiloStok);
            $sqlprofil = "INSERT INTO tblstokprofil ( adet, geldigiYer, baskiId, kilo) 
                VALUES ('$hurdaStok', 'kromat', '$baskiId', '$kiloStok')";

            mysqli_query($db, $sqlprofil);
            $sebep = $sebepler[$i];
            $sqlHurda = "INSERT INTO tblhurda ( aciklama,operatorId, geldigiYer, baskiId, adet, kilo ) 
                VALUES ( '$sebep', '$operatorId', 'kromat', '$baskiId', '$hurdalar[$i]', '$kiloHurda')";
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

if (isset($_POST['kromatbitir'])) {
    $id = $_POST['kromatbitir'];

    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $bitisVardiya = vardiyaBul($vardiya, date("H:i"));
    $zaman = date("Y-m-d H:i:s");
    $sepetId = isset($_POST['sepetId']) ? $_POST['sepetId'] : "";
    $baskilarTemp = tablogetir("tblsepet", 'id', $sepetId, $db)['icindekiler'];
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
    // burada yapılan işlemde kromatId 'leri baskı tarfını gönderdik bu şekilkde baskının geçmişi buradan takip edilecek...
    for ($i = 0; $i < $uzunluk; $i++) {

        $baskiId = $baskilar[$i];
        $kromatIds = tablogetir("tblbaski", 'id', $baskiId, $db)['kromatId'];

        if ($kromatIds != '0' && $kromatIds != '-1') {
            $kromatIds = $kromatIds . ";" . $id;

            $sqlBaski = "UPDATE tblbaski set
                        kromatId = '$kromatIds'
                    where id = '$baskiId'";

        } else {

            $kromatIds = $id;

            $sqlBaski = "UPDATE tblbaski set
                        kromatId = '$kromatIds'
                    where id = '$baskiId'";
        }
        mysqli_query($db, $sqlBaski);
    }

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