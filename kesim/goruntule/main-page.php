<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";


$kesimId = 0;
if (isset($_GET['id'])) {
    $kesimId = $_GET['id'];

    $sql = "SELECT * FROM tblkesim WHERE id = '$kesimId'";
    $kesim = mysqli_query($db, $sql)->fetch_assoc();

    $baski = tablogetir("tblbaski", "id", $kesim['baskiId'], $db);
    $siparis = tablogetir("tblsiparis", 'id', $baski['siparisId'], $db);
    $profil = tablogetir("tblprofil", 'id', $siparis['profilId'], $db);

}

date_default_timezone_set('Europe/Istanbul');


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kesim Görüntüle
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Sipariş Bilgileri</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div>
                                            <H2>

                                                <?php echo $siparis['satirNo']; ?>
                                                <span style="color: #2b6b4f"> </span>
                                            </H2>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                        <?php echo $profil['profilNo']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Sipariş Türü: </span>
                                        <?php echo $siparis['siparisTuru'] == "B" ? 'Boyalı' : ($siparis['siparisTuru'] == "E" ? "Eloksal" : "Ham"); ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> İstenilen Termik: </span>
                                        <?php echo $siparis['istenilenTermik']; ?>
                                    </h6>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold">Net Adet: </span>
                                        <?php echo $baski['basilanNetAdet']; ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kesilen Boy</label>
                        <input class="form-control" disabled value="<?php echo $kesim['kesilenBoy'] ?>">
                        <?php if ($kesim['kesilenBoy'] && $kesim['kesilenBoy'] > 0 && $kesim['kesilenBoy'] != $siparis['boy']) { ?>
                            <span style="color: red">Kesilen Boy istenen boydan farklı</span>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($kesim['hurdaAdet'] && $kesim['hurdaAdet'] > 0) { ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input disabled class="form-control form-control-lg"
                                   value="<?php echo $kesim['hurdaAdet']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hurdaya Atılma Sebebi</label>
                            <input disabled class="form-control form-control-lg"
                                   value="<?php echo $kesim['hurdaSebep']; ?>">
                        </div>
                    </div>
                <?php } ?>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Net Adet</label>
                        <input type="text" value="<?php echo $kesim['netAdet'] ?>" disabled
                               class="form-control form-control-lg">
                    </div>
                </div>


                <?php if ($kesim['sepetId1'] && $kesim['sepetId1'] > 0) {
                   $sepetAd1 = tablogetir("tblsepet", 'id', $kesim['sepetId1'], $db)['ad'];
                    ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Sepet 1 </label>
                                <input type="text" value="<?php echo $sepetAd1 ?>" disabled
                                       class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Adet 1 </label>
                                <input type="text" value="<?php echo $kesim['sepet1Adet'] ?>" disabled
                                       class="form-control form-control-lg">

                            </div>
                        </div>

                <?php } ?>

                <?php if ($kesim['sepetId2'] && $kesim['sepetId2'] > 0) {
                    $sepetAd2 = tablogetir("tblsepet", 'id', $kesim['sepetId2'], $db)['ad'];
                    ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sepet 2 </label>
                            <input type="text" value="<?php echo $sepetAd2 ?>" disabled
                                   class="form-control form-control-lg">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Adet 2 </label>
                            <input type="text" value="<?php echo $kesim['sepet2Adet'] ?>" disabled
                                   class="form-control form-control-lg">

                        </div>
                    </div>

                <?php } ?>

                <?php if ($kesim['sepetId3'] && $kesim['sepetId3'] > 0) {
                    $sepetAd3 = tablogetir("tblsepet", 'id', $kesim['sepetId3'], $db)['ad'];
                    ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sepet 3 </label>
                            <input type="text" value="<?php echo $sepetAd3 ?>" disabled
                                   class="form-control form-control-lg">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Adet 3 </label>
                            <input type="text" value="<?php echo $kesim['sepet3Adet'] ?>" disabled
                                   class="form-control form-control-lg">

                        </div>
                    </div>

                <?php } ?>


            </div>

            <div class="card-footer">
                <div>
                    <a href="../" class="btn btn-info float-right">Kesimlere Geri Dön</a>
                </div>
            </div>
        </div>
    </div>

</section>
