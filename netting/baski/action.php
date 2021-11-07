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
        $data['musteriAd'] = firmaBul($row['musteriId'], $db, 'firmaAd');
        $data['profil'] = profilbul($row['profilId'], $db, 'profilAdi') . " - " . profilbul($row['profilId'], $db, 'profilNo');
        $data['alasim'] = alasimBul($row['alasimId'], $db, 'ad');
        $data['biyetBirimGramaj'] = alasimBul($row['alasimId'], $db, 'biyetBirimGramaj');
        $data['tolerans'] = $row['maxTolerans'];
        $data['boy'] = $row['boy'];
        $data['kg'] = $row['kilo'];
        $data['adet'] = $row['adet'];
        $data['aciklama'] = $row['baskiAciklama'];
        $data['profilId'] = $row['profilId'];
        $data['basilanKilo'] = $row['basilanKilo'];
        $data['basilanAdet'] = $row['basilanAdet'];
        $data['kiloAdet'] = $row['kiloAdet'];

    }

    echo json_encode($data);
}


if ($received_data->action == 'takimgetir') {

    $profilId = $received_data->profil;
    $sql = "SELECT * FROM tbltakim WHERE durum = '1' AND profilId = '$profilId' order by sonGramaj asc";

    $result = $db->query($sql);
    $datas = array();
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['parca1'] = $row['parca1'];
        $data['parca2'] = $row['parca2'];
        $data['takimNo'] = $row['takimNo'];
        $data['firma'] = firmaBul($row['firmaId'], $db, 'firmaAd');
        $data['sonGramaj'] = $row['sonGramaj'];
        $data['cap'] = $row['cap'];
        $data['kalipCins'] = kalipBul($row['kalipCins']);
        array_push($datas, $data);
    }

    echo json_encode($datas);
}

if ($received_data->action == 'baskibaslat') {
    $baslazamani = $received_data->baslazamani;
    $siparisId = $received_data->siparisId;
    $takimId = $received_data->takimId;

    $sql = "INSERT INTO tblbaski ( baslaZamani, siparisId, takimId)
                VALUES ('$baslazamani','$siparisId','$takimId')";

    if (mysqli_query($db, $sql)) {

        $baski = mysqli_insert_id($db);
        $data['baski'] = $baski;

    }

    echo json_encode($data);
}


?>