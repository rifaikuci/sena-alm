<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$takimId = $_POST['takimno'];



$takim = tablogetir("tbltakim", 'takimNo', $takimId, $db);
$takimId = $takim['id'];
$sql = "SELECT * FROM tblkaliphane  
            where takimId = '$takimId' ";

$result = $db->query($sql);


?>

<!-- TODO durum kısmı yanlış veri geliyor, takım no yukarı alıyor.  -->
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Takım Geçmişi
    </h4>
</div>
<div class="card-body table-responsive p-0">

    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Takım No</th>
            <th scope="col">İşlem Zamanı</th>
            <th scope="col">Description</th>
            <th scope="col">Durum</th>

        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_array()) {?>
            <tr>
                <td><?php echo $takim['takimNo'] ?></td>
                <td><?php echo tarihsaat($row['datetime']); ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo takimDurumBul($takim['konum']); ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



