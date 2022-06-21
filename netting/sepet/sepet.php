<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$id = $_POST['id'];

$row = tablogetir('tblsepet', 'id', $id, $db);

$ad = $row['ad'];
$tur = $row['tur'];
$durum = $row['durum'];
$isTermik = $row['isTermik'];
$finishedKromat = $row['finishedKromat'];
$turAciklama = "";
$termikAciklama = "";
$kromatAciklama = "";
$durumAciklama = "";

if ($tur == "termik") {
    $turAciklama = "Termik";
} else if ($tur == "araba") {
    $turAciklama = "Araba";
} else if ($tur == "kromat") {
    $turAciklama = "Kromat";
} else if ($tur == "kromatS") {
    $turAciklama = "Kromat Araba";
}
if($row['icindekiler']) {
    $icindekiler = rtrim($row['icindekiler'], ";");
    $adet = rtrim($row['adetler'], ";");
    $baskiId = explode(";", $icindekiler);
    $adetler = explode(";",$adet);
}



if($isTermik == 0) {
    $termikAciklama = "Yok";
}

if($isTermik == 1) {
    $termikAciklama = "Termik Devam Ediyor";
}

if($isTermik == 2) {
    $termikAciklama = "Termik Bitti";
}

if($finishedKromat == 0) {
    $kromatAciklama = "Yok";
}

if($finishedKromat == 1) {
    $kromatAciklama = "Kromat Bitti";
}

if($durum == 0) {
    $durumAciklama = "Yok";
}

if($durum == 1) {
    $durumAciklama = "Dolu";
}

if($durum == 2) {
    $durumAciklama = "Termik Bitti";
}


?>

<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Sepet Detayı
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Sepet: <?php echo $ad ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Türü: <?php echo $turAciklama ?></label>
        </div>
    </div>
</div>


<div class="card-body table-responsive p-0">


    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Sipariş No</th>
            <th>Sipariş Satırı</th>
            <th>Adet</th>
            <th>Termik</th>
            <th>Kromat</th>
            <th>Durum</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($baskiId); $i++) {
            $baski = tablogetir("tblbaski", 'id',$baskiId[$i], $db);
            $siparis = tablogetir("tblsiparis", 'id',$baski['siparisId'], $db)['siparisNo'];
            ?>
            <tr>
                <td><?php echo $siparis ?></td>
                <td><?php echo $baski['satirNo'] ?></td>
                <td><?php echo $adetler[$i] ?></td>
                <td><?php echo $termikAciklama ?></td>
                <td><?php echo $kromatAciklama ?></td>
                <td><?php echo $durumAciklama ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



