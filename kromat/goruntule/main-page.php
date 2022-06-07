<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlkromat = "SELECT k.id as id, k.adetler, hurdalar, sebepler, sepetler, sepetId, baslaZaman, bitisZaman, ad
       FRom tblkromat k  INNER JOIN tblsepet s on  s.id = k.sepetId  WHERE k.id = '$id'";
    $kromat = mysqli_query($db, $sqlkromat)->fetch_assoc();

    $adetler = rtrim($kromat['adetler'], ";");
    $adetler = explode(";", $adetler);

    $hurdalar = rtrim($kromat['hurdalar'], ";");
    $hurdalar = explode(";", $hurdalar);

    $sebepler = rtrim($kromat['sebepler'], ";");
    $sebepler = explode(";", $sebepler);

    $sepetler = rtrim($kromat['sepetler'], ";");
    $sepetler = explode(";", $sepetler);


} ?>


<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kromat Alanı
        </div>
        <div class="card-body">
            <form>

                <div class="row">

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Sepet</label>
                            <input disabled
                                   value="<?php echo $kromat['ad'] ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Başlama Zamanı</label>
                            <input disabled
                                   value="<?php echo tarihsaat($kromat['baslaZaman']) ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Başlama Zamanı</label>
                            <input disabled
                                   value="<?php echo tarihsaat($kromat['bitisZaman']) ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>


                    <div class="col-sm-12" style="margin: 30px">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d">Sepet Bilgileri</h3>
                        </div>
                    </div>
                </div>

                <?php for ($i = 0; $i < count($adetler); $i++) { ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Sepet</label>
                                <input type="text" required class="form-control form-control-lg"
                                       value="<?php echo tablogetir("tblsepet", 'id', $sepetler[$i], $db)['ad'] ?>"
                                       disabled
                                       placeholder="0.1">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Kromata Gönderilecek Adet</label>
                                <input type="text" required class="form-control form-control-lg"
                                       value="<?php echo $adetler[$i] ?>" disabled
                                       placeholder="0.1">
                            </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Hurda Adet</label>
                                <input type="text" required class="form-control form-control-lg"
                                       value="<?php echo $hurdalar[$i] ?>" disabled
                                       placeholder="0.1">
                            </div>
                        </div>

                        <?php if ($hurdalar[$i] != 0) { ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Hurdaya Atılma Sebebi</label>
                                    <input type="text" required class="form-control form-control-lg"
                                           value="<?php echo $sebepler[$i] ?>" disabled
                                           placeholder="">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="card-footer">
                    <div>
                        <a href="../"
                           class="btn btn-success float-right">Kromatlara Dön</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
