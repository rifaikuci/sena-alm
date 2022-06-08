<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$id = $_POST['id'];

$sql = "select s.id as id, barkodNo, partino, firmaAd, ad, cap, toplamKg, ortalamaBoy from tblstokbiyet s 
INNER JOIN tblfirma f ON f.id = s.firmaid
INNER JOIN tblalasim a ON a.id = s.alasimid where s.id = '$id'";
$result = $db->query($sql);


?>
<div class="card-body table-responsive p-0">
    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Sipariş No</th>
            <th scope="col">Parti No</th>
            <th scope="col">Firma</th>
            <th scope="col">Alaşım</th>
            <th scope="col">Çap</th>
            <th scope="col">Toplam Kg</th>
            <th scope="col">Ortalama Boy</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($biyet = $result->fetch_array()) {
            ?>
            <tr>
                <td><?php echo $biyet['barkodNo'] ?></td>
                <td> <?php echo $biyet['partino'] ?></td>
                <td> <?php echo $biyet['firmaAd'] ?></td>
                <td> <?php echo $biyet['ad'] ?></td>
                <td> <?php echo $biyet["cap"] ?></td>
                <td> <?php echo $biyet["toplamKg"] . " Kg" ?></td>
                <td> <?php echo $biyet["ortalamaBoy"] . " Cm" ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



