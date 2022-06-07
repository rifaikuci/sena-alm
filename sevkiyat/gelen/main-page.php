<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";
$sql = "SELECT * FROM tblsevkiyat order by id desc ";
$result = $db->query($sql);
#TODO BURADA kalınıd
?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Sevkiyat Stoğa Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Sevkiyat Stoğa Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Sevkiyat Stoktan Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Sevkiyat Stoktan Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Sevkiyat Stoktan Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Sevkiyat Stoktan Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Giriş Sevkiyatları</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <div>
                    <h6 style="color: #0b93d5">
                   <a class="btn btn-default " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a>  Biyetlerin yazdırılmasını temsil eder</h6>
                    <h6 style="color: #0b93d5">
                        <a class="btn btn-warning " target="_blank"
                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a>  Boyaların yazdırılmasını temsil eder</h6>
                    <h6 style="color: #0b93d5">
                        <a class="btn btn-info " target="_blank"
                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a>  Malzemelerin yazdırılmasını temsil eder</h6>
                    <h6 style="color: #0b93d5">
                        <a class="btn btn-danger " target="_blank"
                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a>  Hepsinin yazdırılmasını temsil eder</h6>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sevkiyat Kodu</th>
                                <th>Şoför Bilgisi</th>
                                <th>Plaka</th>
                                <th>Açıklama</th>
                                <th style="text-align: center">Yazdırma İşlemi</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['kod']; ?></td>
                                    <td><?php
                                        $personel1 = tablogetir('tblpersonel', 'id', $row['personelId1'], $db)['adsoyad'];
                                        echo $row['personelId2'] ? $personel1 . "- " . tablogetir('tblpersonel', 'id', $row['personelId2'], $db)['adsoyad'] :
                                            $personel1; ?>
                                    </td>
                                    <td><?php echo $row['plaka']; ?></td>
                                    <td><?php echo kelimeAyirma($row['aciklama'], 30); ?></td>

                                    <td style="text-align: center">
                                        <?php if(isTableSevkiyat($db,"tblstokbiyet", $row['id']) > 0) { ?>
                                        <a class="btn btn-default"
                                           href="<?php echo '../../netting/sevkiyat/pdf.php?biyet='.$row['id'];?>"><i class="fa fa-print" aria-hidden="true"></i></a> <?php  }?>

                                        <?php if(isTableSevkiyat($db,"tblstokboya", $row['id']) > 0) { ?>
                                        <a class="btn btn-warning " target="_blank"
                                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a> <?php  }?>

                                        <?php if(isTableSevkiyat($db,"tblstokmalzeme", $row['id']) > 0 ) { ?>
                                        <a class="btn btn-info" target="_blank"
                                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a>  <?php  }?>

                                        <a class="btn btn-danger " target="_blank"
                                           href="#"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    </td>

                                    <td style="text-align: center">
                                        <a href=<?php echo "goruntule/?id=" . $row['id']; ?> class="btn
                                           btn-warning">Görüntüle</a>
                                        <a onclick="return confirm('Silmek istediğinizden emin misiniz?')"
                                           href=<?php echo base_url() . "netting/sevkiyat/gelen.php?gelensil=" . $row['id']; ?> class="btn
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


