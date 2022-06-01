<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if (isset($_POST['takimId']) && isset($_POST['oldProcess']) && isset($_POST['newProcess'])) {
    $oldProcess = $_POST['oldProcess'];
    $takimId = $_POST['takimId'];
    $newProcess = $_POST['newProcess'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : '';
    $kostikHavuzId = 0;
    $kumlamaHavuzId = 0;
    $teneferHavuzId = 0;
    $etKalinlik = 0;
    $tur = 0;

    $takim = tablogetir("tbltakim", "id", $takimId, $db);
    $profil = tablogetir("tblprofil", "id", $takim['profilId'], $db);
    $etKalinlik  = $profil['etKalinlik'];
    $teneferSayisi = $takim['teneferSayisi'];
    $yapilanTeneferBaski = $takim['yapilanTeneferBaski'];
    $parca = $takim['parca1'];
    $prefix = $parca[3].$parca[4];




    if ($oldProcess == "K1" || $oldProcess == "T1") {
        $kostikHavuzId = tablogetir("tblhavuz", "tur",  "kostik", $db)['logHavuzId'];

    } else if ($oldProcess == "T2" || $oldProcess == "K2") {
        $kumlamaHavuzId = tablogetir("tblhavuz", "tur", "kum", $db)['logHavuzId'];

    }

    else if ( ($oldProcess == "K3" && $newProcess == "N4" ) ) {
        $tempNewProcess  = "N3";

        $teneferHavuzId = tablogetir("tblhavuz", "tur", "tenefer", $db)['logHavuzId'];
            $sqlTemp = "INSERT INTO tblkaliphane (takimId, oldProcess, newProcess, description, operatorId, kumlamaHavuzId, kostikHavuzId, teneferHavuzId) 
            VALUES ('$takimId', '$oldProcess', '$tempNewProcess', '$description', '$operatorId', '$kumlamaHavuzId', '$kostikHavuzId', '$teneferHavuzId')";

            mysqli_query($db, $sqlTemp);
        $teneferHavuzId = 0;
        $oldProcess = "N3";
        $newProcess = "N4";
        $kumlamaHavuzId = tablogetir("tblhavuz", "tur", "kum", $db)['logHavuzId'];
        $teneferSayisi = $teneferSayisi + 1;
        $yapilanTeneferBaski = 0;

    }

    if(in_array($prefix,["KZ","KK","KD", "BZ", "BK", "BD"]) ) {
        $siradakiTeneferBaski  = teneferBaskiSiraBul(1, $etKalinlik,$teneferSayisi);
    } else {
        $siradakiTeneferBaski  = teneferBaskiSiraBul(2, $etKalinlik,$teneferSayisi);
    }


    $sqlTakim = "UPDATE tbltakim SET konum = '$newProcess', teneferSayisi = '$teneferSayisi', siradakiTeneferBaski = '$siradakiTeneferBaski', yapilanTeneferBaski = '$yapilanTeneferBaski' WHERE id = $takimId";
    mysqli_query($db, $sqlTakim);

    $sql = "INSERT INTO tblkaliphane (takimId, oldProcess, newProcess, description, operatorId, kumlamaHavuzId, kostikHavuzId, teneferHavuzId) 
VALUES ('$takimId', '$oldProcess', '$newProcess', '$description', '$operatorId', '$kumlamaHavuzId', '$kostikHavuzId', '$teneferHavuzId')";


    echo json_encode(mysqli_query($db, $sql));

}

if (isset($_POST['kalipguncelle'])) {
    $takimdurum = isset($_POST['takimdurum']) ? $_POST['takimdurum'] : "";
    $takimId = isset($_POST['takimId']) ? $_POST['takimId'] : "";
    $description = 'işlem manuel olarak yapildi';
    $oldprocess = isset($_POST['oldprocess']) ? $_POST['oldprocess'] : 'P';
    $operatorId = isset($_POST['e']) ? $_POST['operatorId'] : 0;

    if ($oldprocess == "$takimdurum") {
        header("Location:../../kaliphane/?durum=konumayni");
        exit();
    }

    $sqlTakim = "UPDATE tbltakim SET konum = '$takimdurum' WHERE id = $takimId";
    mysqli_query($db, $sqlTakim);

    $sql = "INSERT INTO tblkaliphane (takimId, oldProcess, newProcess, description, operatorId) 
VALUES ('$takimId', '$oldprocess', '$takimdurum', '$description', '$operatorId')";

    if (mysqli_query($db, $sql)) {
        header("Location:../../kaliphane/?durum=ok");
        exit();
    } else {
        header("Location:../../kaliphane/?durum=no");
        exit();
    }


}


?>