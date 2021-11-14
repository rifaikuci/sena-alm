<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');




if (isset($_POST['baskiId'])) {
    $id = $_POST['baskiId'];
    $baskiDurum = strval($_POST['baskiDurum']) == "true" ? 1 : 0;
    $sonlanmaNeden = strval($_POST['baskiDurum']) == "true" ? "Tamamlandı" : $_POST['sonlanmaNeden'];
    $siparisKonum = strval($_POST['baskiDurum']) == "true" ? "kesim" : "baski";
    $siparisId = $_POST['siparisId'];
    $takimId = $_POST['takimId'];
    $baslaZamani = $_POST['baslaZamani'];
    $bitisZamani = date("d.m.Y H:i");
    $kayitTarih = date("d.m.Y");
    $vardiya = ayarSqlBul(1, $db, 'vardiya');
    $vardiyaKod = vardiyaBul($vardiya);
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $biyetId = $_POST['biyetId'];
    $biyetBoy = $_POST['biyetBoy'];
    $araIsFire = $_POST['araIsFire'];
    $konveyorBoy = $_POST['konveyorBoy'];
    $boylamFire = $_POST['boylamFire'];
    $baskiFire = $_POST['baskiFire'];
    $biyetFire = $_POST['biyetFire'];
    $verilenBiyet = $_POST['verilenBiyet'];
    $guncelGr = $_POST['guncelGr'];
    $satirNo = $_POST['satirNo'];
    $basilanBrutKg = $_POST['basilanBrutKg'];
    $basilanNetKg = $_POST['basilanNetKg'];
    $basilanNetAdet = $_POST['basilanNetAdet'];
    $kovanSicaklik = $_POST['kovanSicaklik'];
    $kalipSicaklik = $_POST['kalipSicaklik'];
    $biyetSicaklik = $_POST['biyetSicaklik'];
    $hiz = $_POST['hiz'];
    $fire = $_POST['fire'];
    $takimSonDurum = $_POST['takimSonDurum'];
    $aciklama = $_POST['aciklama'];
    $baslangicSaati = strtotime($baslaZamani);
    $bitisSaati = strtotime($bitisZamani);
    $saatFark = ($bitisSaati - $baslangicSaati) / 3600;
    $performans = $saatFark > 0 ? number_format($basilanNetKg / $saatFark, 2) : 0;
    $sqlBaski = "UPDATE tblbaski set
                    siparisId= '$siparisId',
                    takimId = '$takimId',
                    bitisZamani = '$bitisZamani',
                    kayitTarih = '$kayitTarih',
                    vardiyaKod = '$vardiyaKod',
                    vardiya = '$vardiya',
                    operatorId = '$operatorId',
                    biyetId = '$biyetId',
                    biyetBoy = '$biyetBoy',
                    araIsFire = '$araIsFire',
                    konveyorBoy = '$konveyorBoy',
                    boylamFire = '$boylamFire',
                    baskiFire = '$baskiFire',
                    biyetFire = '$biyetFire',
                    verilenBiyet = '$verilenBiyet',
                    guncelGr = '$guncelGr',
                    basilanBrutKg = '$basilanBrutKg',
                    basilanNetKg = '$basilanNetKg',
                    basilanNetAdet = '$basilanNetAdet',
                    kovanSicaklik = '$kovanSicaklik',
                    kalipSicaklik = '$kalipSicaklik',
                    biyetSicaklik = '$biyetSicaklik',
                    hiz = '$hiz',
                    fire = '$fire',
                    performans = '$performans',
                    takimSonDurum = '$takimSonDurum',
                    aciklama = '$aciklama',
                    sonlanmaNeden = '$sonlanmaNeden'
                    where id = '$id'";
    mysqli_query($db, $sqlBaski);


    $sqlHurda = "INSERT INTO tblhurda (toplamKg, aciklama,operatorId,baskiId) 
                VALUES ('$fire', 'Baskı Firesi', '$operatorId', '$id')";

    mysqli_query($db, $sqlHurda);

    $sqlTakim = "Select * from tbltakim where id = '$takimId'";
    $result = mysqli_query($db, $sqlTakim);
    $takim = $result->fetch_assoc();
    $brutKilo = $takim['brutKilo'] + $basilanBrutKg;
    $netKilo = $takim['netKilo'] + $basilanNetKg;

    $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr'
                    where id = '$takimId'";
    mysqli_query($db, $sqlTakimgGuncelle);

    if ($takim['parca1'] != "") {
        $parca1 = $takim['parca1'];
        $parca1Sql = "select * from tblkalipparcalar where senaNo= '$parca1'";
        $resultparca1 = mysqli_query($db, $parca1Sql);
        $resultparca1 = $resultparca1->fetch_assoc();

        $parca1NetKilo = $resultparca1['netKilo'] + $basilanNetKg;
        $parca1BrutKilo = $resultparca1['brutKilo'] + $basilanBrutKg;

        $sqlParca1gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca1BrutKilo',
                    netKilo = '$parca1NetKilo'
                    where senaNo= '$parca1'";
        mysqli_query($db, $sqlParca1gGuncelle);

    }

    if ($takim['parca2'] != "") {
        $parca2 = $takim['parca2'];
        $parca2Sql = "select * from tblkalipparcalar where senaNo= '$parca2'";
        $resultparca2 = mysqli_query($db, $parca2Sql);
        $resultparca2 = $resultparca2->fetch_assoc();

        $parca2NetKilo = $resultparca2['netKilo'] + $basilanNetKg;
        $parca2BrutKilo = $resultparca2['brutKilo'] + $basilanBrutKg;

        $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2BrutKilo',
                    netKilo = '$parca2NetKilo'
                    where senaNo= '$parca2'";
        mysqli_query($db, $sqlParca2gGuncelle);
    }

    $profilsql = "select * from tblstokprofil where siparis= '$satirNo'";
    $resultProfil = mysqli_query($db, $profilsql);
    $resultProfil = $resultProfil->fetch_assoc();

    $profilNetKilo = $resultProfil['toplamKg'] + $basilanNetKg;
    $profilNetAdet = $resultProfil['toplamAdet'] + $basilanNetAdet;


    $sqlprofilguncelle = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKilo',
                    toplamAdet = '$profilNetAdet'
                    where siparis= '$satirNo'";

    mysqli_query($db, $sqlprofilguncelle);

    $kalanBiyet = biyetbul($biyetId, $db, 'kalanKg');
    $kalanBiyet = $kalanBiyet - $basilanBrutKg;


    $sqlbiyet = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyet'
                    where id= '$biyetId'";

    mysqli_query($db, $sqlbiyet);


    $sqlSiparis = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdet',
                    basilanKilo = '$basilanNetKg',
                    baskiDurum = '$baskiDurum',
                    konum = '$siparisKonum'
                    where id = '$siparisId'";

    if (mysqli_query($db, $sqlSiparis)) {
        header("Location:../../baski/?durumekle=ok");
        exit();
    } else {
        header("Location:../../baski/?durumekle=no");
        exit();
    }

}

