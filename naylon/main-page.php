<?php

include "../netting/baglan.php";
include "../include/sql.php";

$sql = "
 select n.id as id, b.satirNo, n.zaman,
        s.siparisTuru, n.adet, profilNo, profilAdi, boy, e.ad as eloksalAd, pr.ad as boyaAd,
               p.paketAdet as pia
 from tblnaylon n
 LEFT JOIN tblbaski b ON n.baskiId = b.id
         INNER JOIN tblsiparis s on s.id = b.siparisId
         INNER JOIN tblprofil p on p.id = s.profilId
         LEFT JOIN tbleloksal e on s.eloksalId = e.id
         LEFT JOIN tblprboya pr on s.boyaId = pr.id order by n.zaman ASC 
 ";
$result = $db->query($sql);
?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Naylonlama Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Naylonlama Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Naylonlama Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Naylonlama Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumdevam'] == "ok") {
        durumSuccess("Naylonlama Başarılı Bir Şekilde Tamamlandı. ");
    } else if ($_GET['durumdevam'] == "no") {
        durumDanger("Naylonlama Tamamlanırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Naylonlama</h4>
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
                                <th>Tarih</th>
                                <th>Satır No</th>
                                <th>Profil No</th>
                                <th>Boy</th>
                                <th>Yüzey Detay</th>
                                <th>Adet</th>
                                <th>PIA</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td><?php echo tarihsaat($row['zaman']); ?></td>
                                    <td>  <?php echo $row['satirNo']; ?></td>
                                    <td>  <?php echo $row['profilNo']; ?></td>
                                    <td>  <?php echo $row['boy']; ?></td>
                                    <td>  <?php
                                        $yuzey  = $row['siparisTuru'];
                                        $yuzeyDetay = $yuzey == "B" ? "Boyalı" : ($yuzey == "E" ? "Eloksal" : "Pres");
                                        $cins = $yuzey == "B" ? $row['boyaAd'] : ($yuzey == "E" ? $row['eloksalAd'] : "Pres");

                                        echo

                                        $yuzeyDetay."/".$cins; ?></td>
                                    <td>  <?php echo $row['adet']; ?></td>
                                    <td>  <?php echo $row['pia']; ?></td>



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


