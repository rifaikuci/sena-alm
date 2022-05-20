<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$balyaNo = $_POST['balyano'];

$row = tablogetir('tblbalyalama', 'balyaNo', $balyaNo, $db);

$sevkiyatNo = tablogetir('tblsevkiyatcikis', 'id', $row['sevkiyatId'], $db)['kod'];

$baskiId = explode(";", $row['baskiId']);
$netAdet = explode(";", $row['netAdet']);
$netKilo = explode(";", $row['netKilo']);
$mtGr = explode(";", $row['mtGr']);
$paketDetay = explode(";", $row['paketDetay']);
$realTolerans = explode(";", $row['realTolerans']);
$teorikTolerans = explode(";", $row['teorikTolerans']);
$satirNo = explode(";", $row['satirNo']);
$siparisNo = explode(";", $row['siparisNo']);
?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Balya Detayı
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Balya No: <?php echo $row['balyaNo'] ?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Balya Boy: <?php echo $row['balyaBoy'] ?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Balya Kilo: <?php echo $row['balyaKilo'] ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Balya
                No: <?php $musteri = tablogetir("tblfirma", 'id', $row['musteriId'], $db)['firmaAd'];
                echo $musteri ?></label>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0">


    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>Sipariş No</th>
            <th>Sipariş Satırı</th>
            <th>Net Adet</th>
            <th>Net Kilo</th>
            <th>Mt/Gr</th>
            <th>Reel T.</th>
            <th>Teorik T.</th>

        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($siparisNo); $i++) { ?>
            <tr>
                <td><?php echo $siparisNo[$i] ?></td>
                <td><?php echo $satirNo[$i] ?></td>
                <td><?php echo $netAdet[$i] ?></td>
                <td><?php echo $netKilo[$i] ?></td>
                <td><?php echo $mtGr[$i] ?></td>
                <td style="color: <?php echo $realTolerans[$i] > 0 ? '#ff0000' : '#3ea800' ?> "><?php echo "%" . $realTolerans[$i] ?></td>
                <td style="color: <?php echo $teorikTolerans[$i] > 0 ? '#ff0000' : '#3ea800' ?> "><?php echo "%" . $teorikTolerans[$i] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



