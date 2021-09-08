<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
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
        $paketEn = $_POST['paketEn'];
        $paketBoy = $_POST['paketBoy'];
        $balyaAdet = $_POST['balyaAdet'];
        $maxGramaj = $_POST['maxGramaj'];
        $ezilmeKatsayisi = $_POST['ezilmeKatsayisi'];
        $aciklama = $_POST['aciklama'];
        $cizim = $_POST['cizim'];
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

        if ($_FILES['cizim']['name'] != "") {
            $cizim = imageUpload("cizim", "asset/img/profilcizim");

            if ($cizim == "hataboyimage") {
                header("Location:../../tanimlar/profil/?hataboyimage=ok");
                exit();
            } else if ($cizim == "gecersizturimage") {
                header("Location:../../tanimlar/profil/?gecersizturimage=ok");
                exit();
            } else if ($cizim == "hataimage") {
                header("Location:../../tanimlar/profil/?hataimage=ok");
                exit();
            }
        }

        $sql = "INSERT INTO tblprofil (profilAdi, sektorId, gramaj, alan, cevre, paketAdet,
                                      paketEn, paketBoy, balyaAdet, maxGramaj, ezilmeKatsayisi, aciklama,
                                      seo, resim, paketlemeSekli, sepetDizilmeSekli, cizim )
                VALUES ('$profilAdi', '$sektorId','$gramaj', '$alan','$cevre', '$paketAdet',
                        '$paketEn', '$paketBoy', '$balyaAdet','$maxGramaj', '$ezilmeKatsayisi','$aciklama',
                        '$seo', '$resim', '$paketlemeSekli', '$sepetDizilmeSekli', '$cizim')";

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
    $resim = profilbul($id, $db, 'resim');
    $sepet = profilbul($id, $db, 'sepetDizilmeSekli');
    $paket = profilbul($id, $db, 'paketlemeSekli');
    $cizim= profilbul($id, $db, 'cizim');

    if (file_exists("../../" . $resim)) {
        unlink("../../" . $resim);
    }

    if (file_exists("../../" . $sepet)) {
        unlink("../../" . $sepet);
    }

    if (file_exists("../../" . $paket)) {
        unlink("../../" . $paket);
    }

    if (file_exists("../../" . $cizim)) {
        unlink("../../" . $cizim);
    }

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
    $profilAdi = $_POST['profilAdi'];
    $sektorId = $_POST['sektorId'];
    $gramaj = $_POST['gramaj'];
    $alan = $_POST['alan'];
    $cevre = $_POST['cevre'];
    $paketAdet = $_POST['paketAdet'];
    $paketEn = $_POST['paketEn'];
    $paketBoy = $_POST['paketBoy'];
    $balyaAdet = $_POST['balyaAdet'];
    $maxGramaj = $_POST['maxGramaj'];
    $ezilmeKatsayisi = $_POST['ezilmeKatsayisi'];
    $aciklama = $_POST['aciklama'];
    $seo = seo($profilAdi);
    $resimyol = $_POST['resimyol'];
    $sepetyol = $_POST['sepetyol'];
    $paketyol = $_POST['paketyol'];
    $cizimyol = $_POST['cizimyol'];

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
        } else {
            if (file_exists("../../" . $resimyol)) {
                unlink("../../" . $resimyol);
            }
            $resimyol = $resim;
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
        } else {
            if (file_exists("../../" . $paketyol)) {

                unlink("../../" . $paketyol);
            }
            $paketyol = $paketlemeSekli;
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
        } else {
            if (file_exists("../../" . $sepetyol)) {
                unlink("../../" . $sepetyol);

            }
            $sepetyol = $sepetDizilmeSekli;

        }
    }

    if ($_FILES['cizim']['name'] != "") {
        $cizim = imageUpload("cizim", "asset/img/profilcizim");

        if ($cizim == "hataboyimage") {
            header("Location:../../tanimlar/profil/?hataboyimage=ok");
            exit();
        } else if ($cizim == "gecersizturimage") {
            header("Location:../../tanimlar/profil/?gecersizturimage=ok");
            exit();
        } else if ($cizim == "hataimage") {
            header("Location:../../tanimlar/profil/?hataimage=ok");
            exit();
        } else {
            if (file_exists("../../" . $cizimyol)) {
                unlink("../../" . $cizimyol);

            }
            $cizimyol = $cizim;

        }
    }


    $sql = "UPDATE tblprofil set 
        profilAdi = '$profilAdi', sektorId = '$sektorId', gramaj = '$gramaj', alan = '$alan',
        cevre = '$cevre', paketAdet = '$paketAdet', paketEn = '$paketEn', paketBoy = '$paketBoy', balyaAdet = '$balyaAdet', 
                       maxGramaj = '$maxGramaj', ezilmeKatsayisi ='$ezilmeKatsayisi', aciklama = '$aciklama',
                    seo = '$seo', resim = '$resimyol', paketlemeSekli = '$paketyol' , sepetDizilmeSekli  = '$sepetyol', cizim = '$cizim'  
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