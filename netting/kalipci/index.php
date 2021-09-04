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
    $kalipciNo = firmaBul($firmaId,$db,'kisaKod'). $_POST['kalipciNo'];
    $cap = $_POST['cap'];
    $kalite = $_POST['kalite'];
    $figurSayi = $_POST['figurSayi'];
    $takimNo= "";
    $netKilo= 0;
    $brutKilo= 0;
    $durum = 1; //1 Aktif 2 Pasif 3 Çöp
    $maxId = maxIdBul($db,"tblkalipparcalar") + 1;
    $maxId =  sprintf('%04d',$maxId);
    $prefix = $_POST['prefix'];
    if($kalipCins  == 4) {
        $cap = 220;
        $parca = 100;
        $prefix = "BOL";
    }

    $senaNo = "SN-".$prefix.$maxId;




    $sql = "INSERT INTO tblkalipparcalar (firmaId, profilId, kalipCins, parca, senaNo, kalipciNo,
                                      cap, kalite, figurSayi, takimNo, durum, netKilo, brutKilo)
                VALUES ('$firmaId', '$profilId','$kalipCins', '$parca','$senaNo', '$kalipciNo',
                        '$cap', '$kalite','$figurSayi', '$takimNo','$durum', '$netKilo', '$brutKilo')";

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
    $kalipciNo = firmaBul($firmaId,$db,'kisaKod'). $_POST['kalipciNo'];
    $cap = $_POST['cap'];
    $kalite = $_POST['kalite'];
    $figurSayi = $_POST['figurSayi'];


    $sql = "UPDATE tblkalipparcalar set 
        firmaId = '$firmaId', profilId = '$profilId', kalipciNo = '$kalipciNo', cap = '$cap',
        kalite = '$kalite', figurSayi = '$figurSayi' WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        header("Location:../../kalipci/?durumguncelleme=ok");
        exit();
    } else {
        header("Location:../../kalipci/?durumguncelleme=no");
        exit();
    }
}


?>