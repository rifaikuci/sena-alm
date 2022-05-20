<?php
include "../../netting/baglan.php";
include "../../include/data.php";


$firmasql = "SELECT * FROM tblfirma  ";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);

$boyasql = "SELECT * FROM tblprboya";
$boyalar = $db->query($boyasql);

$eloksalsql = "SELECT * FROM tbleloksal";
$eloksallar = $db->query($eloksalsql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sipariş Ekleme Alanı
        </div>
        <div class="card-body" id="siparis-giris">
            <form method="post" action="<?php echo base_url() . 'netting/siparis/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <input name="arrayProfilId" :value="arrayProfilId" type="hidden">
                        <input name="arrayBoy" :value="arrayBoy" type="hidden">
                        <input name="arrayAdet" :value="arrayAdet" type="hidden">
                        <input name="arrayKilo" :value="arrayKilo" type="hidden">
                        <input name="arraySiparisTur" :value="arraySiparisTur" type="hidden">
                        <input name="arrayAlasimId" :value="arrayAlasimId" type="hidden">
                        <input name="arrayTermimTarih" :value="arrayTermimTarih" type="hidden">
                        <input name="arrayMaxTolerans" :value="arrayMaxTolerans" type="hidden">
                        <input name="arrayAraKagit" :value="arrayAraKagit" type="hidden">
                        <input name="arrayKrepeKagit" :value="arrayKrepeKagit" type="hidden">
                        <input name="arrayNaylonId" :value="arrayNaylonId" type="hidden">
                        <input name="arrayKorumaBandi" :value="arrayKorumaBandi" type="hidden">
                        <input name="arrayBoyaId" :value="arrayBoyaId" type="hidden">
                        <input name="arrayEloksalId" :value="arrayEloksalId" type="hidden">
                        <input name="arrayKiloAdet" :value="arrayKiloAdet" type="hidden">
                        <input name="arrayBaskiAciklama" :value="arrayBaskiAciklama" type="hidden">
                        <input name="arrayBoyaAciklama" :value="arrayBoyaAciklama" type="hidden">
                        <input name="arrayPaketAciklama" :value="arrayPaketAciklama" type="hidden">
                        <input name="arrayistenilenTermik" :value="arrayistenilenTermik" type="hidden">
                        <input type="hidden" value="<?php echo isset($_SESSION['operatorId']) ?  $_SESSION['operatorId'] : 0; ?>" name="operatorId">



                        <div class="form-group">
                            <label>Müşteri</label>
                            <select required name="musteriId" class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Müşteri Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tarih</label>
                            <input disabled type="date" class="form-control form-control-lg" name="siparisTarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">

                    <p>
                        <span style="color: red">*</span> Adet veya Kilodan dilediğinizi girebilirsiniz.
                    </p>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title" style="color: #0e84b5;font-weight: bold">
                                    <i class="fas fa-list"></i>
                                    Sipariş Detayları
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Profiller</label>
                                            <select id="siparisProfilId"  v-model="siparis.profil"
                                                    name="profilId" class="form-control select2" style="width: 100%;">
                                                <option selected disabled value="">Profil Seçiniz</option>
                                                <?php while ($profil = $profiller->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $profil['id'] . ";" . $profil['profilNo'] . "-" . $profil['profilAdi'] ?>"><?php echo $profil['profilNo'] . "-" . $profil['profilAdi']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Boy (mm)</label>
                                            <input v-model="siparis.boy" type="number" placeholder="1 mm"
                                                   @input="checkBoy($event)"
                                                   class="form-control form-control-lg" name="boy">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Adet</label>
                                            <input :disabled="adetDisabled" v-model="siparis.adet" type="number"
                                                   class="form-control form-control-lg" name="adet"
                                                   @input="checkAdet($event)"
                                                   placeholder="1" step="1">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Kilo (Kg)</label>
                                            <input :disabled="kiloDisabled" v-model="siparis.kilo" step="0.1"
                                                   placeholder="0.1 kg" type="number"
                                                   @input="checkKilo($event)"
                                                   class="form-control form-control-lg" name="kilo">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Sipariş Türü</label>
                                            <select @change="onChangeSiparis($event)" v-model="siparis.siparisTur"
                                                    name="siparisTur" class="form-control">
                                                <option selected disabled value="">Sipariş Türü Seçiniz</option>
                                                <?php for ($i = 0; $i < count($profilTur); $i++) { ?>
                                                    <option value="<?php echo $profilTur[$i] ?>"><?php echo $profilTur[$i] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3" v-if="isBoya">
                                        <div class="form-group">
                                            <label>Boyalar </label>
                                            <select v-model="siparis.boyaId" name="boyaId" class="form-control">
                                                <option selected disabled value="">Boya Seçiniz</option>
                                                <?php while ($boya = $boyalar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $boya['id']; ?>"><?php echo $boya['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3" v-if="isEloksal">
                                        <div class="form-group">
                                            <label>Eloksal </label>
                                            <select v-model="siparis.eloksalId" name="eloksalId" class="form-control">
                                                <option selected disabled value="">Eloksal Seçiniz</option>
                                                <?php while ($eloksal = $eloksallar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $eloksal['id']; ?>"><?php echo $eloksal['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Alaşımlar </label>
                                            <select v-model="siparis.alasim" name="alasimlId" class="form-control"
                                                    @change="alasimOnChange($event)">
                                                <option selected disabled value="">Alaşım Seçiniz</option>
                                                <?php while ($alasim = $alasimlar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $alasim['id'] . ";" . $alasim['ad']; ?>"><?php echo $alasim['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Termin Tarihi</label>
                                            <input v-model="siparis.termimTarih" type="date"
                                                   class="form-control form-control-lg" name="termimTarih">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Tolerans (%)</label>
                                            <input v-model="siparis.maxTolerans" placeholder="1 (%)" type="number"
                                                   @input="checkTolerans($event)"
                                                   class="form-control form-control-lg" name="maxTolerans">
                                            <span v-if="errorShow" style="color: red" class="help-block"> Mevcut Kalıplar ile istenilen tolerans yakalanamaz. </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>İstenilen Termik</label>
                                            <select v-model="siparis.istenilenTermik" name="istenilenTermik" class="form-control">
                                                <option selected disabled value="">İstenilen Termik</option>
                                                <?php for ($i = 0; $i < count($termikDurum); $i++) { ?>
                                                    <option value="<?php echo $termikDurum[$i] ?>"><?php echo $termikDurum[$i] ?></option>
                                                <?php } ?>>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Naylon</label>
                                            <select v-model="siparis.naylonId" name="naylonDurum" class="form-control">
                                                <option selected disabled value="">Naylon Seçiniz</option>
                                                <option value="1">Baskılı</option>
                                                <option value="2">Baskısız</option>
                                                <option value="3">Yok</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Koruma Bandı</label>
                                            <select v-model="siparis.korumaBandi" name="korumaBandi" class="form-control">
                                                <option selected disabled value="">Koruma Bandı Seçiniz</option>
                                                <option value="1">Baskılı</option>
                                                <option value="2">Baskısız</option>
                                                <option value="3">Yok</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>~~</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input v-model="siparis.araKagit" name="araKagit" type="checkbox"
                                                           id="checkboxPrimary1"
                                                           @input="checkKagit()">
                                                    <label style="color: #0e84b5" for="checkboxPrimary1">
                                                        Ara Kağıt
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>~~</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input v-model="siparis.krepeKagit" name="krepeKagit"
                                                           type="checkbox" id="checkboxPrimary2"
                                                           @input="checkKagit()">
                                                    <label style="color: #0e84b5" for="checkboxPrimary2">
                                                        Krepe Kağıt
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Baskı Açıklama</label>
                                            <input v-model="siparis.baskiAciklama" type="text"
                                                   class="form-control form-control-lg" name="baskiAciklama"
                                                   @input="checkAciklama($event)"
                                                   placeholder="Baskı Açıklama Giriniz ">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Paket Açıklama</label>
                                            <input v-model="siparis.paketAciklama" type="text"
                                                   class="form-control form-control-lg" name="paketAciklama"
                                                   @input="checkAciklama($event)"
                                                   placeholder=" Paket Açıklama Giriniz ">
                                        </div>
                                    </div>

                                    <div v-if="siparis.siparisTur == 'Boyalı' " class="col-sm-4">
                                        <div class="form-group">
                                            <label>Boya Açıklama</label>
                                            <input v-model="siparis.boyaAciklama" type="text"
                                                   class="form-control form-control-lg" name="boyaAciklama"
                                                   @input="checkAciklama($event)"
                                                   placeholder="Boya Açıklama Giriniz ">
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div v-if="isFullSiparisData" class="col-sm-12">
                                        <div style="text-align: right">
                                            <button v-on:click="ekle" class="btn btn-dark float-right">Ekle
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div v-if="arraySiparisler.length > 0" style="text-align: center" class="col-sm-12">
                                        <h4 style="color: deepskyblue">Siparişler</h4>
                                    </div>
                                    <div v-if="arraySiparisler.length > 0" class="card-body table-responsive p-0">


                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th>Profil</th>
                                                <th>Boy (mm)</th>
                                                <th>Adet</th>
                                                <th>Kilo</th>
                                                <th>Tür</th>
                                                <th>Alaşım</th>
                                                <th>Termin T.</th>
                                                <th>Tolerans</th>
                                                <th>Ara K.</th>
                                                <th>Krepe K.</th>
                                                <th>Naylon</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr v-for="(row,index) in arraySiparisler">
                                                <td>{{row.profilAd}}</td>
                                                <td>{{row.boy}}</td>
                                                <td>{{row.adet}}</td>
                                                <td>{{row.kilo}}</td>
                                                <td>{{row.siparisTur}}</td>
                                                <td>{{row.alasimAd}}</td>
                                                <td>{{row.termimTarih}}</td>
                                                <td>{{row.maxTolerans}}</td>
                                                <td>{{row.araKagitAd}}</td>
                                                <td>{{row.krepeKagitAd}}</td>
                                                <td>{{row.naylonAd}}</td>

                                                <td><a style="color: white" v-on:click="siparisSil(index)"
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

                <div class="card-footer">
                    <div>
                        <button :disabled="arraySiparisler.length == 0"  onclick="return confirm('Kaydetmek istediğinizden emin misiniz?')"
                                 type="submit" name="siparisekle" class="btn btn-info float-right">Kaydet</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>

        </div>


    </div>

</section>
