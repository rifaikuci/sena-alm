<?php
include '../baglan.php';
include '../../include/helper.php';
date_default_timezone_set('Europe/Istanbul');

ini_set('display_errors', 1);

if (isset($_POST['profilekleme'])) {
    try {
        $profilAdi = $_POST['profilAdi'];
        $sektorId = $_POST['sektorId'];
        $gramaj = $_POST['gramaj'];
        $alan = $_POST['alan'];
        $cevre = $_POST['cevre'];
        $paketAdet = $_POST['paketAdet'];
        $paketEbat = $_POST['paketEbat'];
        $balyaAdet = $_POST['balyaAdet'];
        $maxGramaj = $_POST['maxGramaj'];
        $ezilmeKatsayisi = $_POST['ezilmeKatsayisi'];
        $aciklama = $_POST['aciklama'];
        $seo = seo($profilAdi);
        $resim = "";
        $paketlemeSekli = "";
        $sepetDizilmeSekli = "";

        if ($_FILES['resim']['name'] != "") {
            $resim = pdfUpload('resim', "asset/img/profilresim/");

            if ($resim == "hataboypdf") {
                header("Location:../../tanimlar/profil/?hataboypdf=ok");
                exit();
            } else if ($resim == "gecersizturpdf") {
                header("Location:../../tanimlar/profil/?gecersizturpdf=ok");
                exit();
            } else if ($resim == "hatapdf") {
                header("Location:../../tanimlar/profil/?hatapdf=ok");
                exit();
            }

        }

        if ($_FILES['paketlemeSekli']['name'] != "") {
            $paketlemeSekli = imageUpload("paketlemeSekli", "asset/img/profilpaketleme");
            if ($paketlemeSekli == "hataboyimage") {
                header("Location:../../tanimlar/profil/?hataboyimage=ok");
                exit();
            } else if ($paketlemeSekli == "gecersizturimage") {
                header("Location:../../tanimlar/profil/?gecersizturimage=ok");
                exit();
            } else if ($paketlemeSekli == "hataimage") {
                header("Location:../../tanimlar/profil/?hataimage=ok");
                exit();
            }
        }

        if ($_FILES['sepetDizilmeSekli']['name'] != "") {
            $sepetDizilmeSekli = imageUpload("sepetDizilmeSekli", "asset/img/profilsepet");

            if ($sepetDizilmeSekli == "hataboyimage") {
                header("Location:../../tanimlar/profil/?hataboyimage=ok");
                exit();
            } else if ($sepetDizilmeSekli == "gecersizturimage") {
                header("Location:../../tanimlar/profil/?gecersizturimage=ok");
                exit();
            } else if ($sepetDizilmeSekli == "hataimage") {
                header("Location:../../tanimlar/profil/?hataimage=ok");
                exit();
            }
        }

        $sql = "INSERT INTO tblprofil (profilAdi, sektorId, gramaj, alan, cevre, paketAdet,
                                      paketEbat, balyaAdet, maxGramaj, ezilmeKatsayisi, aciklama,
                                      seo, resim, paketlemeSekli, sepetDizilmeSekli )
                VALUES ('$profilAdi', '$sektorId','$gramaj', '$alan','$cevre', '$paketAdet',
                        '$paketEbat', '$balyaAdet','$maxGramaj', '$ezilmeKatsayisi','$aciklama',
                        '$seo', '$resim', '$paketlemeSekli', '$sepetDizilmeSekli')";

        if (mysqli_query($db, $sql)) {
            header("Location:../../tanimlar/profil/?durumekle=ok");
            exit();
        } else {
            header("Location:../../tanimlar/profil/?durumekle=no");
            exit();
        }
    } catch (ErrorException $e) {
        echo $e;
    }
}

if (isset($_GET['profilsil'])) {
    $id = $_GET['profilsil'];
    $sql = "DELETE FROM tblprofil where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/profil/?durumsil=ok");
        exit();
    } else {
        header("Location:../../tanimlar/profil/?durumsil=no");
        exit();
    }
}

if (isset($_POST['profilguncelleme'])) {
    $id = $_POST['id'];
    $adsoyad = $_POST['adsoyad'];
    $isegiristarih = $_POST['isegiristarih'];
    $isecikistarih = $_POST['isecikistarih'];
    $adres = $_POST['adres'];
    $tc = $_POST['tc'];
    $telefon = $_POST['telefon'];
    $mail = $_POST['mail'];
    $bedentshirt = $_POST['bedentshirt'];
    $bedenpantalon = $_POST['bedenpantalon'];
    $bedenayakkabi = $_POST['bedenayakkabi'];
    $rolId = $_POST['rolId'];

    $sql = "UPDATE tblprofil set 
        adsoyad = '$adsoyad', isegiristarih = '$isegiristarih', isecikistarih = '$isecikistarih', adres = '$adres',
        tc = '$tc', telefon = '$telefon', mail = '$mail', bedentshirt = '$bedentshirt', 
                       bedenpantalon = '$bedenpantalon', bedenayakkabi ='$bedenayakkabi', rolId = '$rolId' 
            WHERE id='$id'";
    if (mysqli_query($db, $sql)) {
        header("Location:../../tanimlar/profil/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../tanimlar/profil/?durumguncelleme=no");
        exit();
    }
}
?>