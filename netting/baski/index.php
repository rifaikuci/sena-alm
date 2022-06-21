<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');


if (isset($_POST['baskiekle'])) {
    $id = $_POST['baskiId'];
    $baskiDurum = strval($_POST['baskiDurum']) == "true" ? 1 : 0;
    $sonlanmaNeden = strval($_POST['baskiDurum']) == "true" ? "Tamamlandı" : $_POST['sonlanmaNeden'];
    $siparisKonum = strval($_POST['baskiDurum']) == "true" ? "kesim" : "baski";
    $siparisId = $_POST['siparisId'];
    $takimId = $_POST['takimId'];
    $baslaZamani = $_POST['baslaZamani'];
    $bitisZamani = date("d.m.Y H:i");
    $kayitTarih = date("d.m.Y");
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiyaKod = vardiyaBul($vardiya, date("H:i"));
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $boy = $_POST['boy'];
    $guncelGr = $_POST['guncelGr'];
    $istenilenTermik = $_POST['istenilenTermik'];
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
    $performans = $saatFark > 0 ? sayiFormatla($basilanNetKg / $saatFark, 2) : 0;
    $satirNo = $_POST['satirNo'];
    $kesimId = 0;
    $boyaId = 0;
    $firinlamaId = 0;
    $kromatId = 0;
    $naylonId = 0;
    $paketId = 0;
    $boyaPaketId = 0;
    $termikId = 0;
    $naylonDurum = tablogetir('tblsiparis', 'id', $siparisId, $db)['naylonDurum'];
    $arrayBiyetBoy = explode(",", $_POST['arrayBiyetBoy']);
    $arrayBiyetId = explode(",", $_POST['arrayBiyetId']);
    $arrayBiyetAd = explode(",", $_POST['arrayBiyetAd']);
    $arrayBiyetVerilenBiyet = explode(",", $_POST['arrayBiyetVerilenBiyet']);
    $arrayBiyetAraisFire = explode(",", $_POST['arrayBiyetAraisFire']);
    $arrayBiyetKonveyorBoy = explode(",", $_POST['arrayBiyetKonveyorBoy']);
    $arrayBiyetBoylamFire = explode(",", $_POST['arrayBiyetBoylamFire']);
    $arrayBiyetFireBiyet = explode(",", $_POST['arrayBiyetFireBiyet']);
    $arrayBiyetBaskiFire = explode(",", $_POST['arrayBiyetBaskiFire']);
    $arrayBiyetler = explode(",", $_POST['arrayBiyetler']);
    $arrayBiyetBrut = explode(",", $_POST['arrayBiyetBrut']);

    $biyetId = '';
    $biyetBoy = '';
    $araIsFire = '';
    $konveyorBoy = '';
    $boylamFire = '';
    $baskiFire = '';
    $biyetFire = '';
    $verilenBiyet = '';
    $biyetBrut = '';

    for ($i = 0; $i < count($arrayBiyetBoy); $i++) {

        $biyetId = $biyetId . $arrayBiyetId[$i] . ";";
        $biyetBoy = $biyetBoy . $arrayBiyetBoy[$i] . ";";
        $araIsFire = $araIsFire . $arrayBiyetAraisFire[$i] . ";";
        $konveyorBoy = $konveyorBoy . $arrayBiyetKonveyorBoy[$i] . ";";
        $boylamFire = $boylamFire . $arrayBiyetBoylamFire[$i] . ";";
        $baskiFire = $baskiFire . $arrayBiyetBaskiFire[$i] . ";";
        $biyetFire = $biyetFire . $arrayBiyetFireBiyet[$i] . ";";
        $verilenBiyet = $verilenBiyet . $arrayBiyetVerilenBiyet[$i] . ";";
        $biyetBrut = $biyetBrut . $arrayBiyetBrut[$i] . ";";

    }

    $biyetId = rtrim($biyetId, ";");
    $biyetBoy = rtrim($biyetBoy, ";");
    $araIsFire = rtrim($araIsFire, ";");
    $konveyorBoy = rtrim($konveyorBoy, ";");
    $boylamFire = rtrim($boylamFire, ";");
    $baskiFire = rtrim($baskiFire, ";");
    $biyetFire = rtrim($biyetFire, ";");
    $verilenBiyet = rtrim($verilenBiyet, ";");
    $biyetBrut = rtrim($biyetBrut, ";");


    if ($istenilenTermik == "Termiksiz") {
        $termikId = -1;
    }

    $type = $satirNo[3];

    if ($type == "E") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "H") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "B") {
        $paketId = -1;
    }

    if ($naylonDurum == 3) {
        $naylonId = -1;
    }


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
                    biyetBrut = '$biyetBrut',
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
                    sonlanmaNeden = '$sonlanmaNeden',
                    satirNo = '$satirNo',
                    kesimId = '$kesimId',
                    boyaId = '$boyaId',
                    firinlamaId = '$firinlamaId',
                    kromatId = '$kromatId',
                    naylonId = '$naylonId',
                    paketId = '$paketId',
                    boyaPaketId = '$boyaPaketId',
                    termikId = '$termikId'
                    where id = '$id'";
    mysqli_query($db, $sqlBaski);


    $takim = tablogetir("tbltakim", "id", $takimId, $db);

    $brutKilo = $takim['brutKilo'] + $basilanBrutKg;
    $netKilo = $takim['netKilo'] + $basilanNetKg;
    $oldProcess = $takim['konum'];
    $yapilanTeneferBaski = $takim['yapilanTeneferBaski'] + $basilanBrutKg;

    $sqlKalipIslem = "INSERT INTO tblkaliphane (takimId,basilanNetKilo, basilanBrutKilo, oldProcess, newProcess, operatorId ) 
                VALUES ('$takimId', '$basilanNetKg', '$basilanBrutKg', '$oldProcess', '$takimSonDurum','$operatorId')";

    mysqli_query($db, $sqlKalipIslem);


    $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr',
                    yapilanTeneferBaski = '$yapilanTeneferBaski'
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


    $sqlprofilstok = "INSERT INTO tblstokprofil (adet, kilo,operatorId,baskiId, geldigiYer) 
                VALUES ('$basilanNetAdet', '$basilanNetKg', '$operatorId', '$id','baski')";

    mysqli_query($db, $sqlprofilstok);

    $fire = sayiFormatla($fire);
    $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId, geldigiYer, kilo) 
                VALUES ('1', 'Baskı Firesi', '$operatorId', '$id','baski', '$fire' )";

    mysqli_query($db, $sqlHurda);


    $biyetler = explode(';', $biyetId);
    $brutler = explode(';', $biyetBrut);

    for ($s = 0; $s < count($biyetler); $s++) {
        $kalanBiyet = 0;
        $idBiyet = $biyetler[$s];
        $biyetGetir = tablogetir('tblstokbiyet', 'id', $idBiyet, $db);
        $kalanBiyet = $biyetGetir['kalanKg'];
        $kalanBiyet = $kalanBiyet - $brutler[$s];

        $ortlamaBoy = $biyetGetir['ortlamaBoy'];
        $alasimGetir =  tablogetir('tblalasim', 'id', $biyetGetir['alasimId'], $db);
        $ortlamaBoy = $kalanBiyet / $alasimGetir['biyetBirimGramaj'];
        $ortlamaBoy   = sayiFormatla($ortlamaBoy);

        $sqlbiyet = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyet',
                    ortalamaBoy = '$ortlamaBoy'
                    where id= '$idBiyet'";

        mysqli_query($db, $sqlbiyet);

    }

    $siparis = tablogetir('tblsiparis', 'id', $siparisId, $db);
    $basilanNetAdetSiparis = $basilanNetAdet + $siparis['basilanNetAdet'];
    $basilanNetKgSiparis = $basilanNetKg + $siparis['basilanNetKilo'];

    $sqlSiparis = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdetSiparis',
                    basilanKilo = '$basilanNetKgSiparis',
                    baskiDurum = '$baskiDurum'
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
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $baskiresult = mysqli_query($db, $sqlbaski);
    $baski = $baskiresult->fetch_assoc();
    $takimId = $baski['takimId'];
    $boy = $baski['boy'];
    $basilanNetKg = $baski['basilanNetKg'];
    $basilanBrutKg = $baski['basilanBrutKg'];
    $basilanNetAdet = $baski['basilanNetAdet'];
    $siparisId = $baski['siparisId'];
    $biyetId = $baski['biyetId'];
    $satirNo = tablogetir('tblsiparis', 'id', $siparisId, $db)['satirNo'];


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
        // $takimSonDurum = $satir['takimSonDurum'];
        $teorikGramaj = $satir['guncelGr'];
        $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    sonGramaj = '$teorikGramaj'
                    where id = '$takimId'";
    } else {
        //    $takimSonDurum = "Raf";
        $teorikGramaj = tablogetir('tblprofil', 'id', $takim['profilId'], $db)['gramaj'];
        $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
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

    /*
    $sqlprofilstok = "INSERT INTO tblstokprofil (adet, kilo,operatorId,baskiId, geldigiYer)
                VALUES ('$basilanNetAdet', '$basilanNetKg', '$operatorId', '$id','baski')";

    mysqli_query($db, $sqlprofilstok);
*/


    $kalanBiyet = tablogetir('tblstokbiyet', 'id', $biyetId, $db)['kalanKg'];
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

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiyaKod = vardiyaBul($vardiya, date("H:i"));
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $biyetId = $_POST['biyetId'];
    $biyetBoy = $_POST['biyetBoyG'];
    $araIsFire = $_POST['araIsFire'];
    $istenilenTermik = $_POST['istenilenTermik'];
    $konveyorBoy = $_POST['konveyorBoyG'];
    $boy = $_POST['boy'];
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
    $performans = $saatFark > 0 ? sayiFormatla($basilanNetKg / $saatFark, 2) : 0;
    $satirNo = $_POST['satirNo'];
    $naylonDurum = tablogetir('tblsiparis', 'id', $siparisId, $db)['naylonDurum'];
    $kesimId = 0;
    $boyaId = 0;
    $firinlamaId = 0;
    $kromatId = 0;
    $naylonId = 0;
    $paketId = 0;
    $boyaPaketId = 0;
    $termikId = 0;

    if ($istenilenTermik == "Termiksiz") {
        $termikId = -1;
        $naylonId = -1;
    }

    $type = $satirNo[3];

    if ($type == "E") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $naylonId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "H") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "B") {
        $paketId = -1;
    }

    if ($naylonDurum == 3) {
        $naylonId = -1;
    }


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
                    sonlanmaNeden = '$sonlanmaNeden',
                     satirNo = '$satirNo',
                    kesimId = '$kesimId',
                    boyaId = '$boyaId',
                    firinlamaId = '$firinlamaId',
                    kromatId = '$kromatId',
                    naylonId = '$naylonId',
                    paketId = '$paketId',
                    boyaPaketId = '$boyaPaketId',
                    termikId = '$termikId'
                    where id = '$id'";
    mysqli_query($db, $sqlBaski);


    $fire = sayiFormatla($fire);

    $sqlHurda = "INSERT INTO tblhurda (adet, aciklama,operatorId,baskiId,geldigiYer, kilo) 
                VALUES ('1', 'Baskı Firesi', '$operatorId', '$id', 'baski', '$fire')";

    mysqli_query($db, $sqlHurda);

    $sqlTakim = "Select * from tbltakim where id = '$takimId'";
    $result = mysqli_query($db, $sqlTakim);
    $takim = $result->fetch_assoc();
    $brutKilo = $takim['brutKilo'] + $basilanBrutKg;
    $netKilo = $takim['netKilo'] + $basilanNetKg;
    $oldProcess = $takim['konum'];

    $yapilanTeneferBaski = $takim['yapilanTeneferBaski'] + $basilanBrutKg;
    $sqlKalipIslem = "INSERT INTO tblkaliphane (takimId,basilanNetKilo, basilanBrutKilo, oldProcess, newProcess, operatorId ) 
                VALUES ('$takimId', '$basilanNetKg', '$basilanBrutKg', '$oldProcess', '$takimSonDurum','$operatorId')";

    mysqli_query($db, $sqlKalipIslem);

    $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr',
                    yapilanTeneferBaski = '$yapilanTeneferBaski'
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

    $sqlprofilstok = "INSERT INTO tblstokprofil (adet, kilo,operatorId,baskiId, geldigiYer) 
                VALUES ('$basilanNetAdet', '$basilanNetKg', '$operatorId', '$id','baski')";

    mysqli_query($db, $sqlprofilstok);


    $kalanBiyet = tablogetir('tblstokbiyet', 'id', $biyetId, $db)['kalanKg'];
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

