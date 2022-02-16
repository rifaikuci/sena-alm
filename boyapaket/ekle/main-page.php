<?php
include "../../netting/baglan.php";
include "../../include/sql.php";

$boyaSql = "SELECT * FROM tblboya where isFirin = '1' and isPaket = '0'";
$boyaSepet = $db->query($boyaSql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boya Paket Alanı
        </div>
        <div class="card-body" id="boya-paket">
            <form method="post" action="<?php echo base_url() . 'netting/boyapaket/index.php' ?>">
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
                                            <span style="color: darkcyan; font-weight: bold"> Boyanan Adet: </span>
                                            {{topAdet}}
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Paket Iç Adet: </span>
                                            {{paketIcAdet}}
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Koruma Bandı: </span>
                                            {{korumaBandiAd}}
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Ara Kağıt: </span>
                                            {{araKagitAd}}
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-8">
                                        <h3 style="color: red">
                                            {{paketAciklama}}
                                        </h3>
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
                            <select required name="boyaId" class="select2"
                                    id="boya-paket-giris"
                                    data-dropdown-css-class="select2-blue"
                                    data-placeholder="Paketlenecek Ürünü Seçiniz "
                                    style="width: 100%;">
                                <option selected value="0">Satır No - Toplam Adet - Kesim No</option>
                                <?php while ($boya = $boyaSepet->fetch_array()) {
                                    $kesimId = $boya['kesimId'];
                                    $baskiId = tablogetir('tblkesim', 'id', $kesimId, $db)['baskiId'];
                                    $siparisId = tablogetir('tblbaski', 'id', $baskiId, $db)['siparisId'];
                                    $siparis = tablogetir('tblsiparis', 'id', $siparisId, $db);
                                    $satirNo = $siparis['satirNo'];
                                    $koruma = $siparis['korumaBandi'];
                                    $value = $satirNo . " - " . $boya['topAdet'] . " - " . $kesimId;
                                    $key = $kesimId . ";" . $baskiId . ";" . $siparisId . ";" . $boya['topAdet'] . ";" . $koruma. ";". $boya['id'] ?>
                                    <option value="<?php echo $key ?>"> <?php echo $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input name="hurdaAdet"
                                   v-model="hurdaAdet"
                                   @change="netAdetCalculate($event)"
                                   class="form-control" type="number"
                                   placeholder="0">
                            <input type="hidden" name="operatorId" value="<?php echo $_SESSION['operatorId'] ?>">
                            <input name="boyapaketbaslat" value="boyapaketbaslat" type="hidden">
                            <input type="hidden" name="netAdet" :value="netAdet">
                            <input type="hidden" name="kesimId" :value="kesimId">
                            <input type="hidden" name="baskiId" :value="baskiId">
                            <input type="hidden" name="profilId" :value="profilId">
                            <input type="hidden" name="satirNo" :value="satirNo">
                            <input type="hidden" name="boyaId" :value="boyaId">

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="hurdaAdet && hurdaAdet > 0">
                        <div class="form-group">
                            <label>Hurda Sebebi</label>
                            <select class="form-control"
                                    name="hurdaSebep"
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

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Rutuş Adet</label>
                            <input name="rutusAdet"
                                   v-model="rutusAdet"
                                   @change="netAdetCalculate($event)"
                                   class="form-control" type="number"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2" v-if="rutusAdet && rutusAdet > 0">
                        <div class="form-group">
                            <label>Rütuş Sebebi</label>
                            <select class="form-control"
                                    name="rutusSebep"
                                    style="width: 100%;">
                                <option selected value=""> Sebep Seçiniz</option>
                                <option value="Rutuş 1">Rutuş 1</option>
                                <option value="Rutuş 2">Rutuş 2</option>
                                <option value="Rutuş 3">Rutuş 3</option>
                                <option value="Rutuş 4">Rutuş 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Net Adet</label>
                            <input v-model="netAdet"
                                   disabled
                                   class="form-control" type="number"
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button  v-on:click="bitir($event)" type="submit"
                                class="btn btn-info float-right">Ekle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
