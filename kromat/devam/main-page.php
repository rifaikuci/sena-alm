<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";


#Todo BURADA KALINDI
$kromatId = 0;
if (isset($_GET['kromat'])) {
    $kromatId = $_GET['kromat'];

    $sql = "SELECT * FROM tblkromat WHERE id = '$kromatId'";
    $kromat = mysqli_query($db, $sql)->fetch_assoc();
    $sepetKromat = tablogetir('tblsepet', 'id', $kromat['sepetId'], $db);

    $adetler =  $kromat['adetler'];
    $adetler = rtrim($adetler, ";");
    $adetler = explode(";",$adetler);

    $hurdalar =  $kromat['hurdalar'];
    $hurdalar = rtrim($hurdalar, ";");
    $hurdalar = explode(";",$hurdalar);

    $sebepler =  $kromat['sebepler'];
    $sebepler = rtrim($sebepler, ";");
    $sebepler = explode(";",$sebepler);

    $kromatIcındekiler = tablogetir("tblsepet", 'id', $kromat['sepetId'], $db)['icindekiler'];
    $icindekiler = rtrim($kromatIcındekiler, ";");
    $icindekiler = explode(";",$icindekiler);



}

date_default_timezone_set('Europe/Istanbul');


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kromat Bitirme Alanı
        </div>
        <div class="card-body" id="kromat-guncelle">
            <form method="post" action="<?php echo base_url() . 'netting/kromat/index.php' ?>">

                <div class="row">

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Kromat Sepet</label>
                            <input type="text" value="<?php echo $sepetKromat['ad'] ?>" class="form-control form-control-lg" disabled>
                            <input type="hidden" name="kromatbitir" value="<?php echo $kromat['id']?>">
                            <input type="hidden" name="sepetId" value="<?php echo $kromat['sepetId']?>">
                            <input type="hidden" name="operatorId"  value="<?php echo $_SESSION['operatorId']?>">
                        </div>
                    </div>



                    <div class="col-sm-12" style="margin: 30px">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d">Sepet Bilgileri</h3>
                        </div>
                    </div>
                </div>

                <?php for($k = 0; $k < count($adetler); $k++ ) {?>
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Satır No</label>
                            <input value="<?php
                            $satirNo = tablogetir('tblbaski', 'id', $icindekiler[$k],$db)['satirNo'];
                            echo $satirNo ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Kromat Adedi</label>
                            <input value="<?php echo $adetler[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Hurda Adedi</label>
                            <input value="<?php echo $hurdalar[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <?php if($hurdalar[$k] && $hurdalar[$k] > 0) { ?>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Sebepler</label>
                            <input value="<?php echo $sebepler[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0">
                        </div>
                    </div>
                    <?php } ?>

                </div>

                <?php } ?>

                <div class="card-footer">
                    <div>
                        <button  type="submit" class="btn btn-info float-right">Bitir</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>

    </div>

</section>
