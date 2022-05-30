<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$takimId = $_POST['takimno'];
$takimno = $_POST['takimno'];
$brutkilo = $_POST['brutkilo'];
$netkilo = $_POST['netkilo'];



$takim = tablogetir("tbltakim", 'takimNo', $takimId, $db);
$takimId = $takim['id'];
$sql = "SELECT * FROM tblkaliphane  
            where takimId = '$takimId' ";

$result = $db->query($sql);


?>

<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Takım Geçmişi - (<?php echo $takimno; ?>)
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Brüt Kilo: <?php echo sayiFormatla($brutkilo)?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Net Kilo: <?php echo sayiFormatla($netkilo)?></label>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0">

    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">İşlem Zamanı</th>
            <th scope="col">Description</th>
            <th scope="col">Eski Konum</th>
            <th scope="col">Yeni Konum</th>
            <th scope="col">Basılan Brüt</th>
            <th scope="col">Basılan Net</th>

        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_array()) {?>
            <tr>
                <td><?php echo tarihsaat($row['datetime']); ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo takimDurumBul($row['oldProcess']) ?></td>
                <td><?php echo takimDurumBul($row['newProcess']) ?></td>
                <td><?php echo $row['basilanBrutKilo'] ?></td>
                <td><?php echo $row['basilanNetKilo'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



