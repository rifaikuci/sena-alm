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

    $sql = "SELECT * FROM tblkalipparcalar  
            where kalipCins = '$kalipCins' AND takimNo = '' AND cap= '$cap' AND  firmaId = '$firmaId' AND
                profilId = '$profilId' AND figurSayi = '$figurSayi' AND parca = $parca AND durum = '1'";


} else {
    $sql = "SELECT * FROM tblkalipparcalar  
                    where kalipCins = '$kalipCins' AND takimNo = '' AND parca  = $parca AND durum = '1' ";
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
        while ($parca = $result->fetch_array()) { ?>
            <tr>
                <td class="parcaselected2" style="color: indianred"
                    data-senaNo="<?php echo $parca['senaNo'] ?>"
                    data-firmaId="<?php echo $parca['firmaId'] ?>"
                    data-firmaAd="<?php echo firmaBul($parca['firmaId'], $db, 'firmaAd') ?>"
                    data-profilId="<?php echo $parca['profilId'] ?>"
                    data-profilAd="<?php echo profilbul($parca['profilId'], $db, 'profilAdi') ?>"
                    data-figurSayi="<?php echo $parca['figurSayi'] ?>"
                    data-cap="<?php echo $parca['cap'] ?>"> <?php echo $parca['senaNo'] ?>
                </td>
                <td> <?php echo firmaBul($parca["firmaId"], $db, 'firmaAd') ?></td>
                <td><?php echo $parca['kalipciNo'] ?></td>
                <td> <?php echo profilbul($parca["profilId"], $db, 'profilAdi') ?></td>
                <td><?php echo trim(parcaBul($parca['parca'])); ?></td>
                <td> <?php echo $parca['cap'] ?></td>
                <td> <?php echo $parca['kalite']; ?></td>
                <td> <?php echo $parca['figurSayi']; ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



