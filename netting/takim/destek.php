<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$parca = $_POST['parca'];



$sql = "SELECT * FROM tblkalipparcalar  
            where id IN($parca)";


$result = $db->query($sql);


?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Destekler
    </h4>
</div>
<div class="card-body table-responsive p-0">

    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Sena No</th>
            <th scope="col">Firma</th>
            <th scope="col">Kalıpçı No</th>
            <th scope="col">Parça</th>
            <th scope="col">Çap</th>
            <th scope="col">Kalite</th>
            <th scope="col">Figür</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_array()) {
            $firma = tablogetir('tblfirma','id',$row['firmaId'], $db)
            ?>
            <tr>
                <td><?php echo $row['senaNo'] ?></td>
                <td> <?php echo $firma['firmaAd'] ?></td>
                <td><?php echo $firma['kisaKod'].$row['kalipciNo'] ?></td>
                <td>Destek</td>
                <td> <?php echo $row['cap'] ?></td>
                <td> <?php echo $row['kalite']; ?></td>
                <td> <?php echo $row['figurSayi']; ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



