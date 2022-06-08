<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "select s.id as id,  termimTarih, siparisNo, satirNo, profilNo, profilAdi, boy, adet, firmaAd,siparisTarih  from tblsiparis s
INNER  JOIN tblprofil p ON p.id = s.profilId
INNER JOIN  tblfirma f  order by s.termimTarih asc ";
$result = $db->query($sql);

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
        <h4 style="color: #0b93d5">Siparişler Satır Bazlı</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sipariş No</th>
                                <th>Satır No</th>
                                <th>Profil No</th>
                                <th>Boy</th>
                                <th>Adet</th>
                                <th>Kilo</th>
                                <th>Müşteri</th>
                                <th>Tarih</th>
                                <th>Termin Tarihi</th>
                                <th style="text-align: center"></th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['siparisNo']; ?></td>
                                    <td><?php echo $row['satirNo']; ?></td>
                                    <td><?php echo $row['profilNo']; ?></td>
                                    <td><?php echo $row['boy']?></td>
                                    <td><?php echo $row['adet']?></td>
                                    <td><?php echo sayiFormatla($row['kilo']);?></td>
                                    <td><?php echo $row['firmaAd']; ?></td>
                                    <td><?php echo tarih($row['siparisTarih']); ?></td>
                                    <td><?php echo tarih($row['termimTarih']); ?></td>

                                    <td>
                                        <a
                                                href="<?php echo "./guncelle/index.php?satirno=" . $row['satirNo']; ?>"
                                                class="btn btn-outline-warning"><i class="fa fa-edit"></i>
                                        </a>

                                        <a
                                                onclick="return confirm('Silmek istediğinizden emin misiniz?')"
                                                href="<?php echo base_url() . "netting/siparis-satir/index.php?siparissatirSil=" . $row['satirNo']; ?>"
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


