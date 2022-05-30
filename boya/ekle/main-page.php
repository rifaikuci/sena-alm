<?phpinclude "../../netting/baglan.php";include "../../include/sql.php";require_once "../../include/data.php";$sepetsql = "SELECT * FROM tblsepet where  ( icindekiler != '' and tur = 'kromatS' and finishedKromat = '1')";$sepetler = $db->query($sepetsql);$boyasql = "SELECT * FROM tblstokboya where  kalan > 0 order by kalan asc";$boyalar = $db->query($boyasql);$siklonsql = "SELECT * FROM tblsiklon where  kalan > 0 order by kalan asc";$siklonlar = $db->query($siklonsql);$rutussql = "SELECT * FROM tblrutusprofil where  kalan > 0 order by kalan asc";$rutuslar = $db->query($rutussql);// kürlenme dakikası ve  fırım sıcaklığı çılarılacak //?><section class="content">    <div class="card card-info">        <div class="card-header">            Boyanma (Fırınlama) Alanı        </div>        <div class="card-body" id="boya-giris">            <form method="post" action="<?php echo base_url() . 'netting/boya/index.php' ?>"                  enctype="multipart/form-data">                <div class="row">                    <div class="col-sm-6">                        <div class="form-group">                            <label>Baskılar</label>                            <select required id="boyanma_sepet" class="select2"                                    data-dropdown-css-class="select2-gray"                                    data-placeholder="Sepet - Baskı -  Adet "                                    style="width: 100%;">                                <option selected value="0">Sepet - Baskı - Adet</option>                                <?php while ($sepet = $sepetler->fetch_array()) {                                    $icindekiler = rtrim($sepet['icindekiler'], ";");                                    $icindekiler = explode(";", $icindekiler);                                    $adetler = rtrim($sepet['adetler'], ";");                                    $adetler = explode(";", $adetler);                                    for ($i = 0; $i < count($icindekiler); $i++) {                                        $baskiId = $icindekiler[$i];                                        $baski =  tablogetir("tblbaski", 'id', $baskiId, $db);                                        $siparisId = $baski['siparisId'];                                        $siparis = tablogetir('tblsiparis', 'id', $siparisId, $db);                                        $profilId = $siparis['profilId'];                                        $satirNo = $siparis['satirNo'];                                        ?>                                        <option value="<?php echo $sepet['id']  . ";" . $satirNo  . ";" . $baskiId  . ";" . $profilId?>">                                            <?php echo $sepet['ad'] . " - " . $icindekiler[$i] . " - " . $adetler[$i] ?></option>                                    <?php }                                } ?>                            </select>                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Alınan Adet</label>                            <input v-model="boyanma.adet"                                   @input="dataKontrol($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Hurda Adet</label>                            <input                                   v-model="boyanma.hurdaAdet"                                   @input="dataKontrol($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2" v-if="boyanma.hurdaAdet && boyanma.hurdaAdet > 0">                        <div class="form-group">                            <label>Hurda Sebebi</label>                            <select class="form-control"                                    v-model="boyanma.hurdaSebep"                                    style="width: 100%;">                                <option selected value=""> Sebep Seçiniz</option>                                <?php for ($i = 0; $i < count($hurdaSebep); $i++) { ?>                                    <option value="<?php echo $hurdaSebep[$i] ?>"><?php echo $hurdaSebep[$i] ?></option>                                <?php } ?>                            </select>                        </div>                    </div>                    <div class="col-md-12">                        <div class="form-group">                            <button :disabled="!boyanmaData" v-on:click="ekle" class="btn btn-success float-right">                                Boya Al                            </button>                        </div>                    </div>                    <br>                    <br>                    <div v-if="array.length > 0" style="text-align: center" class="col-sm-12">                        <h4 style="color: deepskyblue">Alınan Malzemeler</h4>                    </div>                    <div v-if="array.length > 0"   class="card-body table-responsive p-0">                        <table class="table table-hover text-nowrap">                            <thead>                            <tr>                                <th>Sepet No</th>                                <th>Baskı Id</th>                                <th>Satır No</th>                                <th>Profil No</th>                                <th>Alınan Adet</th>                                <th>Hurda Adet</th>                                <th>Hurda Sebep</th>                                <th>İşlem</th>                            </tr>                            </thead>                            <tbody>                            <tr v-for="(row,index) in array">                                <td>{{row.sepetId}}</td>                                <td>{{row.baskiId}}</td>                                <td>{{row.satirNo}}</td>                                <td>{{row.profilId}}</td>                                <td>{{row.adet}}</td>                                <td>{{row.hurdaAdet}}</td>                                <td>{{row.hurdaSebep}}</td>                                <td><a style="color: white" v-on:click="sil(index)"                                       class="btn btn-danger">Sil</a></td>                            </tr>                            </tbody>                        </table>                    </div>                    <div class="col-sm-12">                        <div style="text-align: center">                            <h3 style="color: #0c525d">                                Bilgiler                            </h3>                        </div>                    </div>                    <input type="hidden" name="boyabaslat" value="boyabaslat">                    <input type="hidden" name="sepetId" :value="sepetId">                    <input type="hidden" name="array" :value="array">                    <input type="hidden" name="arraySepetId" :value="arraySepetId">                    <input type="hidden" name="arraySatirNo" :value="arraySatirNo">                    <input type="hidden" name="arrayBaskiId" :value="arrayBaskiId">                    <input type="hidden" name="arrayProfilId" :value="arrayProfilId">                    <input type="hidden" name="arrayAdet" :value="arrayAdet">                    <input type="hidden" name="arrayHurdaAdet" :value="arrayHurdaAdet">                    <input type="hidden" name="arrayHurdaSebep" :value="arrayHurdaSebep">                    <input type="hidden" name="topAdet" :value="topAdet">                    <input type="hidden" name="ortAskiAdet" :value="ortAskiAdet">                    <input type="hidden" name="netBoya" :value="netBoya">                    <input type="hidden" name="operatorId" value="<?php echo $_SESSION['operatorId'] ?>">                    <div class="col-sm-4">                        <div class="form-group">                            <label>Boyalar</label>                            <select required name="boyaId" class="select2"                                    data-dropdown-css-class="select2-blue"                                    data-placeholder="Boya Seçiniz"                                    style="width: 100%;">                                <option selected value="">Barkod - Parti No - Boya Türü - Cins - Kilo/Kalan</option>                                <?php while ($boya = $boyalar->fetch_array()) {?>                                <option value="<?php echo $boya['id']?>">                                    <?php echo $boya['barkodNo'] . " - ". $boya['partino'] ?>                                </option>                                <?php } ?>                            </select>                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Kullanılan Boya</label>                            <input required name="kullanilanBoya"                                   v-model="kullanilanBoya"                                   @input="changeBoya($event)"                                   class="form-control"                                   type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-4">                        <div class="form-group">                            <label>Siklon Boya</label>                            <select name="siklonId" class="select2" id="boya_siklon_giris"                                    data-dropdown-css-class="select2-blue"                                    data-placeholder="Siklon Boya Seçiniz"                                    style="width: 100%;">                                <option value="0" selected>Barkod - Parti No - Cins - Kalan</option>                                <?php while ($siklon = $siklonlar->fetch_array()) {                                    $tempboya = tablogetir("tblstokboya", "id", $siklon['boyaId'], $db);                                    ?>                                    <option value="<?php echo $siklon['id'] ?>"> <?php echo $tempboya['barkodNo'] . " - " . $tempboya['partino'] . " - " . $tempboya['cins'] . " - " . $tempboya['kalan'] ?></option>                                <?php } ?>                            </select>                        </div>                    </div>                    <div class="col-sm-2" v-if="siklonId > 0">                        <div class="form-group">                            <label>S. Altı Kullanılan Boya (KG)</label>                            <input name="siklonKullanilanKg"                                   v-model="siklonKullanilanKg"                                   @input="changeBoya($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Askı Tipi</label>                            <select required name="askiId" class="select2"                                    data-dropdown-css-class="select2-blue"                                    data-placeholder="Askı Seçiniz "                                    style="width: 100%;">                                <option selected value="0">Seçiniz</option>                                <?php for ($i = 0; $i < count($askilar); $i++) { ?>                                    <option value="<?php echo $askilar[$i] ?>"><?php echo $askilar[$i] ?></option>                                <?php } ?>                            </select>                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Rutuş Profil</label>                            <select name="rutusId" class="select2" id="boya_rutus_id"                                    data-dropdown-css-class="select2-blue"                                    data-placeholder="Rutuş Profil"                                    style="width: 100%;">                                <option selected value="0">Seçiniz</option>                                <?php while ($rutus = $rutuslar->fetch_array()) {                                    $profil = tablogetir("tblprofil", 'id', $rutus['profilId'], $db);                                    $profil = $profil['profilAdi'] + " - " + $profil['profilNo'] ?>                                    <option value="<?php echo $rutus['id'] ?>"><?php echo $profil + " - " + $rutus['kalan'] ?></option>                                <?php } ?>                            </select>                        </div>                    </div>                    <div class="col-sm-2" v-if="rutusId > 0">                        <div class="form-group">                            <label>Rutuş Adet</label>                            <input name="rutusAdet"                                   v-model="rutusAdet"                                   @input="tophesapla($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>S. Altına Ayrılan Boya (KG)</label>                            <input name="siklonAyrilanKg"                                   v-model="siklonAyrilanKg"                                   @input="changeBoya($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Net Boya (KG)</label>                            <input v-model="netBoya"                                   disabled                                   class="form-control" type="text"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Top. Askı</label>                            <input name="topAski"                                   v-model="topAski"                                   required                                   @input="changeTopAski($event)"                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Top. Adet</label>                            <input v-model="topAdet"                                   disabled                                   class="form-control" type="number"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Ort. Askı Adet</label>                            <input v-model="ortAskiAdet"                                   disabled                                   class="form-control"                                   placeholder="0">                        </div>                    </div>                </div>                <div class="card-footer">                    <div>                        <button onclick="return confirm('Boyanma Başlatılıyor?')"                                type="submit" class="btn btn-info float-right">Başlat                        </button>                        <a href="../"                           class="btn btn-warning float-left">Vazgeç</a>                    </div>                </div>        </div>        </form>    </div></section>