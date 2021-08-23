<?php

include 'baglan.php';
include '../include/helper.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'profilId') {

    $sql = "SELECT * FROM tblprofil WHERE id = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['ad'] = $row['profilAdi'];
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
        $data['ozkutle'] = $row['ozkutle'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'boyaId') {

    $sql = "SELECT * FROM tblboya WHERE id = '$received_data->id'";

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
?>