<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblbalyalama order by id desc ";
$result = $db->query($sql);

?>
<!-- TODO , kilo ve boy kısmı eklencek. -->
<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Balyalama Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Balyalama Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Balyalama Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Balyalama Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Balyalama Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Balyalama Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Balyalama</h4>
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
                                <th>Balya No</th>
                                <th>Baş. Tar.</th>
                                <th style="text-align: center">Durum</th>

                            </tr>
                            </thead>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['balyaNo']; ?></td>
                                    <td><?php echo tarihsaat($row['tarih']); ?></td>
                                    <td>
                                        <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                           class="btn btn-outline-primary">Görüntüle</a>
                                    </td>
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


