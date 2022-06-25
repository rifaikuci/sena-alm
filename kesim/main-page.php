<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "
select  
    b.kesimId as id, satirNo, baskiId, tarih, kesilenBoy, hurdaAdet, netAdet
    from tblkesim k INNER JOIN tblbaski b ON b.kesimId = k.id order by id desc
";
$result = $db->query($sql);

$islemArray = [1,2];
$sonuc = in_array($rolId, $islemArray);
?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Kesim Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Kesim Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Kesim Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kesim Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Kesim Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Kesim Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kesimler</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if($sonuc) { ?>
                    <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <?php } ?>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Satır No</th>
                                <th>Baskı ID</th>
                                <th>Tarih</th>
                                <th>Kesilen Boy</th>
                                <th>Hurda Adet</th>
                                <th>Net Adet</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['satirNo']; ?></td>
                                    <td><?php echo $row['baskiId']; ?></td>
                                    <td><?php echo tarih($row['tarih']); ?></td>
                                    <td><?php echo $row['kesilenBoy']; ?></td>
                                    <td><?php echo $row['hurdaAdet']; ?></td>
                                    <td><?php echo $row['netAdet']; ?></td>
                                    <td>
                                    <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                           class="btn btn-outline-primary">Görüntüle</a>

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


