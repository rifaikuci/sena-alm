<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$partino = $_POST['partino'];
$firmaId = $_POST['firmaId'];
$alasimId = $_POST['alasimId'];
$adet = $_POST['adet'];
$boy = $_POST['boy'];
$cap = $_POST['cap'];


$sql = "SELECT * FROM tblstokbiyet  where partino = '$partino' AND firmaId = '$firmaId' AND alasimId= '$alasimId' AND   adet = '$adet' AND boy = '$boy' AND cap = '$cap'";
$result = $db->query($sql);


?>
<div class="card-body table-responsive p-0">
    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Barkod</th>
            <th scope="col">Parti No</th>
            <th scope="col">Firma</th>
            <th scope="col">Alaşım</th>
            <th scope="col">Adet</th>
            <th scope="col">Çap</th>
            <th scope="col">Boy</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($biyet = $result->fetch_array()) {
            ?>
            <tr>
                <td><?php echo $biyet['barkodNo'] ?></td>
                <td> <?php echo $biyet['partino'] ?></td>
                <td> <?php echo firmaBul($biyet["firmaId"], $db, 'firmaAd') ?></td>
                <td> <?php echo alasimBul($biyet["alasimId"], $db, 'ad') ?></td>
                <td> <?php echo $biyet['adet'] ?></td>
                <td> <?php echo $biyet["cap"] ?></td>
                <td> <?php echo $biyet["boy"] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



