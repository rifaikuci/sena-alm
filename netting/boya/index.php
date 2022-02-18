<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['boyabaslat'])) {

    $maxAdet = $_POST['maxAdet'];
    $sepetId = $_POST['sepetId'];
    $satirNo = $_POST['satirNo'];
    $kesimId = $_POST['kesimId'];
    $baskiId = $_POST['baskiId'];
    $profilId = $_POST['profilId'];
    $oran = $_POST['oran'];
    $ortAskiAdet = $_POST['ortAskiAdet'];
    $netBoya = $_POST['netBoya'];
    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $askiId = $_POST['askiId'];
    $firinSicaklik = $_POST['firinSicaklik'];
    $kurlenmeDakikasi = $_POST['kurlenmeDakikasi'];
    $boyaId = $_POST['boyaId'];
    $kullanilanBoya = $_POST['kullanilanBoya'];
    $siklonId = $_POST['siklonId'] ? $_POST['siklonId'] : 0;
    $siklonKullanilanKg = $_POST['siklonKullanilanKg'];
    $siklonAyrilanKg = $_POST['siklonAyrilanKg'];
    $topAski = $_POST['topAski'];
    $topAdet = $_POST['topAdet'];
    $altSebep = $_POST['altSebep'];
    $rutusId = $_POST['rutusId'] ? $_POST['rutusId'] : 0;
    $hurdaAdet = $_POST['hurdaAdet'];
    $hurdaSebep = $_POST['hurdaSebep'];
    $rutusAdet = $_POST['rutusAdet'];
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaZaman = date("d.m.Y H:i");


    $sepetGetir = tablogetir('tblsepet', 'id', $sepetId, $db);
    $icindekiler = rtrim($sepetGetir['icindekiler'], ";");
    $arrayIcinde = explode(";", $icindekiler);

    $adetlerGetir = rtrim($sepetGetir['adetler'], ";");
    $arrayAdet = explode(";", $adetlerGetir);
    $key = array_search($kesimId, $arrayIcinde);

    $adet = $arrayAdet[$key] - $topAdet - $hurdaAdet;

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


    // stok profil ve hurda
    if ($hurdaAdet > 0) {
        $geciciAdet = -1 * ($hurdaAdet);
        $sqlprofil = "INSERT INTO tblstokprofil (toplamAdet, gelisAmaci,siparis) 
                VALUES ( '$geciciAdet', 'boya', '$satirNo')";
       mysqli_query($db, $sqlprofil);

        $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'boya', '$kesimId')";
     mysqli_query($db, $sqlHurda);
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


    $sqlBoya = "INSERT INTO tblboya  (
                        sepetId,
                        rutusAdet,
                        netBoya,
                        ortAskiAdet,
                        topAski,
                        rutusId,
                        siklonId,
                        kullanilanBoya,
                        oran,
                        siklonAyrilanKg,
                        hurdaAdet,
                        maxAdet,
                        hurdaSebep,
                        altSebep,
                        baslaOperator,
                        baslaVardiya,
                        baslaZaman,
                        topAdet,
                        kesimId,
                        siklonKullanilanKg,
                        boyaId,
                        askiId,
                        firinSicaklik,
                        kurlenmeDakikasi)
                   VALUES  (
                        '$sepetId',
                        '$rutusAdet',
                        '$netBoya',
                        '$ortAskiAdet',
                        '$topAski',
                        '$rutusId',
                        '$siklonId',
                        '$kullanilanBoya',
                        '$oran',
                        '$siklonAyrilanKg',
                        '$hurdaAdet',
                        '$maxAdet',
                        '$hurdaSebep',
                        '$altSebep',
                        '$operatorId',
                        '$baslaVardiya',
                        '$baslaZaman',
                        '$topAdet',
                        '$kesimId',
                        '$siklonKullanilanKg',
                        '$boyaId',
                        '$askiId',
                        '$firinSicaklik',
                        '$kurlenmeDakikasi'
    
                   )";
    if (mysqli_query($db, $sqlBoya)) {
        header("Location:../../boya/?durumekle=ok");
        exit();
    } else {
        header("Location:../../boya/?durumekle=no");
        exit();
    }

}