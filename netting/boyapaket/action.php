<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'siparisgetir') {

    $id = $received_data->id;
    $id = intval($id);
    $sql = "
     select s.id as id,
       satirNo,
       firmaAd,
       profilAdi,
       profilNo,
       ad,
       paketAdet,
       biyetBirimGramaj,
       maxTolerans,
       paketAciklama,
       boy,
       kilo,
       adet,
       profilId, basilanKilo,
       basilanAdet, kiloAdet,naylonDurum, araKagit, krepeKagit

from tblsiparis s
         INNER JOIN tblprofil p ON p.id = s.profilId
         INNER JOIN tblalasim a ON a.id = S.alasimId
         INNER JOIN tblfirma f ON f.id = s.musteriId where s.id = '$id'
     ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = $row['firmaAd'];
        $data['profil'] = $row['profilAdi'] . " - " . $row['profilNo'];
        $data['alasim'] =  $row['ad'];
        $data['paketIcAdet'] = $row['paketAdet'];
        $data['biyetBirimGramaj'] =  $row['biyetBirimGramaj'];
        $data['tolerans'] = $row['maxTolerans'];
        $data['paketAciklama'] = $row['paketAciklama'];
        $data['boy'] = $row['boy'];
        $data['kg'] = $row['kilo'];
        $data['adet'] = $row['adet'];
        $data['profilId'] = $row['profilId'];
        $data['basilanKilo'] = $row['basilanKilo'];
        $data['basilanAdet'] = $row['basilanAdet'];
        $data['kiloAdet'] = $row['kiloAdet'];
        $data['naylonDurum'] = $row['naylonDurum'];
        $data['araKagit'] = $row['araKagit'];
        $data['krepeKagit'] = $row['krepeKagit'];
        $data['kalanKg'] = $row['kilo'] - $row['basilanKilo'];
    }

    echo json_encode($data);
}



?>