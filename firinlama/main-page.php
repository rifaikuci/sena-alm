<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblfirinlama order by id desc ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Fırınlama Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Fırınlama Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Fırınlama Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Fırınlama Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Fırınlama Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Fırınlama Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Fırınlama</h4>
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
                                <th>Baş. Tar.</th>
                                <th>Boyananlar</th>
                                <th style="text-align: center">Durum</th>
                                <th style="text-align: center">İşlem Bitiş</th>

                            </tr>
                            </thead>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaTarih']); ?></td>
                                    <td><?php echo str_replace(";", ",", $row['boyalar']); ?></td>
                                    <td><?php echo $row['bitisTarih'] ? "Fırınlama Bitti" : "Fırınlama Devam Ediyor"; ?></td>
                                    <td>
                                        <?php
                                        if (!$row['bitisTarih']) { ?>
                                            <?php $operatorId = isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0; ?>
                                            <a onclick=" return confirm('Fırınlama Tamamlanıyor')"
                                                    href="<?php echo base_url() . "netting/firinlama/index.php?operator=" . $operatorId . "&firinlamabitir=" . $row['id']; ?>"
                                               class="btn btn-warning">Bitir</a>
                                            <a onclick=" return confirm('Fırınlama İptal Ediliyor')"
                                                    href="<?php echo base_url() . "netting/firinlama/index.php?firinlamasil=" . $row['id']; ?>"
                                               class="btn btn-danger">Sil</a>
                                        <?php } else {
                                            echo $row['bitisTarih'];
                                        } ?>
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


