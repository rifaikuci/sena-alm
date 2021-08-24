<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

if (isset($_POST['sevkiyatekle'])) {
    /*
      echo "Biyet Pari No : " .    $_POST['biyetpartino']."\n";
      echo "Biyet Pari No : " .    $_POST['biyetfirma']."\n";
      echo "Biyet Pari No : " .    $_POST['biyetalasim']."\n";
      echo "Biyet Pari No : " .    $_POST['biyetadetbiyet']."\n";
      echo "Biyet Pari No : " .    $_POST['biyetcap']."\n";
      echo "Biyet Pari No : " .    $_POST['biyetboy']."\n";
    */
    $personelId1 = $_POST['personelId1'];
    $personelId2 = $_POST['personelId2'];
    $plaka = $_POST['plaka'];
    $sevkiyatarih = $_POST['sevkiyatarih'];
    $sevkiyasaat= $_POST['sevkiyasaat'];
    $aciklama= $_POST['aciklama'];
    $tarih = $sevkiyatarih . " " . $sevkiyasaat;

    $sevkiyatarihbaslangic  = $sevkiyatarih. " 00:00:00";
    $sevkiyatarihbitis  = $sevkiyatarih. " 23:59:59";
    $result = $db->query("SELECT COUNT(*)  FROM tblsevkiyat where 
        sevkiyatTarih BETWEEN '$sevkiyatarihbaslangic' AND '$sevkiyatarihbitis'");
    $row = $result->fetch_row();
    $gunlukSevkiyat =  $row[0] + 1;
    $kod = date('d.m.Y',strtotime($sevkiyatarih));
    $kod = $kod . "- $gunlukSevkiyat";

    $sql = "INSERT INTO tblsevkiyat (kod, personelId1, personelId2, plaka, sevkiyatTarih, tur, aciklama
        ) VALUES ('$kod', '$personelId1', '$personelId2', '$plaka', '$tarih', 1, '$aciklama')";

     $sevkiyatId = maxIdBul($db,'tblsevkiyat');

    if (mysqli_query($db, $sql)) {
        echo "başarılı";
        exit();
    } else {
        echo 'basarisi';
        exit();
    }

}
?>