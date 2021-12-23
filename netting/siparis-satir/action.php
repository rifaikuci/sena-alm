<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'siparisgetir') {

    $satirno = $received_data->satirno;

    $sql = "SELECT  * from tblsiparis where satirNo = '$satirno'";
    $result = $db->query($sql);
    while ($row = $result->fetch_array()) {
        $profil = tablogetir('tblprofil','id',$row['profilId'], $db );
        $profilAdi = $profil['profilAdi'];
        $profilNo = $profil['profilNo'];
        $alasim = tablogetir('tblalasim', 'id', $row['alasimId'], $db);
        $data['id'] = $row['id'];
        $data['profil'] = $row['profilId'] . ";" . $profilNo . "-" . $profilAdi;
        $data['profilId'] = $row['profilId'];
        $data['profilAdi'] = $profilNo . "-" . $profilAdi;
        $data['adet'] = $row['adet'];
        $data['kilo'] = $row['kilo'];
        $data['siparisTur'] = $row['siparisTuru'] == 'H' ? "Ham" : ($row['siparisTuru'] == 'B' ? "Boyalı" : "Eloksal");
        $data['alasim'] = $row['alasimId'] . ";" . $alasim['ad'];
        $data['alasimAd'] =  $alasim['ad'];
        $data['alasimId'] = $row['alasimId'];
        $data['musteriId'] = $row['musteriId'];
        $data['naylonId'] = $row['naylonDurum'];
        $data['naylonAd'] = $row['naylonDurum'] == 1 ? "Baskılı" : ($row['naylonDurum'] == 2 ? "Baskısız" : "Yok");
        $data['araKagit'] = $row['araKagit'];
        $data['araKagitAd'] = $row['araKagit'] == 1 ? "Var" : "Yok";
        $data['krepeKagit'] = $row['krepeKagit'];
        $data['krepeKagitAd'] = $row['krepeKagit'] == 1 ? "Var" : "Yok";
        $data['termimTarih'] = explode(" ", $row['termimTarih'])[0];
        $data['tabloTarih'] = tarih($row['termimTarih']);
        $data['siparisNo'] = $row['siparisNo'];
        $data['boyaId'] = $row['boyaId'];
        $data['eloksalId'] = $row['eloksalId'];
        $data['maxTolerans'] = $row['maxTolerans'];
        $data['boy'] = $row['boy'];
        $data['satirNo'] = $row['satirNo'];
        $data['istenilenTermin'] = $row['istenilenTermin'];
        $data['paketAciklama'] = $row['paketAciklama'];
        $data['boyaAciklama'] = $row['boyaAciklama'];
        $data['baskiAciklama'] = $row['baskiAciklama'];
        $data['kiloAdet'] = $row['kiloAdet'];
        $data['kalanAdet'] = $row['kalanAdet'];
        $data['kalanKilo'] = $row['kalanKilo'];
        $data['konum'] = $row['konum'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'tolerans') {

    $profilId = $received_data->profilId;
    $deger = $received_data->deger;

    $sql = "SELECT  * from tblprofil where id = '$profilId' ";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    $gramaj = $row['gramaj'];
    $gramaj = $gramaj + (($gramaj * $deger) / 100);

    $sqlMax = "SELECT  * FROM tbltakim where durum  = 1 and profilId = '$profilId'";
    $takimGramajDegerler = $db->query($sqlMax);

    $array = array();
    while ($takim = $takimGramajDegerler->fetch_array()) {
        array_push($array, $takim['sonGramaj']);
    }
    $minDeger = min($array);

    $sonuc = $minDeger <= $gramaj ? false : true;

    $data['deger'] = $sonuc;

    echo json_encode($data);
}

if ($received_data->action == 'siparislerlistesi') {

    $siparisNo = $received_data->siparisNo;

    $sql = "SELECT  * from tblsiparis where siparisNo = '$siparisNo'";
    $result = $db->query($sql);
    $datam = array();
    $siparis = null;
    while ($row = $result->fetch_array()) {
        $alasim = tablogetir('tblalasim','id',$row['alasimId'], $db );
        $profil = tablogetir('tblprofil','id',$row['profilId'], $db );
        $profilAdi =  $profil['profilAdi'];
        $profilNo =  $profil['profilNo'];
        $siparis['id'] = $row['id'];
        $siparis['profil'] = $row['profilId'] . ";" . $profilNo . "-" . $profilAdi;
        $siparis['profilId'] = $row['profilId'];
        $siparis['profilAdi'] = $profilNo . "-" . $profilAdi;
        $siparis['adet'] = $row['adet'];
        $siparis['kilo'] = $row['kilo'];
        $siparis['siparisTur'] = $row['siparisTuru'] == 'H' ? "Ham" : ($row['siparisTuru'] == 'B' ? "Boyalı" : "Eloksal");
        $siparis['alasim'] =  $row['alasimId'].";".$alasim['ad'];
        $siparis['alasimAd'] = $alasim['ad'];
        $siparis['alasimId'] = $row['alasimId'];
        $siparis['musteriId'] = $row['musteriId'];
        $siparis['naylonId'] = $row['naylonDurum'];
        $siparis['naylonAd'] = $row['naylonDurum'] == 1 ? "Baskılı" : ($row['naylonDurum'] == 2 ? "Baskısız" : "Yok");
        $siparis['araKagit'] = $row['araKagit'];
        $siparis['araKagitAd'] = $row['araKagit'] == 1 ? "Var" : "Yok";
        $siparis['krepeKagit'] = $row['krepeKagit'];
        $siparis['krepeKagitAd'] = $row['krepeKagit'] == 1 ? "Var" : "Yok";
        $siparis['termimTarih'] = explode(" ", $row['termimTarih'])[0];
        $siparis['tabloTarih'] = tarih($row['termimTarih']);
        $siparis['siparisNo'] = $row['siparisNo'];
        $siparis['boyaId'] = $row['boyaId'];
        $siparis['eloksalId'] = $row['eloksalId'];
        $siparis['maxTolerans'] = $row['maxTolerans'];
        $siparis['boy'] = $row['boy'];
        $siparis['satirNo'] = $row['satirNo'];
        $siparis['istenilenTermin'] = $row['istenilenTermin'];
        $siparis['paketAciklama'] = $row['paketAciklama'];
        $siparis['boyaAciklama'] = $row['boyaAciklama'];
        $siparis['baskiAciklama'] = $row['baskiAciklama'];
        $siparis['kiloAdet'] = $row['kiloAdet'];
        $siparis['kalanAdet'] = $row['kalanAdet'];
        $siparis['kalanKilo'] = $row['kalanKilo'];
        $siparis['silmeLinki'] = base_url() . "netting/siparis/index.php/?satirsil=" . $row['satirNo'] . "&siparisno=" . $row['siparisNo'];
        array_push($datam, $siparis);
    }
    echo json_encode($datam);
}

?>