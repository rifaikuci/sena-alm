<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";


$kromatId = 0;
if (isset($_GET['kromat'])) {
    $kromatId = $_GET['kromat'];

    $sql = "SELECT * FROM tblkromat WHERE id = '$kromatId'";
    $kromat = mysqli_query($db, $sql)->fetch_assoc();
    $sepetKromat = tablogetir('tblsepet', 'id', $kromat['sepetId'], $db);

    $adetler =  $kromat['adetler'];
    $adetler = rtrim($adetler, ";");
    $adetler = explode(";",$adetler);

    $sepetler =  $kromat['sepetler'];
    $sepetler = rtrim($sepetler, ";");
    $sepetler = explode(";",$sepetler);

    $hurdalar =  $kromat['hurdalar'];
    $hurdalar = rtrim($hurdalar, ";");
    $hurdalar = explode(";",$hurdalar);

    $sebepler =  $kromat['sebepler'];
    $sebepler = rtrim($sebepler, ";");
    $sebepler = explode(";",$sebepler);

    $kromatIcındekiler = tablogetir("tblsepet", 'id', $kromat['sepetId'], $db)['icindekiler'];
    $icindekiler = rtrim($kromatIcındekiler, ";");
    $icindekiler = explode(";",$icindekiler);

    #todo KROMAt kısmı yapılırken dikkat edilse iyi olur.


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

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kromat Sepet</label>
                            <input type="text" value="<?php echo $sepetKromat['ad'] ?>" class="form-control form-control-lg" disabled>
                            <input type="hidden" name="kromatbitir" value="<?php echo $kromat['id']?>">
                            <input type="hidden" name="sepetId" value="<?php echo $kromat['sepetId']?>">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>



                    <div class="col-sm-6" style="margin: 30px">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d">Sepet Bilgileri</h3>
                        </div>
                    </div>
                </div>

                <?php for($k = 0; $k < count($adetler); $k++ ) {?>
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Sepet - Satır No - Profil No - Profil Adi - Profil Boy - Rengi - Adet </label>
                            <input value="<?php

                            $baskiId= $icindekiler[$k];
                            $sqltemp = "SELECT b.satirNo, profilNo, profilAdi, boy, pr.ad,siparisTuru FROM tblbaski b
                                                        LEFT JOIN tblsiparis s on b.siparisId = s.id
                                                        LEFT JOIN tblprofil p on p.id = s.profilId
                                                        LEFT JOIN tblprboya pr on pr.id = s.boyaId  where b.id = '$baskiId'";
                            $temp = mysqli_query($db, $sqltemp)->fetch_assoc();

                            $sepetAd = tablogetir("tblsepet", 'id',$sepetler[$k],$db)['ad'];
                            echo $sepetAd . " - " . $temp['satirNo'] . " - ". $temp['profilNo'] . " - " .
                                $temp['profilAdi'] . " - " . $temp['boy'] . " - " . $temp['ad']  . " - " . $adetler[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>
                    
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kromat Adedi</label>
                            <input value="<?php echo $adetler[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hurda Adedi</label>
                            <input value="<?php echo $hurdalar[$k] ?>"
                                   disabled
                                   type="text" class="form-control form-control-lg"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <?php if($hurdalar[$k] && $hurdalar[$k] > 0) { ?>

                    <div class="col-sm-2">
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
