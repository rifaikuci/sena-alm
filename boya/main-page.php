<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblboya order by id desc ";
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
                                <th>Sepet</th>
                                <th>Parti No</th>
                                <th>Kesim</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaZaman']) ; ?></td>
                                    <td><?php echo tablogetir('tblsepet', 'id',$row['sepetId'], $db)['ad']; ?></td>
                                    <td><?php echo tablogetir('tblstokboya', 'id',$row['boyaId'], $db)['partino']; ?></td>
                                    <td><?php echo $row['kesimId']; ?></td>

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


