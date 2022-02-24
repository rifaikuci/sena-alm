<?php
include "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/data.php";


if ($_GET['baski']) {
    $baskiId = $_GET['baski'];
    $sql = "SELECT * FROM tblbaski WHERE id = '$baskiId'";
    $result = mysqli_query($db, $sql);
    $baski = $result->fetch_assoc();


    $siparisId = $baski['siparisId'];
    $sqlsiparis = "SELECT * FROM tblsiparis WHERE id = '$siparisId'";
    $resultsiparis = mysqli_query($db, $sqlsiparis);
    $siparis = $resultsiparis->fetch_assoc();

    $takimId = $baski['takimId'];
    $profilId = tablogetir('tbltakim', 'id', $takimId, $db)['profilId'];

    $sqltakimlar = "SELECT * FROM tbltakim WHERE durum = '1' AND profilId = '$profilId' order by sonGramaj asc ";

    $takimlar = $db->query($sqltakimlar);
    $biyetgr = tablogetir('tblalasim', 'id', $siparis['alasimId'], $db)['biyetBirimGramaj'];

}

ini_set('display_errors', 1);


$siparissql = "SELECT * FROM tblsiparis where baskiDurum = 0 order by termimTarih asc";
$siparisler = $db->query($siparissql);


$biyetSql = "SELECT * FROM tblstokbiyet where kalanKg > 0";
$biyetler = $db->query($biyetSql);


