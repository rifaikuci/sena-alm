<?php

include 'baglan.php';
include '../include/helper.php';
include '../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'profilId') {

    $sql = "SELECT * FROM tblprofil WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['ad'] = $row['profilNo'];
        $data['agirlik'] = $row['gramaj'];
        $data['resim'] = base_url() . $row['resim'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'firmaId') {

    $sql = "SELECT * FROM tblfirma WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['firmaAd'] = $row['firmaAd'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'alasimId') {

    $sql = "SELECT * FROM tblalasim WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['ad'] = $row['ad'];
        $data['biyetBirimGramaj'] = $row['biyetBirimGramaj'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'boyaId') {

    $sql = "SELECT * FROM tblprboya WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['ad'] = $row['ad'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'malzemeId') {

    $sql = "SELECT * FROM tblmalzemeler WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['ad'] = $row['ad'];
        $data['miktar'] = $row['birimMiktari'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'destekId') {

    $parca = $received_data->kalipCins == 0 || $received_data->kalipCins == 1 ? '2,5' : ($received_data->kalipCins == 2 ? '8' : ($received_data->kalipCins == 3 ? '10' : '100'));
    $firmaId = $received_data->firmaId;
    $profilId = $received_data->profilId;
    $figur = $received_data->figur;
    $cap = $received_data->cap;
    $sql = "
    select k.id as id,
       senaNo,
       profilId,
       cap,
       kalite,
       figurSayi,
       kalipCins,
       kalipciNo,
       parca,
       durum,
       netKilo,
       brutKilo,
       profilNo,
       firmaAd
from tblkalipparcalar k
         INNER JOIN tblprofil p on p.id = k.profilId
         INNER JOIN tblfirma f on f.id = k.firmaId
WHERE k.durum = '1'
  AND k.firmaId = '$firmaId'
  AND k.figurSayi = '$figur'
  AND k.cap = '$cap'
  AND k.parca IN ($parca)
    ";

    $result = $db->query($sql);
    $listedestekler = array();
    while ($row = $result->fetch_array()) {
        $data['senaNo'] = $row['senaNo'];
        $data['id'] = $row['id'];
        $data['profilId'] = $row['profilId'];
        $data['cap'] = $row['cap'];
        $data['kalite'] = $row['kalite'];
        $data['figurSayi'] = $row['figurSayi'];
        $data['kalipCins'] = $row['kalipCins'];
        $data['kalipciNo'] = $row['kalipciNo'];
        $data['parca'] = $row['parca'];
        $data['durum'] = $row['durum'];
        $data['netKilo'] = $row['netKilo'];
        $data['brutKilo'] = $row['brutKilo'];
        $data['profilNo'] = $row['profilNo'];
        $data['firmaAdi'] = $row['firmaAd'];
        array_push($listedestekler, $data);
    }

    echo json_encode($listedestekler);

}

if ($received_data->action == 'alasimlar') {

    $firmaId = $received_data->firmaid;
    $sql = "SELECT * FROM tblalasim WHERE firmaId = '$firmaId' ";

    $result = $db->query($sql);
    $listedestekler = array();
    while ($row = $result->fetch_array()) {
        $data['ad'] = $row['ad'];
        $data['id'] = $row['id'];
        $data['biyetBirimGramaj'] = $row['biyetBirimGramaj'];
        $data['firmaId'] = $row['firmaId'];
        array_push($listedestekler, $data);
    }
    echo json_encode($listedestekler);
}

?>