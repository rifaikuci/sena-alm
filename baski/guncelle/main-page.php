<?php
include "../../netting/baglan.php";
require_once "../../include/sql.php";

$baskiId = 0;
if (isset($_GET['baski'])) {
    $baskiId = $_GET['baski'];

    $sql = "SELECT * FROM tblbaski WHERE id = '$baskiId'";
    $result = mysqli_query($db, $sql);
    $baski = $result->fetch_assoc();

    $biyetSql = "SELECT * FROM tblstokbiyet where durum = 1 and kalanKg > 0";
    $biyetler = $db->query($biyetSql);

    $siparissql = "SELECT * FROM tblsiparis where baskiDurum = 0 order by termimTarih asc";
    $siparisler = $db->query($siparissql);
}

date_default_timezone_set('Europe/Istanbul');

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Baskı Güncelleme Alanı
        </div>
        <div class="card-body" id="baski-guncelle" :baski="<?php echo $baskiId; ?>">
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
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Sipariş</label>

                            <select name="siparisId" required class="form-control select2" id="siparis_guncelle"
                                    style="width: 100%;">
                                <option disabled value="">
                                    Sipariş No - Termim Tarih - Müşteri - Profil No - Profil Ad - Boy - Tür - Tür Detayı
                                    - İstenen/Basılan K/A
                                </option>
                                <?php while ($siparis = $siparisler->fetch_array()) { ?>

                                    <option <?php echo $siparis['id'] == $baski['siparisId'] ? "selected" : "" ?>
                                            value="<?php echo $siparis['id']; ?>">
                                        <?php
                                        $siparisTuru = $siparis['siparisTuru'] == "H" ? "Ham" :
                                            ($siparis['siparisTuru'] == "B" ? "Boyalı" : "Eloksal");

                                        $tur = $siparis['siparisTuru'] == "H" ? "Yok" :
                                            ($siparis['siparisTuru'] == "B" ? tablogetir('tblboya', 'id', $siparis['boyaId'], $db)['ad'] :
                                                tablogetir('tbleloksal', 'id', $siparis['eloksalId'], $db)['ad']);
                                        $kiloVeyaAdet = $siparis['kiloAdet'] == "K" ? $siparis['kilo'] . "/" :
                                            $siparis['adet'] . "/";

                                        $basilanKiloVeyaAdet = $siparis['kiloAdet'] == "K" ? $siparis['basilanKilo'] . " Kilo" :
                                            $siparis['basilanAdet'] . " Adet";

                                        $profil = tablogetir('tblprofil', 'id', $siparis['profilId'], $db);
                                        echo
                                            $siparis['satirNo'] . " - " .
                                            tarih($siparis['termimTarih']) . " - " .
                                            tablogetir('tblfirma', 'id', $siparis['musteriId'], $db)['firmaAd'] . " - " .
                                            $profil['profilNo'] . " -" .
                                            $profil['profilAdi'] . " -" .
                                            $siparis['boy'] . " - " .
                                            tablogetir('tblalasim', 'id', $siparis['alasimId'], $db)['ad'] . " - " .
                                            $siparisTuru . " - " . $tur . " - " . $kiloVeyaAdet . $basilanKiloVeyaAdet;;

                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Takımlar</label>

                            <select class="form-control select2" id="takim_id_guncelle" name="takimId"
                                    required
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Takım No - Kalıp - Çap
                                </option>

                                <option v-for="takim in takimlar" :value="takim.id" :selected="takim.id == takimId">
                                    {{takim.takimNo}} - {{ takim.kalipCins }} - {{takim.cap}}
                                </option>

                            </select>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Başlama Tarihi</label>
                            <input required type="date" class="form-control form-control-lg" name="baslaTarih"
                                   :value="baslaTarih">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Başlama Saat</label>
                            <input required type="time" class="form-control form-control-lg" name="baslaSaat"
                                   :value="baslaSaat">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Bitiş Tarihi</label>
                            <input required type="date" class="form-control form-control-lg" name="bitisTarih"
                                   :value="bitisTarih">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Bitiş Saat</label>
                            <input required type="time" class="form-control form-control-lg" name="bitisSaat"
                                   :value="bitisSaat">
                        </div>
                    </div>

                </div>
                <br>
                <br>
                <hr style="color: #1F2D3D">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyetler</label>

                            <select class="form-control select2"
                                    required name="biyetId"
                                    style="width: 100%;">
                                <?php while ($biyet = $biyetler->fetch_array()) { ?>
                                    <option
                                        <?php echo $baski['biyetId'] == $biyet['id'] ? "selected" : "" ?>
                                            value="<?php echo $biyet['id']; ?>">
                                        <?php echo $biyet['partino'] . " - " .
                                            tablogetir('tblalasim', 'id', $biyet['alasimId'], $db)['ad'] . " - " .
                                            tablogetir('tblfirma', 'id', $biyet['firmaId'], $db)['firmaAd']; ?>
                                    </option>
                                <?php } ?>

                            </select>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyet Boy</label>

                            <input v-model="biyetBoy"
                                   @change="handleBiyetBoy($event)"
                                   required name="biyetBoy"
                                   class="form-control" type="number" name="biyetBoy" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Ara iş Fire</label>

                            <input v-model="araIsFire" class="form-control" name="araIsFire"
                                   required type="number" name="araIsFire" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Konveyör Boy</label>

                            <input v-model="konveyorBoy"
                                   @change="handleChangeKonveyor($event)"
                                   required
                                   class="form-control" type="number" name="konveyorBoy"
                                   step="0.001" placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Boylam Fire</label>

                            <input v-model="boylamFire"
                                   @change="handleBoylamFire($event)"
                                   required name="boylamFire"
                                   class="form-control" type="number" name="boylamFire" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Baskı Fire</label>
                            <input v-model="baskiFire" disabled
                                   required
                                   class="form-control" type="number"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="baskiFire" name="baskiFire" :value="baskiFire">
                            <input type="hidden" v-model="satirNo" name="satirNo" :value="satirNo">
                            <input type="hidden" name="baskiguncelle" value="baski-guncelle">
                            <input type="hidden"
                                   value="<?php echo isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0; ?>"
                                   name="operatorId">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fire Biyet</label>
                            <input v-model="biyetFire"
                                   required
                                   class="form-control" type="number" name="biyetFire"
                                   step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Verilen Biyet</label>
                            <input v-model="verilenBiyet"
                                   required
                                   @change="handleVerilenBiyet($event)"
                                   class="form-control" type="number" name="verilenBiyet"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Güncel Gr</label>
                            <input v-model="guncelGr"
                                   required
                                   @change="handleGuncelGr($event)"
                                   class="form-control" type="number" name="guncelGr"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Brüt Kg</label>
                            <input v-model="basilanBrutKg" disabled
                                   class="form-control" type="number" name="basilanBrutKg"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="basilanBrutKg" name="basilanBrutKg" :value="basilanBrutKg">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Net Adet</label>
                            <input v-model="basilanNetAdet"
                                   required
                                   @change="handleBasilanNetAdet($event)"
                                   class="form-control" type="number" name="basilanNetAdet"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Net Kg</label>
                            <input v-model="basilanNetKg" disabled
                                   class="form-control" type="number" name="basilanNetKg"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="basilanNetKg" name="basilanNetKg" :value="basilanNetKg">
                            <input type="hidden" v-model="baslazamani" name="baslaZamani" :value="baslazamani">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kovan Sıcaklığı</label>
                            <input v-model="kovanSicaklik"
                                   required
                                   @change="handleKovanSicaklik($event)"
                                   class="form-control" type="number" name="kovanSicaklik"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kalıp Sıcaklığı</label>
                            <input v-model="kalipSicaklik"
                                   @change="handleKalipSicaklik($event)"
                                   class="form-control" type="number" name="kalipSicaklik"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyet Sıcaklığı</label>
                            <input v-model="biyetSicaklik"
                                   @change="handleBiyetSicaklik($event)"
                                   class="form-control" type="number" name="biyetSicaklik"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hız</label>
                            <input v-model="hiz"
                                   @change="handleHiz($event)"
                                   class="form-control" type="number" name="hiz"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fire</label>
                            <input v-model="fire" disabled
                                   class="form-control" type="number" name="fire"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="fire" name="fire" :value="fire">
                            <input type="hidden" v-model="baskiId" name="baskiId" :value="baskiId">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Takım Son Durum</label>

                            <select class="form-control select2" name="takimSonDurum"
                                    required
                                    id="takimSonDurum"
                                    style="width: 100%;">
                                <option <?php echo $baski['takimSonDurum'] == "Pres" ? "selected" : "" ?>
                                        value="Pres">PRES
                                </option>
                                <option <?php echo $baski['takimSonDurum'] == "Kostik" ? "selected" : "" ?>
                                        value="Kostik">KOSTİK
                                </option>
                                <option <?php echo $baski['takimSonDurum'] == "Tenefer" ? "selected" : "" ?>
                                        value="Tenefer">TENEFER
                                </option>

                                <option <?php echo $baski['takimSonDurum'] == "Raf" ? "selected" : "" ?>
                                        value="Raf">RAF
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input required
                                   class="form-control" type="text" name="aciklama"
                                   value="<?php echo $baski['aciklama'] ?>"
                                   placeholder="Açıklama Giriniz...">
                            <input type="hidden" v-model="baskiDurum" :value="baskiDurum" name="baskiDurum">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Baskı Sonlanma Nedeni</label>

                            <select class="form-control select2" name="sonlanmaNeden"
                                    :required="!baskiDurum"
                                    style="width: 100%;">
                                <option <?php echo $baski['sonlanmaNeden'] == "Kalıp Kırıldı" ? "selected" : "" ?>
                                        value="Kalıp Kırıldı">Kalıp Kırıldı
                                </option>
                                <option <?php echo $baski['sonlanmaNeden'] == "Kalıp Dinlenme" ? "selected" : "" ?>
                                        value="Kalıp Dinlenme">Kalıp Dinlenme
                                </option>
                                <option <?php echo $baski['sonlanmaNeden'] == "Kalıp Boy Farkı" ? "selected" : "" ?>
                                        value="Kalıp Boy Farkı">Kalıp Boy Farkı
                                </option>
                                <option <?php echo $baski['sonlanmaNeden'] == "Mühre Kırıldı" ? "selected" : "" ?>
                                        value="Mühre Kırıldı">Mühre Kırıldı
                                </option>
                                <option <?php echo $baski['sonlanmaNeden'] == "Bolster Kırıldı" ? "selected" : "" ?>
                                        value="Bolster Kırıldı">Bolster Kırıldı
                                </option>
                                <option <?php echo $baski['sonlanmaNeden'] == "Tamamlandı" ? "selected" : "" ?>
                                        value="Tamamlandı">Tamamlandı
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>~~</label>
                            <p style="color: darkcyan; font-weight: bold">* Tamamlandı seçilirse baskı
                                bitirilecektir.</p>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit"
                                onclick="return confirm('Baskıyı Güncellemek İstediğinizden emin misiniz?')"
                                class="btn btn-info float-right">
                            Baskıyı Güncelle
                        </button>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>

