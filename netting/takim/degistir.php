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

    $sql = "SELECT * FROM tblkalipparcalar  
            where takimNo = '' AND cap= '$cap' AND  firmaId = '$firmaId' AND
                profilId = '$profilId' AND figurSayi = '$figurSayi' AND  durum = '1' AND parca = '$parca'";
} else {
    $sql = "SELECT * FROM tblkalipparcalar  
                    where takimNo = '' AND  durum = '1' ";
}


$result = $db->query($sql);


?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        <?php echo parcaBul($parca)?>
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
                <td> <?php echo firmaBul($parca["firmaId"], $db, 'firmaAd') ?></td>
                <td><?php echo $parca['kalipciNo'] ?></td>
                <td> <?php echo profilbul($parca["profilId"], $db, 'profilNo') ?></td>
                <td><?php echo trim(parcaBul($parca['parca'])); ?></td>
                <td> <?php echo $parca['cap'] ?></td>
                <td> <?php echo $parca['kalite']; ?></td>
                <td> <?php echo $parca['figurSayi']; ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>


