<?php

include "../netting/baglan.php";
include "../include/sql.php";

$sql = "
select
    bp.id as id,
    b.satirNo,
    b.id as baskiId,
    s.id as siparisId,
    zaman,
    netAdet,
    profilNo,
    boy,
    firmaAd,
    ad
    from tblboyapaket bp
INNER JOIN  tblbaski  b ON b.id = bp.baskiid
INNER JOIN  tblsiparis s ON s.id = b.siparisid
INNER JOIN tblprofil p ON p.id = s.profilid
INNER JOIN tblfirma f On f.id = s.musteriId
INNER JOIN  tblprboya pr On s.boyaId = pr.id order by id desc
";
$result = $db->query($sql);

$islemArray = [1,7];
$sonuc = in_array($rolId, $islemArray);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Boya Paketleme Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Boya Paketleme Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumdevam'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Tamamlandı. ");
    } else if ($_GET['durumdevam'] == "no") {
        durumDanger("Boya Paketleme Tamamlanırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Boya Paketleme</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if ($sonuc) { ?>

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
                                <th>Sipariş No</th>
                                <th>Tarih</th>
                                <th>Net Adet</th>
                                <th>Profil</th>
                                <th>Boy</th>
                                <th>Müşteri</th>
                                <th>Renk</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) {
                                $satirNo = $row['satirNo']; ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $satirNo; ?></td>
                                    <td><?php echo tarihsaat($row['zaman']); ?></td>
                                    <td><?php echo $row['netAdet']; ?></td>
                                    <td><?php echo $row['profilNo']; ?></td>
                                    <td><?php echo $row['boy']; ?></td>
                                    <td><?php echo $row['firmaAd']; ?></td>
                                    <td><?php echo $row['ad']; ?></td>
                                    <td style="text-align: center">
                                        <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                           class="btn btn-outline-primary">Görüntüle</a>
                                    </td>

                                </tr>
                                <?php $sira++;
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


