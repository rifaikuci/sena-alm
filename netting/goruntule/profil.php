<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";
$id = $_POST['id'];

$sql = "SELECT * FROM tblstokprofil  where id = '$id'";
$result = $db->query($sql);



?>
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Sipariş No</th>
            <th scope="col">Profil</th>
            <th scope="col">Boy</th>
            <th scope="col">Firma</th>
            <th scope="col">Müşteri</th>
            <th scope="col">Tür</th>
            <th scope="col">Geliş A.</th>
            <th scope="col">İç Adet</th>
            <th scope="col">Paket Adet</th>
            <th scope="col">Adet</th>
            <th scope="col">M/Gr</th>
            <th scope="col">Tolerans</th>
        </tr>
        </thead>
        <tbody>
        <?php $sira = 1;
        while ($profil = $result->fetch_array()) {
            $mgr = mGrBul($profil['toplamKg'], $profil['toplamAdet'], $profil['boy']);
            $tolerans = toleransBul($mgr, $profil['profilId'], $db);
            ?>
            <tr>
                <td><?php echo tablogetir('tblprofil','id',$profil['profilId'], $db )['profilNo']; ?></td>
                <td><?php echo $profil['boy'] ?></td>
                <td><?php echo tablogetir('tblfirma','id',$profil['firmaId'], $db)['firmaAd'] ?> </td>
                <td><?php echo tablogetir('tblfirma','id',$profil['musteriId'], $db)['firmaAd'] ?> </td>
                <td><?php echo $profil['tur'] ?></td>
                <td><?php echo $profil['gelisAmaci'] ?></td>
                <td><?php echo $profil['icAdet'] ?></td>
                <td><?php echo $profil['paketAdet'] ?></td>
                <td><?php echo $profil['toplamAdet'] ?></td>
                <td><?php echo $profil['toplamKg'] ?></td>
                <td><?php echo $mgr ?></td>
                <td style="color:<?php echo $tolerans < 0 ? '#00b44e' : '#ff2400' ?>"> <?php echo "% " . $tolerans ?></td>
            </tr>
            <?php $sira++;
        } ?>
        </tbody>
    </table>
</div>



