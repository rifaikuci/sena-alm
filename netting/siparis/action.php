<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'kilo') {

    $profilId  = $received_data->profilId;

    $sql = "SELECT AVG(sonGramaj) as deger from tbltakim where durum = 1  AND profilId = '$profilId' ";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach ($result as $row) {
        $data['ortalama'] = $row['deger']  && $row['deger']  ?  $row['deger'] :  tablogetir("tblprofil", 'id',$profilId,$db)['gramaj'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'tolerans') {

    $profilId  = $received_data->profilId;
    $deger  = $received_data->deger;

    $sql = "SELECT  * from tblprofil where id = '$profilId' ";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    $gramaj = $row['gramaj'];
    $gramaj = $gramaj +  (($gramaj *  $deger) / 100 );

    $sqlMax = "SELECT  * FROM tbltakim where durum  = 1 and profilId = '$profilId'";
    $takimGramajDegerler = $db->query($sqlMax);

    $array = array();
    while ($takim = $takimGramajDegerler->fetch_array()) {
        array_push($array,$takim['sonGramaj']);
    }
    $minDeger =  min($array);

    $sonuc = $minDeger <= $gramaj ? false : true;

    $data['deger'] = $sonuc;

    echo json_encode($data);
}

if ($received_data->action == 'siparislerlistesi') {

    $siparisNo  = $received_data->siparisNo;

    $sql = "
    select s.id as id,
       profilAdi,
       profilNo,
       siparisNo,
       profilId,
       adet,
       kilo,
       siparisTuru,
       alasimId,
       ad,
       musteriId,
       naylonDurum,
       korumaBandi,
       araKagit,
       krepeKagit,
       termimTarih,
       boyaId,
       eloksalId,
       maxTolerans,
       boy,
       satirNo,
       istenilenTermik,
       paketAciklama,
       boyaAciklama,
       baskiAciklama,
       kiloAdet,
       kalanAdet,
       kalanKilo
from tblsiparis s
         INNER JOIN tblprofil p on p.id = s.profilId
         INNER JOIN tblalasim a on a.id = s.alasimId where s.siparisNo = '$siparisNo'
    ";
    $result = $db->query($sql);
    $datam = array();
    $siparis = null;
    while ($row = $result->fetch_array()) {
        $profilAdi =  $row['profilAdi'];
        $profilNo =  $row['profilNo'];
        $siparis['id'] =  $row['id'];
        $siparis['profil'] = $row['profilId'].";".$profilNo."-".$profilAdi;
        $siparis['profilId'] = $row['profilId'];
        $siparis['profilAdi'] =$profilNo."-".$profilAdi;
        $siparis['adet'] =  $row['adet'];
        $siparis['kilo'] =  sayiFormatla($row['kilo']);
        $siparis['siparisTur'] =  $row['siparisTuru'] == 'H'  ? "Ham" : ($row['siparisTuru'] == 'B' ? "Boyalı": "Eloksal") ;
        $siparis['alasim'] =  $row['alasimId'].";".$row['ad'];
        $siparis['alasimAd'] = $row['ad'];
        $siparis['alasimId'] = $row['alasimId'];
        $siparis['musteriId'] =  $row['musteriId'];
        $siparis['naylonId'] =  $row['naylonDurum'];
        $siparis['korumaBandi'] =  $row['korumaBandi'];
        $siparis['naylonAd'] =  $row['naylonDurum'] == 1 ?"Baskılı" : ($row['naylonDurum'] == 2 ? "Baskısız" : "Yok");
        $siparis['araKagit'] =  $row['araKagit'];
        $siparis['araKagitAd'] =  $row['araKagit'] == 1  ? "Var" : "Yok";
        $siparis['krepeKagit'] =  $row['krepeKagit'];
        $siparis['krepeKagitAd'] =  $row['krepeKagit'] == 1  ? "Var" : "Yok";
        $siparis['termimTarih'] =  explode(" ",$row['termimTarih'])[0];
        $siparis['tabloTarih'] =  tarih($row['termimTarih']);
        $siparis['siparisNo'] =  $row['siparisNo'];
        $siparis['boyaId'] =  $row['boyaId'];
        $siparis['eloksalId'] =  $row['eloksalId'];
        $siparis['maxTolerans'] =  $row['maxTolerans'];
        $siparis['boy'] =  $row['boy'];
        $siparis['satirNo'] =  $row['satirNo'];
        $siparis['istenilenTermik'] =  $row['istenilenTermik'];
        $siparis['paketAciklama'] =  $row['paketAciklama'];
        $siparis['boyaAciklama'] =  $row['boyaAciklama'];
        $siparis['baskiAciklama'] =  $row['baskiAciklama'];
        $siparis['kiloAdet'] =  $row['kiloAdet'];
        $siparis['kalanAdet'] =  $row['kalanAdet'];
        $siparis['kalanKilo'] =  sayiFormatla($row['kalanKilo']);
        $siparis['silmeLinki'] =  base_url()."netting/siparis/index.php/?satirsil=". $row['satirNo']."&siparisno=".$row['siparisNo'];
        array_push($datam,$siparis);
    }
    echo json_encode($datam);
}

?>