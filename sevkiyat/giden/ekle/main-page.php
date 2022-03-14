<?php
include "../../../netting/baglan.php";
include "../../../include/data.php";

$personelsql = "SELECT * FROM tblpersonel";
$personeller = $db->query($personelsql);

$personelsql2 = "SELECT * FROM tblpersonel";
$personeller2 = $db->query($personelsql2);

$firmasql = "SELECT * FROM tblfirma";
$firmalar = $db->query($firmasql);

$firmaboyasql = "SELECT * FROM tblfirma ";
$firmalarboya = $db->query($firmaboyasql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);

$boyasql = "SELECT * FROM tblprboya";
$boyalar = $db->query($boyasql);

$malzemelersql = "SELECT * FROM tblmalzemeler";
$malzemeler = $db->query($malzemelersql);

$malzemelerfirmasql = "SELECT * FROM tblfirma";
$malzemelerfirma = $db->query($malzemelerfirmasql);

$profilfirmasql = "SELECT * FROM tblfirma";
$profilfirmalar = $db->query($profilfirmasql);

$profilmusterisql = "SELECT * FROM tblfirma";
$profilfirmamusteri = $db->query($profilmusterisql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sevkiyat Gönderim Ekleme Alanı
        </div>
        <div class="card-body" id="stok-cikis">
            <form method="post" action="<?php echo base_url() . 'netting/sevkiyat/giden.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>1. Şoför</label>
                            <select required name="personelId1" class="form-control select2" style="width: 100%;">
                                <option selected value="">{{denemee}}</option>
                                <?php while ($personel = $personeller->fetch_array()) { ?>
                                    <option value="<?php echo $personel['id']; ?>"><?php echo $personel['adsoyad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>2. Şoför</label>
                            <select name="personelId2" class="form-control select2" style="width: 100%;">
                                <option selected value="0">2. Şoför Seçiniz</option>
                                <?php while ($personel2 = $personeller2->fetch_array()) { ?>
                                    <option value="<?php echo $personel2['id']; ?>"><?php echo $personel2['adsoyad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Plaka</label>
                            <input required type="text" class="form-control form-control-lg" name="plaka"
                                   placeholder="Plaka Bilgisi ">
                            <input type="hidden" value="<?php echo isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0; ?>" name="operatorId">
                            <input type="hidden" value="sevkiyatCikisBaslatma" name="sevkiyatCikisBaslatma">

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Sevkiyat Tarihi</label>
                            <input required type="date" class="form-control form-control-lg" name="sevkiyatarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Sevkiyat Zamanı</label>
                            <input required type="time" class="form-control form-control-lg" name="sevkiyatsaat">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" class="form-control form-control-lg" name="aciklama"
                                   placeholder="Sevkiyat Açıklaması">
                        </div>
                    </div>

                </div>
                <br>
                <hr style="color: #fff0f0">
                <br>


                <div class="col-12" style="text-align: center">
                    <h4>Stoktakiler</h4>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sevkiyat Kodu</th>
                                <th>Şoför Bilgisi</th>
                                <th>Plaka</th>
                                <th>Tarih</th>
                                <th>Açıklama</th>
                                <th style="text-align: center">Yazdırma İşlemi</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="card-footer">
                    <div>
                        <button type="submit" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>

            </form>
        </div>

</section>
