<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


if ($_POST['cap'] != "" && $_POST['firmaId'] != "" && $_POST['profilId'] != "" && $_POST['figurSayi'] != "") {
    $cap = trim($_POST['cap']);
    $firmaId = trim($_POST['firmaId']);
    $profilId = trim($_POST['profilId']);
    $figurSayi = trim($_POST['figurSayi']);
    $parca = trim($_POST['parca']);

    $sql = "select k.id as id,
       senaNo,
       firmaAd,
       kalipciNo,
       profilNo,
       parca,
       cap,
       kalite,
       figurSayi
from tblkalipparcalar k
         LEFT JOIN tblfirma f on f.id = k.firmaId
         LEFT JOIN tblprofil p on p.id = k.profilId
where k.takimNo = ''
  AND k.cap = '$cap'
  AND k.firmaId = '$firmaId'
  AND k.profilId = '$profilId'
  AND k.figurSayi = '$figurSayi'
  AND k.durum = '1'
  AND k.parca = '$parca'";
} else {
    $sql = "select k.id as id,
       senaNo,
       firmaAd,
       kalipciNo,
       profilNo,
       parca,
       cap,
       kalite,
       figurSayi
from tblkalipparcalar k
         INNER JOIN tblfirma f on f.id = k.firmaId
         INNER JOIN tblprofil p on p.id = k.profilId
where k.takimNo = ''
  AND k.durum = '1'
 ";
}


$result = $db->query($sql);


?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        <?php echo parcaBul($parca) ?>
    </h4>
</div>

<div class="card-body table-responsive p-0">

    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Sena No</th>
            <th scope="col">Firma</th>
            <th scope="col">Kalıpçı No</th>
            <th scope="col">Profil</th>
            <th scope="col">Parça</th>
            <th scope="col">Çap</th>
            <th scope="col">Kalite</th>
            <th scope="col">Figür</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($parca = $result->fetch_array()) { ?>
            <tr>
                <td class="newselectparca" style="color: indianred"
                    data-senano="<?php echo $parca['senaNo'] ?>">
                    <?php echo $parca['senaNo'] ?>
                </td>
                <td> <?php echo $parca['firmaAd']; ?></td>
                <td><?php echo $parca['kalipciNo'] ?></td>
                <td> <?php echo $parca['profilNo']; ?></td>
                <td><?php echo trim(parcaBul($parca['parca'])); ?></td>
                <td> <?php echo $parca['cap'] ?></td>
                <td> <?php echo $parca['kalite']; ?></td>
                <td> <?php echo $parca['figurSayi']; ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



