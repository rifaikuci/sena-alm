<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if ($received_data->action == 'anbargetir') {


    $balyalamasql = "
    select a.id as id,
       a.satirNo,
       musteriId,
       firmaAd,
       s.boy,
       figurSayi,
       baskiId,
       siparisNo,
       krepeKagit,
       korumaBandi,
       naylonDurum,
       t.takimNo,
       takimId,
       s.profilId,
       profilNo,
       profilAdi,
       gramaj, a.kalanAdet,
       a.tarih as tarih,
       pr.paketAdet 
from tblanbar a
         INNER JOIN tblbaski b ON b.id = a.baskiId
         INNER JOIN tblsiparis s ON s.id = b.siparisId
         INNER JOIN tblfirma f ON f.id = s.musteriId
         INNER JOIN tbltakim t on b.takimId = t.id
         INNER JOIN tblkalipparcalar t2 ON t2.senaNo = t.parca1
         INNER JOIN tblprofil pr on pr.id = s.profilId where a.kalanAdet > 0 group by a.satirNo order by a.tarih asc

    ";


    $result = $db->query($balyalamasql);
    $datam = array();
    $balyalama = null;
    while ($row = $result->fetch_array()) {

        $satirno = $row['satirNo'];
        $sqlOrtGramaj = "SELECT  AVG(guncelGr) as deger FROM tblbaski where satirNo = '$satirno' group by satirNo";
        $deger = mysqli_query($db, $sqlOrtGramaj)->fetch_assoc();

        $balyalama['id'] = $row['id'];
        $balyalama['baskiId'] = $row['baskiId'];
        $balyalama['satirNo'] = $row['satirNo'];
        $balyalama['musteriId'] = $row['musteriId'];
        $balyalama['musteri'] = $row['firmaAd'] ;
        $balyalama['siparisNo'] = $row['siparisNo'];
        $balyalama['boy'] = $row['boy'];
        $balyalama['takimId'] = $row['takimId'];
        $balyalama['figurSayi'] = $row['figurSayi'];
        $balyalama['profilId'] = $row['profilId'];
        $balyalama['gramaj'] = $row['gramaj'];
        $balyalama['ortGramaj'] = $deger['deger'];

        $balyalama['pIA'] = $row['paketAdet'];
        $balyalama['araKagit'] = $row['araKagit'] == 1 ? "Var" : "Yok";
        $balyalama['krepeKagit'] = $row['krepeKagit'] == 1 ? "Var" : "Yok";
        $balyalama['korumaBandi'] = $row['korumaBandi'] == 1 || $row['korumaBandi'] == 2 ? "Var" : "Yok";
        $balyalama['naylonDurum'] = $row['naylonDurum'] == 1 || $row['naylonDurum'] == 2 ? "Var" : "Yok";

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