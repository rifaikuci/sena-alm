<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'boyagetir') {



    $boyasql = "SELECT * FROM tblboya where   isFirin = 0";


    
    $result = $db->query($boyasql);
    $datam = array();
    $boya = null;
    while ($row = $result->fetch_array()) {
        $boya['sepetId'] = $row['sepetId'];
        $boya['baskiId'] = $row['baskiId'];
        $boya['id'] = $row['id'];
        $boya['topAdet'] = $row['topAdet'];
        $boya['baslaZaman'] = $row['baslaZaman'];
        $boya['firinSicaklik'] = $row['firinSicaklik'];
        $boya['kurlenmeDakikasi'] = $row['kurlenmeDakikasi'];
        array_push($datam, $boya);
    }
    echo json_encode($datam);
}



?>