<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tbltermik order by id desc ";
$result = $db->query($sql);


#todo sepetler ve içindekiler aynı hücrede yazılacak sepetler ve ynaındaki hücreyi birleştiricez. -> bu olmayacak sadece hangi sepetlerde bulunduğuna dair bilgi vereceğiz.
?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Termik Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Termik Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Termik Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Termik Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Termikler</h4>
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
                                <th>Baş. Tar.</th>
                                <th>Sepetler</th>
                                <th>Satır No - Baskı ID - T. Sonuç</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem /Bitirilme Zam.</th>
                                <th></th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo tarihsaat($row['baslaTarih']); ?></td>
                                    <td><?php
                                        $tempsepet = explode(";", $row['sepetler']);
                                        for ($i = 0; $i < count($tempsepet); $i++)
                                            echo tablogetir('tblsepet', 'id', $tempsepet[$i], $db)['ad'] . "<br>"; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tempBaskilar = explode(";", $row['baskilar']);
                                        for ($i = 0; $i < count($tempBaskilar); $i++) {
                                            $baski = tablogetir('tblbaski', 'id', $tempBaskilar[$i], $db);
                                            echo $baski['satirNo'] . " - " . $tempBaskilar[$i] . " - " . $baski['termikSonuc'] . "<br>";

                                        } ?>
                                    </td>
                                    <td><?php echo $row['bitisTarih'] ? "Termik Bitti" : "Termik Devam Ediyor"; ?></td>
                                    <td>
                                        <?php
                                        if (!$row['bitisTarih']) { ?>
                                            <a href=<?php echo "devam/?termik=" . $row['id']; ?> class="btn
                                               btn-warning">Bitir</a>
                                        <?php } else {
                                            echo $row['bitisTarih'];
                                        } ?>

                                    </td>
                                    <td>
                                        <?php
                                        if ($row['bitisTarih']) { ?>
                                            <a href="<?php echo "goruntule/?id=" . $row['id']; ?>"
                                               class="btn btn-outline-primary">Görüntüle</a>
                                        <?php } ?>
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