date_default_timezone_set('Europe/Istanbul');

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Baskı Oluşturma Alanı
        </div>
        <div class="card-body" id="baski-yari-guncelle"
             :value="<?php echo $siparis['boy'] ?>"
             :birimgr="<?php echo $biyetgr ?>"
             :kg="<?php echo $siparis['kilo'] ?>"
             :kalanKgG="<?php echo $siparis['kilo'] - $siparis['basilanKilo'] ?>"


        >
            <form method="post" action="<?php echo base_url() . 'netting/baski/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
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
                                                    <?php echo $siparis['satirNo']; ?>
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
                                            <?php echo tablogetir('tblfirma', 'id', $siparis['musteriId'], $db)['firmaAd']; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                            <?php echo tablogetir('tblprofil', 'id', $siparis['profilId'], $db)['profilAdi'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Alaşım: </span>
                                            <?php echo tablogetir('tblalasim', 'id', $siparis['alasimId'], $db)['ad']; ?>
                                        </h6>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Tolerans: </span>
                                            <?php echo $siparis['maxTolerans'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Boy: </span>
                                            <?php echo $siparis['boy'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Kilo: </span>
                                            <?php echo $siparis['kilo'] ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Basılan Kg - Kalan Kg: </span>

                                            <?php echo $siparis['basilanKilo'], " - ", $siparis['kilo'] - $siparis['basilanKilo'] ?>
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Adet: </span>
                                            <?php echo $siparis['basilanAdet'] ?>
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-8">
                                        <h3 style="color: red">
                                            <?php echo $siparis['baskiAciklama'] ?>
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
                                <?php echo "Tarih: " . tarih(explode(" ", $baski['kayitTarih'])[0]) . " " . explode(" ", $baski['kayitTarih'])[1]; ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sipariş</label>

                            <select required class="form-control select2" disabled
                                    value="<?php echo $baski['siparisId'] ?>"
                                    style="width: 100%;">
                                <?php while ($row = $siparisler->fetch_array()) { ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['satirNo'] ?>
                                    </option>
                                <?php } ?>

                            </select>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Takımlar</label>

                            <select required class="form-control" disabled
                                    value="<?php echo $baski['takimId'] ?>"
                                    style="width: 100%;">
                                <?php while ($takim = $takimlar->fetch_array()) { ?>

                                    <option
                                            value="<?php echo $takim['id']; ?>">
                                        <?php echo $takim['takimNo'] . " - " . kalipBul($takim['kalipCins']) . " - " . $takim['cap'] ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>
                    </div>

                    <div class="col-sm-1">

                    </div>

                    <div class="col-sm-5" style="margin-top: 30px;">
                        <label>
                            <?php echo "Baskı Başlama Zamanı: " . tarih(explode(" ", $baski['baslaZamani'])[0]) . " " . explode(" ", $baski['baslaZamani'])[1]; ?>
                        </label>
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
                                <option selected disabled value="">
                                    Parti No - Alaşım - Firma
                                </option>
                                <?php while ($biyet = $biyetler->fetch_array()) { ?>
                                    <option value="<?php echo $biyet['id']; ?>">
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
                            <input v-model="biyetBoyG"
                                   @change="handleBiyetBoyG($event)"
                                   required name="biyetBoyG"
                                   class="form-control" type="number" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Ara iş Fire</label>

                            <input class="form-control" name="araIsFire"
                                   required type="number" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Konveyör Boy</label>

                            <input v-model="konveyorBoyG"
                                   @change="handleChangeKonveyor($event)"
                                   required
                                   class="form-control" type="number" name="konveyorBoyG"
                                   step="0.001" placeholder="0,1">

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Boylam Fire</label>

                            <input v-model="boylamFireG"
                                   @change="handleBoylamFireG($event)"
                                   required
                                   class="form-control" type="number" name="boylamFireG" step="0.001"
                                   placeholder="0,1">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Baskı Fire</label>
                            <input v-model="baskiFireG" disabled
                                   required
                                   class="form-control" type="number"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="baskiFireG" name="baskiFireG" :value="baskiFireG">
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
                            <input v-model="verilenBiyetG"
                                   required
                                   @change="handleverilenBiyetG($event)"
                                   class="form-control" type="number" name="verilenBiyetG"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Güncel Gr</label>
                            <input v-model="guncelGrG"
                                   required
                                   @change="handleguncelGrG($event)"
                                   class="form-control" type="number" name="guncelGrG"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Brüt Kg</label>
                            <input v-model="basilanBrutKgG" disabled
                                   class="form-control" type="number" name="basilanBrutKgG"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="basilanBrutKgG" name="basilanBrutKgG" :value="basilanBrutKgG">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Net Adet</label>
                            <input v-model="basilanNetAdetG"
                                   required
                                   @change="handlebasilanNetAdetG($event)"
                                   class="form-control" type="number" name="basilanNetAdetG"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Basılan Net Kg</label>
                            <input v-model="basilanNetKgG" disabled
                                   class="form-control" type="number" name="basilanNetKgG"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="basilanNetKgG" name="basilanNetKgG" :value="basilanNetKgG">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kovan Sıcaklığı</label>
                            <input v-model="kovanSicaklikG"
                                   required
                                   @change="handlekovanSicaklikG($event)"
                                   class="form-control" type="number" name="kovanSicaklikG"
                                   step="0.001"
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kalıp Sıcaklığı</label>
                            <input v-model="kalipSicaklikG"
                                   @change="handlekalipSicaklikG($event)"
                                   class="form-control" type="number" name="kalipSicaklikG"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyet Sıcaklığı</label>
                            <input v-model="biyetSicaklikG"
                                   @change="handlebiyetSicaklikG($event)"
                                   class="form-control" type="number" name="biyetSicaklikG"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>hizG</label>
                            <input v-model="hizG"
                                   @change="handlehizG($event)"
                                   class="form-control" type="number" name="hizG"
                                   step="0.001" required
                                   placeholder="0,1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fire</label>
                            <input v-model="fireG" disabled
                                   class="form-control" type="number" name="fireG"
                                   step="0.001"
                                   placeholder="0,1">
                            <input type="hidden" v-model="fireG" name="fireG" :value="fireG">
                            <input type="hidden" name="baskiIdG" value="<?php echo $baskiId ?>">
                            <input type="hidden" name="siparisId" value="<?php echo $siparisId ?>">
                            <input type="hidden" name="takimId" value="<?php echo $takimId ?>">
                            <input type="hidden" name="satirNo" value="<?php echo $siparis['satirNo'] ?>">
                            <input type="hidden" name="baslaZamani" value="<?php echo $baski['baslaZamani'] ?>">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Takım Son Durum</label>

                            <select class="form-control select2" name="takimSonDurum"
                                    required
                                    id="takimSonDurum"
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Takım Son Durumu Seçiniz
                                </option>

                                <?php for ($i = 0; $i < count($takimSonDurum); $i++) { ?>
                                    <option <?php echo $baski['takimSonDurum'] == $takimSonDurum[$i] ? "selected" : "" ?>
                                            value="<?php echo $takimSonDurum[$i] ?>"><?php echo $takimSonDurum[$i] ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input required
                                   class="form-control" type="text" name="aciklama"
                                   placeholder="Açıklama Giriniz...">
                            <input type="hidden" v-model="baskiDurumG" :value="baskiDurumG" name="baskiDurumG">

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="isCheckG">
                        <div class="form-group">
                            <label>~~</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input v-model="baskiDurumG" type="checkbox" id="checkboxPrimary2">
                                    <label style="color: #0e84b5" :key="checkboxPrimary2" for="checkboxPrimary2">
                                        Sipariş Bitirilsin Mi
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!baskiDurumG" class="col-sm-4">
                        <div class="form-group">
                            <label>Baskı Sonlanma Nedeni</label>

                            <select class="form-control select2" name="sonlanmaNeden"
                                    :required="!baskiDurumG"
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
                        <button v-if="baskiBitirG" type="submit" name="baskiyariekle"
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

