<?php

include "../netting/baglan.php";
include "../include/sql.php";

$sql = "SELECT * FROM tblkalipparcalar order by id desc ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Kalıp Stoğa Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Kalıp Stoğa Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Kalıp Stoktan Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kalıp Stoktan Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Kalıp Stoktan Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Kalıp Stoktan Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kalıplar</h4>
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
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sena No</th>
                                <th>Profil</th>
                                <th>Firma</th>
                                <th>Kalıp Cinsi</th>
                                <th>Parça</th>
                                <th>Çap</th>
                                <th>Durum</th>
                                <th>Net Kilo</th>

                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['senaNo']; ?></td>
                                    <td><?php echo profilbul($row['profilId'], $db, "profilAdi"); ?></td>
                                    <td><?php echo firmaBul($row['firmaId'], $db, 'firmaAd'); ?></td>
                                    <td><?php echo trim(kalipBul($row['kalipCins'])); ?></td>
                                    <td><?php echo trim(parcaBul($row['parca'])); ?></td>
                                    <td><?php echo $row['cap']; ?></td>
                                    <td style="color: <?php echo $row['durum'] == 1 ? '#00b44e' :  ( $row['durum'] == 2 ? '#d55537'  :  '#b8860b' )  ?>"><b>
                                           <?php echo $row['durum'] == 1 ? "Aktif" :  ( $row['durum'] == 2 ? 'Pasif'  :  'Çöp' )
                                            ?></b></td>
                                    <td><?php echo $row['netKilo']; ?></td>
                                    <td><a href=<?php echo "guncelle/?id=" . $row['id']; ?> class="btn
                                           btn-warning">Düzenle</a>
                                        <a href=<?php echo base_url() . "netting/kalipci/index.php?kalipsil=" . $row['id']; ?> class="btn
                                           btn-danger">Sil</a></td>
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


