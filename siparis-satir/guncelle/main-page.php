<?php
include '../../netting/baglan.php';
include "../../include/sql.php";
require_once "../../include/helper.php";
require_once "../../include/data.php";

$satirno = 0;
if (isset($_GET['satirno'])) {
    $satirno = $_GET['satirno'];

    $sql = "Select * from tblsiparis where satirNo = '$satirno'";
    $row = mysqli_query($db, $sql)->fetch_assoc();


}

$firmasql = "SELECT * FROM tblfirma";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);

$boyasql = "SELECT * FROM tblprboya";
$boyalar = $db->query($boyasql);

$eloksalsql = "SELECT * FROM tbleloksal";
$eloksallar = $db->query($eloksalsql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);

#todo güncelleme ypılacak. -> profil kısmıda getirecek
?>

<section class="content" id="siparisguncelleneceksatir" satirno="<?php echo $satirno ?>">
    <form action="<?php echo base_url() . 'netting/siparis-satir/index.php' ?>" method="post">
        <div class="card card-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group-sm">
                            <label style="color: #7f8c8d">Müşteri
                                Sipariş No: <?php echo $row['siparisNo'] ?></label>
                            <br>
                            <label style="color: #7f8c8d">Müşteri
                                Adı: <?php echo tablogetir('tblfirma','id',$row['musteriId'], $db)['firmaAd'] ?></label>
                            <br>
                            <label style="color: #7f8c8d">Sipariş
                                Tarihi: <?php echo tarih($row['siparisTarih']) ?></label>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="card card-info">
            <div class="row">
                <div class="col-md-6">
                    <div style="text-align: right; margin: 5px">
                        <h5 style="color: #2b6b4f">Sipariş Detayı</h5>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>No</label>
                                        <input v-model="satirno" type="text"
                                               class="form-control form-control-lg"
                                               disabled>
                                        <input type="hidden" name="satirNo" :value="satirno">
                                        <input type="hidden" name="id" :value="id">
                                        <input type="hidden" name="kilo" :value="kilo">
                                        <input type="hidden" name="adet" :value="adet">
                                        <input type="hidden" name="profilId" :value="profilId">
                                        <input type="hidden" name="alasimId" :value="alasimId">
                                        <input type="hidden" name="araKagit" :value="araKagit">
                                        <input type="hidden" name="krepeKagit" :value="krepeKagit">
                                        <input type="hidden" name="kiloAdet" :value="kiloAdet">
                                        <input type="hidden" value="<?php echo isset($_SESSION['operatorId']) ?  $_SESSION['operatorId'] : 0; ?>" name="operatorId">

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Profiller</label>
                                        <select @change="profilOnChange($event)" v-model="profil"
                                                    class="form-control">
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
                                        <input v-model="boy" type="number" placeholder="1 mm"
                                               @input="checkBoy($event)" step="1"
                                               class="form-control form-control-lg" name="boy">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Adet</label>
                                        <input :disabled="adetDisabled" v-model="adet" type="number"
                                               class="form-control form-control-lg" name="adet"
                                               @input="checkAdet($event)"
                                               placeholder="1" step="1">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kilo</label>
                                        <input :disabled="kiloDisabled" v-model="kilo" step="0.1"
                                               placeholder="0.1" type="number"
                                               @input="checkKilo($event)"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Sipariş Türü</label>
                                        <select @change="onChangeSiparis($event)" v-model="siparisTur"
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
                                        <select  name="boyaId"  v-model = "boyaId" class="form-control">
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
                                        <select name="eloksalId" v-model="eloksalId" class="form-control">
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
                                        <select v-model="alasim" class="form-control"
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
                                        <input v-model="termimTarih" type="date"
                                               class="form-control form-control-lg" name="termimTarih">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tolerans (%)</label>
                                        <input v-model="maxTolerans" placeholder="1 (%)" type="number"
                                               @input="checkTolerans($event)"
                                               class="form-control form-control-lg" name="maxTolerans">
                                        <span v-if="errorShow" style="color: red" class="help-block"> Mevcut Kalıplar ile istenilen tolerans yakalanamaz. </span>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>~~</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox"
                                                        v-model="araKagit"
                                                       id="checkboxPrimary1"
                                                       @input="()=> {araKagit = !araKagit}">
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
                                                <input v-model="krepeKagit"
                                                       type="checkbox" id="checkboxPrimary2"
                                                       @input="()=> {krepeKagit = !krepeKagit}">
                                                <label style="color: #0e84b5" for="checkboxPrimary2">
                                                    Krepe Kağıt
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Naylon</label>
                                        <select v-model="naylonId" name="naylonDurum" class="form-control">
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
                                        <select v-model="korumaBandi" name="korumaBandi" class="form-control">
                                            <option selected disabled value="">Koruma Bandı Seçiniz</option>
                                            <option value="1">Baskılı</option>
                                            <option value="2">Baskısız</option>
                                            <option value="3">Yok</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>İstenilen Termik</label>
                                        <select v-model="istenilenTermik" name="istenilenTermik"
                                                class="form-control">
                                            <option selected disabled value="">İstenilen Termik</option>
                                            <option value="Termiksiz">0</option>
                                            <option value="Yarı Termikli">4 - 7</option>
                                            <option value="Termikli">10 - 14</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Baskı Açıklama</label>
                                        <input v-model="baskiAciklama" type="text"
                                               class="form-control form-control-lg" name="baskiAciklama"
                                               @input="checkAciklama($event)"
                                               placeholder="Baskı Açıklama Giriniz ">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Paket Açıklama</label>
                                        <input v-model="paketAciklama" type="text"
                                               class="form-control form-control-lg" name="paketAciklama"
                                               @input="checkAciklama($event)"
                                               placeholder=" Paket Açıklama Giriniz ">
                                    </div>
                                </div>
                                <input type="hidden" name="siparissaitrguncelle" value="guncelleekrani">

                                <div v-if="siparisTur == 'Boyalı' " class="col-sm-4">
                                    <div class="form-group">
                                        <label>Boya Açıklama</label>
                                        <input v-model="boyaAciklama" type="text"
                                               class="form-control form-control-lg" name="boyaAciklama"
                                               @input="checkAciklama($event)"
                                               placeholder="Boya Açıklama Giriniz ">
                                    </div>
                                </div>
                                <div class="col-sm-12" v-if="isFullSiparisData">
                                    <div style="text-align: right" name="siparissaitrguncelle">
                                        <button type="submit" class="btn btn-dark float-right">Güncelle
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

</section>


