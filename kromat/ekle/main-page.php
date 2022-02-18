<?php
include "../../netting/baglan.php";
include "../../include/sql.php";

$sepetsql = "SELECT * FROM tblsepet where  (durum =  2 and isTermik != '1' and icindekiler != '' and tur = 'termik') or  (tur = 'kromat' and icindekiler != '')";
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

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Sepet</label>
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
                            <input type="hidden" name="arraykesim[]"  v-model="kesimlerId">
                            <input type="hidden" name="arrayadet[]"  v-model="adetler">
                            <input type="hidden" name="arrayhurda[]"  v-model="hurdaAdetler">
                            <input type="hidden" name="arraysebep[]"  v-model="sebepler">
                            <input type="hidden" name="operatorId"  value="<?php echo $_SESSION['operatorId']?>">
                        </div>
                    </div>


                    <div class="col-sm-8">
                        <div class="form-group">
                            <label></label>
                            <select required name="sepetler[]" id="kromat_sepet" class="select2" multiple="multiple"
                                    data-dropdown-css-class="select2-gray"
                                    data-placeholder="Sepet - Kesim -  Adet "
                                    style="width: 100%;">
                                <option disabled value="">Sepet - Kesim - Adet</option>
                                <?php while ($sepet = $sepetler->fetch_array()) {
                                    $icindekiler = rtrim($sepet['icindekiler'], ";");
                                    $icindekiler = explode(";", $icindekiler);
                                    $adetler = rtrim($sepet['adetler'], ";");
                                    $adetler = explode(";", $adetler);

                                    for ($i = 0; $i < count($icindekiler); $i++) {
                                        ?>
                                        <option value="<?php echo $sepet['id'] . ";" . $icindekiler[$i] . ";" . $adetler[$i] ?>"> <?php echo $sepet['ad'] . " - " . $icindekiler[$i] . " - " . $adetler[$i] ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div v-if="kesimler" class="col-sm-12" style="margin: 30px">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d">Sepet Bilgileri</h3>
                        </div>
                    </div>
                </div>

                <div class="row" v-for="kesim in kesimler">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kromata Gönderilecek Adet</label>
                            <input required v-model="kesim.adet"
                                   type="number" class="form-control form-control-lg"
                                   min="0.1" step="0.1"
                                   placeholder="0.1">
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input required v-model="kesim.hurdaAdet"
                                   type="number" class="form-control form-control-lg"
                                   min="0" step="0.1"
                                   placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-4" v-if="kesim.hurdaAdet > 0 ">
                        <div class="form-group">
                            <label>Hurdaya Atılma Sebebi</label>
                            <select :required="kesim.hurdaAdet > 0" v-model="kesim.sebep" class="form-control"
                                    style="width: 100%;">
                                <option selected value=""> Sebep Seçiniz</option>
                                <option value="ezik var">Ezik Var</option>
                                <option value="boy kurtarmadı">Boy Kurtarmadı</option>
                                <option value="delik var">Delik Var</option>
                                <option value="eksenel yamuk">Eksenel Yamuk</option>
                                <option value="olcu uygunsuz">Ölçü Uygunsuz</option>
                                <option value="yüzey lekeli">Yüzey Lekeli</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button  v-on:click="kromatekle" type="submit" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
