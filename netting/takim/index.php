<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);


if (isset($_POST['profilId']) && isset($_POST['kalipCins']) ) {
    $profilId = $_POST['profilId'];
    $cap = $_POST['cap'];
    $kalipCins = $_POST['kalipCins'];
    $bolsterler = $_POST['bolsterler'];
    $destekler = $_POST['destekler'];
    $firmaId = $_POST['firmaId'];
    $parca1 = $_POST['parca1SenaNo'];
    $parca2 = $_POST['parca2SenaNo'];
    $profil = $_POST['profil'];
    $kisaKod = firmaBul($firmaId, $db, 'kisaKod');
    $sonEk = firmaTakimNoBul($db, "tbltakim", $firmaId, $profilId);
    $takimNo = "SN-" . $kisaKod . $profil . "-";
    $sonEk = sprintf('%03d', $sonEk);
    $takimNo = $takimNo . $sonEk;
    $parca2 = $parca2 == "Parçayı Seç" ? "" : $parca2;
    $sonGramaj = profilbul($profilId,$db,'gramaj');


    $bolster = "";
    for ($i = 0; $i < count($bolsterler); $i++) {
        if ($i == count($bolsterler) - 1) {
            $bolster = $bolster . $bolsterler[$i];
        } else {
            $bolster = $bolster . $bolsterler[$i] . ",";
        }
    }
    $destek = "";
    for ($i = 0; $i < count($destekler); $i++) {
        if ($i == count($destekler) - 1) {
            $destek = $destek . $destekler[$i];
        } else {
            $destek = $destek . $destekler[$i] . ",";
        }
    }

    $sql = "INSERT INTO tbltakim (parca1, parca2, takimNo, firmaId, profilId, cap, kalipCins, bolster, destek,sonGramaj)
                            VALUES ('$parca1', '$parca2','$takimNo', '$firmaId','$profilId', '$cap', '$kalipCins', '$bolster', '$destek', '$sonGramaj')";

    if (mysqli_query($db, $sql)) {
        $updateParca = "UPDATE tblkalipparcalar set 
                    takimNo = '$takimNo' WHERE senaNo='$parca1' OR senaNo='$parca2' ";
        mysqli_query($db, $updateParca);
        header("Location:../../takim/?durumekle=ok");
        exit();
    } else {
        header("Location:../../takim/?durumekle=no");
        exit();
    }
}


if (isset($_POST['copetakim'])) {

    $takimno = $_POST['takimno'];
    $parca1 = $_POST['parca1'];
    $parca2 = $_POST['parca2'];
    $parca1cop = $_POST['parca1cop'];
    $parca2cop = $_POST['parca2cop'];
    $updateTakim = "UPDATE tbltakim set 
                    durum = 2 WHERE takimNo='$takimno'";
    mysqli_query($db, $updateTakim);

        if($parca1) {
            $parca1sql = "UPDATE tblkalipparcalar set 
                    durum = 2, copNedeni = '$parca1cop' WHERE senaNo = '$parca1'";
            mysqli_query($db, $parca1sql);
        }

    if($parca2) {
        $parca2sql = "UPDATE tblkalipparcalar set 
                    durum = 2, copNedeni = '$parca2cop' WHERE senaNo = '$parca2'";
        mysqli_query($db, $parca2sql);
    }



        header("Location:../../takim/?durumcop=ok");
        exit();
}

if (isset($_POST['takimdegistir'])) {



    $copNedeni = $_POST['commentText'];
    $takimNo = $_POST['takimNo'];
    $parcaeski = $_POST['parcaeski'];
    $parcayeni = $_POST['parcayeni'];
    $parcaNo = $_POST['parcaNo'];
    $sonGramaj = $_POST['sonGramaj'];


    $sql1 = "UPDATE tblkalipparcalar set 
                    durum = 2, copNedeni = '$copNedeni' WHERE senaNo = '$parcaeski'";
    mysqli_query($db, $sql1);

    $sql2 = "UPDATE tblkalipparcalar set 
                     takimNo = '$takimNo' WHERE senaNo = '$parcayeni'";
    mysqli_query($db, $sql2);


    if($parcaNo == 1) {
        $sql3 = "UPDATE tbltakim set 
                     parca1 = '$parcayeni', sonGramaj = '$sonGramaj' WHERE takimNo = '$takimNo'";

    }else {
        $sql3 = "UPDATE tbltakim set 
                     parca2 = '$parcayeni', sonGramaj = '$sonGramaj' WHERE takimNo = '$takimNo'";
    }


    if (mysqli_query($db, $sql3)) {

        header("Location:../../takim/?durumdegis=ok");
        exit();
    } else {
        header("Location:../../takim/?durumdegis=no");
        exit();
    }
}


if (isset($_POST['desbols'])) {


    $bolsterler = $_POST['bolsterler'];
    $destekler = $_POST['destekler'];
    $takimNo = $_POST['takim'];

    $bolster = "";
    for ($i = 0; $i < count($bolsterler); $i++) {
        if ($i == count($bolsterler) - 1) {
            $bolster = $bolster . $bolsterler[$i];
        } else {
            $bolster = $bolster . $bolsterler[$i] . ",";
        }
    }
    $destek = "";
    for ($i = 0; $i < count($destekler); $i++) {
        if ($i == count($destekler) - 1) {
            $destek = $destek . $destekler[$i];
        } else {
            $destek = $destek . $destekler[$i] . ",";
        }
    }


    $sql = "UPDATE tbltakim set 
                     bolster = '$bolster', destek = '$destek' WHERE takimNo = '$takimNo'";
    if (mysqli_query($db, $sql)) {

        header("Location:../../takim/?desbols=ok");
        exit();
    } else {
        header("Location:../../takim/?desbols=no");
        exit();
    }
}



?>