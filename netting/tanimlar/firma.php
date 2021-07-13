<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['firmaekleme'])) {
    try {
        $firmaAd = $_POST['firmaAd'];
        $seo = seo($firmaAd);
        $kisaKod = $_POST['kisaKod'];
        $firmaTurId = $_POST['firmaTurId'];
        $vergiDairesi = $_POST['vergiDairesi'];
        $vergiNumara = $_POST['vergiNumara'];
        $yetkiliKisi = $_POST['yetkiliKisi'];
        $telefon = $_POST['telefon'];
        $mail = $_POST['mail'];
        $adres = $_POST['adres'];
        $il = $_POST['il'];
        $ilce = $_POST['ilce'];
        $aciklama = $_POST['aciklama'];
        $naylon = $_POST['naylon'];

        $sql = "INSERT INTO tblfirma (firmaAd, seo, kisaKod, firmaTurId, vergiDairesi, vergiNumara,
                                      yetkiliKisi, telefon, mail, adres, il, ilce, aciklama, naylon)
                VALUES ('$firmaAd', '$seo','$kisaKod', '$firmaTurId','$vergiDairesi', '$vergiNumara',
                        '$yetkiliKisi', '$telefon','$mail', '$adres','$il', '$ilce', '$aciklama', '$naylon')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/firma/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/firma/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['firmasil'])) {
    $id = $_GET['firmasil'];
    $sql = "DELETE FROM tblfirma where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/firma/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/firma/?durumsil=no");
        exit();
    }
}

if (isset($_POST['firmaguncelleme'])) {
    $id = $_POST['id'];
    $firmaAd = $_POST['firmaAd'];
    $seo = seo($firmaAd);
    $kisaKod = $_POST['kisaKod'];
    $firmaTurId = $_POST['firmaTurId'];
    $vergiDairesi = $_POST['vergiDairesi'];
    $vergiNumara = $_POST['vergiNumara'];
    $yetkiliKisi = $_POST['yetkiliKisi'];
    $telefon = $_POST['telefon'];
    $mail = $_POST['mail'];
    $adres = $_POST['adres'];
    $il = $_POST['il'];
    $ilce = $_POST['ilce'];
    $aciklama = $_POST['aciklama'];
    $naylon = $_POST['naylon'];

    $sql = "UPDATE tblfirma set 
        firmaAd = '$firmaAd', seo = '$seo', kisaKod = '$kisaKod', firmaTurId = '$firmaTurId',
        vergiDairesi = '$vergiDairesi', vergiNumara = '$vergiNumara', yetkiliKisi = '$yetkiliKisi', telefon = '$telefon',
        mail = '$mail', adres = '$adres', il = '$il', ilce = '$ilce',  aciklama = '$aciklama', naylon = '$naylon'
            WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/firma/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/firma/?durumguncelleme=no");
        exit();
    }
}
?>