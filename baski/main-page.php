<?php

include "../netting/baglan.php";
include "../include/sql.php";
require_once "../include/data.php";

$sqlsilinecek = "DELETE FROM tblbaski where bitisZamani = ''";
mysqli_query($db, $sqlsilinecek);

$sql = "SELECT * FROM tblbaski order by id desc ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Baskı Başarılı Bir Şekilde Sonlandı. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Baskı Sonlanırken bir hata oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Baskı Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Baskı Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Baskı Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Baskı Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Baskılar</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>

                <!-- TODO buraya operatorId zamanında tabloya kullanıcının bilgileri de gösterilecek !-->
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Baslangıç - Bitiş Zamanı</th>
                                <th>Satır No</th>
                                <th>Takım</th>
                                <th>Basılan Net Kg/Adet</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['bitisZamani'] ? tarihsaat($row['baslaZamani']) . " - " . tarihsaat($row['bitisZamani']) : tarihsaat($row['baslaZamani']); ?></td>
                                    <td><?php echo $row['satirNo']; ?></td>
                                    <td><?php echo tablogetir('tbltakim', 'id', $row['takimId'], $db)['takimNo']; ?></td>
                                    <td><?php echo sayiFormatla($row['basilanNetKg']) . " Kg / " . $row['basilanNetAdet'] . " Adet"; ?></td>
                                    <td>
                                        Görüntüle eklenecek
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


