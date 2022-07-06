<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";
require_once "../../include/style.php";
$profilId = $_POST['profilId'];
$boy = $_POST['boy'];

#tenefer vakti gelenleri baski tarafında göster
#todo Zamana göre Sıralama Yapıldığı Yer
$sql = "
select str_to_date(b.bitisZamani, '%d.%m.%Y %H:%i') as bitisZamani,
       b.id                                         as id,
       b.fire,
       b.guncelGr,
       biyetBoy,
       b.araIsFire,
       b.konveyorBoy,
       b.boylamFire,
       b.baskiFire,
       t.takimNo,
       s.profilId
from tblbaski b
         INNER JOIN tbltakim t ON b.takimId = t.id
INNER JOIN tblsiparis s ON s.id = b.siparisId
where s.profilId = '$profilId'
  and s.boy = '$boy'
    and b.bitisZamani != ''
ORDER BY b.bitisZamani desc
LIMIT 5
 ";


$profil = tablogetir("tblprofil", 'id', $profilId, $db);
$result = $db->query($sql);


?>

<style>
    body{
        padding-top:50px;
        background-color:#34495e;
    }



    .hiddenRow {
        padding: 0 !important;
    }
</style>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Profil Geçmişi (Son 5 )
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

<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>İşlem Zamanı</th>
                        <th>Takım No</th>
                        <th>Baskı Id</th>
                        <th>Güncel Gr</th>
                        <th>Fire</th>
                    </tr>
                    </thead>
                    <?php $sira = 1; while ($row = $result->fetch_array()) {
                        $idText = "demo".$sira;

                        $biyetBoy = explode(";",$row['biyetBoy']);
                        $araIsFire = explode(";",$row['araIsFire']);
                        $konveyorBoy = explode(";",$row['konveyorBoy']);
                        $boylamFire = explode(";",$row['boylamFire']);
                        $baskiFire = explode(";",$row['baskiFire']);
                        ?>
                    <tr data-toggle="collapse" data-target="<?php echo "#".$idText;?>" class="accordion-toggle">
                        <td><?php echo tarihsaat($row['bitisZamani'])?></td>
                        <td><?php echo $row['takimNo']?></td>
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['guncelGr']?></td>
                        <td><?php echo $row['fire']?></td>
                    </tr>

                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" id="<?php echo $idText;?>">
                                <table class="table table-striped">
                                    <thead style="background-color: #0b93d5">
                                    <tr class="info">
                                        <th>Biyet Boy</th>
                                        <th>Araiş Fire</th>
                                        <th>Konveyör Boy</th>
                                        <th>Boylam Fire</th>
                                        <th>Baskı Fire</th>
                                    </tr>
                                    </thead>

                                    <tbody>


                                    <?php for ($i=0; $i < count($biyetBoy); $i++) { ?>
                                    <tr>
                                        <td> <?php  echo $biyetBoy[$i]; ?> </td>
                                        <td> <?php  echo $araIsFire[$i]; ?> </td>
                                        <td> <?php  echo $konveyorBoy[$i]; ?> </td>
                                        <td> <?php  echo $boylamFire[$i]; ?> </td>
                                        <td> <?php  echo $baskiFire[$i]; ?> </td>

                                    </tr>
                                    <?php  }  ?>


                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>
                    <?php $sira++; } ?>

                </table>
            </div>

        </div>

    </div>
</div>





