<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'kilo') {

    $profilId  = $received_data->profilId;

    $sql = "SELECT AVG(sonGramaj) as deger from tbltakim where durum = 1  AND profilId = '$profilId' ";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['ortalama'] = $row['deger'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'tolerans') {

    $profilId  = $received_data->profilId;
    $deger  = $received_data->deger;

    $sql = "SELECT  * from tblprofil where id = '$profilId' ";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    $gramaj = $row['gramaj'];
    $gramaj = $gramaj +  (($gramaj *  $deger) / 100 );

    $sqlMax = "SELECT  * FROM tbltakim where durum  = 1 and profilId = '$profilId'";
    $takimGramajDegerler = $db->query($sqlMax);

    $array = array();
    while ($takim = $takimGramajDegerler->fetch_array()) {
        array_push($array,$takim['sonGramaj']);
    }
    $minDeger =  min($array);

    $sonuc = $minDeger <= $gramaj ? false : true;

        $data['deger'] = $sonuc;

    echo json_encode($data);
}



?>