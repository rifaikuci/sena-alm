<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['boyapaketbaslat'])) {

    $maxAdet = $_POST['maxAdet'];
    $sepetId = $_POST['sepetId'];
    $satirNo = $_POST['satirNo'];
    $kesimId = $_POST['kesimId'];
    $baskiId = $_POST['baskiId'];
    $profilId = $_POST['profilId'];
    $oran = $_POST['oran'];
    $ortAskiAdet = $_POST['ortAskiAdet'];
    $netboyapaket = $_POST['netboyapaket'];
    $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
    $askiId = $_POST['askiId'];
    $firinSicaklik = $_POST['firinSicaklik'];
    $kurlenmeDakikasi = $_POST['kurlenmeDakikasi'];
    $boyapaketId = $_POST['boyapaketId'];
    $kullanilanboyapaket = $_POST['kullanilanboyapaket'];
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


       // mysqli_query($db, $sqlSepet);
    } else {
        $sqlSepet = "UPDATE tblsepet set
                        icindekiler = '$icindeTablo',
                        adetler = '$adetTablo',
                        isTermik = '0'
                    where id = '$sepetId'";
    //    mysqli_query($db, $sqlSepet);
    }


    // stok profil ve hurda
    if ($hurdaAdet > 0) {
        $geciciAdet = -1 * ($hurdaAdet);
        $sqlprofil = "INSERT INTO tblstokprofil (toplamAdet, gelisAmaci,siparis) 
                VALUES ( '$geciciAdet', 'boyapaket', '$satirNo')";
//        mysqli_query($db, $sqlprofil);

        $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kesimId) 
                VALUES ('$hurdaAdet', '$hurdaSebep', '$operatorId','$baskiId', 'boyapaket', '$kesimId')";
  //      mysqli_query($db, $sqlHurda);
    }


    // siklon tablosuna kayıt eklenmesi
    if ($siklonAyrilanKg > 0) {
        $sqlSiklon = "INSERT INTO tblsiklon (kilo, kalan,boyapaketId) 
                VALUES ( '$siklonAyrilanKg', '$siklonAyrilanKg', '$boyapaketId')";
     //   mysqli_query($db, $sqlSiklon);
    }

    // boyapaketnın düşürülmesi
    if ($kullanilanboyapaket > 0) {
        $boyapaketKalan = tablogetir('tblstokboyapaket', 'id', $boyapaketId, $db)['kalan'];
        $kalan = $boyapaketKalan - $kullanilanboyapaket;

        $sqlstokboyapaket = "UPDATE tblstokboyapaket set
                        kalan = '$kalan'
                    where id = '$boyapaketId'";
        //mysqli_query($db, $sqlstokboyapaket);
    }

    // rutus düşürülmesi
    if ($rutusId > 0 && $rutusAdet > 0) {
        $sqlrutusAyrilanKalan = tablogetir('tblrutusprofil', 'id', $rutusId, $db)['kalan'];
        $kalan = $sqlrutusAyrilanKalan - $rutusAdet;

        $sqlRutusAyrilan = "UPDATE tblrutusprofil set
                        kalan = '$kalan'
                    where id = '$rutusId'";
     //   mysqli_query($db, $sqlRutusAyrilan);
    }


    // siklon boyapaket düşürülmesi
    if ($siklonId > 0 && $siklonKullanilanKg > 0) {
        $siklonKalan = tablogetir('tblsiklon', 'id', $siklonId, $db)['kalan'];
        $kalan = $siklonKalan - $siklonKullanilanKg;

        $sqlisiklon = "UPDATE tblsiklon set
                        kalan = '$kalan'
                    where id = '$siklonId'";
    //    mysqli_query($db, $sqlisiklon);
    }


    $sqlboyapaket = "INSERT INTO tblboyapaket  (
                        sepetId,
                        rutusAdet,
                        netboyapaket,
                        ortAskiAdet,
                        topAski,
                        rutusId,
                        siklonId,
                        kullanilanboyapaket,
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
                        boyapaketId,
                        askiId,
                        firinSicaklik,
                        kurlenmeDakikasi)
                   VALUES  (
                        '$sepetId',
                        '$rutusAdet',
                        '$netboyapaket',
                        '$ortAskiAdet',
                        '$topAski',
                        '$rutusId',
                        '$siklonId',
                        '$kullanilanboyapaket',
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
                        '$boyapaketId',
                        '$askiId',
                        '$firinSicaklik',
                        '$kurlenmeDakikasi'
    
                   )";
    if (mysqli_query($db, $sqlboyapaket)) {
        header("Location:../../boyapaket/?durumekle=ok");
        exit();
    } else {
        header("Location:../../boyapaket/?durumekle=no");
        exit();
    }

}