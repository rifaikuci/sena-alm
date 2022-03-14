<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'balyalamagetir') {

    $balyalamasql = "SELECT * FROM tblbalyalama   where    sevkiyatId = 0";


    $result = $db->query($balyalamasql);
    $datam = array();
    $balyalama = null;
    while ($row = $result->fetch_array()) {
        $balyalama = null;

        $balyalama['id'] = $row['id'];
        $balyalama['operatorId'] = $row['operatorId'];
        $balyalama['tarih'] = $row['tarih'];
        $balyalama['baskiId'] = $row['baskiId'];
        $balyalama['netAdet'] = $row['netAdet'];
        $balyalama['netKilo'] = $row['netKilo'];
        $balyalama['mtGr'] = $row['mtGr'];
        $balyalama['paketDetay'] = $row['paketDetay'];
        $balyalama['realTolerans'] = $row['realTolerans'];
        $balyalama['teorikTolerans'] = $row['teorikTolerans'];
        $balyalama['satirNo'] = $row['satirNo'];
        $balyalama['siparisNo'] = $row['siparisNo'];
        $balyalama['balyaNo'] = $row['balyaNo'];
        $balyalama['balyaBoy'] = $row['balyaBoy'];
        $balyalama['balyaKilo'] = $row['balyaKilo'];

    array_push($datam,$balyalama);
    }
    echo json_encode($datam);
}


?>