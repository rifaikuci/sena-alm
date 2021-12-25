<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
date_default_timezone_set('Europe\Istanbul');

ini_set('display_errors', 1);


if (isset($_POST['siparisekle'])) {

    $musteriId = $_POST['musteriId'];
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $siparisTarih = date("Y-m-d H:i:s");
    $arrayProfil = explode(",", $_POST['arrayProfilId']);
    $arrayBoy = explode(",", $_POST['arrayBoy']);
    $arrayAdet = explode(",", $_POST['arrayAdet']);
    $arrayKilo = explode(",", $_POST['arrayKilo']);
    $arraySiparisTur = explode(",", $_POST['arraySiparisTur']);
    $arrayAlasimId = explode(",", $_POST['arrayAlasimId']);
    $arrayTermimTarih = explode(",", $_POST['arrayTermimTarih']);
    $arrayMaxTolerans = explode(",", $_POST['arrayMaxTolerans']);
    $arrayAraKagit = explode(",", $_POST['arrayAraKagit']);
    $arrayKrepeKagit = explode(",", $_POST['arrayKrepeKagit']);
    $arrayNaylonId = explode(",", $_POST['arrayNaylonId']);
    $arrayBoyaId = explode(",", $_POST['arrayBoyaId']);
    $arrayEloksalId = explode(",", $_POST['arrayEloksalId']);
    $arrayBaskiAciklama = explode(",", $_POST['arrayBaskiAciklama']);
    $arrayPaketAciklama = explode(",", $_POST['arrayPaketAciklama']);
    $arrayBoyaAciklama = explode(",", $_POST['arrayBoyaAciklama']);
    $arrayIstenilenTermin = explode(",", $_POST['arrayIstenilenTermin']);
    $arrayKiloAdet = explode(",", $_POST['arrayKiloAdet']);

    $yil = date('y');
    $ay = str_pad(date('m'), 2, "0", STR_PAD_LEFT);
    $gun = str_pad(date('d'), 2, "0", STR_PAD_LEFT);
    $date = new DateTime(date('Y-m-d'));
    $hafta = $date->format("W");
    $hafta = str_pad($hafta, 2, "0", STR_PAD_LEFT);

    $siparisTarihYil = "" . date('Y-m-d');


    $haftaAritmetikSayi = siparisHaftaBul($db, $yil, $hafta);
    $haftaKod = str_pad($haftaAritmetikSayi, 3, "0", STR_PAD_LEFT);
    $siparisNo = "SEN-" . $yil . $hafta . $haftaKod;


    $gunAritmetikSayi = siparisGunBul($db, $yil, $hafta, $gun);
    $gunAritmetik = str_pad($gunAritmetikSayi, 2, "0", STR_PAD_LEFT);


    $sql = "INSERT INTO tblsiparis (profilId, adet, kilo, siparisTuru, alasimId, musteriId, naylonDurum,
                        araKagit, krepeKagit, siparisTarih, termimTarih, istenilenTermin, siparisNo, boyaId,
                        eloksalId, maxTolerans, boy, satirNo, durum,siparisTarihYil,ay, gun, yil, hafta,
                        kiloAdet, kalanAdet, kalanKilo, baskiAciklama, paketAciklama, boyaAciklama, konum, operatorId )  VALUES ";

    $sqlprofil = "INSERT INTO tblstokprofil (profilId, firmaId,musteriId,tur,gelisAmaci, boy, toplamKg, icAdet,paketAdet,toplamAdet, siparisNo, sevkiyatId, istenilenTermin, siparis) VALUES ";

    for ($i = 0; $i < count($arrayProfil); $i++) {

        $siparisTur = strtoupper(substr($arraySiparisTur[$i], 0, 1));
        $gunAritmetik = str_pad($gunAritmetikSayi, 2, "0", STR_PAD_LEFT);
        $satirNo = "SN-" . $siparisTur . $ay . $gun . $gunAritmetik;

        $kiloAdet = "";
        $kalanAdet = "";
        $kalanKilo = "";
        if ($arrayKiloAdet[$i] == "A") {
            $kalanKilo = 0;
            $kalanAdet = $arrayAdet[$i];
            $kiloAdet = 'A';
        } else {
            $kalanKilo = $arrayKilo[$i];
            $kalanAdet = 0;
            $kiloAdet = 'K';

        }
        if ($siparisTur == 'B') {
            $profilTur = "Boyalı";
            $eloksalId = 0;
            $boyaId = $arrayBoyaId[$i];
        } else if ($siparisTur == 'E') {
            $profilTur = "Eloksal";

            $boyaId = 0;
            $eloksalId = $arrayEloksalId[$i];
        } else {
            $profilTur = "Ham";
            $eloksalId = 0;
            $boyaId = 0;
        }


        $sql = $sql . " ('$arrayProfil[$i]', '$arrayAdet[$i]', '$arrayKilo[$i]','$siparisTur' , 
        '$arrayAlasimId[$i]', '$musteriId', '$arrayNaylonId[$i]', $arrayAraKagit[$i], $arrayKrepeKagit[$i],
        '$siparisTarih', '$arrayTermimTarih[$i]', '$arrayIstenilenTermin[$i]', '$siparisNo', '$boyaId',
        '$eloksalId', '$arrayMaxTolerans[$i]', '$arrayBoy[$i]','$satirNo', '0', '$siparisTarihYil', '$ay',
        '$gun', '$yil', '$hafta', '$kiloAdet', '$kalanAdet','$kalanKilo', '$arrayBaskiAciklama[$i]', 
         '$arrayPaketAciklama[$i]', '$arrayBoyaAciklama[$i]', 'baski', '$operatorId'),";

        $sqlprofil = $sqlprofil . "('$arrayProfil[$i]', '0', '$musteriId', '$profilTur', 'uretim', '$arrayBoy[$i]', '0','0','0','0','0','0','$arrayIstenilenTermin[$i]', '$satirNo' ),";

        $gunAritmetikSayi++;

    }
    $sql[strlen($sql) - 1] = ";";
    $sqlprofil[strlen($sqlprofil) - 1] = ";";


    if (mysqli_query($db, $sql)) {

        mysqli_query($db, $sqlprofil);
        header("Location:../../siparis/?durumekle=ok");
        exit();
    } else {
        header("Location:../../siparis/?durumekle=no");
        exit();
    }
}

