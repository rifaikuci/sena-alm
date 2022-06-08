<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'naylongetir') {

    // id 1 ise -> baskılı, 2 ise baskısızlar getirilecek
    $id = $received_data->tur;
    // stok malzemede 5 -> baskılı olduğu için yazıldı
    $malzemeId = $id == 1 ? 5  : ($id == 2 ? 6 : 0);
    $sql = "
     select s.id as id, malzemeId, kalan, partino, firmaAd, firmaId, adet, barkod
from tblstokmalzeme s
         INNER JOIN tblfirma f ON f.id = s.firmaId
     WHERE s.malzemeId = '$malzemeId' and s.kalan > 0 order by s.kalan asc ";

    $datam = array();
    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $data = null;
        $data['id'] = $row['id'];
        $data['partino'] = $row['partino'];
        $data['firmaAd'] = $row['firmaAd'];
        $data['malzemeId'] = $row['malzemeId'];
        $data['firmaId'] = $row['firmaId'];
        $data['adet'] =  $row['adet'];
        $data['kalan'] =  $row['kalan'];
        $data['barkod'] =  $row['barkod'];
        array_push($datam, $data);
    }

    echo json_encode($datam);
}



?>