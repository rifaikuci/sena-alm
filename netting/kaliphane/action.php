<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'kalipgetir') {

    $takimId = $received_data->takimId; 

    $takimSql = "SELECT * FROM tblkaliphane where takimId = '$takimId'";


    $result = $db->query($takimSql);
    $datam = array();
    $takim = null;

    while ($row = $result->fetch_array()) {

        $takim['id'] = $row['id'];
        $takim['takimId'] = $row['takimId'];
        $takim['description'] = $row['description'];
        $takim['basilanNetKilo'] = $row['basilanNetKilo'];
        $takim['basilanBrutKilo'] = $row['basilanBrutKilo'];
        $takim['newProcess'] = $row['newProcess'];
        $takim['kostikHavuzId'] = $row['kostikHavuzId'];
        $takim['kumlamaHavuzId'] = $row['kumlamaHavuzId'];
        $takim['teneferHavuzId'] = $row['teneferHavuzId'];
        $takim['operatorId'] = $row['operatorId'];
        $takim['datetime'] = tarihsaat($row['datetime']);
        $takim['oldProcess'] = $row['oldProcess'];

        array_push($datam, $takim);
    }
    echo json_encode($datam);
}



?>