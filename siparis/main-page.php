<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "
SELECT MAX(s.id) as id, MAX(siparisNo) as siparisNo, MAX(firmaAd) as firmaAd, Max(siparisTarih) as siparisTarih
FROM tblsiparis s
         INNER JOIN tblfirma f ON f.id = s.musteriId
group by s.siparisNo
order by id desc
";
$result = $db->query($sql);

$islemArray = [1];
$sonuc = in_array($rolId, $islemArray);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Sipariş Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Sipariş Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Sipariş Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Sipariş Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Sipariş Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Sipariş Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Siparişler</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if($sonuc) {  ?>
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <?php } ?>
                <br>
                <div class="card" id="siparis-detay-goster">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sipariş No</th>
                                <th>Müşteri</th>
                                <th>Tarih</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['siparisNo']; ?></td>
                                    <td><?php echo $row['firmaAd']; ?></td>
                                    <td><?php echo tarih($row['siparisTarih']); ?></td>

                                    <td>
                                        <a
                                                href="<?php echo "./goruntule/index.php?siparisno=" . $row['siparisNo']; ?>"
                                                class="btn btn-outline-primary"><i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" v-on:click="detayGoster($event)"
                                                class="btn btn-outline-dark"
                                                data-toggle="modal" data-siparisno="<?php echo $row['siparisNo'] ?>">
                                            <i class="fa fa-expand"></i>
                                        </button>
                                        <a
                                                onclick="return confirm('Silmek istediğinizden emin misiniz?')"
                                                href="<?php echo base_url() . "netting/siparis/index.php?siparisSil=" . $row['siparisNo']; ?>"
                                                class="btn btn-outline-danger"><i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $sira++;
                            } ?>
                            </tbody>
                        </table>

                        <div id="modalviewdetay" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-xl">

                                <div class="modal-content">
                                    <div style="margin: 10px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


