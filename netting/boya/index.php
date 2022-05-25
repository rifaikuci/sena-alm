<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['boyabaslat'])) {

    $ortAskiAdet = $_POST['ortAskiAdet'];
    $netBoya = $_POST['netBoya'];
    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $askiId = $_POST['askiId'];
    $boyaId = $_POST['boyaId'];
    $kullanilanBoya = $_POST['kullanilanBoya'];
    $siklonId = $_POST['siklonId'] ? $_POST['siklonId'] : 0;
    $siklonKullanilanKg = $_POST['siklonKullanilanKg'];
    $siklonAyrilanKg = $_POST['siklonAyrilanKg'];
    $topAski = $_POST['topAski'];
    $topAdet = $_POST['topAdet'];
    $rutusId = $_POST['rutusId'] ? $_POST['rutusId'] : 0;
    $rutusAdet = $_POST['rutusAdet'] != "" ? $_POST['rutusAdet'] : 0  ;
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaZaman = date("d.m.Y H:i");

    $array = explode(',',$_POST['array']);
    $arraySepetId = explode(',',$_POST['arraySepetId']);
    $arraySatirNo = explode(',',$_POST['arraySatirNo']);
    $arrayBaskiId = explode(',',$_POST['arrayBaskiId']);
    $arrayProfilId = explode(',',$_POST['arrayProfilId']);
    $arrayAdet = explode(',',$_POST['arrayAdet']);
    $arrayHurdaAdet = explode(',',$_POST['arrayHurdaAdet']);
    $arrayHurdaSebep = explode(',',$_POST['arrayHurdaSebep']);

    $arrays = '';
    $sepetIds = '';
    $satirNos = '';
    $baskiIds = '';
    $profilIds = '';
    $adets = '';
    $hurdaAdets = '';
    $hurdaSebeps = '';

    for($i = 0; $i <count($arraySepetId); $i++ ) {

        $arrays = $arrays . $array[$i] . ";";
        $sepetIds = $sepetIds . $arraySepetId[$i] . ";";
        $satirNos = $satirNos . $arraySatirNo[$i] . ";";
        $baskiIds = $baskiIds . $arrayBaskiId[$i] . ";";
        $profilIds = $profilIds . $arrayProfilId[$i] . ";";
        $adets = $adets . $arrayAdet[$i] . ";";
        $hurdaAdets = $hurdaAdets . $arrayHurdaAdet[$i] . ";";
        $hurdaSebeps = $hurdaSebeps . $arrayHurdaSebep[$i] . ";";


        $sepetId = $arraySepetId[$i];
        $satirNo = $arraySatirNo[$i];
        $baskiId = $arrayBaskiId[$i];
        $profilId = $arrayProfilId[$i];
        $adet = $arrayAdet[$i];
        $hurdaAdet = $arrayHurdaAdet[$i];
        $hurdaSebep = $arrayHurdaSebep[$i];

        $sepetGetir = tablogetir('tblsepet', 'id', $sepetId, $db);
        $icindekiler = rtrim($sepetGetir['icindekiler'], ";");
        $arrayIcinde = explode(";", $icindekiler);

        $adetlerGetir = rtrim($sepetGetir['adetler'], ";");
        $arrayAdetSepet = explode(";", $adetlerGetir);
        $key = array_search($baskiId, $arrayIcinde);

        $adetKalan = $arrayAdetSepet[$key] - $adet - $hurdaAdet;

        $adetTablo = "";
        $icindeTablo = "";

        if ($adetKalan <= 0) {
            $arrayAdetSepet[$key] = "bitti";
            $arrayIcinde[$key] = "bitti";
        } else {
            $arrayAdetSepet[$key] = $adetKalan;
        }

        for ($j = 0; $j < count($arrayAdetSepet); $j++) {
            $adetTablo = $adetTablo . "" . $arrayAdetSepet[$j] . ";";
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


        // stok profil ve hurda
        if ($hurdaAdet > 0) {
            $geciciAdet = -1 * ($hurdaAdet);
            $kilo = kiloBul($baskiId, $hurdaAdet, $db);

            $kiloStok = -1 * $kilo;
            $kiloHurda = $kilo;

            $sqlprofil = "INSERT INTO tblstokprofil (adet, geldigiYer,baskiId, kilo) 
                VALUES ( '$geciciAdet', 'boya', '$baskiId', '$kiloStok')";
            mysqli_query($db, $sqlprofil);

            $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kilo) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'boya', '$kiloHurda')";
            mysqli_query($db, $sqlHurda);
        }

    }



    // siklon tablosuna kayıt eklenmesi
    if ($siklonAyrilanKg > 0) {
        $sqlSiklon = "INSERT INTO tblsiklon (kilo, kalan,boyaId) 
                VALUES ( '$siklonAyrilanKg', '$siklonAyrilanKg', '$boyaId')";
       mysqli_query($db, $sqlSiklon);
    }

    // boyanın düşürülmesi
    if ($kullanilanBoya > 0) {
        $boyaKalan = tablogetir('tblstokboya', 'id', $boyaId, $db)['kalan'];
        $kalan = $boyaKalan - $kullanilanBoya;

        $sqlstokboya = "UPDATE tblstokboya set
                        kalan = '$kalan'
                    where id = '$boyaId'";
        mysqli_query($db, $sqlstokboya);
    }

    // rutus düşürülmesi
    if ($rutusId > 0 && $rutusAdet > 0) {
        $sqlrutusAyrilanKalan = tablogetir('tblrutusprofil', 'id', $rutusId, $db)['kalan'];
        $kalan = $sqlrutusAyrilanKalan - $rutusAdet;

        $sqlRutusAyrilan = "UPDATE tblrutusprofil set
                        kalan = '$kalan'
                    where id = '$rutusId'";
        mysqli_query($db, $sqlRutusAyrilan);
    }


    // siklon boya düşürülmesi
    if ($siklonId > 0 && $siklonKullanilanKg > 0) {
        $siklonKalan = tablogetir('tblsiklon', 'id', $siklonId, $db)['kalan'];
        $kalan = $siklonKalan - $siklonKullanilanKg;

        $sqlisiklon = "UPDATE tblsiklon set
                        kalan = '$kalan'
                    where id = '$siklonId'";
        mysqli_query($db, $sqlisiklon);
    }

    $sepetIds = rtrim($sepetIds, ";");
    $baskiIds = rtrim($baskiIds, ";");
    $adets = rtrim($adets, ";");
    $hurdaAdets = rtrim($hurdaAdets, ";");
    $hurdaSebeps = rtrim($hurdaSebeps, ";");

    $sqlBoya = "INSERT INTO tblboya  (
                        sepetler,
                        baskilar,
                        adetler,
                        hurdaAdetler,
                        hurdaSebepler,
                        rutusAdet,
                        netBoya,
                        ortAskiAdet,
                        topAski,
                        rutusId,
                        siklonId,
                        kullanilanBoya,
                        siklonAyrilanKg,
                        baslaOperator,
                        baslaVardiya,
                        baslaZaman,
                        topAdet,
                        siklonKullanilanKg,
                        boyaId,
                        askiId)
                   VALUES  (
                        '$sepetIds',
                        '$baskiIds',
                        '$adets',
                        '$hurdaAdets',
                        '$hurdaSebeps',
                        '$rutusAdet',
                        '$netBoya',
                        '$ortAskiAdet',
                        '$topAski',
                        '$rutusId',
                        '$siklonId',
                        '$kullanilanBoya',
                        '$siklonAyrilanKg',
                        '$operatorId',
                        '$baslaVardiya',
                        '$baslaZaman',
                        '$topAdet',
                        '$siklonKullanilanKg',
                        '$boyaId',
                        '$askiId'
                   )";

    mysqli_query($db, $sqlBoya);
    $id = mysqli_insert_id($db);


    $boyaIds = tablogetir("tblbaski", 'id', $baskiId, $db)['boyaId'];

    if ($boyaIds != '0' && $boyaIds != '-1') {
        $boyaIds = $boyaIds . ";" . $id;

        $sqlBaski = "UPDATE tblbaski set
                        boyaId = '$boyaIds'
                    where id = '$baskiId'";

    } else {

        $boyaIds = $id;

        $sqlBaski = "UPDATE tblbaski set
                        boyaId = '$boyaIds'
                    where id = '$baskiId'";
    }


    if (mysqli_query($db, $sqlBaski)) {
        header("Location:../../boya/?durumekle=ok");
        exit();
    } else {
        header("Location:../../boya/?durumekle=no");
        exit();
    }

}