<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

$sql = "select f.id as id, firmaAd, ad, kisaKod, yetkiliKisi
from tblfirma f
         INNER JOIN tblfirmatur ft ON ft.id = f.firmaTurId
order by f.id desc";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Firma Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Firma Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Firma Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Firma Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Firma Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Firma Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Firmalar</h4>
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
                                <th>Firmad Adı</th>
                                <th>Firmad Türü</th>
                                <th>Kısa Kod</th>
                                <th>Yetkili Kişi</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['firmaAd']; ?></td>
                                    <td><?php
                                        echo $row['ad']; ?></td>
                                    <td><?php echo $row['kisaKod']; ?></td>
                                    <td><?php echo $row['yetkiliKisi']; ?></td>
                                    <td>
                                        <a href=<?php echo "guncelle/?id=" . $row['id']; ?> class="btn
                                           btn-warning">Düzenle</a>
                                        <a href=<?php echo base_url() . "netting/tanimlar/firma.php?firmasil=" . $row['id']; ?> class="btn
                                           btn-danger">Sil</a>
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


