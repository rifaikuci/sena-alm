<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$siparisNo = $_POST['siparisNo'];

$sql = "
select s.id as id,
       satirNo,
       profilId,
       boy,
       adet,
       kilo,
       ad,
       termimTarih,
       maxTolerans,
       araKagit,
       krepeKagit,
       naylonDurum,
       siparisNo
from tblsiparis s
         INNER JOIN tblalasim a on
    s.alasimId = a.id where s.siparisNo =  '$siparisNo'";
$result = $db->query($sql);

$sql2 = "SELECT * FROM tblsiparis  where siparisNo = '$siparisNo'";
$resultfirst = $db->query($sql2);
$firstrow = mysqli_fetch_assoc($resultfirst);
?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Sipariş Detayı
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Sipariş No: <?php echo $firstrow['siparisNo']?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Müşteri Adı: <?php echo tablogetir('tblfirma','id',$firstrow['musteriId'], $db)['firmaAd'] ?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Sipariş Tarihi: <?php echo tarih($firstrow['siparisTarih'])?></label>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0">


    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>#</th>
            <th>Profil</th>
            <th>Boy (mm)</th>
            <th>Adet</th>
            <th>Kilo</th>
            <th>Alaşım</th>
            <th>Termin T.</th>
            <th>Tolerans</th>
            <th>Ara K.</th>
            <th>Krepe K.</th>
            <th>Naylon</th>
        </tr>
        </thead>
        <tbody>
<?php while ($row = $result->fetch_array()) { ?>
        <tr>
            <td><?php  echo $row['satirNo'];?></td>
            <td><?php  echo $row['profilId'];?></td>
            <td><?php  echo $row['boy'];?></td>
            <td><?php  echo $row['adet'];?></td>
            <td><?php  echo sayiFormatla($row['kilo']);?></td>
            <td><?php  echo $row['ad'];?></td>
            <td><?php  echo tarih($row['termimTarih']);?></td>
            <td><?php  echo "%".$row['maxTolerans'];?></td>
            <td><?php  echo $row['araKagit'] == "1" ? "Var" : "Yok";?></td>
            <td><?php  echo $row['krepeKagit'] == "1" ? "Var" : "Yok";?></td>
            <td><?php  echo $row['naylonDurum'] == 1 ? "Baskılı" : ($row['naylonDurum'] == 2 ? "Baskısız" : "Yok") ;?></td>

        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



