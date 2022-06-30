<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'boyagetir') {



    $boyasql = "
  select b.id as id, profilAdi, profilNo, ad,boy,  sepetler, baskilar, topAdet, baslaZaman, sicaklik, boyaTuru, firinId, baski.satirNo
from tblboya b
         INNER JOIN tblbaski baski on baski.id = SUBSTRING_INDEX(b.baskilar, ';', 1)
         INNER JOIN tblstokboya s on s.id = b.boyaId
         INNER JOIN tblsiparis si on si.id = baski.siparisId
         INNER JOIN tblprofil p on p.id = si.profilId
        INNER JOIN  tblprboya pr on pr.id = si.boyaId
where firinId = 0
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
        $boya['satirNo'] = $row['satirNo'];
        $boya['profilAdi'] = $row['profilAdi'];
        $boya['profilNo'] = $row['profilNo'];
        $boya['boyaAd'] = $row['ad'];
        $boya['boy'] = $row['boy'];
        array_push($datam, $boya);
    }
    echo json_encode($datam);
}



?>