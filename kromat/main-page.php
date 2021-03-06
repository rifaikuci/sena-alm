<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "select k.id as id, baslaZaman, havuzKromatId, havuzAsitId, bitisZaman, ad  from tblkromat k
INNER JOIN tblsepet s on k.sepetId  = s.id order by k.id desc";
$result = $db->query($sql);

$islemArray = [1,5];
$sonuc = in_array($rolId, $islemArray);

$kromatSepetDurum = tablogetir("tblhavuz","tur",'kromat', $db)['durum'];
$asitSepetDurum = tablogetir("tblhavuz","tur",'asit', $db)['durum'];


?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Kromat Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kromat Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumdevam'] == "ok") {
        durumSuccess("Kromat Başarılı Bir Şekilde Tamamlandı. ");
    } else if ($_GET['durumdevam'] == "no") {
        durumDanger("Kromat Tamamlanırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kromatlar</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if($sonuc) { ?>
                <div style="text-align: right;margin-right: auto">
                    <?php  if($kromatSepetDurum > 0 && $asitSepetDurum > 0) {?>
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                    <?php } else { ?>

                            <?php if($kromatSepetDurum == 0) { ?>
                                <div>
                                    <p style="color: red; font-weight: bold">Kromat ekleyebilmek için Kromat Havuzu doldurunuz!</p>
                                </div>
                                <?php } else if ($asitSepetDurum == 0) { ?>
                                <div> <p style="color: red; font-weight: bold">Kromat ekleyebilmek için Asit Havuzu doldurunuz!</p>
                                </div>
                                <?php } else if ($kromatSepetDurum == 0 && $asitSepetDurum == 0 ) { ?>
                            <div>
                                <p style="color: red; font-weight: bold">Kromat ekleyebilmek için Kromat-Asit Havuzu doldurunuz!</p>
                            </div>
                                <?php } ?>
                    <?php }?>
                </div>
                <?php } ?>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>

                            <tr>
                                <th>#</th>
                                <th>Başlama Tarih</th>
                                <th>Sepet</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaZaman']); ?></td>
                                    <td><?php echo $row['ad']; ?></td>
                                    <td><?php if ($row['bitisZaman']) { ?>
                                            <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                               class="btn btn-outline-primary">Görüntüle</a>
                                        <?php } else { ?>
                                            Kromat Devam Ediyor <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!$row['bitisZaman']) { ?>
                                            <a href=<?php echo "devam/?kromat=" . $row['id']; ?> class="btn
                                               btn-warning">Bitir</a>
                                        <?php } else {
                                            echo tarihsaat($row['bitisZaman']);

                                        } ?>
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


