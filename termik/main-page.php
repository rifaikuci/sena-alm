<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tbltermik order by id desc ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Termik Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Termik Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Termik Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Termikler</h4>
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
                                <th>Sepetler</th>
                                <th>Kesimler</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem /Bitirilme Zam.</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaTarih']); ?></td>
                                    <td><?php echo $row['sepetler']; ?></td>
                                    <td><?php echo $row['kesimler']; ?></td>
                                    <td><?php echo $row['bitisTarih'] ? "Termik Bitti" : "Termik Devam Ediyor"; ?></td>
                                    <td>
                                        <?php
                                        if (!$row['bitisTarih']) { ?>
                                            <a href=<?php echo "devam/?termik=" . $row['id']; ?> class="btn
                                               btn-warning">Bitir</a>
                                        <?php } else {
                                            echo $row['bitisTarih'];
                                        } ?>
                                        <?php if (!$row['bitisTarih']) { ?>
                                            <a href=<?php echo base_url() . "netting/termik/index.php?termiksil=" . $row['id']; ?> class="btn
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

