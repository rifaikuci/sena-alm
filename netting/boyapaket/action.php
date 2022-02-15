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
    $sql = "SELECT * FROM tblsiparis WHERE id = '$id' ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $profil = tablogetir('tblprofil','id',$row['profilId'], $db );
        $alasim  = tablogetir('tblalasim','id',$row['alasimId'], $db);


        $data['id'] = $row['id'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = tablogetir('tblfirma','id',$row['musteriId'], $db)['firmaAd'];
        $data['profil'] = $profil['profilAdi'] . " - " . $profil['profilNo'];
        $data['alasim'] =  $alasim['ad'];
        $data['paketIcAdet'] = $profil['paketAdet'];
        $data['biyetBirimGramaj'] =  $alasim['biyetBirimGramaj'];
        $data['tolerans'] = $row['maxTolerans'];
        $data['paketAciklama'] = $row['maxTolerans'];
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
        $data['kalanKg'] = $row['kilo'] - $row['basilanKilo'];
    }

    echo json_encode($data);
}



?>