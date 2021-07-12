<?php
include "../../../netting/baglan.php";

$personelsql = "SELECT * FROM tblpersonel where rolId = 10";
$personeller = $db->query($personelsql);

$personelsql2 = "SELECT * FROM tblpersonel where rolId = 10";
$personeller2 = $db->query($personelsql2);

$firmasql = "SELECT * FROM tblfirma";
$firmalar = $db->query($firmasql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sevkiyat Giriş Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/personel.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>1. Şoför</label>
                            <select required name="personelId1" class="form-control" style="width: 100%;">
                                <option selected value="">Şoför Seçiniz</option>
                                <?php while ($personel = $personeller->fetch_array()) { ?>
                                    <option value="<?php echo $personel['id']; ?>"><?php echo $personel['adsoyad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>2. Şoför</label>
                            <select name="personelId2" class="form-control" style="width: 100%;">
                                <option selected value="">2. Şoför Seçiniz</option>
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
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Konum</label>
                            <input required type="text" class="form-control form-control-lg" name="konum"
                                   placeholder="Geldiği Yer ">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Tarihi</label>
                            <input required type="text" class="form-control form-control-lg" name="konum"
                                   disabled value="<?php echo tarih(date("Y-m-d")) ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
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


                <div class="col-12">
                    <h4>Ürün Bilgileri <small>Giriş Stoğu</small></h4>
                </div>
        </div>
        <!-- ./row -->
        <div class="row" id="stok-giris">
            <div class="col-sm-12">
                <div class="card card-gray-dark card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="biyet" data-toggle="pill" href="#custom-tabs-one-home"
                                   role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Biyetler</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profil" data-toggle="pill" href="#custom-tabs-one-profile"
                                   role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profil</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                 aria-labelledby="biyet">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Parti Numarası</label>
                                            <input v-model="biyet.partino" required type="text"
                                                   @input="checkpartino($event)"
                                                   class="form-control form-control-lg">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Firma Adı</label>
                                            <select v-model="biyet.firmaId" required name="firmaId" class="form-control"
                                                    style="width: 100%;">
                                                <option value="">Firma Seçiniz</option>
                                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                                    <option value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Alaşım Türü</label>
                                            <select v-model="biyet.alasimId" required name="alasimId"
                                                    class="form-control"
                                                    style="width: 100%;">
                                                <option value="">Alaşım Seçiniz</option>
                                                <?php while ($alasim = $alasimlar->fetch_array()) { ?>
                                                    <option value="<?php echo $alasim['id']; ?>"><?php echo $alasim['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Adet</label>
                                            <input v-model="biyet.adetbiyet" required type="number"
                                                   class="form-control form-control-lg"
                                                   @input="checkadetbiyet($event)"
                                                   name="adetbiyet" placeholder="0" step="1">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Çap (mm)</label>
                                            <select v-model="biyet.cap" required class="form-control"
                                                    style="width: 100%;">
                                                <option selected value="">Çap Seçiniz</option>
                                                <option value="127">127</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Boy(cm)</label>
                                            <input v-model='biyet.boy' required type="number"
                                                   class="form-control form-control-lg"
                                                   name="boy" placeholder="0" step="1" @input="checkboy($event)">
                                        </div>
                                    </div>

                                </div>
                                <div style="text-align: right" v-if="isFullBiyetData">
                                    <button v-on:click="biyetekle" class="btn btn-info float-right">Yeni
                                        Biyet Ekle
                                    </button>

                                </div>

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Parti No</th>
                                            <th>Firma</th>
                                            <th>Alaşım</th>
                                            <th>Adet</th>
                                            <th>Çap</th>
                                            <th>Boy</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="(biyet,index) in biyetler">
                                            <td> {{biyet.partino}}</td>
                                            <td> {{biyet.firmaAd}}</td>
                                            <td> {{biyet.alasimAd}}</td>
                                            <td> {{biyet.adetbiyet}}</td>
                                            <td> {{biyet.cap}}</td>
                                            <td> {{biyet.boy}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                 aria-labelledby="profil">
                                Profil
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div>
                <button type="submit" name="personelekleme" class="btn btn-info float-right">Ekle</button>
                <a href="../"
                   class="btn btn-warning float-left">Vazgeç</a>
            </div>
        </div>
        </form>
    </div>
</section>
