<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$kalipCins = $_POST['kalipCins'];
$parca = $kalipCins == 0 ? 1 : ($kalipCins == 1 ? 4 : ($kalipCins == 2 ? 7 : ""));

$parcaIsimleri = $kalipCins == 0 ? "Kapaklar" : ($kalipCins == 1 ? "Kapaklar" : ($kalipCins == 2 ? "Kalıplar" : ""));
if ($_POST['cap'] != "" && $_POST['firmaId'] != "" && $_POST['profilId'] != "" && $_POST['figur'] != "") {
    $cap = trim($_POST['cap']);
    $firmaId = trim($_POST['firmaId']);
    $profilId = trim($_POST['profilId']);
    $figurSayi = trim($_POST['figur']);

    $sql = "
    select k.id as id,
       kalipCins,
       takimNo,
       cap,
       firmaId,
       firmaAd,
       profilId,
       figurSayi,
       parca,
       durum,
       senaNo,
       profilNo,
       kalipciNo, kalite
from tblkalipparcalar k
         INNER JOIN tblprofil p on p.id = k.profilId
         INNER JOIN tblfirma f on f.id = k.firmaId
where k.kalipCins = '$kalipCins' AND k.takimNo = '' AND k.cap= '$cap' AND  k.firmaId = '$firmaId' AND
        k.profilId = '$profilId' AND k.figurSayi = '$figurSayi' AND k.parca = '$parca' AND k.durum = '1'
    ";


} else {
    $sql = "select k.id as id,
       kalipCins,
       takimNo,
       cap,
       firmaId,
       firmaAd,
       profilId,
       figurSayi,
       parca,
       durum,
       senaNo,
       profilNo,
       kalipciNo, kalite
from tblkalipparcalar k
         INNER JOIN tblprofil p on p.id = k.profilId
         INNER JOIN tblfirma f on f.id = k.firmaId
                    where k.kalipCins = '$kalipCins' AND k.takimNo = '' AND k.parca  = '$parca' AND k.durum = '1' ";
}

$result = $db->query($sql);


?>


<div style="text-align: center">
    <h4 style="color: #0e84b5">
        <?php echo $parcaIsimleri ?>
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
        while ($parca = $result->fetch_array()) {
            ?>
            <tr>
                <td class="parcaselected2" style="color: indianred"
                    data-senaNo="<?php echo $parca['senaNo'] ?>"
                    data-firmaId="<?php echo $parca['firmaId'] ?>"
                    data-firmaAd="<?php echo $parca['firmaAd'] ?>"
                    data-profilId="<?php echo $parca['profilId'] ?>"
                    data-profilAd="<?php echo $parca['profilNo'] ?>"
                    data-figurSayi="<?php echo $parca['figurSayi'] ?>"
                    data-cap="<?php echo $parca['cap'] ?>"> <?php echo $parca['senaNo'] ?>
                </td>
                <td> <?php echo $parca['firmaAd'] ?></td>
                <td><?php echo $parca['kalipciNo'] ?></td>
                <td> <?php echo $parca['profilNo'] ?></td>
                <td><?php echo trim(parcaBul($parca['parca'])); ?></td>
                <td> <?php echo $parca['cap'] ?></td>
                <td> <?php echo $parca['kalite']; ?></td>
                <td> <?php echo $parca['figurSayi']; ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



