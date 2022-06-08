<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'boyagetir') {


     $sicaklik  = $received_data->sicaklik;

    $boyasql = "
    SELECT  sicaklik, boyaTuru, s.id as id,partino, firmaId, sevkiyatId, cins, kilo, barkodNo, adet, kalan, ad FROM tblstokboya s
INNER  JOIN  tblprboya pr on pr.id = s.boyaTuru
where s.sicaklik = '$sicaklik' AND  s.kalan > 0 order by s.kalan + 0 asc
    ";


    
    $result = $db->query($boyasql);
    $datam = array();
    $boya = null;
    while ($row = $result->fetch_array()) {
        $boya['partino'] = $row['partino'];
        $boya['firmaId'] = $row['firmaId'];
        $boya['sevkiyatId'] = $row['sevkiyatId'];
        $boya['boyaTur'] = $row['ad'];
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