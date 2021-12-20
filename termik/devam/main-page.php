<?php
include "../../netting/baglan.php";
include "../../include/sql.php";


$termikId = 0;
if (isset($_GET['termik'])) {
    $termikId = $_GET['termik'];

    $sql = "SELECT * FROM tbltermik WHERE id = '$termikId'";
    $termik = mysqli_query($db, $sql)->fetch_assoc();

    $kesimler = explode(";", $termik['kesimler']);

}

date_default_timezone_set('Europe/Istanbul');


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Termik Bitirme Alanı
        </div>
        <div class="card-body" id="termik-guncelle">
            <form method="post" action="<?php echo base_url() . 'netting/termik/index.php' ?>"
                  enctype="multipart/form-data">
                <div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div style="text-align: right">
                                    <label> Termik Başlama Zamanı: <span
                                                style="color: #0b93d5"> <?php echo $termik['baslaTarih'] ?> </span></label>
                                </div>
                                <input type="hidden" value="true" name="termikbitir">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div style="text-align: right">

                                    <div style="text-align: center">
                                        <label style="color: darkgreen;font-size: 25px">Kesimler için Termik
                                            Değerleri</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $baskilar = "";
                    $termik = "";
                    $siparisler = "";
                    $tur = "";
                    for ($i = 0; $i < count($kesimler); $i++) { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">

                                    <label><?php $baski = tablogetir('tblbaski', 'kesimId', $kesimler[$i], $db);
                                        $siparis = tablogetir('tblsiparis', 'id', $baski['siparisId'], $db);
                                        $baskilar = $baskilar . $baski['id'] . ",";
                                        $siparisler = $siparisler . $siparis['id'] . ",";
                                        $tur = $tur . $siparis['siparisTuru'] . ",";
                                        $termik = $termik . $siparis['istenilenTermin'] . ",";
                                        echo "Baskı Numarası  : " . $baski['id'] . " Termik Değeri : " . $siparis['istenilenTermin'];
                                        ?></label>
                                    <input name="<?php echo "baski" . $baski['id'] ?>" required class="form-control"
                                           type="number" placeholder="1">
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                    $baskilar = rtrim($baskilar, ',');
                    $tur = rtrim($tur, ',');
                    $termik = rtrim($termik, ',');
                    $siparisler = rtrim($siparisler, ',');

                    ?>
                    <input type="hidden" name="baskilar" value="<?php echo $baskilar ?>">
                    <input type="hidden" name="tur" value="<?php echo $tur ?>">
                    <input type="hidden" name="id" value="<?php echo $termikId ?>">
                    <input type="hidden" name="siparisler" value="<?php echo $siparisler ?>">


                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" class="btn btn-info float-right">Bitir</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>

                </div>
            </form>

        </div>


    </div>

</section>
