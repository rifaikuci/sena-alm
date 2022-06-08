<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'siparisgetir') {

    $id = $received_data->id;
    $baskiId = intval($id);
    $sql = "select b.id as id,
       s.id as siparisId,
       b.satirNo,
       korumaBandi,
       firmaAd,
       profilNo,
       ad,
       paketAdet,
       biyetBirimGramaj,
       maxTolerans,
       boy,
       kilo,
       adet,
       paketAciklama,
       profilId,
       basilanAdet,
       kiloAdet,
       naylonDurum,
       araKagit,
       krepeKagit,
       basilanKilo
from tblbaski b
         INNER JOIN tblsiparis s on b.siparisId = s.id
         INNER JOIN tblprofil p on s.profilId = p.id
         INNER JOIN tblalasim a on s.alasimId = a.id
         INNER JOIN tblfirma f on s.musteriId = f.id where b.id = '$id'";


    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {

        $data['id'] = $row['siparisId'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = $row['firmaAd'];
        $data['profil'] = $row['profilAdi'] . " - " . $row['profilNo'];
        $data['alasim'] =  $row['ad'];
        $data['paketIcAdet'] = $row['paketAdet'];
        $data['biyetBirimGramaj'] =  $row['biyetBirimGramaj'];
        $data['tolerans'] = $row['maxTolerans'];
        $data['boy'] = $row['boy'];
        $data['kg'] = $row['kilo'];
        $data['adet'] = $row['adet'];
        $data['paketAciklama'] = $row['paketAciklama'];
        $data['profilId'] = $row['profilId'];
        $data['basilanKilo'] = $row['basilanKilo'];
        $data['basilanAdet'] = $row['basilanAdet'];
        $data['kiloAdet'] = $row['kiloAdet'];
        $data['naylonDurum'] = $row['naylonDurum'];
        $data['araKagit'] = $row['araKagit'];
        $data['krepeKagit'] = $row['krepeKagit'];
        $data['siparisId'] = $row['siparisId'];
        $data['satirNo'] = $row['satirNo'];
        $data['baskiId'] = $baskiId;
        $data['korumaBandiId'] = $row['korumaBandi'];
        $data['kalanKg'] = $row['kilo'] - $row['basilanKilo'];
    }

    echo json_encode($data);
}



?>