<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'boyagetir') {


     $sicaklik  = $received_data->sicaklik;

    $boyasql = "SELECT * FROM tblstokboya where sicaklik = '$sicaklik' AND  kalan > 0 order by kalan asc";


    
    $result = $db->query($boyasql);
    $datam = array();
    $boya = null;
    while ($row = $result->fetch_array()) {
        $boya['partino'] = $row['partino'];
        $boya['firmaId'] = $row['firmaId'];
        $boya['sevkiyatId'] = $row['sevkiyatId'];
        $boya['boyaTur'] = tablogetir("tblprboya", "id",  $row['boyaTuru'], $db)['ad'];
        $boya['sicaklik'] = $row['sicaklik'];
        $boya['id'] = $row['id'];
        $boya['cins'] = $row['cins'];
        $boya['kilo'] = $row['kilo'];
        $boya['barkodNo'] = $row['barkodNo'];
        $boya['adet'] = $row['adet'];
        $boya['kalan'] = $row['kalan'];
        array_push($datam, $boya);
    }
    echo json_encode($datam);
}



?>