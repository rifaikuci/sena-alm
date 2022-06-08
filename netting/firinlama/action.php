<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'boyagetir') {



    $boyasql = "
    select b.id as id, sepetler, baskilar, topAdet, baslaZaman, sicaklik, boyaTuru, isFirin
from tblboya b
         INNER JOIN tblstokboya s on s.id = b.boyaId where isFirin = 0
    ";


    
    $result = $db->query($boyasql);
    $datam = array();
    $boya = null;
    while ($row = $result->fetch_array()) {
        $boya['sepetId'] = $row['sepetler'];
        $boya['baskiId'] = $row['baskilar'];
        $boya['id'] = $row['id'];
        $boya['topAdet'] = $row['topAdet'];
        $boya['baslaZaman'] = $row['baslaZaman'];
        $boya['firinSicaklik'] = $row['sicaklik'];
        $boya['boyaTuru'] = $row['boyaTuru'];
        array_push($datam, $boya);
    }
    echo json_encode($datam);
}



?>