<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {
    $id = $_GET['id'];

    $sql = "SELECT k.id as id, k.senaNo, firmaAd,kalite, figurSayi, kalipciNo, cap, profilAdi, profilNo, boy  FROM tblkalipparcalar k 
         INNER JOIN tblfirma f on f.id = k.firmaId
         INNER JOIN tblprofil p on p.id = k.profilId                                      
         WHERE k.id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

}

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Parça Güncelleme Alanı
        </div>
        <div class="card-body" id="kalip-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kalipci/index.php' ?>" enctype="multipart/form-data">
                <div class="row">


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Sena No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['senaNo'] ?>">
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Firma Ad</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['firmaAd'] ?>">
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kalıpçı No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['kalipciNo'] ?>">
                        </div>
                    </div>

                    <div class='col-sm-2'>
                        <div class="form-group">
                            <label>Kalıp Cinsi</label>
                            <input  disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo kalipBul($row['kalipCins']) ?>">
                        </div>
                    </div>
                    <?php if($row['kalipCins'] != 4) { ?>
                    <div class='col-sm-2'>
                        <div class="form-group">
                            <label>Parça</label>
                            <input  disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo parcaBul($row['parca']) ?>">
                        </div>
                    </div>
                    <?php } ?>

                    <?php if($row['kalipCins'] != 4) { ?>
                        <div class='col-sm-2'>
                            <div class="form-group">
                                <label>Profil</label>
                                <input disabled type="text" class="form-control form-control-lg"
                                       value="<?php echo $row['profilNo'] . " - " .$row['profilAdi']   ?>">
                            </div>
                        </div>
                    <?php } ?>

                    <div class='col-sm-2'>
                        <div class="form-group">
                            <label>Çap</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['cap']?>">
                        </div>
                    </div>



                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Boy (mm)</label>
                            <input disabled  type="text" class="form-control form-control-lg" name="boy"
                                   value="<?php echo $row['boy']?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kalite</label>
                            <input disabled  type="text" class="form-control form-control-lg" name="boy"
                                   value="<?php echo $row['kalite']?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Figür Sayı</label>
                            <input disabled  type="text" class="form-control form-control-lg" name="boy"
                                   value="<?php echo $row['figurSayi']?>">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <br><br>
                    <?php if($row['kalipCins'] ==4)  {?>
                    <div class="col-sm-7" style="text-align: center">
                        <div class="form-group">
                            <input type="file" name="cizim">
                        </div>
                        <div>
                            <img src="<?php echo base_url() . $row['cizim']; ?>" alt="<?php echo $row['senaNo']; ?>"
                                 class="img img-fluid">
                        </div>
                    </div>
                    <?php } ?>

                </div>

                <div class="card-footer">
                    <div>
                        <a href="../"
                           class="btn btn-outline-primary float-right">Geri Dön</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
