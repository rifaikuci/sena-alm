<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
date_default_timezone_set('Europe\Istanbul');

//ini_set('display_errors', 1);


if (isset($_GET['siparissatirSil'])) {
    $satirno = $_GET['siparisSil'];
    $sql = "DELETE FROM tblsiparis where satirNo = '$satirno' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../siparis-satir/?durumsil=ok");
        exit();
    } else {
        header("Location:../../siparis-satir/?durumsil=no");
        exit();
    }
}

if (isset($_POST['siparissaitrguncelle'])) {
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
    $araKagit = strval($_POST['araKagit']) == "true" ? 1 : 0;;
    $krepeKagit = strval($_POST['krepeKagit']) == "true" ? 1 : 0;;
    $naylonDurum = $_POST['naylonDurum'];
    $istenilenTermin = $_POST['istenilenTermin'];
    $kiloAdet = $_POST['kiloAdet'];
    $baskiAciklama = $_POST['baskiAciklama'];
    $paketAciklama = $_POST['paketAciklama'];
    $boyaAciklama = $_POST['boyaAciklama'];
    $konum = $_POST['konum'];
    $id = $_POST['id'];
    $siparisTurKod = substr($_POST['siparisTur'], 0, 1);
    $satirNo[3] = $siparisTurKod;
    $kiloAdet = "";
    if ($kiloAdet == "A") {
        $kiloAdet = 'A';
    } else {
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
        siparisTuru = '$siparisTurKod',
        kiloAdet = '$kiloAdet',
        baskiAciklama = '$baskiAciklama',
        paketAciklama = '$paketAciklama',
        boyaAciklama = '$boyaAciklama',
        profilId = '$profilId',
        konum = '$konum'
WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../siparis-satir/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../siparis-satir/?durumguncelleme=no");
        exit();
    }

}


?>