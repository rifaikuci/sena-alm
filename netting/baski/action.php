<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'baskigetir') {

    $id = $received_data->id;
    $id = intval($id);
    $sql = "SELECT * FROM tblsiparis WHERE id = $id ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $profil = tablogetir('tblprofil','id',$row['profilId'], $db );
        $alasim  = tablogetir('tblalasim','id',$row['alasimId'], $db);

        $data['id'] = $row['id'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = tablogetir('tblfirma','id',$row['musteriId'], $db)['firmaAd'];
        $data['profil'] = $profil['profilAdi'] . " - " . $profil['profilNo'];
        $data['alasim'] =  $alasim['ad'];

        $data['biyetBirimGramaj'] =  $alasim['biyetBirimGramaj'];
        $data['tolerans'] = $row['maxTolerans'];
        $data['boy'] = $row['boy'];
        $data['istenilenTermik'] = $row['istenilenTermik'];
        $data['kg'] = $row['kilo'];
        $data['adet'] = $row['adet'];
        $data['aciklama'] = $row['baskiAciklama'];
        $data['profilId'] = $row['profilId'];
        $data['basilanKilo'] = $row['basilanKilo'];
        $data['basilanAdet'] = $row['basilanAdet'];
        $data['kiloAdet'] = $row['kiloAdet'];
        $data['kalanKg'] = $row['kilo'] - $row['basilanKilo'];
    }

    echo json_encode($data);
}


if ($received_data->action == 'takimgetir') {

    $profilId = $received_data->profil;
    $sql = "SELECT * FROM tbltakim WHERE durum = '1' AND profilId = '$profilId' order by sonGramaj asc";

    $result = $db->query($sql);
    $datas = array();
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['parca1'] = $row['parca1'];
        $data['parca2'] = $row['parca2'];
        $data['takimNo'] = $row['takimNo'];
        $data['firma'] = tablogetir('tblfirma','id',$row['firmaId'], $db)['firmaAd'];
        $data['sonGramaj'] = $row['sonGramaj'];
        $data['cap'] = $row['cap'];
        $data['kalipCins'] = kalipBul($row['kalipCins']);
        array_push($datas, $data);
    }

    echo json_encode($datas);
}

if ($received_data->action == 'baskibaslat') {
    $baslazamani = $received_data->baslazamani;
    $siparisId = $received_data->siparisId;
    $takimId = $received_data->takimId;
    $kayitTarih = date("Y-m-d H:i:s");

    $sql = "INSERT INTO tblbaski ( baslaZamani, siparisId, takimId, kayitTarih)
                VALUES ('$baslazamani','$siparisId','$takimId', '$kayitTarih')";

    if (mysqli_query($db, $sql)) {

        $baski = mysqli_insert_id($db);
        $data['baski'] = $baski;

    }

    echo json_encode($data);
}

if ($received_data->action == 'baskiguncellegetir') {

    $id = $received_data->id;
    $id = intval($id);
    $sql = "SELECT * FROM tblbaski WHERE id = $id ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['siparisId'] = $row['siparisId'];
        $data['takimId'] = $row['takimId'];
        $data['baslaSaat'] = explode(" ",$row['baslaZamani'])[1];
        $data['bitisSaat'] = explode(" ",$row['bitisZamani'])[1];
        $data['baslaTarih'] =  explode(" ",$row['baslaZamani'])[0];
        $data['bitisTarih'] =  date("Y-m-d", strtotime( explode(" ",$row['bitisZamani'])[0]));
        $data['kayitTarih'] = $row['kayitTarih'];
        $data['vardiyaKod'] = $row['vardiyaKod'];
        $data['vardiya'] = $row['vardiya'];
        $data['operatorId'] = $row['operatorId'];
        $data['biyetId'] = $row['biyetId'];
        $data['biyetBoy'] = $row['biyetBoy'];
        $data['araIsFire'] = $row['araIsFire'];
        $data['konveyorBoy'] = $row['konveyorBoy'];
        $data['boylamFire'] = $row['boylamFire'];
        $data['baskiFire'] = $row['baskiFire'];
        $data['biyetFire'] = $row['biyetFire'];
        $data['istenilenTermik'] = $row['istenilenTermik'];
        $data['verilenBiyet'] = $row['verilenBiyet'];
        $data['guncelGr'] = $row['guncelGr'];
        $data['basilanBrutKg'] = $row['basilanBrutKg'];
        $data['basilanNetKg'] = $row['basilanNetKg'];
        $data['basilanNetAdet'] = $row['basilanNetAdet'];
        $data['kovanSicaklik'] = $row['kovanSicaklik'];
        $data['kalipSicaklik'] = $row['kalipSicaklik'];
        $data['biyetSicaklik'] = $row['biyetSicaklik'];
        $data['hiz'] = $row['hiz'];
        $data['fire'] = $row['fire'];
        $data['performans'] = $row['performans'];
        $data['takimSonDurum'] = $row['takimSonDurum'];
        $data['aciklama'] = $row['aciklama'];
        $data['sonlanmaNeden'] = $row['sonlanmaNeden'];
        $siparis =  tablogetir('tblsiparis','id',$row['siparisId'], $db);
        $data['profilId'] =$siparis['profilId'];
        $data['istenilenTermik'] =$siparis['istenilenTermik'];



        }

    echo json_encode($data);
}

?>