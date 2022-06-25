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
    $sql = "
    select s.id as id,
       satirNo,
       firmaAd,
       profilNo,
       profilAdi,
       ad,
       biyetBirimGramaj,
       maxTolerans,
       boy,
       istenilenTermik,
       kilo, adet, baskiAciklama, profilId, basilanAdet, kiloAdet, basilanKilo, resim
from tblsiparis s
         INNER JOIN tblprofil p ON s.profilId = p.id
         INNER JOIN tblalasim a ON a.id = s.alasimId
         INNER JOIN tblfirma f ON f.id = s.musteriId where s.id = '$id'
    ";

    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {

        $data['id'] = $row['id'];
        $data['satirNo'] = $row['satirNo'];
        $data['musteriAd'] = $row['firmaAd'];
        $data['profil'] = $row['profilAdi'] . " - " . $row['profilNo'];
        $data['alasim'] =  $row['ad'];

        $data['biyetBirimGramaj'] =  $row['biyetBirimGramaj'];
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
        $data['cizim'] = base_url().$row['resim'];

    }

    echo json_encode($data);
}


if ($received_data->action == 'takimgetir') {

    $profilId = $received_data->profil;
    $sql = "Select t.id as id, profilId, konum, durum, sonGramaj, parca1, parca2, takimNo, firmaAd, cap, kalipCins
from tbltakim t
         INNER JOIN tblfirma f ON t.firmaId = f.id
WHERE t.durum = '1' AND t.konum = 'P' AND t.profilId = '$profilId' order by t.sonGramaj asc ";

    $result = $db->query($sql);
    $datas = array();
    while ($row = $result->fetch_array()) {
        $data['id'] = $row['id'];
        $data['parca1'] = $row['parca1'];
        $data['parca2'] = $row['parca2'];
        $data['takimNo'] = $row['takimNo'];
        $data['firma'] = $row['firmaAd'];
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
   // $id = intval($id);
    $sql = "select b.id as id,
       siparisId,
       takimId,
       baslaZamani,
       bitisZamani,
       kayitTarih,
       vardiyaKod,
       vardiya,
       b.operatorId,
       biyetId,
       biyetBoy,
       araIsFire,
       konveyorBoy,
       boylamFire,
       baskiFire,
       biyetFire,
       istenilenTermik,
       verilenBiyet,
       guncelGr,
       basilanBrutKg,
       basilanNetKg,
       basilanNetAdet,
       kovanSicaklik,
       kalipSicaklik,
       biyetSicaklik,
       hiz,
       fire,
       performans,
       takimSonDurum,
       aciklama,
       sonlanmaNeden,
       profilId
from tblbaski b
         INNER JOIN tblsiparis s ON s.id = b.siparisId where b.id = '$id'";

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
        $data['profilId'] =$row['profilId'];
        $data['istenilenTermik'] =$row['istenilenTermik'];



        }

    echo json_encode($data);
}

?>