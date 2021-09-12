<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

if (isset($_POST['kalipciekle'])) {

    $firmaId = $_POST['firmaId'];
    $profilId = $_POST['profilId'];
    $kalipCins = $_POST['kalipCins'];
    $parca = $_POST['parca'];
    $kalipciNo = $_POST['kalipciNo'];
    $cap = $_POST['cap'];
    $kalite = $_POST['kalite'];
    $figurSayi = $_POST['figurSayi'];
    $takimNo = "";
    $netKilo = 0;
    $brutKilo = 0;
    $durum = 1; //1 Aktif 2 Pasif 3 Çöp
    $maxId = maxIdBul($db, "tblkalipparcalar") + 1;
    $maxId = sprintf('%04d', $maxId);
    $prefix = $_POST['prefix'];
    $cizim = "";
    if ($kalipCins == 4) {
        $cap = 220;
        $parca = 100;
        $prefix = "BOL";
    }

    $senaNo = "SN-" . $prefix . $maxId;

    if ($_FILES['cizim']['name'] != "") {
        $cizim = imageUpload("cizim", "asset/img/bolster");
        if ($cizim == "hataboyimage") {
            header("Location:../../kalipci/?hataboyimage=ok");
            exit();
        } else if ($cizim == "gecersizturimage") {
            header("Location:../../kalipci/?gecersizturimage=ok");
            exit();
        } else if ($cizim == "hataimage") {
            header("Location:../../kalipci/?hataimage=ok");
            exit();
        }
    }


    $sql = "INSERT INTO tblkalipparcalar (firmaId, profilId, kalipCins, parca, senaNo, kalipciNo,
                                      cap, kalite, figurSayi, takimNo, durum, netKilo, brutKilo, cizim)
                VALUES ('$firmaId', '$profilId','$kalipCins', '$parca','$senaNo', '$kalipciNo',
                        '$cap', '$kalite','$figurSayi', '$takimNo','$durum', '$netKilo', '$brutKilo', '$cizim')";

    if (mysqli_query($db, $sql)) {
        header("Location:../../kalipci/?durumekle=ok");
        exit();
    } else {
        header("Location:../../kalipci/?durumekle=no");
        exit();
    }
}


if (isset($_GET['kalipsil'])) {
    $id = $_GET['kalipsil'];
    $cizim = parcalarsqlbul($id, $db, 'cizim');
    if (file_exists("../../" . $cizim)) {
        unlink("../../" . $cizim);
    }
    $sql = "DELETE FROM tblkalipparcalar where id = '$id' ";

    if (mysqli_query($db, $sql)) {
        header("Location:../../kalipci/?durumsil=ok");
        exit();
    } else {
        header("Location:../../kalipci/?durumsil=no");
        exit();
    }
}

if (isset($_POST['kalipciguncelleme'])) {

    $id = $_POST['id'];
    $firmaId = $_POST['firmaId'];
    $profilId = $_POST['profilId'];
    $kalipciNo = $_POST['kalipciNo'];
    $cap = $_POST['cap'];
    $kalite = $_POST['kalite'];
    $figurSayi = $_POST['figurSayi'];
    $cizim = parcalarsqlbul($id, $db, 'cizim');

    if ($_FILES['cizim']['name'] != "") {
        if (file_exists("../../" . $cizim)) {
            unlink("../../" . $cizim);
        }
        $cizim = imageUpload("cizim", "asset/img/bolster");
        if ($cizim == "hataboyimage") {
            header("Location:../../kalipci/?hataboyimage=ok");
            exit();
        } else if ($cizim == "gecersizturimage") {
            header("Location:../../kalipci/?gecersizturimage=ok");
            exit();
        } else if ($cizim == "hataimage") {
            header("Location:../../kalipci/?hataimage=ok");
            exit();
        }
    }
    $sql = "UPDATE tblkalipparcalar set 
        firmaId = '$firmaId', profilId = '$profilId', kalipciNo = '$kalipciNo', cap = '$cap',
        kalite = '$kalite', figurSayi = '$figurSayi', cizim = '$cizim' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../kalipci/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../kalipci/?durumguncelleme=no");
        exit();
    }
}


?>