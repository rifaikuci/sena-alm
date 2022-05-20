<?php
if ($_GET['id']) {

    $id = $_GET['id'];
    include '../../../netting/baglan.php';
    include "../../../include/sql.php";
    require_once "../../../include/helper.php";
    require_once "../../../include/data.php";

    $detail = tablogetir('tblsevkiyatcikis', 'id', $id, $db);
    $balyaIds = $detail['balyaId'];

    $baskilarTemp = explode(";", $balyaIds);

    $baskilarTemp = array_unique($baskilarTemp);

    $balyaText = "";
    $baskilar = array();
    for ($i = 0; $i < count($baskilarTemp); $i++) {
        if ($baskilarTemp[$i]) {
            $balyaText = $balyaText . $baskilarTemp[$i] . ",";
        }
    }

    $balyaText = rtrim($balyaText, ',');

    $sql = "SELECT * FROM tblbalyalama where  id in  (" . $balyaText . ")";
    $result = $db->query($sql);


} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sevkiyat Görüntüleme
        </div>
        <div class="card-body" id="balya-detay-goster">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/personel.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Kodu: </label> <?php echo $detail['kod'] ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Tarih: </label> <?php echo tarih( $detail['sevkiyatTarih']) ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Şoförler: </label> <?php
                            $personel1 = tablogetir('tblpersonel', 'id', $detail['personelId1'], $db)['adsoyad'];
                            echo $detail['personelId2'] ? $personel1 . "- " . tablogetir('tblpersonel', 'id', $detail['personelId2'], $db)['adsoyad'] :
                                $personel1; ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Plaka: </label> <?php echo $detail['plaka'] ?>

                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Açıklama: </label> <?php echo $detail['aciklama'] ?>

                        </div>
                    </div>
                </div>


                <div style="text-align: center">
                    <h4 style="color: #0e84b5;">
                        Balyalar
                    </h4>
                </div>

                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Balya No</th>
                                <th>Kilo</th>
                                <th>Boy</th>
                                <th>Müşteri</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            $toplamBalyaKilo = 0;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira ?></td>
                                    <td><?php echo $row['balyaNo']; ?></td>
                                    <td><?php echo $row['balyaKilo']; ?></td>
                                    <td><?php echo $row['balyaBoy']; ?></td>
                                    <td><?php $musteri = tablogetir("tblfirma", 'id', $row['musteriId'], $db)['firmaAd'];
                                        echo $musteri;
                                        ?></td>
                                    <td style="text-align: center">
                                        <button type="button" v-on:click="detayGoster($event)"
                                                class="btn btn-outline-dark"
                                                data-toggle="modal" data-balyano="<?php echo $row['balyaNo'] ?>">
                                            <i class="fa fa-expand"></i>
                                        </button>

                                    </td>
                                </tr>
                                <?php $sira++;
                                $toplamBalyaKilo = $row['balyaKilo'] + $toplamBalyaKilo;
                            } ?>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div style="text-align: center">
                    <h3 style="color: #0b93d5"> <?php echo "Toplam Sevkiyat Kilo  : " . $toplamBalyaKilo ?></h3>
                </div>


                <!-- balyalar -->
                <div id="balyalar" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>


                            <div class="modal-body"></div>
                        </div>

                    </div>
                </div

            </form>

            <div class="card-footer">
                <div>
                    <a href="../"
                       class="btn btn-primary float-right">Sevkiyat Ekranına Dön</a>
                </div>
            </div>
        </div>
</section>