if (isset($_GET['baskisil'])) {
    $id = $_GET['baskisil'];
    $sql = "DELETE FROM tblbaski where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../baski/?durumsil=ok");
        exit();
    } else {
        header("Location:../../baski/?durumsil=no");
        exit();
    }
}

if (isset($_GET['baskisilinecek'])) {
    $id = $_GET['baskisilinecek'];
    $sqlbaski = "SELECT * FROM tblbaski where id = '$id'";
    $baskiresult = mysqli_query($db, $sqlbaski);
    $baski = $baskiresult->fetch_assoc();
    $takimId = $baski['takimId'];
    $basilanNetKg = $baski['basilanNetKg'];
    $basilanBrutKg = $baski['basilanBrutKg'];
    $basilanNetAdet = $baski['basilanNetAdet'];
    $siparisId = $baski['siparisId'];
    $biyetId = $baski['biyetId'];
    $satirNo = siparisBul($siparisId, $db, 'satirNo');


    $sqlHurda = "DELETE FROM tblhurda where baskiId = '$id'";
    mysqli_query($db, $sqlHurda);


    $sqlTakim = "Select * from tbltakim where id = '$takimId'";
    $result = mysqli_query($db, $sqlTakim);
    $takim = $result->fetch_assoc();
    $brutKilo = $takim['brutKilo'] - $basilanBrutKg;
    $netKilo = $takim['netKilo'] - $basilanNetKg;


    $sqlTakimBaskaVar = "SELECT COUNT(*) FRom tblbaski where takimId = '$takimId' and id !='$id' order by id desc";
    $calistir = mysqli_query($db, $sqlTakimBaskaVar);
    $takimUzunluk = $calistir->fetch_row()[0];


    if ($takimUzunluk > 0) {
        $sonSatir = "SELECT * FRom tblbaski where takimId = '$takimId' and id !='$id' order by id desc";
        $sonSatir = mysqli_query($db, $sonSatir);
        $satir = $sonSatir->fetch_assoc();
        $takimSonDurum = $satir['takimSonDurum'];
        $teorikGramaj = $satir['guncelGr'];
        $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$teorikGramaj'
                    where id = '$takimId'";
    } else {
        $takimSonDurum = "RAF";
        $teorikGramaj = profilbul($takim['profilId'], $db, 'gramaj');
        $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$teorikGramaj'
                    where id = '$takimId'";
    }

    mysqli_query($db, $sqlTakimgGuncelle);

    if ($takim['parca1'] != "") {
        $parca1 = $takim['parca1'];
        $parca1Sql = "select * from tblkalipparcalar where senaNo= '$parca1'";
        $resultparca1 = mysqli_query($db, $parca1Sql);
        $resultparca1 = $resultparca1->fetch_assoc();

        $parca1NetKilo = $resultparca1['netKilo'] - $basilanNetKg;
        $parca1BrutKilo = $resultparca1['brutKilo'] - $basilanBrutKg;

        $sqlParca1gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca1BrutKilo',
                    netKilo = '$parca1NetKilo'
                    where senaNo= '$parca1'";
        mysqli_query($db, $sqlParca1gGuncelle);

    }

    if ($takim['parca2'] != "") {
        $parca2 = $takim['parca2'];
        $parca2Sql = "select * from tblkalipparcalar where senaNo= '$parca2'";
        $resultparca2 = mysqli_query($db, $parca2Sql);
        $resultparca2 = $resultparca2->fetch_assoc();

        $parca2NetKilo = $resultparca2['netKilo'] - $basilanNetKg;
        $parca2BrutKilo = $resultparca2['brutKilo'] - $basilanBrutKg;

        $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2BrutKilo',
                    netKilo = '$parca2NetKilo'
                    where senaNo= '$parca2'";

        mysqli_query($db, $sqlParca2gGuncelle);
    }


    $profilsql = "select * from tblstokprofil where siparis= '$satirNo'";
    $resultProfil = mysqli_query($db, $profilsql);
    $resultProfil = $resultProfil->fetch_assoc();

    $profilNetKilo = $resultProfil['toplamKg'] - $basilanNetKg;
    $profilNetAdet = $resultProfil['toplamAdet'] - $basilanNetAdet;

    $sqlprofilguncelle = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKilo',
                    toplamAdet = '$profilNetAdet'
                    where siparis= '$satirNo'";
    mysqli_query($db, $sqlprofilguncelle);


    $kalanBiyet = biyetbul($biyetId, $db, 'kalanKg');
    $kalanBiyet = $kalanBiyet + $basilanBrutKg;


    $sqlbiyet = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyet'
                    where id= '$biyetId'";

    mysqli_query($db, $sqlbiyet);


    $siparisql = "select * from tblsiparis where id= '$siparisId'";
    $satiriparis = mysqli_query($db, $siparisql);
    $satiriparis = $satiriparis->fetch_assoc();


    $basilanNetAdet = $satiriparis['basilanAdet'] - $basilanNetAdet;
    $basilanNetKg = $satiriparis['basilanKilo'] - $basilanNetKg;
    $sqlSiparis = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdet',
                    basilanKilo = '$basilanNetKg',
                    baskiDurum = '0',
                    konum = 'baski'
                    where id = '$siparisId'";

    mysqli_query($db, $sqlSiparis);

    $sqlsil = "DELETE FROM tblbaski where id = '$id' ";

    if (mysqli_query($db, $sqlsil)) {
        header("Location:../../baski/?durumsil=ok");
        exit();
    } else {
        header("Location:../../baski/?durumsil=no");
        exit();
    }
}



