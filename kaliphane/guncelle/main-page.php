<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['takimno']) {

    $takimno = $_GET['takimno'];
    $sqltakim = "SELECT * FROM tbltakim WHERE takimNo = '$takimno'";
    $takim = mysqli_query($db, $sqltakim)->fetch_assoc();
    $takimId = $takim['id'];
    $sqlkaliphane = "SELECT * FROM tblkaliphane WHERE takimId = '$takimId' order by datetime desc LIMIT 1";
    $kaliphane = mysqli_query($db, $sqlkaliphane)->fetch_assoc();
    $operatorId = isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0;

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kalıp Güncelleme
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo base_url() . 'netting/kaliphane/index.php' ?>"
                  enctype="multipart/form-data">

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Takım No</label>
                            <input class="form-control" type="text" disabled value="<?php echo $takimno; ?>">
                            <input class="form-control" type="hidden" value="kalipguncelle" name="kalipguncelle">
                            <input class="form-control" type="hidden" value="<?php echo $takim['konum']?>" name="oldprocess">
                            <input class="form-control" type="hidden" value="<?php echo $takim['id']?>" name="takimId">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input class="form-control" type="text" disabled value="<?php echo $kaliphane['description']; ?>">
                        </div>
                    </div>



                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Konum</label>
                            <input class="form-control" type="text" disabled
                                   value="<?php echo takimDurumBul($takim['konum']); ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Takım Son Durum</label>

                            <select class="form-control select2" name="takimdurum"
                                    style="width: 100%;">
                                <?php foreach($takimDurumlar as $key=> $value) { ?>
                                    <option
                                        <?php echo $takim['konum'] == $key ? "selected" : "" ?>
                                            value="<?php echo $key ?>"><?php echo $key . " - ".  $value?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>

                </div>
        </div>


        <div class="card-footer">
            <div>
                <button type="submit" class="btn btn-info float-right">Güncelle
                </button>
                <a href="../"
                   class="btn btn-warning float-left">Vazgeç</a>
            </div>
        </div>
    </div>


    </form>

</section>
