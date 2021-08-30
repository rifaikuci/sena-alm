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
    $sevkiyasaat = $_POST['sevkiyasaat'];
    $aciklama = $_POST['aciklama'];
    $tarih = $sevkiyatarih . " " . $sevkiyasaat;

    $sevkiyatarihbaslangic = $sevkiyatarih . " 00:00:00";
    $sevkiyatarihbitis = $sevkiyatarih . " 23:59:59";
    $result = $db->query("SELECT COUNT(*)  FROM tblsevkiyat where 
        sevkiyatTarih BETWEEN '$sevkiyatarihbaslangic' AND '$sevkiyatarihbitis'");
    $row = $result->fetch_row();
    $gunlukSevkiyat = $row[0] + 1;
    $kod = date('d.m.Y', strtotime($sevkiyatarih));
    $kod = $kod . "- $gunlukSevkiyat";

    $sql = "INSERT INTO tblsevkiyat (kod, personelId1, personelId2, plaka, sevkiyatTarih, tur, aciklama
        ) VALUES ('$kod', '$personelId1', '$personelId2', '$plaka', '$tarih', 1, '$aciklama')";

    $sevkiyatId = maxIdBul($db, 'tblsevkiyat');

    if (mysqli_query($db, $sql)) {

        $sevkiyatId = maxIdBul($db, 'tblsevkiyat');

        /*************************** Biyetler ********************* */
        $biyetpartino = explode(",", $_POST['biyetpartino']);
        $biyetfirmaId = explode(",", $_POST['biyetfirmaId']);
        $biyetalasimId = explode(",", $_POST['biyetalasimId']);
        $biyetadetbiyet = explode(",", $_POST['biyetadetbiyet']);
        $biyetcap = explode(",", $_POST['biyetcap']);
        $biyetboy = explode(",", $_POST['biyetboy']);
        $sqlBiyet = "INSERT INTO tblstokbiyet (partino, firmaId, alasimId, cap, boy, sevkiyatId, barkodNo, adet)  VALUES ";
        for ($i = 0; $i < count($biyetpartino); $i++) {
            $biyetpartinosatir = $biyetpartino[$i];
            $biyetfirmasatir = $biyetfirmaId[$i];
            $biyetalasimsatir = $biyetalasimId[$i];
            $biyetcapsatir = $biyetcap[$i];
            $biyetboysatir = $biyetboy[$i];
            $firmaKod = firmaKod($biyetfirmasatir, $db);

            for ($j = 0; $j < $biyetadetbiyet[$i]; $j++) {
                $barkod = $firmaKod . mt_rand();
                $sqlBiyet = $sqlBiyet . " ('$biyetpartinosatir', '$biyetfirmasatir', '$biyetalasimsatir','$biyetcapsatir', '$biyetboysatir',  '$sevkiyatId', '$barkod', '$biyetadetbiyet[$i]'),";
            }
        }
        $sqlBiyet[strlen($sqlBiyet) - 1] = ";";


        /*************************** Boyalar ********************* */
        $boyapartino = explode(",", $_POST['boyapartino']);
        $boyafirmaId = explode(",", $_POST['boyafirmaId']);
        $boyaboyaId = explode(",", $_POST['boyaboyaId']);
        $boyaadet = explode(",", $_POST['boyaadet']);
        $boyakilo = explode(",", $_POST['boyakilo']);
        $boyasicaklik = explode(",", $_POST['boyasicaklik']);
        $boyacins = explode(",", $_POST['boyacins']);
        $sqlBoya = "INSERT INTO tblstokboya (partino, firmaId, boyaTuru, sicaklik, cins, sevkiyatId, barkodNo, kilo)  VALUES ";
        for ($i = 0; $i < count($boyapartino); $i++) {
            $boyapartinosatir = $boyapartino[$i];
            $boyafirmasatir = $boyafirmaId[$i];
            $boyapboyaidsatir = $boyaboyaId[$i];
            $boyaadetsatir = $boyaadet[$i];
            $boyakilosatir = $boyakilo[$i];
            $boyasicakliksatir = $boyasicaklik[$i];
            $boyacinssatir = $boyacins[$i];

            $firmaKod = firmaKod($boyafirmasatir, $db);

            for ($j = 0; $j < $boyaadetsatir; $j++) {
                $barkod = $firmaKod . mt_rand();
                $sqlBoya = $sqlBoya . " ('$boyapartinosatir', '$boyafirmasatir', '$boyapboyaidsatir','$boyasicakliksatir', '$boyacinssatir',  '$sevkiyatId', '$barkod', '$boyaadetsatir'),";
            }
        }
        $sqlBoya[strlen($sqlBoya) - 1] = ";";

        /*************************** Malzemeler ********************* */
        $malzemepartino = explode(",", $_POST['malzemepartino']);
        $malzemefirmaId = explode(",", $_POST['malzemefirmaId']);
        $malzemeId = explode(",", $_POST['malzememalzemeId']);
        $malzemeadet = explode(",", $_POST['malzemeadet']);

        $sqlMalzeme = "INSERT INTO tblstokmalzeme (partino, firmaId, malzemeId, sevkiyatId, barkod, adet)  VALUES ";
        for ($i = 0; $i < count($malzemepartino); $i++) {
            $malzemepartinosatir = $malzemepartino[$i];
            $malzemefirmasatir = $malzemefirmaId[$i];
            $malzemeidsatir = $malzemeId[$i];
            $malzemeadetsatir = $malzemeadet[$i];

            $firmaKod = firmaKod($malzemefirmasatir, $db);

            for ($j = 0; $j < $malzemeadetsatir; $j++) {
                $barkod = $firmaKod . mt_rand();
                $sqlMalzeme = $sqlMalzeme . " ('$malzemepartinosatir', '$malzemefirmasatir', '$malzemeidsatir', '$sevkiyatId', '$barkod', '$malzemeadetsatir'),";
            }
        }

        $sqlMalzeme[strlen($sqlMalzeme) - 1] = ";";

        $profilprofilId = explode(",", $_POST['profilprofilId']);
        $profilfirmaId = explode(",", $_POST['profilfirmaId']);
        $profilmusteriId = explode(",", $_POST['profilmusteriId']);
        $profiltur = explode(",", $_POST['profiltur']);
        $profilgelisAmaci = explode(",", $_POST['profilgelisAmaci']);
        $profilboy = explode(",", $_POST['profilboy']);
        $profiltoplamkilo = explode(",", $_POST['profiltoplamkilo']);
        $profilicadet = explode(",", $_POST['profilicadet']);
        $profilpaketAdet = explode(",", $_POST['profilpaketAdet']);
        $profiltoplamadet = explode(",", $_POST['profiltoplamadet']);

        $sqlProfil = "INSERT INTO tblstokprofil (profilId, firmaId, musteriId, tur, gelisAmaci, boy, toplamKg, icAdet, paketAdet, toplamAdet, siparisNo, sevkiyatId)  VALUES ";
        for ($i = 0; $i < count($profilprofilId); $i++) {

            $siparisno = "SN" . mt_rand();
            $sqlProfil = $sqlProfil . " ('$profilprofilId[$i]', '$profilfirmaId[$i]', '$profilmusteriId[$i]','$profiltur[$i]' , '$profilgelisAmaci[$i]', '$profilboy[$i]', '$profiltoplamkilo[$i]',
            '$profilicadet[$i]', '$profilpaketAdet[$i]', '$profiltoplamadet[$i]','$siparisno', '$sevkiyatId'),";
        }
        $sqlProfil[strlen($sqlProfil) - 1] = ";";
        try {
            if(count($biyetpartino) > 0) {
                mysqli_query($db, $sqlBiyet);
            }
            if(count($boyapartino) > 0) {
                mysqli_query($db, $sqlBoya);
            }
            if(count($malzemepartino) > 0) {
                mysqli_query($db, $sqlMalzeme);
            }
            if(count($profilprofilId) > 0 && $_POST['profilprofilId']) {
                mysqli_query($db, $sqlProfil);
            }

            header("Location:../../sevkiyat/gelen/?durumekle=ok");
            exit();
        } catch (Exception $e) {
            echo $e;
        }
    } else {
        header("Location:../../sevkiyat/gelen/?durumekle=no");
        exit();
    }
}

if (isset($_GET['gelensil'])) {
    $id = $_GET['gelensil'];
    $sql = "DELETE FROM tblsevkiyat where id = '$id' ";
    $sqlstokbiyet = "DELETE FROM tblstokbiyet where sevkiyatId = '$id' ";
    $sqlstokboya = "DELETE FROM tblstokboya where sevkiyatId = '$id' ";
    $sqlstokmalzeme = "DELETE FROM tblstokmalzeme where sevkiyatId = '$id' ";
    $sqlstokprofil = "DELETE FROM tblstokprofil where sevkiyatId = '$id' ";

    if (mysqli_query($db, $sql)) {
        mysqli_query($db, $sqlstokbiyet);
        mysqli_query($db, $sqlstokboya);
        mysqli_query($db, $sqlstokmalzeme);
        mysqli_query($db, $sqlstokprofil);
        header("Location:../../sevkiyat/gelen/?durumsil=ok");
        exit();
    } else {
        header("Location:../../sevkiyat/gelen/?durumsil=no");
        exit();
    }


}
?>