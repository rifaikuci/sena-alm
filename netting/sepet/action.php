<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'sepetgetir') {


    $sepetsql = "SELECT * FROM tblsepet";


    $result = $db->query($sepetsql);
    $datam = array();
    $sepet = null;

    while ($row = $result->fetch_array()) {

        $sepet['id'] = $row['id'];
        $sepet['ad'] = $row['ad'];
        $sepet['tur'] = $row['tur'];
        $sepet['durum'] = $row['durum'];
        $sepet['icindekiler'] = $row['icindekiler'];
        $sepet['isTermik'] = $row['isTermik'];
        $sepet['adetler'] = $row['adetler'];
        $sepet['finishedKromat'] = $row['finishedKromat'];
        $sepet['isBos'] = $row['icindekiler']  ? "Dolu"  : "Boş" ;


        array_push($datam, $sepet);
    }
    echo json_encode($datam);
}



?>