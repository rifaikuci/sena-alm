<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'baskigetir') {

    $id = $received_data->id;
    $sql = "SELECT * FROM tblsiparis WHERE id = '$id' ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = firmaBul($row['musteriId'],$db,'firmaAd');
        $data['profil'] = profilbul($row['profilId'],$db,'profilAdi'). " - ". profilbul($row['profilId'],$db,'profilNo');
        $data['alasim'] = alasimBul($row['alasimId'],$db,'ad');
        $data['tolerans'] = $row['maxTolerans'];
        $data['boy'] = $row['boy'];
        $data['kg'] = $row['kilo'];
        $data['adet'] = $row['adet'];
        $data['aciklama'] = $row['baskiAciklama'];

    }

    echo json_encode($data);
}

?>