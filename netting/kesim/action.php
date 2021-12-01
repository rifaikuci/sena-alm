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
        $profilId = siparisBul($row['siparisId'], $db, 'profilId');
        $siparisTur = siparisBul($row['siparisId'], $db, 'siparisTuru');
        $data['id'] = $row['id'];
        $data['satirNo'] = siparisBul($row['siparisId'], $db, 'satirNo');
        $data['istenilenBoy'] = siparisBul($row['siparisId'], $db, 'boy');
        $data['istenilenTermik'] = siparisBul($row['siparisId'], $db, 'istenilenTermin');
        $data['basilanNetAdet'] = $row['basilanNetAdet'];
        $data['kayitTarih'] = $row['kayitTarih'];
        $data['siparisId'] = $row['siparisId'];
        $data['profil'] = profilbul($profilId, $db, 'profilAdi') . " - " . profilbul($profilId, $db, 'profilNo');
        $data['siparisTur'] = $siparisTur == "B" ? "Boyalı" : ($siparisTur == "E" ? "Eloksal" : "Ham");
    }

    echo json_encode($data);
}

if ($received_data->action == 'kesimgetir') {

    $id = $received_data->id;
    $id = intval($id);
    $sql = "SELECT * FROM tblkesim WHERE id = $id ";
    $row = mysqli_query($db, $sql)->fetch_assoc();
    $sepet1 = $row['sepetId1'];
    $sepet2 = $row['sepetId2'];
    $sepet3 = $row['sepetId3'];
    $siparisId = baskiBul($row['baskiId'], $db, 'siparisId');

    $sqlsepet = "SELECT  * from tblsepet where tur = 'termik' and durum = 0 or id in ('$sepet1', '$sepet2', '$sepet3')";
    $result = $db->query($sqlsepet);
    $datam = array();
    $sepet = null;

    while ($satir = $result->fetch_array()) {

        $sepet['ad'] = $satir['ad'];
        $sepet['tur'] = $satir['tur'];
        $sepet['durum'] = $satir['durum'];
        $sepet['icindekiler'] = $satir['icindekiler'];
        $sepet['id'] = $satir['id'];
        array_push($datam, $sepet);
    }

    $sqlbaski = "SELECT * FROM tblbaski where  bitisZamani !='' and kesimId in (0,'$id') ";
    $baski = $db->query($sqlbaski);
    $baskilar = array();
    $tempbaski = null;

    while ($baskisatir = $baski->fetch_array()) {

        $tempbaski['id'] = $baskisatir['id'];
        $tempbaski['satirNo'] = siparisBul($baskisatir['siparisId'],$db,'satirNo');
        $tempbaski['tur'] = siparisBul($baskisatir['siparisId'], $db, 'siparisTuru');
        $tempbaski['kayitTarih'] = $baskisatir['kayitTarih'];
        array_push($baskilar, $tempbaski);
    }

    $profilId = siparisBul($siparisId, $db, 'profilId');
    $siparisTur = siparisBul($siparisId, $db, 'siparisTuru');



    $data['id'] = $row['id'];
    $data['baskiId'] = $row['baskiId'];
    $data['operatorId'] = $row['operatorId'];
    $data['siparisId'] = $siparisId;
    $data['sepet1'] = $row['sepetId1'];
    $data['sepet2'] = $row['sepetId2'];
    $data['sepet3'] = $row['sepetId3'];
    $data['sepet1Adet'] = $row['sepet1Adet'];
    $data['sepet2Adet'] = $row['sepet2Adet'];
    $data['sepet3Adet'] = $row['sepet3Adet'];
    $data['hurdaAdet'] = $row['hurdaAdet'];
    $data['netAdet'] = $row['netAdet'];
    $data['kesilenBoy'] = $row['kesilenBoy'];
    $data['hurdaAdet'] = hurdabul($id,$db,'toplamKg');
    $data['aciklama'] = hurdabul($id,$db,'aciklama');
    $data['tarih'] = date("Y-m-d", strtotime(explode(" ", $row['tarih'])[0]));
    $data['saat'] = date("H:i", strtotime(explode(" ", $row['tarih'])[1]));
    $data['durum'] = $row['durum'];
    $data['satirNo'] = siparisBul($siparisId, $db, 'satirNo');
    $data['sepetler'] = $datam;
    $data['baskilar'] = $baskilar;
    $data['istenilenBoy'] = siparisBul($siparisId, $db, 'boy');
    $data['istenilenTermik'] = siparisBul($siparisId, $db, 'istenilenTermin');
    $data['basilanNetAdet'] = baskiBul($row['baskiId'], $db,'basilanNetAdet');
    $data['profil'] = profilbul($profilId, $db, 'profilAdi') . " - " . profilbul($profilId, $db, 'profilNo');
    $data['siparisTur'] = $siparisTur == "B" ? "Boyalı" : ($siparisTur == "E" ? "Eloksal" : "Ham");


    echo json_encode($data);
}


?>