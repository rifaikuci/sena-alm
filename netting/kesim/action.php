<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'sepetgetir') {


    $sql = "SELECT  * from tblsepet where tur = 'termik' and durum = 0";
    $result = $db->query($sql);
    $datam = array();
    $sepet = null;
    while ($row = $result->fetch_array()) {

        $sepet['ad'] = $row['ad'];
        $sepet['tur'] = $row['tur'];
        $sepet['durum'] = $row['durum'];
        $sepet['icindekiler'] = $row['icindekiler'];
        $sepet['id'] = $row['id'];
        array_push($datam, $sepet);
    }
    echo json_encode($datam);
}

if ($received_data->action == 'baskigetir') {

    $id = $received_data->id;
    $id = intval($id);
    $sql = "SELECT * FROM tblbaski WHERE id = $id ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $profilId= siparisBul($row['siparisId'], $db, 'profilId');
        $siparisTur =  siparisBul($row['siparisId'], $db, 'siparisTuru');
        $data['id'] = $row['id'];
        $data['satirNo'] = siparisBul($row['siparisId'], $db, 'satirNo');
        $data['istenilenBoy'] =siparisBul($row['siparisId'], $db, 'boy');
        $data['istenilenTermik'] = siparisBul($row['siparisId'], $db, 'istenilenTermin');
        $data['basilanNetAdet'] = $row['basilanNetAdet'];
        $data['kayitTarih'] = $row['kayitTarih'];
        $data['siparisId'] = $row['siparisId'];
        $data['profil'] = profilbul($profilId, $db, 'profilAdi') . " - " . profilbul($profilId, $db, 'profilNo');
        $data['siparisTur'] = $siparisTur == "B" ? "Boyalı" : ($siparisTur == "E" ? "Eloksal"  : "Ham" );
    }

    echo json_encode($data);
}

?>