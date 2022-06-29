<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "
select baslaZaman, topAdet, partino, tblboya.id as id, profilNo, profilAdi, boy,ad, kod, tblstokboya.cins, b.satirNo
from tblboya
         INNER JOIN tblstokboya on tblboya.boyaId = tblstokboya.id
         INNER JOIN tblbaski b on b.id = SUBSTRING_INDEX(tblboya.baskilar, ';', 1)
         INNER JOIN tblsiparis s on s.id = b.siparisId
         INNER JOIN tblprofil p on p.id = s.profilId
         INNER JOIN tblprboya pr on pr.id = s.boyaId
order by id desc";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Boyanma Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Boyanma Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Boyanma Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Boyanmalar</h4>
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
                                <th>#</th>
                                <th>İşlem Tarihi</th>
                                <th>Satır No</th>
                                <th>Profil No/Adı</th>
                                <th>Boy</th>
                                <th>Toplam Adet</th>
                                <th>Renk/Cins</th>
                                <th>Durum</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaZaman']); ?></td>
                                    <td><?php echo $row['satirNo']; ?></td>
                                    <td><?php echo $row['profilNo']."/".$row['profilAdi']; ?></td>
                                    <td><?php echo $row['boy']; ?></td>
                                    <td><?php echo $row['topAdet']; ?></td>
                                    <td><?php echo $row['ad']."/".$row['cins']; ?></td>
                                    <td><a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                           class="btn btn-outline-primary">Görüntüle</a></td>

                                </tr>
                                <?php $sira++;
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


