<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
if ($_GET['takimno']) {
    $takimno = $_GET['takimno'];
    $sql = "SELECT * FROM tbltakim WHERE takimNo = '$takimno'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    $firmaId = $row['firmaId'];
    $profilId = $row['profilId'];
    $cap = $row['cap'];

    $parca1 = $row['parca1'];
    $parca2 = $row['parca2'];
    $sqlParca1 = "select * from tblkalipparcalar where  senaNo ='$parca1'";
    $result1 = mysqli_query($db, $sqlParca1);
    $row1 = $result1->fetch_assoc();
    $figurSayi = $row1['figurSayi'];

    $parca1Adi = parcaBul($row1['parca']);

    $sqlParca2 = "select * from tblkalipparcalar where  senaNo ='$parca2'";
    $result2 = mysqli_query($db, $sqlParca2);
    $row2 = $result2->fetch_assoc();
    $parca2Adi = parcaBul($row2['parca']);

    $bolsterler = explode(",", $row['bolster']);
    $destekler = explode(",", $row['destek']);

    $bolstersql = "SELECT * FROM tblkalipparcalar where durum =1 and parca =100";
    $bolstergetir = $db->query($bolstersql);

    $parcacins = $row['kalipCins'] == 0 || $row['kalipCins'] == 1 ? '2,5' : ($row['kalipCins'] == 2 ? '8' : ($row['kalipCins'] == 3 ? '10' : '100'));

    $desteksql = "SELECT * FROM tblkalipparcalar WHERE durum = '1' AND $firmaId = '$firmaId' AND figurSayi = '$figurSayi' AND cap = '$cap' AND parca IN($parcacins) ";
    $destekgetir = $db->query($desteksql);



}


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Destek ve bolster güncelleme alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/takim/index.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Takım No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['takimNo'] ?>">
                            <input  type="hidden" class="form-control form-control-lg" name="takim"
                                   value="<?php echo $row['takimNo'] ?>">

                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo profilbul($row['profilId'], $db, 'profilNo'); ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Firma</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo firmaBul($row['firmaId'], $db, 'firmaAd'); ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kalıp Türü</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo kalipBul($row['kalipCins']); ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Parça 1</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['parca1']; ?>">
                        </div>
                    </div>

                    <?php if($row['parca2']) {?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Parça 2</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['parca2']; ?>">
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Çap</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['cap'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Figür</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row1['figurSayi'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group" >
                            <label>Bolster Seçiniz</label>
                            <div class="select2-blue">
                                <select :disabled="!ekle" required name="bolsterler[]" class="select2" multiple="multiple"
                                        data-dropdown-css-class="select2-blue"
                                        data-placeholder="Sena No - Firma Adı -Kalıpçı No - Kalite - Figür Sayı"
                                        style="width: 100%;">
                                    <?php
                                    while ($bolster = $bolstergetir->fetch_array()) { ?>
                                        <option value="<?php echo $bolster['id'] ?>"
                                            <?php echo in_array($bolster['id'], $bolsterler) ? "selected" : "" ?>
                                        >
                                            <?php echo $bolster['senaNo'] . " - " . firmaBul($bolster['firmaId'], $db, "firmaAd") . " - " . $bolster['kalipciNo'] . " - " . $bolster['kalite'] . " - " . $bolster['figurSayi'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Destek Seçiniz</label>
                            <div class="select2-blue">
                                <select :disabled="!ekle" required name="destekler[]" class="select2" multiple="multiple"
                                        data-dropdown-css-class="select2-blue"
                                        data-placeholder="Sena No - Firma Adı -Kalıpçı No - Kalite - Figür Sayı"
                                        style="width: 100%;">
                                    <?php
                                    while ($destek = $destekgetir->fetch_array()) { ?>
                                        <option value="<?php echo $destek['id'] ?>"
                                            <?php echo in_array($destek['id'], $destekler) ? "selected" : "" ?>
                                        >
                                            <?php echo $destek['senaNo'] . " - " . firmaBul($destek['firmaId'], $db, "firmaAd") . " - " . $destek['kalipciNo'] . " - " . $destek['kalite'] . " - " . $destek['figurSayi'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="desbols" class="btn btn-info float-right">Kaydet
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
