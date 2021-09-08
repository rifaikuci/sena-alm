<?php
include "../../../netting/baglan.php";

$personelsql = "SELECT * FROM tblpersonel where rolId = 10";
$personeller = $db->query($personelsql);

$personelsql2 = "SELECT * FROM tblpersonel where rolId = 10";
$personeller2 = $db->query($personelsql2);

$firmasql = "SELECT * FROM tblfirma where firmaTurId =3 ";
$firmalar = $db->query($firmasql);

$firmaboyasql = "SELECT * FROM tblfirma where firmaTurId =2";
$firmalarboya = $db->query($firmaboyasql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);

$boyasql = "SELECT * FROM tblboya";
$boyalar = $db->query($boyasql);

$malzemelersql = "SELECT * FROM tblmalzemeler";
$malzemeler = $db->query($malzemelersql);

$malzemelerfirmasql = "SELECT * FROM tblfirma where firmaTurId =1";
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
            Sevkiyat Giriş Ekleme Alanı
        </div>
        <div class="card-body" id="stok-giris">
            <form method="post" action="<?php echo base_url() . 'netting/sevkiyat/gelen.php' ?>">
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
                            <label>Sevkiyat Tarihi</label>
                            <input type="date" class="form-control form-control-lg" name="sevkiyatarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Zamanı</label>
                            <input type="time" class="form-control form-control-lg" name="sevkiyasaat">
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

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-gray-dark card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="biyet" data-toggle="pill"
                                           href="#custom-tabs-one-home"
                                           role="tab" aria-controls="custom-tabs-one-home"
                                           aria-selected="true">Biyetler</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="boya" data-toggle="pill"
                                           href="#custom-tabs-one-profile"
                                           role="tab" aria-controls="custom-tabs-one-profile"
                                           aria-selected="false">Boya</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="malzemeler" data-toggle="pill"
                                           href="#custom-tabs-one-malzeme"
                                           role="tab" aria-controls="custom-tabs-one-malzeme"
                                           aria-selected="false">Malzemeler</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="profil" data-toggle="pill"
                                           href="#custom-tabs-one-profil"
                                           role="tab" aria-controls="custom-tabs-one-profil"
                                           aria-selected="false">Profiller</a>
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
                                                    <input v-model="biyet.partino" type="text"
                                                           @input="checkpartino($event)"
                                                           placeholder="Parti Numarası Giriniz..."
                                                           class="form-control form-control-lg">
                                                    <input name="biyetpartino" :value="biyetpartino" type="hidden">
                                                    <input name="biyetfirmaId" :value="biyetfirmaId" type="hidden">
                                                    <input name="biyetfirmaAd" :value="biyetfirmaAd" type="hidden">
                                                    <input name="biyetalasimId" :value="biyetalasimId" type="hidden">
                                                    <input name="biyetalasimAd" :value="biyetalasimAd" type="hidden">
                                                    <input name="biyetadetbiyet" :value="biyetadetbiyet" type="hidden">
                                                    <input name="biyetcap" :value="biyetcap" type="hidden">
                                                    <input name="biyetboy" :value="biyetboy" type="hidden">

                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Firma Adı</label>
                                                    <select v-model="biyet.firmaId" name="firmaId"
                                                            class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Firma Seçiniz</option>
                                                        <?php while ($firma = $firmalar->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Alaşım Türü</label>
                                                    <select v-model="biyet.alasimId" name="alasimId"
                                                            class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Alaşım Seçiniz</option>
                                                        <?php while ($alasim = $alasimlar->fetch_array()) { ?>
                                                            <option value="<?php echo $alasim['id']; ?>"><?php echo $alasim['ad']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Adet</label>
                                                    <input v-model="biyet.adetbiyet" type="number"
                                                           class="form-control form-control-lg"
                                                           @input="checkadetbiyet($event)"
                                                           name="adetbiyet" placeholder="0" step="1">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Çap (mm)</label>
                                                    <select v-model="biyet.cap" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Çap Seçiniz</option>
                                                        <option value="127">127</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Boy(mm)</label>
                                                    <input v-model="biyet.boy" type="number"
                                                           class="form-control form-control-lg"
                                                           name="boy" placeholder="0" step="1"
                                                           @input="checkboy($event)">
                                                </div>
                                            </div>

                                        </div>

                                        <div style="text-align: right" v-if="isFullBiyetData">
                                            <button v-on:click="biyetekle" class="btn btn-info float-right">Yeni
                                                Biyet Ekle
                                            </button>

                                        </div>

                                        <div v-if="biyetler.length > 0" class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Parti No</th>
                                                    <th>Firma</th>
                                                    <th>Alaşım</th>
                                                    <th>Adet</th>
                                                    <th>Çap</th>
                                                    <th>Boy</th>
                                                    <th>Toplam Kilo</th>
                                                    <th>Toplam Boy</th>
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
                                                    <td> {{biyet.toplamkilo}} Kg</td>
                                                    <td> {{biyet.toplamboy}} Cm</td>
                                                    <td><a style="color: white" v-on:click="biyetSil(index)"
                                                           class="btn btn-danger">Sil</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                         aria-labelledby="boya">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Parti Numarası</label>
                                                    <input v-model="boya.partino" type="text"
                                                           placeholder="Parti Numarası Giriniz..."
                                                           @input="checkboyapartino($event)"
                                                           class="form-control form-control-lg">
                                                    <input name="boyapartino" :value="boyapartino" type="hidden">
                                                    <input name="boyafirmaId" :value="boyafirmaId" type="hidden">
                                                    <input name="boyafirmaAd" :value="boyafirmaAd" type="hidden">
                                                    <input name="boyaboyaId" :value="boyaboyaId" type="hidden">
                                                    <input name="boyaboyaAd" :value="boyaboyaAd" type="hidden">
                                                    <input name="boyaadet" :value="boyaadet" type="hidden">
                                                    <input name="boyakilo" :value="boyakilo" type="hidden">
                                                    <input name="boyasicaklik" :value="boyasicaklik" type="hidden">
                                                    <input name="boyacins" :value="boyacins" type="hidden">

                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Firma Adı</label>
                                                    <select v-model="boya.firmaId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Firma Seçiniz</option>
                                                        <?php while ($firmaboya = $firmalarboya->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $firmaboya['id']; ?>"><?php echo $firmaboya['firmaAd']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Boya Türü</label>
                                                    <select v-model="boya.boyaId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Boya Seçiniz</option>
                                                        <?php while ($boya = $boyalar->fetch_array()) { ?>
                                                            <option value="<?php echo $boya['id']; ?>"><?php echo $boya['kod'] . " - " . $boya['ad']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Sıcaklık</label>
                                                    <select v-model="boya.sicaklik" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Kürlenme Sıcaklığı</option>
                                                        <option value="180">180</option>
                                                        <option value="200">200</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Cins</label>
                                                    <select v-model="boya.cins" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Cins</option>
                                                        <option value="Mat">Mat</option>
                                                        <option value="Parlak">Parlak</option>
                                                        <option value="Yarı Mat">Yarı Mat</option>
                                                        <option value="Metalik">Metalik</option>
                                                        <option value="Simli">Simli</option>
                                                        <option value="Texture">Texture</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Adet</label>
                                                    <input v-model="boya.adet" type="number"
                                                           @input="checkboyaadet($event)"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>KG</label>
                                                    <input v-model="boya.kilo" type="number"
                                                           @input="checkboyakilo($event)"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>


                                        </div>

                                        <div style="text-align: right" v-if="isFullBoyaData">
                                            <button v-on:click="boyaekle" class="btn btn-info float-right">Yeni
                                                Boya Ekle
                                            </button>

                                        </div>

                                        <div v-if="boyalar.length > 0" class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Parti No</th>
                                                    <th>Firma</th>
                                                    <th>Boya</th>
                                                    <th>Sıcaklık</th>
                                                    <th>Cins</th>
                                                    <th>Adet</th>
                                                    <th>Kilo</th>
                                                    <th>Toplam Kilo</th>
                                                    <th>İşlem</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr v-for="(boya,index) in boyalar">
                                                    <td> {{boya.partino}}</td>
                                                    <td> {{boya.firmaAd}}</td>
                                                    <td> {{boya.boyaAd}}</td>
                                                    <td> {{boya.sicaklik}}</td>
                                                    <td> {{boya.cins}}</td>
                                                    <td> {{boya.adet}}</td>
                                                    <td> {{boya.kilo}}</td>
                                                    <td> {{boya.toplamkilo}}</td>
                                                    <td><a style="color: white" v-on:click="boyaSil(index)"
                                                           class="btn btn-danger">Sil</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-malzeme" role="tabpanel"
                                         aria-labelledby="malzemeler">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Parti Numarası</label>
                                                    <input v-model="malzeme.partino" type="text"
                                                           placeholder="Parti Numarası Giriniz..."
                                                           @input="checkmalzemepartino($event)"
                                                           class="form-control form-control-lg">
                                                    <input name="malzemepartino" :value="malzemepartino" type="hidden">
                                                    <input name="malzemefirmaId" :value="malzemefirmaId" type="hidden">
                                                    <input name="malzemefirmaAd" :value="malzemefirmaAd" type="hidden">
                                                    <input name="malzememalzemeId" :value="malzememalzemeId"
                                                           type="hidden">
                                                    <input name="malzememalzemeAd" :value="malzememalzemeAd"
                                                           type="hidden">
                                                    <input name="malzemeadet" :value="malzemeadet" type="hidden">
                                                </div>

                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Firma Adı</label>
                                                    <select v-model="malzeme.firmaId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Firma Seçiniz</option>
                                                        <?php while ($malzemefirma = $malzemelerfirma->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $malzemefirma['id']; ?>"><?php echo $malzemefirma['firmaAd']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Malzeme</label>
                                                    <select required v-model="malzeme.malzemeId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected value="">Malzeme Seçiniz</option>
                                                        <?php while ($malzeme = $malzemeler->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $malzeme['id']; ?>"><?php echo $malzeme['ad']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Adet</label>
                                                    <input v-model="malzeme.adet" type="number"
                                                           @input="checkmalzemeadet($event)"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>


                                        </div>

                                        <div style="text-align: right" v-if="isFullMalzemeData">
                                            <button v-on:click="malzemeekle" class="btn btn-info float-right">Yeni
                                                Malzeme Ekle
                                            </button>

                                        </div>

                                        <div v-if="malzemeler.length > 0" class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Parti No</th>
                                                    <th>Firma</th>
                                                    <th>Malzeme</th>
                                                    <th>Adet</th>
                                                    <th>Toplam</th>
                                                    <th>İşlem</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr v-for="(malzeme,index) in malzemeler">
                                                    <td> {{malzeme.partino}}</td>
                                                    <td> {{malzeme.firmaAd}}</td>
                                                    <td> {{malzeme.malzemeAd}}</td>
                                                    <td> {{malzeme.adet}}</td>
                                                    <td> {{malzeme.toplam}}</td>
                                                    <td><a style="color: white" v-on:click="malzemeSil(index)"
                                                           class="btn btn-danger">Sil</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profil" role="tabpanel"
                                         aria-labelledby="profil">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Profiller</label>
                                                    <select v-model="profil.profilId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Profil Seçiniz</option>
                                                        <?php while ($profil = $profiller->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $profil['id']; ?>"><?php echo $profil['profilAdi']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Geldiği Firma</label>
                                                    <input name="profilprofilId" :value="profilprofilId" type="hidden">
                                                    <input name="profilprofilAd" :value="profilprofilAd" type="hidden">
                                                    <input name="profilboy" :value="profilboy" type="hidden">
                                                    <input name="profilfirmaId" :value="profilfirmaId" type="hidden">
                                                    <input name="profilfirmaAd" :value="profilfirmaAd" type="hidden">
                                                    <input name="profilmusteriId" :value="profilmusteriId"
                                                           type="hidden">
                                                    <input name="profilmusteriAd" :value="profilmusteriAd"
                                                           type="hidden">

                                                    <input name="profilicadet" :value="profiladet" type="hidden">
                                                    <input name="profilpaketAdet" :value="profilpaketAdet"
                                                           type="hidden">
                                                    <input name="profiltoplamadet" :value="profiltoplamadet"
                                                           type="hidden">
                                                    <input name="profiltoplamkilo" :value="profiltoplamkilo"
                                                           type="hidden">
                                                    <input name="profiltur" :value="profiltur" type="hidden">
                                                    <input name="profilgelisAmaci" :value="profilgelis" type="hidden">
                                                    <select v-model="profil.firmaId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Geldiği Firma Seçiniz
                                                        </option>
                                                        <?php while ($profilfirma = $profilfirmalar->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $profilfirma['id']; ?>"><?php echo $profilfirma['firmaAd']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Müşteri</label>
                                                    <select v-model="profil.musteriId" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected disabled value="">Müşteri Seçiniz</option>
                                                        <?php while ($musteri = $profilfirmamusteri->fetch_array()) { ?>
                                                            <option
                                                                    value="<?php echo $musteri['id']; ?>"><?php echo $musteri['firmaAd']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Profil Tür</label>
                                                    <select v-model="profil.tur" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected value="">Profil Tür Seçiniz</option>
                                                        <option value="Pres">Pres</option>
                                                        <option value="Boyalı">Boyalı</option>
                                                        <option value="Eloksallı">Eloksallı</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Geliş Amacı</label>
                                                    <select v-model="profil.gelis" class="form-control"
                                                            style="width: 100%;">
                                                        <option selected value="">Geliş Amacı Seçiniz</option>
                                                        <option value="Boya">Boya</option>
                                                        <option value="Kesim">Kesim</option>
                                                        <option value="Delim">Delim</option>
                                                        <option value="Sertleştirm">Sertleştirm</option>
                                                        <option value="Paketleme">Paketleme</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Boy (mm)</label>
                                                    <input v-model="profil.boy" type="number"
                                                           @input="checkprofilboy($event)"
                                                           class="form-control form-control-lg" placeholder="0.1"
                                                           step="0.1">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Toplam Kg </label>
                                                    <input type="number"
                                                           v-model="profil.toplamkilo"
                                                           class="form-control form-control-lg" placeholder="0.1"
                                                           step="0.1">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label> İç Adet</label>
                                                    <input v-model="profil.adet" type="number"
                                                           @input="checkprofiladet($event)"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Paket Adet</label>
                                                    <input v-model="profil.paketAdet" type="number"
                                                           @input="checkprofilpaketAdet($event)"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Toplam Adet</label>
                                                    <input v-model="profil.toplamadet" type="number"
                                                           class="form-control form-control-lg" placeholder="0"
                                                           step="1">
                                                </div>
                                            </div>


                                        </div>

                                        <div style="text-align: right" v-if="isFullProfilData">
                                            <button v-on:click="profilekle" class="btn btn-info float-right">Yeni
                                                Profil Ekle
                                            </button>

                                        </div>

                                        <div v-if="profiller.length > 0" class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Profil</th>
                                                    <th>Boy (mt)</th>
                                                    <th>Firma</th>
                                                    <th>Müşteri</th>
                                                    <th>Çizim</th>
                                                    <th>İç adet</th>
                                                    <th>Paket Adet</th>
                                                    <th>Adet</th>
                                                    <th>Toplam Kg</th>
                                                    <th>M/Gr</th>
                                                    <th>Tolerans</th>
                                                    <th>İşlem</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr v-for="(profil,index) in profiller">
                                                    <td> {{profil.profilAd}}</td>
                                                    <td> {{profil.boy}}</td>
                                                    <td> {{profil.firmaAd}}</td>
                                                    <td> {{profil.musteriAd}}</td>
                                                    <td><a target="_blank" :href="profil.resim">Çizim</a></td>
                                                    <td> {{profil.adet}}</td>
                                                    <td> {{profil.paketAdet}}</td>
                                                    <td> {{profil.toplamadet}}</td>
                                                    <td> {{profil.toplamkilo}}</td>
                                                    <td> {{profil.mGr}}</td>
                                                    <td :style="[profil.tolerans < 0 ? { color :  '#00b44e'} : {color :  '#ff2400'}]">
                                                        % {{profil.tolerans}}
                                                    </td>
                                                    <td><a style="color: white" v-on:click="profilSil(index)"
                                                           class="btn btn-danger">Sil</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button :disabled="profiller.length == 0 &&
                                           malzemeler.length == 0 &&
                                           biyetler.length == 0 &&
                                           boyalar.length == 0"
                                type="submit" name="sevkiyatekle" class="btn btn-info float-right">Ekle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>

            </form>
        </div>

</section>