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

        $satirno = $baski['satirNo'];
        $sqlOrtGramaj = "SELECT  AVG(guncelGr) as deger FROM tblbaski where satirNo = '$satirno' group by satirNo";
        $deger = mysqli_query($db, $sqlOrtGramaj)->fetch_assoc();

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
        $balyalama['ortGramaj'] = $deger['deger'];

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

if ($received_data->action == 'balyalamagetir') {

    $id = $received_data->id;

    $balyalamasql = "SELECT * FROM tblbalyalama   where    id ='$id'";


    $result = $db->query($balyalamasql);
    $datam = array();
    $balyalama = null;
    while ($row = $result->fetch_array()) {

        $balyalama['id'] = $row['id'];
        $balyalama['operatorId'] = $row['operatorId'];
        $balyalama['tarih'] = $row['tarih'];
        $balyalama['baskiId'] = $row['baskiId'];
        $balyalama['netAdet'] = $row['netAdet'];
        $balyalama['netKilo'] = $row['netKilo'];
        $balyalama['mtGr'] = $row['mtGr'];
        $balyalama['paketDetay'] = $row['paketDetay'];
        $balyalama['realTolerans'] = $row['realTolerans'];
        $balyalama['teorikTolerans'] = $row['teorikTolerans'];
        $balyalama['satirNo'] = $row['satirNo'];
        $balyalama['siparisNo'] = $row['siparisNo'];
        $balyalama['balyaNo'] = $row['balyaNo'];
        $balyalama['balyaBoy'] = $row['balyaBoy'];
        $balyalama['balyaKilo'] = sayiFormatla($row['balyaKilo']);

    }
    echo json_encode($balyalama);
}


?>