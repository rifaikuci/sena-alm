<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";

$partino = $_POST['partino'];
$firmaId = $_POST['firmaId'];
$malzemeId = $_POST['malzemeId'];
$adet = $_POST['adet'];


$sql = "select s.id as id,
       barkod,
       partino,
       firmaAd,
       ad,
       birimMiktari,
       firmaId,
       malzemeId,
       adet
from tblstokmalzeme s
         left JOIN tblmalzemeler m ON s.malzemeId = m.id
         left JOIN tblfirma f ON f.id = s.firmaId
where s.partino = '$partino'
  AND s.firmaId = '$firmaId'
  AND s.malzemeId = '$malzemeId'
  AND s.adet = '$adet'
 ";
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
            ?>
            <tr>
                <td><?php echo $malzeme['barkod'] ?></td>
                <td><?php echo $malzeme['partino'] ?></td>
                <td> <?php echo $malzeme['firmaAd']; ?></td>
                <td> <?php echo $malzeme['ad'] ?></td>
                <td> <?php echo $malzeme['birimMiktari'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>