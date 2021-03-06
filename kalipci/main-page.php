<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "
 select k.id as id,
       profilNo,
       firmaAd,kalipCins,parca,cap,kisaKod,kalipciNo, durum,takimNo,senaNo, profilAdi, figurSayi
from tblkalipparcalar k
         LEFT JOIN tblprofil p ON k.profilId = p.id
         LEFT JOIN tblfirma f ON f.id = k.firmaId order by k.id desc
 ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Parça Stoğa Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Parça Stoğa Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Parça Stoktan Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Parça Stoktan Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Parça Stoktan Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Parça Stoktan Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Parçalar</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sena No</th>
                                <th>Profil</th>
                                <th>Firma</th>
                                <th>Tür</th>
                                <th>Parça</th>
                                <th>Çap</th>
                                <th>Figür</th>
                                <th>Kalıpçı No</th>
                                <th>Durum</th>
                                <th>Takım</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['senaNo']; ?></td>
                                    <td><?php echo $row['profilNo'] . " - ". $row['profilAdi']; ?></td>
                                    <td><?php echo $row['firmaAd']; ?></td>
                                    <td><?php echo kalipBul($row['kalipCins']); ?></td>
                                    <td><?php echo trim(parcaBul($row['parca'])); ?></td>
                                    <td><?php echo $row['cap']; ?></td>
                                    <td><?php echo $row['figurSayi']; ?></td>
                                    <td><?php echo $row['kisaKod'] . $row['kalipciNo']; ?></td>
                                    <td style="color: <?php echo $row['durum'] == 1 ? '#00b44e' : ($row['durum'] == 2 ? '#d55537' : '#b8860b') ?>">
                                        <b>
                                            <?php echo $row['durum'] == 1 ? "Aktif" : ($row['durum'] == 2 ? 'Pasif' : 'Çöp')
                                            ?></b></td>
                                    <td><b><?php echo $row['takimNo']; ?></b></td>
                                    <td><a href="<?php echo "goruntule/?id=" . $row['id']; ?>" class="btn btn-outline-primary">Görüntüle</a>
                                        <?php if (!$row['takimNo']) { ?>
                                            <a href=<?php echo base_url() . "netting/kalipci/index.php?kalipsil=" . $row['id']; ?> class="btn
                                               btn-danger">Sil</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $sira++;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


