<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

$sepetsql = "
SELECT * FROM tblsepet where  (durum =  2 and isTermik != '1' and icindekiler != '' and tur = 'termik') or  (tur = 'kromat' and icindekiler != '')
";
$sepetler = $db->query($sepetsql);

$kromatSql = "SELECT * FROM tblsepet where tur = 'kromatS' AND durum = 0";
$kromatSepet = $db->query($kromatSql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kromat Alanı
        </div>
        <div class="card-body" id="kromat-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kromat/index.php' ?>">

                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kromat Sepetleri</label>
                            <select required name="kromatSepet" class="select2"
                                    data-dropdown-css-class="select2-blue"
                                    data-placeholder="Sepet "
                                    style="width: 100%;">
                                <option disabled selected value="">Sepet</option>
                                <?php while ($kromat = $kromatSepet->fetch_array()) { ?>
                                    <option value="<?php echo $kromat['id'] ?>"> <?php echo $kromat['ad'] ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="kromatbaslat" value="kromatbaslat">
                            <input type="hidden" name="arraysepet[]" v-model="sepetler">
                            <input type="hidden" name="arraybaski[]" v-model="baskilarId">
                            <input type="hidden" name="arrayadet[]" v-model="adetler">
                            <input type="hidden" name="arrayhurda[]" v-model="hurdaAdetler">
                            <input type="hidden" name="arraysebep[]" v-model="sebepler">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>


                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Sepet - Satır No - Profil No - Profil Adi - Profil Boy - Rengi - Adet </label>
                            <select required name="sepetler[]" id="kromat_sepet" class="select2" multiple="multiple"
                                    data-dropdown-css-class="select2-gray"
                                    data-placeholder="Sepet - Satır No - Profil No - Profil Adı - Profil Boy - Rengi - Adet "
                                    style="width: 100%;">
                                <option disabled value="">Sepet - Baskılar - Adet</option>
                                <?php while ($sepet = $sepetler->fetch_array()) {
                                    $icindekiler = rtrim($sepet['icindekiler'], ";");
                                    $icindekiler = explode(";", $icindekiler);
                                    $adetler = rtrim($sepet['adetler'], ";");
                                    $adetler = explode(";", $adetler);

                                    for ($i = 0; $i < count($icindekiler); $i++) {
                                        $baskiId= $icindekiler[$i];
                                        $sqltemp = "SELECT b.satirNo, profilNo, profilAdi, boy, pr.ad,siparisTuru FROM tblbaski b
                                                        LEFT JOIN tblsiparis s on b.siparisId = s.id
                                                        LEFT JOIN tblprofil p on p.id = s.profilId
                                                        LEFT JOIN tblprboya pr on pr.id = s.boyaId  where b.id = '$baskiId'";
                                        $temp = mysqli_query($db, $sqltemp)->fetch_assoc();


                                        if ($temp['siparisTuru'] == "B") { ?>

                                            <option value="<?php echo $sepet['id'] . ";" . $icindekiler[$i] . ";" . $adetler[$i] ?>">
                                                <?php echo $sepet['ad'] . " - " . $temp['satirNo'] . " - ". $temp['profilNo'] . " - " .
                                                    $temp['profilAdi'] . " - " . $temp['boy'] . " - " . $temp['ad']  . " - " . $adetler[$i] ?>
                                            </option>
                                        <?php }
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div v-if="baskilar" class="col-sm-12" style="margin: 30px">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d">Sepet Bilgileri</h3>
                        </div>
                    </div>
                </div>

                <div class="row" v-for="(baski,index) in baskilar">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kromata Gönderilecek Adet</label>
                            <input required v-model="baski.adet"
                                   type="number" class="form-control form-control-lg"
                                   min="0" step="1"
                                   @input="calculate($event,baski,index)"
                                   :max ="baski.sepetAdet-baski.hurdaAdet"
                                   placeholder="0">
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input v-model="baski.hurdaAdet"
                                   @input="calculate($event,baski,index)"
                                   :max ="baski.sepetAdet-baski.adet"
                                   type="number" class="form-control form-control-lg" min="0"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4" v-if="baski.hurdaAdet > 0 ">
                        <div class="form-group">
                            <label>Hurdaya Atılma Sebebi</label>
                            <select :required="baski.hurdaAdet && baski.hurdaAdet > 0" v-model="baski.sebep" class="form-control"
                                    style="width: 100%;">
                                <option selected value="0"> Sebep Seçiniz</option>
                                <?php for ($i = 0; $i < count($hurdaSebep); $i++) { ?>
                                    <option value="<?php echo $hurdaSebep[$i] ?>"><?php echo $hurdaSebep[$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="baski.isEkle">
                        <div style="text-align: center">
                            <label style="color: red;margin-top: 35px">Verileri kontrole ediniz.</label>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button :disabled="!isBitir" v-on:click="kromatekle" type="submit" class="btn btn-info float-right">Başlat</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
