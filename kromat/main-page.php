<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblkromat order by id desc ";
$result = $db->query($sql);


?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Kromat Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kromat Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumdevam'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Tamamlandı. ");
    } else if ($_GET['durumdevam'] == "no") {
        durumDanger("Kromat Tamamlanırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kromatlar</h4>
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
                                <th>Başlama Tarih</th>
                                <th>Sepet</th>
                                <th>Havuz Kromat</th>
                                <th>Havuz Asidi</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaTarih']); ?></td>
                                    <td><?php echo tablogetir('tblsepet', 'id', $row['sepetId'], $db)['ad']; ?></td>
                                    <td><?php echo $row['havuzKromatId']; ?></td>
                                    <td><?php echo $row['havuzAsitId']; ?></td>
                                    <td><?php if ($row['bitisZaman']) { ?>
                                            <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                               class="btn btn-outline-primary">Görüntüle</a>
                                        <?php } else { ?>
                                            Kromat Devam Ediyor <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!$row['bitisZaman']) { ?>
                                            <a href=<?php echo "devam/?kromat=" . $row['id']; ?> class="btn
                                               btn-warning">Bitir</a>
                                        <?php } else {
                                            echo tarihsaat($row['bitisZaman']);

                                        } ?>
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


