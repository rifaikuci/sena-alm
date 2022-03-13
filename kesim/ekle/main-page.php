<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";


$kesimsql = "SELECT * FROM tblbaski where 0 >= kesimId and bitisZamani !='' AND 0 >= boyaId and  0 >= firinlamaId
 and  0 >= kromatId  and  0 >= naylonId  and  0 >= paketId  and  0 >= boyaPaketId  and  0 >= termikId";
$baskilar = $db->query($kesimsql);


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Kesim Alanı
        </div>
        <div class="card-body" id="kesim-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kesim/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row" v-if="baskiId > 0">
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
                                            <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                            {{profil}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> İstenilen Boy: </span>
                                            <span :style="[istenilenBoy == 3 || istenilenBoy == 6 ? { color :  '#000'} : {color :  '#ff2400'}]"> {{istenilenBoy}} </span>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Sipariş Türü: </span>
                                            {{siparisTur}}
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Termik Durumu: </span>
                                            {{istenilenTermik}}
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold">Net Adet: </span>
                                            {{basilanNetAdet}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label></label>
                            <select id="kesim_baski_id" name="baskiId" required class="form-control select2"
                                    style="width: 100%;">
                                <option selected disabled value="">Sipariş No</option>
                                <?php while ($baski = $baskilar->fetch_array()) {
                                    ?>
                                    <option
                                            value="<?php echo $baski['id']; ?>"><?php echo $baski['satirNo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kesilen Boy</label>
                            <input type="hidden" name="isSepet1Dolu" :value="isSepet1Dolu">
                            <input type="hidden" name="isSepet2Dolu" :value="isSepet2Dolu">
                            <input type="hidden" name="isSepet3Dolu" :value="isSepet3Dolu">
                            <input type="hidden" name="sepet1Adet" :value="sepet1Adet">
                            <input type="hidden" name="sepet2Adet" :value="sepet2Adet">
                            <input type="hidden" name="sepet3Adet" :value="sepet3Adet">
                            <input type="hidden" name="netAdet" :value="netAdet">
                            <input type="hidden" name="satirNo" :value="satirNo">
                            <input type="hidden" name="siparisId" :value="siparisId">
                            <input type="hidden" name="istenilenBoy" :value="istenilenBoy">
                            <input type="hidden" name="siparisTur" :value="siparisTur">
                            <input type="hidden" name="istenilenTermik" :value="istenilenTermik">
                            <input type="hidden" name="baskiId" :value="baskiId">
                            <input type="hidden" name="basilanNetAdet" :value="basilanNetAdet">
                            <input type="hidden" name="kesimekle" value="true">
                            <input type="hidden" name="sepet1" :value="sepet1">
                            <input type="hidden" name="sepet2" :value="sepet2">
                            <input type="hidden" name="sepet3" :value="sepet3">
                            <input required v-model="kesilenBoy" type="number" class="form-control form-control-lg"
                                   name="kesilenBoy"
                                   min="0.1" step="0.1"
                                   placeholder="0.1">
                            <span v-if="kesilenBoy && kesilenBoy > 0 && istenilenBoy != kesilenBoy" style="color: red">Kesilen Boy istenen boydan farklı</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input @input="() => {netAdet = basilanNetAdet - hurdaAdet}" v-model="hurdaAdet" required
                                   type="number" class="form-control form-control-lg" name="hurdaAdet"
                                   min="0.1" step="0.1"
                                   placeholder="0.1">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hurdaya Atılma Sebebi</label>
                            <select name="hurdaSebep" required class="form-control select2" style="width: 100%;">
                                <option selected disabled value="0">Sebep seçiniz</option>
                                <?php for ($i = 0; $i < count($hurdaSebep); $i++) { ?>
                                    <option value="<?php echo $hurdaSebep[$i] ?>"><?php echo $hurdaSebep[$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Net Adet</label>
                            <input type="text" v-model="netAdet" disabled
                                   class="form-control form-control-lg">
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sepet 1 </label>
                            <select v-model="sepet1" id="kesim_sepet1" class="form-control select2"
                                    style="width: 100%;">
                                <option selected disabled value="">Sepet</option>

                                <option v-for="sepet in sepetler1" :value="sepet.id">{{sepet.ad }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Adet </label>
                            <input type="number" v-model="sepet1Adet" placeholder="0"
                                   class="form-control form-control-lg">

                        </div>
                    </div>
                    <div class="col-sm-4" v-if=" sepet1Adet && sepet1Adet > 0  && adim != 'araba' ">
                        <div class="form-group">
                            <label>~~</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input v-model="isSepet1Dolu" type="checkbox" id="checkboxPrimary3"
                                           @input="()=> {

                                               isSepet1Dolu = !isSepet1Dolu}">
                                    <label style="color: #0e84b5" :key="checkboxPrimary3" for="checkboxPrimary3">
                                        Sepet 1 Doldu mu ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4" v-if="isSepet1Dolu">
                        <div class="form-group">
                            <label>Sepet 2 </label>
                            <select v-model="sepet2" id="kesim_sepet2" class="form-control" style="width: 100%;">
                                <option selected disabled value="">Sepet</option>

                                <option v-for="sepet in sepetler2" :value="sepet.id">{{sepet.ad }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="isSepet1Dolu">
                        <div class="form-group">
                            <label>Adet </label>
                            <input type="number" name="sepet2Adet" v-model="sepet2Adet" placeholder="0"
                                   class="form-control form-control-lg">

                        </div>
                    </div>
                    <div class="col-sm-4" v-if="isSepet1Dolu && sepet2Adet && sepet2Adet > 0">
                        <div class="form-group">
                            <label>~~</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input v-model="isSepet2Dolu" type="checkbox" id="checkboxPrimary1"
                                           @input="()=> {isSepet2Dolu = !isSepet2Dolu}">
                                    <label style="color: #0e84b5" :key="checkboxPrimary1" for="checkboxPrimary1">
                                        Sepet 2 Doldu mu ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4" v-if="isSepet1Dolu && isSepet2Dolu">
                        <div class="form-group">
                            <label>Sepet 3 </label>
                            <select v-model="sepet3" class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Sepet</option>

                                <option v-for="sepet in sepetler3" :value="sepet.id">{{sepet.ad }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="isSepet1Dolu && isSepet2Dolu ">
                        <div class="form-group">
                            <label>Adet </label>
                            <input type="number" name="sepet3Adet" v-model="sepet3Adet" placeholder="0"
                                   class="form-control form-control-lg">

                        </div>
                    </div>
                    <div class="col-sm-4" v-if="isSepet1Dolu && isSepet2Dolu && sepet3Adet && sepet3Adet > 0  ">
                        <div class="form-group">
                            <label>~~</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input v-model="isSepet3Dolu" type="checkbox" id="checkboxPrimary2"
                                           @input="()=> {isSepet3Dolu = !isSepet3Dolu}">
                                    <label style="color: #0e84b5" :key="checkboxPrimary2" for="checkboxPrimary2">
                                        Sepet 3 Doldu mu ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
