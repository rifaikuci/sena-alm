<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";


$parca1 = $_POST['parca1'];
$parca2 = $_POST['parca2'];
$takimno = $_POST['takimno'];

$parca1Adi = $parca1[4] == "K" ? "Kapak" :( $parca1[4] == "Z" ? "Zıvana" :  ($parca1[4] == "H" ? "Hazne" : "Hazneli Kalıp"));

if($parca2) {
    $parca2Adi =$parca2[4] == "K" ? "Kapak" :( $parca2[4] == "Z" ? "Zıvana" :  ($parca2[4] == "H" ? "Hazne" : "Hazneli Kalıp"));
} else {
    $parca1Adi = "Hazneli Kalıp";
}

?>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        <?php echo " Takımı Çöper Çıkarma ($takimno)" ?>
    </h4>

    <div class="card-body">
        <form method="post" action="<?php echo base_url() . 'netting/takim/index.php'?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo $parca1Adi?></label>
                        <input required type="text" class="form-control form-control-lg" name="parca1cop"
                               placeholder="Çöpe Çıkarılma Nedeni">
                        <input required type="hidden" class="form-control form-control-lg" name="takimno" value="<?php  echo  $takimno?>">
                        <input required type="hidden" class="form-control form-control-lg" name="parca1" value="<?php echo $parca1?>">
                        <input required type="hidden" class="form-control form-control-lg" name="parca2" value="<?php echo $parca2?>">
                    </div>
                </div>
                <?php if($parca2) {?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo $parca2Adi?></label>
                        <input <?php echo  $parca2 ? "required" : ""; ?> type="text" class="form-control form-control-lg" name="parca2cop"
                               placeholder="Çöpe Çıkarılma Nedeni">
                    </div>
                </div>
                <?php } ?>


            </div>
            <div class="card-footer">
                <div>
                    <button type="submit" name="copetakim" class="btn btn-info float-right">Kaydet</button>

                </div>
            </div>
        </form>
    </div>
</div>



