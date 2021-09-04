<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
if ($_GET['id']) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tblkalipparcalar WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

}

$firmasql = "SELECT * FROM tblfirma where firmaTurId =1 ";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kalıp Güncelleme Alanı
        </div>
        <div class="card-body" id="kalip-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kalipci/index.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sena No</label>
                            <input required disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['senaNo'] ?>">
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kalıp Cinsi</label>
                            <input required disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo kalipBul($row['kalipCins']) ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Parça</label>
                            <input required disabled type="text" class="form-control form-control-lg" name="kalipciNo"
                                   value="<?php echo parcaBul($row['parca']) ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <select name="firmaId" required class="form-control" style="width: 100%;">
                                <option disabled value="">Firma Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option <?php echo $firma['id'] == $row['firmaId'] ? "selected" : "" ?>
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Profiller</label>
                            <select name="profilId" required class="form-control" style="width: 100%;">
                                <option disabled value="">Profil Seçiniz</option>
                                <?php while ($profil = $profiller->fetch_array()) { ?>
                                    <option <?php echo $profil['id'] == $row['profilId'] ? "selected" : "" ?>
                                            value="<?php echo $profil['id']; ?>"><?php echo $profil['profilAdi']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalıpçı No</label>
                            <input required type="text" class="form-control form-control-lg" name="kalipciNo"
                                   value="<?php echo $row['kalipciNo'] ?>">
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Çap</label>
                            <select name="cap" required class="form-control" style="width: 100%;">
                                <option value="">Çap Seçiniz</option>
                                <option <?php echo $row['cap'] == "160" ? "selected" : "" ?> value="160">160</option>
                                <option <?php echo $row['cap'] == "170" ? "selected" : "" ?> value="170">170</option>
                                <option <?php echo $row['cap'] == "180" ? "selected" : "" ?> value="180">180</option>
                                <option <?php echo $row['cap'] == "220" ? "selected" : "" ?> value="220">220</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalite</label>
                            <select name="kalite" required class="form-control" style="width: 100%;">
                                <option value="">Kalite</option>
                                <option <?php echo $row['kalite'] == "2344" ? "selected" : "" ?> value="2344">2344
                                </option>
                                <option <?php echo $row['kalite'] == "2716" ? "selected" : "" ?>value="2716">2716
                                </option>
                                <option <?php echo $row['kalite'] == "1Dievar60" ? "selected" : "" ?> value="Dievar">
                                    Dievar
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Figür Sayı</label>
                            <input required type="number" class="form-control form-control-lg" name="figurSayi" min="1"
                                   max="10" value="<?php echo $row['figurSayi'] ?>">
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="kalipciguncelleme" class="btn btn-info float-right">Güncelle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
