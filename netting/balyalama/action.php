<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'anbargetir') {


    $balyalamasql = "SELECT * FROM tblanbar   where    kalanAdet  > 0 group by satirNo  order by tarih asc";


    $result = $db->query($balyalamasql);
    $datam = array();
    $balyalama = null;
    while ($row = $result->fetch_array()) {
        $baski = tablogetir("tblbaski", 'id', $row['baskiId'], $db);
        $siparis = tablogetir("tblsiparis", 'satirNo', $baski['satirNo'], $db);
        $balyalama['id'] = $row['id'];
        $balyalama['baskiId'] = $row['baskiId'];
        $balyalama['satirNo'] = $baski['satirNo'];
        $balyalama['musteriId'] = $siparis['musteriId'];
        $balyalama['musteri'] = tablogetir("tblfirma", 'id',$siparis['musteriId'], $db )['firmaAd'] ;
        $balyalama['siparisNo'] = $siparis['siparisNo'];
        $balyalama['boy'] = $siparis['boy'];
        $balyalama['takimId'] = $baski['takimId'];
        $takim = tablogetir("tbltakim", 'id',$baski['takimId'], $db );
        $balyalama['figurSayi'] = tablogetir("tblkalipparcalar", 'senaNo',$takim['parca1'], $db )['figurSayi'];
        $balyalama['profilId'] = $siparis['profilId'];
        $profil =  tablogetir("tblprofil", 'id',$siparis['profilId'], $db);
        $balyalama['gramaj'] = $profil['gramaj'];
        $balyalama['pIA'] = $profil['paketAdet'];
        $balyalama['araKagit'] = $siparis['araKagit'] == 1 ? "Var" : "Yok";
        $balyalama['krepeKagit'] = $siparis['krepeKagit'] == 1 ? "Var" : "Yok";
        $balyalama['korumaBandi'] = $siparis['korumaBandi'] == 1 || $siparis['korumaBandi'] == 2 ? "Var" : "Yok";
        $balyalama['naylonDurum'] = $siparis['naylonDurum'] == 1 || $siparis['naylonDurum'] == 2 ? "Var" : "Yok";

        $balyalama['adet'] = $row['adet'];
        $balyalama['kalanAdet'] = $row['kalanAdet'];
        $balyalama['tarih'] = $row['tarih'];
        array_push($datam, $balyalama);
    }
    echo json_encode($datam);
}


?>