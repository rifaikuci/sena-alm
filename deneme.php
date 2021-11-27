<?php

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
    $vardiya = ayarSqlBul(1, $db, 'vardiya');
    $vardiyaKod = vardiyaBul($vardiya, "H:i");
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


    $sqlHurda = "INSERT INTO tblhurda (toplamKg, aciklama,operatorId,baskiId, geldigiYer) 
                VALUES ('$fire', 'Baskı Firesi', '$operatorId', '$id' 'baski')";

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
                    toplamAdet = '$profilNetAdet',
                    gelisAmaci = 'baski'
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


?>