if (isset($_POST['baskiIdG'])) {
    $id = $_POST['baskiIdG'];
    $baskiDurum = strval($_POST['baskiDurumG']) == "true" ? 1 : 0;

    $sonlanmaNeden = strval($_POST['baskiDurumG']) == "true" ? "Tamamlandı" : $_POST['sonlanmaNeden'];

    $siparisKonum = strval($_POST['baskiDurumG']) == "true" ? "kesim" : "baski";

    $siparisId = $_POST['siparisId'];

    $takimId = $_POST['takimId'];

    $bitisZamani = date("d.m.Y H:i");

    $vardiya = ayarSqlBul(1, $db, 'vardiya');
    $vardiyaKod = vardiyaBul($vardiya);
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $biyetId = $_POST['biyetId'];
    $biyetBoy = $_POST['biyetBoyG'];
    $araIsFire = $_POST['araIsFire'];
    $konveyorBoy = $_POST['konveyorBoyG'];
    $boylamFire = $_POST['boylamFireG'];
    $baskiFire = $_POST['baskiFireG'];
    $biyetFire = $_POST['biyetFire'];
    $verilenBiyet = $_POST['verilenBiyetG'];
    $guncelGr = $_POST['guncelGrG'];
    $satirNo = $_POST['satirNo'];
    $basilanBrutKg = $_POST['basilanBrutKgG'];
    $basilanNetKg = $_POST['basilanNetKgG'];
    $basilanNetAdet = $_POST['basilanNetAdetG'];
    $kovanSicaklik = $_POST['kovanSicaklikG'];
    $kalipSicaklik = $_POST['kalipSicaklikG'];
    $biyetSicaklik = $_POST['biyetSicaklikG'];
    $baslaZamani = $_POST['baslaZamani'];



    $hiz = $_POST['hizG'];
    $fire = $_POST['fireG'];
    $takimSonDurum = $_POST['takimSonDurum'];
    $aciklama = $_POST['aciklama'];

    $baslangicSaati = strtotime($baslaZamani);
    $bitisSaati = strtotime($bitisZamani);
    $saatFark = ($bitisSaati - $baslangicSaati) / 3600;
    $performans = $saatFark > 0 ? number_format($basilanNetKg / $saatFark, 2) : 0;

    $sqlBaski = "UPDATE tblbaski set
                    siparisId= '$siparisId',
                    takimId = '$takimId',
                    bitisZamani = '$bitisZamani',
                    vardiyaKod = '$vardiyaKod',
                    vardiya = '$vardiya',
                    operatorId = '$operatorId',
                    biyetId = '$biyetId',
                    biyetBoy = '$biyetBoy',
                    araIsFire = '$araIsFire',
                    konveyorBoy = '$konveyorBoy',
                    boylamFire = '$boylamFire',
                    baskiFire = '$baskiFire',
                    biyetFire = '$biyetFire',
                    verilenBiyet = '$verilenBiyet',
                    guncelGr = '$guncelGr',
                    basilanBrutKg = '$basilanBrutKg',
                    basilanNetKg = '$basilanNetKg',
                    basilanNetAdet = '$basilanNetAdet',
                    kovanSicaklik = '$kovanSicaklik',
                    kalipSicaklik = '$kalipSicaklik',
                    biyetSicaklik = '$biyetSicaklik',
                    hiz = '$hiz',
                    fire = '$fire',
                    performans = '$performans',
                    takimSonDurum = '$takimSonDurum',
                    aciklama = '$aciklama',
                    sonlanmaNeden = '$sonlanmaNeden'
                    where id = '$id'";
    mysqli_query($db, $sqlBaski);


    $sqlHurda = "INSERT INTO tblhurda (toplamKg, aciklama,operatorId,baskiId) 
                VALUES ('$fire', 'Baskı Firesi', '$operatorId', '$id')";

    mysqli_query($db, $sqlHurda);

    $sqlTakim = "Select * from tbltakim where id = '$takimId'";
    $result = mysqli_query($db, $sqlTakim);
    $takim = $result->fetch_assoc();
    $brutKilo = $takim['brutKilo'] + $basilanBrutKg;
    $netKilo = $takim['netKilo'] + $basilanNetKg;

    $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr'
                    where id = '$takimId'";
    mysqli_query($db, $sqlTakimgGuncelle);

    if ($takim['parca1'] != "") {
        $parca1 = $takim['parca1'];
        $parca1Sql = "select * from tblkalipparcalar where senaNo= '$parca1'";
        $resultparca1 = mysqli_query($db, $parca1Sql);
        $resultparca1 = $resultparca1->fetch_assoc();

        $parca1NetKilo = $resultparca1['netKilo'] + $basilanNetKg;
        $parca1BrutKilo = $resultparca1['brutKilo'] + $basilanBrutKg;

        $sqlParca1gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca1BrutKilo',
                    netKilo = '$parca1NetKilo'
                    where senaNo= '$parca1'";
        mysqli_query($db, $sqlParca1gGuncelle);

    }

    if ($takim['parca2'] != "") {
        $parca2 = $takim['parca2'];
        $parca2Sql = "select * from tblkalipparcalar where senaNo= '$parca2'";
        $resultparca2 = mysqli_query($db, $parca2Sql);
        $resultparca2 = $resultparca2->fetch_assoc();

        $parca2NetKilo = $resultparca2['netKilo'] + $basilanNetKg;
        $parca2BrutKilo = $resultparca2['brutKilo'] + $basilanBrutKg;

        $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2BrutKilo',
                    netKilo = '$parca2NetKilo'
                    where senaNo= '$parca2'";
        mysqli_query($db, $sqlParca2gGuncelle);
    }

    $profilsql = "select * from tblstokprofil where siparis= '$satirNo'";
    $resultProfil = mysqli_query($db, $profilsql);
    $resultProfil = $resultProfil->fetch_assoc();

    $profilNetKilo = $resultProfil['toplamKg'] + $basilanNetKg;
    $profilNetAdet = $resultProfil['toplamAdet'] + $basilanNetAdet;


    $sqlprofilguncelle = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKilo',
                    toplamAdet = '$profilNetAdet'
                    where siparis= '$satirNo'";

    mysqli_query($db, $sqlprofilguncelle);

    $kalanBiyet = biyetbul($biyetId, $db, 'kalanKg');
    $kalanBiyet = $kalanBiyet - $basilanBrutKg;


    $sqlbiyet = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyet'
                    where id= '$biyetId'";

    mysqli_query($db, $sqlbiyet);


    $sqlSiparis = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdet',
                    basilanKilo = '$basilanNetKg',
                    baskiDurum = '$baskiDurum',
                    konum = '$siparisKonum'
                    where id = '$siparisId'";

    if (mysqli_query($db, $sqlSiparis)) {
        header("Location:../../baski/?durumekle=ok");
        exit();
    } else {
        header("Location:../../baski/?durumekle=no");
        exit();
    }

}