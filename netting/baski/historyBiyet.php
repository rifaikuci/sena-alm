<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$profilId = $_POST['profilId'];
$boy = $_POST['boy'];


$sql = "
select  tblbaski.siparisId, tblbaski.id, tblbaski.operatorId, tblsiparis.boy, tblsiparis.profilId, str_to_date(tblbaski.bitisZamani, '%d.%m.%Y %H:%i') as bitisZamani,
       tblbaski.biyetBoy, tblbaski.araIsFire,tblbaski.konveyorBoy, tblbaski.boylamFire
from tblsiparis
         INNER JOIN tblbaski ON tblsiparis.id = tblbaski.siparisId
where tblsiparis.profilId = '$profilId'
  and tblsiparis.boy = '$boy' order by bitisZamani desc LIMIT 10
 ";


$profil = tablogetir("tblprofil", 'id', $profilId, $db);
$result = $db->query($sql);


?>

<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Profil Geçmişi (Biyetler)
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Profil: <?php echo $profil['profilNo'] . " - " . $profil['profilAdi'] ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Boy: <?php echo $boy ?></label>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0">

    <table class="table table-dark table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">İşlem Zamanı</th>
            <th scope="col">Biyet Boy</th>
            <th scope="col">Ara iş Fire</th>
            <th scope="col">Konveyör Boy</th>
            <th scope="col">Boylam Fire</th>

        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_array()) { ?>
            <tr>
                <td><?php echo tarihsaat($row['bitisZamani']); ?></td>
                <td><?php echo $row['takimNo'] ?></td>
                <td><?php echo sayiFormatla($row['basilanNetAdet']) ?></td>
                <td><?php echo sayiFormatla($row['basilanBrutKg']) ?></td>
                <td><?php echo $row['oran'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



