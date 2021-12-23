<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";

$partino = $_POST['partino'];
$firmaId = $_POST['firmaId'];
$malzemeId = $_POST['malzemeId'];
$adet = $_POST['adet'];


$sql = "SELECT * FROM tblstokmalzeme  where partino = '$partino' AND firmaId = '$firmaId' AND malzemeId= '$malzemeId' AND   adet = '$adet'";
$result = $db->query($sql);

$sira = 1;


?>
<div class="card-body table-responsive p-0">
    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Barkod</th>
            <th scope="col">Parti No</th>
            <th scope="col">Firma</th>
            <th scope="col">Malzeme</th>
            <th scope="col">Birim Kg</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($malzeme = $result->fetch_array()) {
            $malzemegetir = tablogetir('tblmalzemeler','id',$malzeme["malzemeId"], $db);
            ?>
            <tr>
                <td><?php echo $malzeme['barkod'] ?></td>
                <td><?php echo $malzeme['partino'] ?></td>
                <td> <?php echo tablogetir('tblfirma','id',$malzeme['firmaId'], $db)['firmaAd']; ?></td>
                <td> <?php echo $malzemegetir['ad'] ?></td>
                <td> <?php echo $malzemegetir['birimMiktari'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>