/*
if (isset($_POST['baskiguncelle'])) {
    $baskiId = $_POST['baskiId'];
    $sqlBaski = "Select * from tblbaski where id = '$baskiId'";
    $baski = mysqli_query($db, $sqlBaski)->fetch_assoc();
    $eskiTakimId = $baski['takimId'];
    $eskiSiparisId = $baski['siparisId'];
    $eskiBiyetId = $baski['biyetId'];

    $yeniTakimId = $_POST['takimId'];
    $yeniSiparisId = $_POST['siparisId'];
    $yeniBiyetId = $_POST['biyetId'];
    $sonlanmaNeden = $_POST['sonlanmaNeden'];
    $baskiDurum = $sonlanmaNeden == "Tamamlandı" ? 1 : 0;
    $siparisKonum = $baskiDurum == 1 ? "kesim" : "baski";
    $baslaZamani = $_POST['baslaTarih'] . " " . $_POST['baslaSaat'];
    $bitisZamani = $_POST['bitisTarih'] . " " . $_POST['bitisSaat'];
    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $vardiyaKod = vardiyaBul($vardiya, $_POST['bitisSaat']);
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
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
    $istenilenTermik = $_POST['istenilenTermik'];
    $hiz = $_POST['hiz'];
    $fire = $_POST['fire'];
    $takimSonDurum = $_POST['takimSonDurum'];
    $aciklama = $_POST['aciklama'];
    $baslangicSaati = strtotime($baslaZamani);
    $bitisSaati = strtotime($bitisZamani);
    $saatFark = ($bitisSaati - $baslangicSaati) / 3600;
    $performans = $saatFark > 0 ? sayiFormatla($basilanNetKg / $saatFark, 2) : 0;
    $satirNo = $_POST['satirNo'];
    $kesimId = 0;
    $boyaId = 0;
    $firinlamaId = 0;
    $kromatId = 0;
    $naylonId = 0;
    $paketId = 0;
    $boyaPaketId = 0;
    $termikId = 0;

    if ($istenilenTermik == "Termiksiz") {
        $termikId = -1;
        $naylonId = -1;
    }

    $type = $satirNo[3];

    if ($type == "E") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "H") {
        $boyaId = -1;
        $firinlamaId = -1;
        $kromatId = -1;
        $boyaPaketId = -1;
    }

    if ($type == "B") {
        $paketId = -1;
    }


    $sqlBaski = "UPDATE tblbaski set
                    siparisId= '$yeniSiparisId',
                    takimId = '$yeniTakimId',
                    bitisZamani = '$bitisZamani',
                    baslaZamani = '$baslaZamani',
                    operatorId = '$operatorId',
                    biyetId = '$yeniBiyetId',
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
                    sonlanmaNeden = '$sonlanmaNeden',
                    satirNo = '$satirNo',
                    kesimId = '$kesimId',
                    boyaId = '$boyaId',
                    firinlamaId = '$firinlamaId',
                    kromatId = '$kromatId',
                    naylonId = '$naylonId',
                    paketId = '$paketId',
                    boyaPaketId = '$boyaPaketId',
                    termikId = '$termikId'
                    where id = '$baskiId'";


    $sqlHurdaGuncelle = "UPDATE tblhurda set
                    adet = '$fire',
                    operatorId = '$operatorId'
                    where baskiId = '$baskiId'";
    mysqli_query($db, $sqlHurdaGuncelle);


    if ($eskiTakimId != $yeniTakimId) {

        $sqlTakimEski = "Select * from tbltakim where id = '$eskiTakimId'";
        $resultEski = mysqli_query($db, $sqlTakimEski);
        $takimEski = $resultEski->fetch_assoc();
        $brutKiloEski = $takimEski['brutKilo'] - $basilanBrutKg;
        $netKiloEski = $takimEski['netKilo'] - $basilanNetKg;


        $sqlTakimEskiBaskaVar = "SELECT COUNT(*) FRom tblbaski where takimId = '$eskiTakimId' and id !='$baskiId' order by id desc";
        $calistirEski = mysqli_query($db, $sqlTakimEskiBaskaVar);
        $takimEskiUzunluk = $calistirEski->fetch_row()[0];


        if ($takimEskiUzunluk > 0) {
            $sonSatirEski = "SELECT * FRom tblbaski where takimId = '$eskiTakimId' and id !='$baskiId' order by id desc";
            $sonSatirEski = mysqli_query($db, $sonSatirEski);
            $satirEski = $sonSatirEski->fetch_assoc();
            $takimEskiSonDurum = $satirEski['takimSonDurum'];
            $teorikGramajEski = $satirEski['guncelGr'];
            $sqlTakimEskiGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKiloEski',
                    netKilo = '$netKiloEski',
                    konum = '$takimEskiSonDurum',
                    sonGramaj = '$teorikGramajEski'
                    where id = '$eskiTakimId'";
        } else {
            $takimEskiSonDurum = "RAF";
            $teorikGramajEski = tablogetir('tblprofil', 'id', $takimEski['profilId'], $db)['gramaj'];
            $sqlTakimEskiGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKiloEski',
                    netKilo = '$netKiloEski',
                    konum = '$takimEskiSonDurum',
                    sonGramaj = '$teorikGramajEski'
                    where id = '$eskiTakimId'";
        }

        mysqli_query($db, $sqlTakimEskiGuncelle);

        if ($takimEski['parca1'] != "") {
            $parca1Eski = $takimEski['parca1'];
            $parca1EskiSql = "select * from tblkalipparcalar where senaNo= '$parca1Eski'";
            $resultEskiparca1 = mysqli_query($db, $parca1EskiSql);
            $resultEskiparca1 = $resultEskiparca1->fetch_assoc();

            $parca1EskiNetKilo = $resultEskiparca1['netKilo'] - $basilanNetKg;
            $parca1EskiBrutKilo = $resultEskiparca1['brutKilo'] - $basilanBrutKg;

            $sqlParca1Guncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca1EskiBrutKilo',
                    netKilo = '$parca1EskiNetKilo'
                    where senaNo= '$parca1Eski'";
            mysqli_query($db, $sqlParca1Guncelle);

        }

        if ($takimEski['parca2'] != "") {
            $parca2Eski = $takimEski['parca2'];
            $parca2EskiSql = "select * from tblkalipparcalar where senaNo= '$parca2Eski'";
            $resultEskiparca2 = mysqli_query($db, $parca2EskiSql);
            $resultEskiparca2 = $resultEskiparca2->fetch_assoc();

            $parca2EskiNetKilo = $resultEskiparca2['netKilo'] - $basilanNetKg;
            $parca2EskiBrutKilo = $resultEskiparca2['brutKilo'] - $basilanBrutKg;

            $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2EskiBrutKilo',
                    netKilo = '$parca2EskiNetKilo'
                    where senaNo= '$parca2Eski'";

            mysqli_query($db, $sqlParca2gGuncelle);
        }


        $sqlTakimYeni = "Select * from tbltakim where id = '$yeniTakimId'";
        $resultYeni = mysqli_query($db, $sqlTakimYeni);
        $takimYeni = $resultYeni->fetch_assoc();
        $brutKiloYeni = $takimYeni['brutKilo'] + $basilanBrutKg;
        $netKiloYeni = $takimYeni['netKilo'] + $basilanNetKg;

        $sqlTakimYenigGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKiloYeni',
                    netKilo = '$netKiloYeni',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr'
                    where id = '$yeniTakimId'";
        mysqli_query($db, $sqlTakimYenigGuncelle);

        if ($takimYeni['parca1'] != "") {
            $parca1Yeni = $takimYeni['parca1'];
            $parca1YeniSql = "select * from tblkalipparcalar where senaNo= '$parca1Yeni'";
            $resultYeniparca1 = mysqli_query($db, $parca1YeniSql);
            $resultYeniparca1 = $resultYeniparca1->fetch_assoc();

            $parca1YeniNetKilo = $resultYeniparca1['netKilo'] + $basilanNetKg;
            $parca1YeniBrutKilo = $resultYeniparca1['brutKilo'] + $basilanBrutKg;

            $sqlParca1gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca1YeniBrutKilo',
                    netKilo = '$parca1YeniNetKilo'
                    where senaNo= '$parca1Yeni'";
            mysqli_query($db, $sqlParca1gGuncelle);

        }

        if ($takimYeni['parca2'] != "") {
            $parca2Yeni = $takimYeni['parca2'];
            $parca2YeniSql = "select * from tblkalipparcalar where senaNo= '$parca2Yeni'";
            $resultYeniparca2 = mysqli_query($db, $parca2YeniSql);
            $resultYeniparca2 = $resultYeniparca2->fetch_assoc();
            $parca2YeniNetKilo = $resultYeniparca2['netKilo'] + $basilanNetKg;
            $parca2YeniBrutKilo = $resultYeniparca2['brutKilo'] + $basilanBrutKg;

            $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2YeniBrutKilo',
                    netKilo = '$parca2YeniNetKilo'
                    where senaNo= '$parca2Yeni'";
            mysqli_query($db, $sqlParca2gGuncelle);
        }

    } else {

        $sqlTakim = "Select * from tbltakim where id = '$yeniTakimId'";
        $result = mysqli_query($db, $sqlTakim);
        $takim = $result->fetch_assoc();
        $brutKilo = $takim['brutKilo'] + $basilanBrutKg - $baski['basilanBrutKg'];
        $netKilo = $takim['netKilo'] + $basilanNetKg - $baski['basilanNetKg'];

        $sqlTakimgGuncelle = "UPDATE tbltakim set
                    brutKilo = '$brutKilo',
                    netKilo = '$netKilo',
                    konum = '$takimSonDurum',
                    sonGramaj = '$guncelGr'
                    where id = '$yeniTakimId'";
        mysqli_query($db, $sqlTakimgGuncelle);

        if ($takim['parca1'] != "") {
            $parca1 = $takim['parca1'];
            $parca1Sql = "select * from tblkalipparcalar where senaNo= '$parca1'";
            $resultparca1 = mysqli_query($db, $parca1Sql);
            $resultparca1 = $resultparca1->fetch_assoc();

            $parca1NetKilo = $resultparca1['netKilo'] + $basilanNetKg - $baski['basilanNetKg'];
            $parca1BrutKilo = $resultparca1['brutKilo'] + $basilanBrutKg - $baski['basilanBrutKg'];

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

            $parca2NetKilo = $resultparca2['netKilo'] + $basilanNetKg - $baski['basilanNetKg'];
            $parca2BrutKilo = $resultparca2['brutKilo'] + $basilanBrutKg - $baski['basilanBrutKg'];

            $sqlParca2gGuncelle = "UPDATE tblkalipparcalar set
                    brutKilo = '$parca2BrutKilo',
                    netKilo = '$parca2NetKilo'
                    where senaNo= '$parca2'";
            mysqli_query($db, $sqlParca2gGuncelle);
        }

    }

    if ($eskiBiyetId != $yeniBiyetId) {

        $kalanBiyetEski = tablogetir('tblstokbiyet', 'id', $eskiBiyetId, $db)['kalanKg'];
        $kalanBiyetEski = $kalanBiyetEski + $baski['basilanBrutKg'];

        $sqlbiyetEski = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyetEski'
                    where id= '$eskiBiyetId'";

        mysqli_query($db, $sqlbiyetEski);


        $kalanBiyetYeni = tablogetir('tblstokbiyet', 'id', $yeniBiyetId, $db)['kalanKg'];
        $kalanBiyetYeni = $kalanBiyetYeni - $basilanBrutKg;

        $sqlbiyetYeni = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyetYeni'
                    where id= '$yeniBiyetId'";

        mysqli_query($db, $sqlbiyetYeni);

    } else {
        $kalanBiyet = tablogetir('tblstokbiyet', 'id', $yeniBiyetId, $db)['kalanKg'];
        $kalanBiyet = $kalanBiyet - $basilanBrutKg + $baski['basilanBrutKg'];

        $sqlbiyet = "UPDATE tblstokbiyet set
                    kalanKg = '$kalanBiyet'
                    where id= '$yeniBiyetId'";

        mysqli_query($db, $sqlbiyet);
    }


    $eskiSatirNo = tablogetir('tblsiparis', 'id', $yeniSiparisId, $db)['satirNo'];
    if ($eskiSatirNo != $satirNo) {

        $profilsqlEski = "select * from tblstokprofil where baskiId = '$id'";
        $resultProfilEski = mysqli_query($db, $profilsqlEski);
        $resultProfilEski = $resultProfilEski->fetch_assoc();

        $profilNetKiloEski = $resultProfilEski['toplamKg'] - $baski['basilanNetKg'];
        $profilNetAdetEski = $resultProfilEski['toplamAdet'] - $baski['basilanNetAdet'];


        $sqlprofilguncelleEski = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKiloEski',
                    toplamAdet = '$profilNetAdetEski',
                    gelisAmaci = 'baski'
                    where siparis= '$eskiSatirNo'";

        mysqli_query($db, $sqlprofilguncelleEski);

        $profilsqlYeni = "select * from tblstokprofil where baskiId  = '$id'";
        $resultProfilYeni = mysqli_query($db, $profilsqlEski);
        $resultProfilYeni = $resultProfilYeni->fetch_assoc();

        $profilNetKiloYeni = $resultProfilYeni['toplamKg'] + $basilanNetKg;
        $profilNetAdetYeni = $resultProfilYeni['toplamAdet'] + $basilanNetAdet;


        $sqlprofilguncelleYeni = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKiloYeni',
                    toplamAdet = '$profilNetAdetYeni',
                    gelisAmaci = 'baski'
                    where baskiId  = '$id'";

        mysqli_query($db, $sqlprofilguncelleYeni);

    } else {

        $profilsql = "select * from tblstokprofil where baskiId  = '$id'";
        $resultProfil = mysqli_query($db, $profilsql);
        $resultProfil = $resultProfil->fetch_assoc();

        $profilNetKilo = $resultProfil['toplamKg'] + $basilanNetKg - $baski['basilanNetKg'];
        $profilNetAdet = $resultProfil['toplamAdet'] + $basilanNetAdet - $baski['basilanNetAdet'];

        $sqlprofilguncelle = "UPDATE tblstokprofil set
                    toplamKg = '$profilNetKilo',
                    toplamAdet = '$profilNetAdet',
                    gelisAmaci = 'baski'
                    where baskiId  = '$id'";

        mysqli_query($db, $sqlprofilguncelle);
    }

    if ($yeniSiparisId != $eskiSiparisId) {

        $eskiSiparis = tablogetir('tblsiparis', 'id', $eskiSiparisId, $db);
        $basilanNetAdetSiparisEski = $eskiSiparis['basilanAdet'] - $baski['basilanNetAdet'];
        $basilanNetKgSiparisEski = $eskiSiparis['basilanKilo'] - $baski['basilanNetKg'];

        $sqlSiparisEski = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdetSiparisEski',
                    basilanKilo = '$basilanNetKgSiparisEski',
                    baskiDurum = '0',
                    konum = 'baski'
                    where id = '$eskiSiparisId'";

        mysqli_query($db, $sqlSiparisEski);

        $yeniSiparis = tablogetir('tblsiparis', 'id', $yeniSiparisId, $db);

        $basilanNetAdetSiparisYeni = $yeniSiparis['basilanAdet'] + $basilanNetAdet;
        $basilanNetKgSiparisYeni = $yeniSiparis['basilanKilo'] + $basilanNetKg;

        $sqlSiparisYeni = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdetSiparisYeni',
                    basilanKilo = '$basilanNetKgSiparisYeni',
                    baskiDurum = '$baskiDurum',
                    konum = '$siparisKonum'
                    where id = '$yeniSiparisId'";

        mysqli_query($db, $sqlSiparisYeni);
    } else {

        $yeniSiparis = tablogetir('tblsiparis', 'id', $yeniSiparisId, $db);

        $basilanNetAdetSiparis = $basilanNetAdet + $yeniSiparis['basilanAdet'] - $baski['basilanNetAdet'];
        $basilanNetKgSiparis = $basilanNetKg + $yeniSiparis['basilanKilo'] - $baski['basilanNetKg'];

        $sqlSiparis = "UPDATE tblsiparis set
                    basilanAdet = '$basilanNetAdetSiparis',
                    basilanKilo = '$basilanNetKgSiparis',
                    baskiDurum = '$baskiDurum',
                    konum = '$siparisKonum'
                    where id = '$yeniSiparisId'";

        mysqli_query($db, $sqlSiparis);
    }


    if (mysqli_query($db, $sqlBaski)) {
        header("Location:../../baski/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../baski/?durumguncelleme=no");
        exit();
    }

}

*/