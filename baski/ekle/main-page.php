
<?php
include "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/data.php";
$siparissql = "SELECT * FROM tblsiparis where baskiDurum = 0 order by termimTarih asc";
$siparisler = $db->query($siparissql);

$biyetSql = "SELECT * FROM tblstokbiyet where kalanKg > 0";
$biyetler = $db->query($biyetSql);


date_default_timezone_set('Europe/Istanbul');
#todo her satır için basilan brut kg diye bir alan eklencek. oradan değerler bulunacak
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Baskı Oluşturma Alanı
        </div>


        <div class="card-body" id="baski-giris">
            <form method="post" action="<?php echo base_url() . 'netting/baski/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row" v-if="isSelected">
                    <div class="col-sm-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Sipariş Bilgileri</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div>
                                                <H2>

                                                    {{satirNo}}
                                                    <span style="color: #2b6b4f"> </span>
                                                </H2>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Müşteri: </span>
                                            {{musteriAd}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                            {{profil}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Alaşım: </span>
                                            {{alasim}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Tolerans: </span>
                                            {{tolerans}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> İstenilen Termik: </span>
                                            {{istenilenTermik}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Boy: </span>
                                            {{boy}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Kilo: </span>
                                            {{kg}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Basılan Kg - Kalan Kg: </span>
                                            {{basilanKilo}} - {{kalanKg}}
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Adet: </span>
                                            {{adet}}
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-8">
                                        <h3 style="color: red">
                                            {{aciklama}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="text-align: right">
                            <label>
                                <?php echo "Tarih: " . date("d.m.Y"); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sipariş</label>

                            <select name="siparisId" required class="form-control select2" id="supplier_id"
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Satır No
                                </option>

                            <?php while ($siparis = $siparisler->fetch_array()) { ?>
                                <option value="<?php echo $siparis['id']; ?>">
                                    <?php echo $siparis['satirNo']; ?>
                                </option>
                            <?php } ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Takımlar</label>

                            <select class="form-control select2" id="takim_id" name="takimId"
                                    required
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Takım No - Kalıp - Çap
                                </option>

                                <option v-for="takim in takimlar" :value="takim.id">
                                    {{takim.takimNo}} - {{ takim.kalipCins }} - {{takim.cap}}
                                </option>

                            </select>

                        </div>
                    </div>


                    <div class="col-sm-2" style="margin-top: 30px;">
                        <button :disabled="baskiBasla == true"
                                onclick="return confirm('Baskıyı Başlatılıyor emin misiniz?')"
                                type="submit"
                                v-on:click="baskiekle($event)"
                                name="baskiekle" class="btn btn-info float-right">Baskıyı Başlat
                        </button>
                    </div>
                    <div class="col-sm-2" style="margin-top: 30px;">
                        <label v-if="baskiBasla == true">
                            Baskı Başlama Zamanı: {{baslazamani}}
                        </label>
                    </div>
                    <input type="hidden" name="istenilenTermik"
                           :value="istenilenTermik">
                    <input type="hidden"  name="satirNo" :value="satirNo">
                    <input type="hidden" name="boy" :value="boy">
                    <input type="hidden" value="baski-ekle" name="baskiekle">
                    <input type="hidden"
                           value="<?php echo isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0; ?>"
                           name="operatorId">
                    <input type="hidden" name="basilanNetKg" :value="basilanNetKg">
                    <input type="hidden" name="baslaZamani" :value="baslazamani">
                    <input name="arrayBiyetBoy" :value="arrayBiyetBoy" type="hidden">
                    <input name="arrayBiyetId" :value="arrayBiyetId" type="hidden">
                    <input name="arrayBiyetAd" :value="arrayBiyetAd" type="hidden">
                    <input name="arrayBiyetVerilenBiyet" :value="arrayBiyetVerilenBiyet" type="hidden">
                    <input name="arrayBiyetAraisFire" :value="arrayBiyetAraisFire" type="hidden">
                    <input name="arrayBiyetKonveyorBoy" :value="arrayBiyetKonveyorBoy" type="hidden">
                    <input name="arrayBiyetBoylamFire" :value="arrayBiyetBoylamFire" type="hidden">
                    <input name="arrayBiyetFireBiyet" :value="arrayBiyetFireBiyet" type="hidden">
                    <input name="arrayBiyetBaskiFire" :value="arrayBiyetBaskiFire" type="hidden">
                    <input name="arrayBiyetler" :value="arrayBiyetler" type="hidden">
                    <input name="arrayBiyetBrut" :value="arrayBiyetBrut" type="hidden">

                </div>
                <br>
                <br>
                <hr style="color: #1F2D3D">


                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Detay Bilgileri</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">


                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Biyetler</label>

                                    <select class="form-control select2" id="biyet_id"
                                            style="width: 100%;">
                                        <option selected value="">
                                            Parti No - Alaşım - Firma
                                        </option>
                                        <?php while ($biyet = $biyetler->fetch_array()) {
                                            $alasim = tablogetir('tblalasim', 'id', $biyet['alasimId'], $db)['ad'];
                                            $firma = tablogetir('tblfirma', 'id', $biyet['firmaId'], $db)['firmaAd'];
                                            $id = $biyet['id'];
                                            $value = $id.";".$biyet['partino'].";".$alasim.";".$firma;
                                            ?>
                                            <option value="<?php echo $value ; ?>">
                                                <?php echo $biyet['partino'] . " - " . $alasim . " - " . $firma; ?>
                                            </option>
                                        <?php } ?>

                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Biyet Boy (cm)</label>
                                    <input v-model="biyet.biyetBoy"
                                           @change="handleBiyetBoy($event)"
                                           class="form-control" type="number" step="0.1" placeholder="0,1">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Verilen Biyet</label>
                                    <input v-model="biyet.biyetVerilenBiyet"
                                           @change="handleVerilenBiyet($event)"
                                           class="form-control" type="number"
                                           step="1" placeholder="0">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Ara iş Fire (gr)</label>

                                    <input v-model="biyet.biyetAraisFire" class="form-control"
                                           type="number" step="1" placeholder="0">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Konveyör Boy (m)</label>

                                    <input v-model="biyet.biyetKonveyorBoy"
                                           @change="calculateBrut($event)"
                                           class="form-control" type="number" step="0.1" placeholder="0,1">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Boylam Fire (m)</label>

                                    <input v-model="biyet.biyetBoylamFire"
                                           @change="calculateBrut($event)"
                                           class="form-control" type="number" step="0.1" placeholder="0,1">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Fire Biyet</label>
                                    <input v-model="biyet.biyetFireBiyet"
                                           @change="handleBiyetFire($event)"
                                           class="form-control" type="number" step="0.1" placeholder="0,1">

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Baskı Fire (%)</label>
                                    <input v-model="biyet.biyetBaskiFire" disabled
                                           class="form-control" type="text"
                                           placeholder="0,1">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Biyet Brüt</label>
                                    <input v-model="biyet.biyetBrut" disabled
                                           class="form-control" type="text">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button :disabled="!biyetData" v-on:click="biyetbaskisiekle" class="btn btn-success float-right">
                                        Biyet Ekle
                                    </button>
                                </div>
                            </div>

                        </div>

                        <br>
                        <br>
                        <div v-if="arrayBiyetler.length > 0" style="text-align: center" class="col-sm-12">
                            <h4 style="color: deepskyblue">Kullanılan Biyetler</h4>
                        </div>
                        <div v-if="arrayBiyetler.length > 0"   class="card-body table-responsive p-0">


                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Biyet</th>
                                    <th>Boy</th>
                                    <th>Verilen Biyet</th>
                                    <th>Araiş Fire</th>
                                    <th>Konveyör Boy</th>
                                    <th>Boylam Fire</th>
                                    <th>Fire Biyet</th>
                                    <th>Baskı Fire</th>
                                    <th>Brüt Kg</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(row,index) in arrayBiyetler">
                                    <td>{{row.biyetAd}}</td>
                                    <td>{{row.biyetBoy}}</td>
                                    <td>{{row.biyetVerilenBiyet}}</td>
                                    <td>{{row.biyetAraisFire}}</td>
                                    <td>{{row.biyetKonveyorBoy}}</td>
                                    <td>{{row.biyetBoylamFire}}</td>
                                    <td>{{row.biyetFireBiyet}}</td>
                                    <td>{{row.biyetBaskiFire}}</td>
                                    <td>{{row.biyetBrut}}</td>

                                    <td><a style="color: white" v-on:click="biyetSil(index)"
                                           class="btn btn-danger">Sil</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <br>
                <br>
                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Güncel Gr</label>
                            <input v-model="guncelGr"
                                   required
                                   @change="handleGuncelGr($event)"
                                   class="form-control" type="number" name="guncelGr"
                                   step="1"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Basılan Net Adet</label>
                            <input v-model="basilanNetAdet"
                                   required
                                   @change="handleBasilanNetAdet($event)"
                                   class="form-control" type="number" name="basilanNetAdet"
                                   step="1"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Basılan Net Kg</label>
                            <input v-model="basilanNetKg" disabled
                                   class="form-control" type="number" name="basilanNetKg"
                                   step="0.01"
                                   placeholder="0,01">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Basılan Brüt Kg</label>
                            <input v-model="basilanBrutKg" disabled
                                   class="form-control" type="number"
                                   step="0.01"
                                   placeholder="0,01">
                            <input type="hidden" name="basilanBrutKg" :value="basilanBrutKg">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Fire (Kg)</label>
                            <input v-model="fire" disabled
                                   class="form-control" type="text"
                                   placeholder="0">
                            <input type="hidden" name="fire" :value="fire">
                            <input type="hidden" name="baskiId" :value="baskiId">

                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kovan Sıcaklığı (°C)</label>
                            <input v-model="kovanSicaklik"
                                   required
                                   @change="handleKovanSicaklik($event)"
                                   class="form-control" type="number" name="kovanSicaklik"
                                   step="1"
                                   placeholder="0">
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kalıp Sıcaklığı (°C)</label>
                            <input v-model="kalipSicaklik"
                                   @change="handleKalipSicaklik($event)"
                                   class="form-control" type="number" name="kalipSicaklik"
                                   step="1" required
                                   placeholder="1">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Biyet Sıcaklığı (°C)</label>
                            <input v-model="biyetSicaklik"
                                   @change="handleBiyetSicaklik($event)"
                                   class="form-control" type="number" name="biyetSicaklik"
                                   step="1" required
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hız (A)</label>
                            <input v-model="hiz"
                                   @change="handleHiz($event)"
                                   class="form-control" type="number" name="hiz"
                                   step="0.1" required
                                   placeholder="0,1">
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Takım Son Durum</label>

                            <select class="form-control select2" name="takimSonDurum"
                                    required
                                    id="takimSonDurum"
                                    style="width: 100%;">
                                <option disabled selected value="">
                                    Takım Son Durumu
                                </option>
                                <?php foreach ($takimSonDurum as $key => $value) { ?>
                                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input required
                                   class="form-control" type="text" name="aciklama"
                                   placeholder="Açıklama Giriniz...">
                            <input type="hidden" :value="baskiDurum" name="baskiDurum">

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="isCheck">
                        <div class="form-group">
                            <label>~~</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input v-model="baskiDurum" type="checkbox" id="checkboxPrimary2">
                                    <label style="color: #0e84b5" :key="checkboxPrimary2" for="checkboxPrimary2">
                                        Sipariş Bitirilsin Mi
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!baskiDurum" class="col-sm-2">
                        <div class="form-group">
                            <label>Baskı Sonlanma Nedeni</label>

                            <select class="form-control select2" name="sonlanmaNeden"
                                    :required="!baskiDurum"
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Baskı Bitirilme Nedeni
                                </option>
                                <?php for ($i = 0; $i < count($baskiBitirilmeNeden); $i++) { ?>
                                    <option value="<?php echo $baskiBitirilmeNeden[$i] ?>"><?php echo $baskiBitirilmeNeden[$i] ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button v-if="baskiBitir" type="submit" name="baskiekle"
                                onclick="return confirm('Baskıyı Bitirmek İstediğinizden emin misiniz?')"
                                class="btn btn-info float-right">
                            Baskıyı Bitir
                        </button>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>