if (isset($_GET['siparisSil'])) {
    $siparisNo = $_GET['siparisSil'];
    $sql = "DELETE FROM tblsiparis where siparisNo = '$siparisNo' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../siparis/?durumsil=ok");
        exit();
    } else {
        header("Location:../../siparis/?durumsil=no");
        exit();
    }
}

if (isset($_GET['satirsil'])) {
    $satirNo = $_GET['satirsil'];
    $siparisno = $_GET['siparisno'];
    $sql = "DELETE FROM tblsiparis where satirNo = '$satirNo' ";
    if (mysqli_query($db, $sql)) {
        header("Location:/sena/siparis/goruntule?siparisno=" . $siparisno);
        exit();
    } else {
        header("Location:/sena/siparis/goruntule?siparisno=" . $siparisno);
        exit();
    }
}

if (isset($_POST['guncellesatir'])) {
    $satirNo = $_POST['satirNo'];
    $profilId = $_POST['profilId'];
    $boy = $_POST['boy'];
    $adet = $_POST['adet'];
    $kilo = $_POST['kilo'];
    $boyaId = $_POST['boyaId'];
    $eloksalId = $_POST['eloksalId'];
    $alasimId = $_POST['alasimId'];
    $termimTarih = $_POST['termimTarih'];
    $maxTolerans = $_POST['maxTolerans'];
    $araKagit = $_POST['araKagit'];
    $krepeKagit = $_POST['krepeKagit'];
    $naylonDurum = $_POST['naylonDurum'];
    $istenilenTermin = $_POST['istenilenTermin'];
    $kiloAdet = $_POST['kiloAdet'];
    $baskiAciklama = $_POST['baskiAciklama'];
    $paketAciklama = $_POST['paketAciklama'];
    $boyaAciklama = $_POST['boyaAciklama'];
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $id = $_POST['id'];
    $siparisTurKod = substr($_POST['siparisTur'], 0, 1);
    $satirNo[3] = $siparisTurKod;

    $kiloAdet = "";
    $kalanAdet = "";
    $kalanKilo = "";
    if ($kiloAdet == "A") {
        $kalanKilo = 0;
        $kalanAdet = $adet;
        $kiloAdet = 'A';
    } else {
        $kalanKilo = $kilo;
        $kalanAdet = 0;
        $kiloAdet = 'K';

    }

    if ($siparisTurKod == 'B') {
        $eloksalId = 0;
    } else if ($siparisTurKod == 'E') {
        $boyaId = 0;
    } else {
        $eloksalId = 0;
        $boyaId = 0;
    }

    $sql = "UPDATE tblsiparis set 
        profilId = '$profilId',
        boy = '$boy',
        adet = '$adet',
        kilo = '$kilo',
        boyaId = '$boyaId',
        eloksalId = '$eloksalId',
        alasimId = '$alasimId',
        termimTarih = '$termimTarih',
        maxTolerans = '$maxTolerans',
        araKagit = '$araKagit',
        krepeKagit = '$krepeKagit',
        naylonDurum = '$naylonDurum',
        istenilenTermin = '$istenilenTermin',
        satirNo = '$satirNo',
        siparisTuru = '$siparisTurKod',
        kalanAdet = '$kalanAdet',
        kalanKilo = '$kalanKilo',
        kiloAdet = '$kiloAdet',
        baskiAciklama = '$baskiAciklama',
        paketAciklama = '$paketAciklama',
        boyaAciklama = '$boyaAciklama',
        operatorId = '$operatorId'
WHERE id='$id'";

    mysqli_query($db, $sql);

}


?>
