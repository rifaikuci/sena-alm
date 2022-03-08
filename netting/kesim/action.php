<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'sepetgetir') {


     $tur  = $received_data->tur;
     if($tur == "araba") {
         $sql = "SELECT  * from tblsepet where tur = '$tur'";


     } else {
         $sql = "SELECT  * from tblsepet where tur = '$tur' and durum = 0 and isTermik = 0";

     }
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
        $siparis = tablogetir('tblsiparis','id',$row['siparisId'], $db);
        $profilId =$siparis['profilId'];
        $siparisTur =$siparis['siparisTuru'];
        $profil = tablogetir('tblprofil','id',$profilId, $db);
        $data['id'] = $row['id'];
        $data['satirNo'] = $siparis['satirNo'];
        $data['istenilenBoy'] = $siparis['boy'];
        $data['istenilenTermik'] = $siparis['istenilenTermik'];
        $data['basilanNetAdet'] = $row['basilanNetAdet'];
        $data['kayitTarih'] = $row['kayitTarih'];
        $data['hurdaAdet'] = $row['hurdaAdet'];
        $data['siparisId'] = $row['siparisId'];
        $data['profil'] = $profil['profilAdi'] . " - " .  $profil['profilNo'];
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
    $siparisId = tablogetir('tblbaski','id',$row['baskiId'], $db)['siparisId'];

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
        $siparis = tablogetir('tblsiparis','id',$baskisatir['siparisId'], $db);
        $tempbaski['satirNo'] =$siparis['satirNo'];
        $tempbaski['tur'] = $siparis['siparisTuru'];
        $tempbaski['kayitTarih'] = $baskisatir['kayitTarih'];
        array_push($baskilar, $tempbaski);
    }

        $siparisgetir =  tablogetir('tblsiparis','id',$siparisId, $db);
    $profilId = $siparisgetir['profilId'];
    $siparisTur = $siparisgetir['siparisTuru'];

    $profil = tablogetir('tblprofil','id',$profilId, $db);

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
    $data['netAdet'] = $row['netAdet'];
    $data['kesilenBoy'] = $row['kesilenBoy'];
    $data['hurdaAdet'] = $row['hurdaAdet'];
    $data['hurdaSebep'] =$row['hurdaSebep'];
    $data['tarih'] = date("Y-m-d", strtotime(explode(" ", $row['tarih'])[0]));
    $data['saat'] = date("H:i", strtotime(explode(" ", $row['tarih'])[1]));
    $data['durum'] = $row['durum'];
    $data['satirNo'] =  $siparisgetir['satirNo'];
    $data['sepetler'] = $datam;
    $data['baskilar'] = $baskilar;
    $data['istenilenBoy'] =  $siparisgetir['boy'];
    $data['istenilenTermik'] =  $siparisgetir['istenilenTermik'];
    $data['basilanNetAdet'] = tablogetir('tblbaski','id',$row['baskiId'], $db)['basilanNetAdet'];
    $data['profil'] = $profil['profilAdi'] . " - " . $profil['profilNo'] ;
    $data['siparisTur'] = $siparisTur == "B" ? "Boyalı" : ($siparisTur == "E" ? "Eloksal" : "Ham");


    echo json_encode($data);
}


?>