<?php
include "../../netting/baglan.php";

$sql = "SELECT * FROM tblsektor order by id desc";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Sektör Türü Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Sektör Türü Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Sektör Türü Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Sektör Türü Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Sektör Türü Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Sektör Türü Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Sektör Türleri</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ad</th>
                                <th>Kısa Kod</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['ad']; ?></td>
                                    <td><?php echo $row['kisakod']; ?></td>
                                    <td>
                                        <a href=<?php echo "guncelle/?id=" . $row['id']; ?> class="btn
                                           btn-warning">Düzenle</a>
                                        <a href=<?php echo base_url() . "netting/tanimlar/sektor.php?sektorsil=" . $row['id']; ?> class="btn
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


