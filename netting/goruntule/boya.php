<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$partino = $_POST['partino'];
$firmaId = $_POST['firmaId'];
$boyaTuru = $_POST['boyaTuru'];
$sicaklik = $_POST['sicaklik'];
$cins = $_POST['cins'];
$kilo = $_POST['kilo'];
$adet = $_POST['adet'];


$sql = "select s.id as id,
       barkodNo,
       partino,
       firmaAd,
       ad,
       sicaklik,
       cins,
       kilo,
       boyaTuru,
       adet
from tblstokboya s
         INNER JOIN tblfirma f ON f.id = s.firmaid
         LEFT JOIN tblprboya p on p.id = s.boyaTuru
where s.partino = '$partino'
  AND s.firmaId = '$firmaId'
  AND s.boyaTuru = '$boyaTuru'
  AND s.adet = '$adet'
  AND s.sicaklik = '$sicaklik'
  AND s.cins = '$cins'
  AND s.kilo = '$kilo'  ";
$result = $db->query($sql);


?>
<div class="card-body table-responsive p-0">
    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Barkod</th>
            <th scope="col">Parti No</th>
            <th scope="col">Firma</th>
            <th scope="col">Boya</th>
            <th scope="col">Sıcaklık</th>
            <th scope="col">Cins</th>
            <th scope="col">Kilo</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($boya = $result->fetch_array()) {
            ?>
            <tr>
                <td><?php echo $boya['barkodNo'] ?></td>
                <td><?php echo $boya['partino'] ?></td>
                <td> <?php echo $boya['firmaAd']; ?></td>
                <td> <?php echo $boya['ad']; ?></td>
                <td> <?php echo $boya['sicaklik'] ?></td>
                <td> <?php echo $boya['cins'] ?></td>
                <td> <?php echo $boya['kilo']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



