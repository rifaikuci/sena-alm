<?phpinclude "../../netting/baglan.php";include "../../include/sql.php";require_once "../../include/data.php";?><section class="content">    <div class="card card-info">        <div class="card-header">            Balyalama Alanı        </div>        <div class="card-body" id="balyalama-giris">            <form method="post" action="<?php echo base_url() . 'netting/balyalama/index.php' ?>"                  enctype="multipart/form-data">                <div class="row">                    <input type="hidden" name="baskiIds" v-model="baskiIds">                    <input type="hidden" name="netAdets" v-model="netAdets">                    <input type="hidden" name="netKilos" v-model="netKilos">                    <input type="hidden" name="siparisNos" v-model="siparisNos">                    <input type="hidden" name="toplamKilo" v-model="toplamKilo">                    <input type="hidden" name="mtGrs" v-model="mtGrs">                    <input type="hidden" name="paketDetays" v-model="paketDetays">                    <input type="hidden" name="realToleranss" v-model="realToleranss">                    <input type="hidden" name="teorikToleranss" v-model="teorikToleranss">                    <input type="hidden" name="satirNos" v-model="satirNos">                    <input type="hidden" name="anbarIds" v-model="anbarIds">                    <input type="hidden" name="musteriId" v-model="musteriId">                    <input type="hidden" value="balyalamaekle" name="balyalamaekle">                    <input type="hidden"                           value="<?php echo isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0; ?>"                           name="operatorId">                    <div v-for="(anbar,index) in anbarlar" class="col-sm-3">                        <div class="form-group">                            <button v-if="anbar.selected" type="button" class=" btn btn-block btn-info btn-lg "                                    @click=clickAnbar(anbar.id)>                                Sipariş: {{anbar.siparisNo}}<br>                                Satırı: {{anbar.satirNo}} <br>                                Müşteri: {{anbar.musteri}} <br>                                Adet: {{anbar.kalanAdet}} <br>                                Boy: {{anbar.boy}} <br>                                Krepe Kağıt: {{anbar.krepeKagit}} <br>                                Ara Kağıt: {{anbar.araKagit}}                            </button>                            <button v-if="!anbar.selected" type="button" class=" btn btn-block btn-secondary btn-lg "                                    @click=clickAnbar(anbar.id)>                                Sipariş: {{anbar.siparisNo}}<br>                                Satırı: {{anbar.satirNo}} <br>                                Müşteri: {{anbar.musteri}} <br>                                Adet: {{anbar.kalanAdet}} <br>                                Boy: {{anbar.boy}} <br>                                Krepe Kağıt: {{anbar.krepeKagit}} <br>                                Ara Kağıt: {{anbar.araKagit}}                            </button>                        </div>                    </div>                </div>                <div class="row" v-for="item in anbarlar" style="margin-top: 30px">                    <div class="col-sm-2" v-if="item.selected" >                        <div class="form-group">                            <label>Satır No</label>                            <input v-model="item.satirNo" disabled                                   type="text" class="form-control form-control-lg"                                   placeholder="Satın">                        </div>                    </div>                    <div class="col-sm-2" v-if="item.selected">                        <div class="form-group">                            <label>Net Adet</label>                            <input required v-model="item.netAdet"                                   @input="hesapla(item.id)"                                   type="number" step="1" class="form-control form-control-lg"                                   placeholder="1">                        </div>                    </div>                    <div class="col-sm-2" v-if="item.selected">                        <div class="form-group">                            <label>Net Kg</label>                            <input required v-model="item.netKilo"                                   @input="hesapla(item.id)"                                   type="number" step="0.001" class="form-control form-control-lg"                                   placeholder="Alınan Adet">                        </div>                    </div>                    <div class="col-sm-2" v-if="item.selected && item.mtGr != 0">                        <div class="form-group">                            <label>MT/Gr</label>                            <input disabled v-model="item.mtGr"                                   type="number" step="0.001" class="form-control form-control-lg"                                   placeholder="Alınan Adet">                        </div>                    </div>                    <div class="col-sm-2" v-if="item.selected && item.mtGr != 0">                        <div class="form-group">                            <label>Teorik Tolerans</label>                            <input disabled v-model="'% '+item.teorikTolerans"                                   :style="[item.teorikTolerans > 0  ? { color :  '#ff0000'} : {color :  '#3ea800'}]"                                   type="text" step="0.001" class="form-control form-control-lg"                                   placeholder="Alınan Adet">                        </div>                    </div>                    <div class="col-sm-2" v-if="item.selected && item.mtGr != 0">                        <div class="form-group">                            <label>Real Tolerans</label>                            <input disabled v-model="'% '+item.realTolerans"                                   :style="[item.realTolerans > 0  ? { color :  '#ff0000'} : {color :  '#3ea800'}]"                                   type="text" step="0.001" class="form-control form-control-lg"                                   placeholder="Alınan Adet">                        </div>                    </div>                    <div class="col-sm-12" v-if="item.selected && item.tamPaket != 0">                        <div class="form-group">                            <label>Paket Detay</label>                            <input disabled v-model="item.paketDetay"                                   type="text" class="form-control form-control-lg"                                   placeholder="0">                        </div>                    </div>                </div>                <hr>                <div class="row" v-if="anbarlar.filter(e => e.selected === true).length > 0">                    <div class="col-sm-2">                        <div class="form-group">                            <label>Toplam Kilo</label>                            <input disabled v-model="toplamKilo"                                   type="text" class="form-control form-control-lg"                                   placeholder="0">                        </div>                    </div>                    <div class="col-sm-2">                        <div class="form-group">                            <label>Balya Boy</label>                            <input required name="balyaBoy"                                   v-model="balyaBoy"                                   type="text" class="form-control form-control-lg"                                   placeholder="0">                        </div>                    </div>                </div>                <div class="card-footer">                    <div>                        <button v-if="anbarlar.filter(e => e.selected === true).length > 0 && kontrolKilo > 0  && balyaBoy > 0 "                                onclick="return confirm('Balyalama Tamamlanıyor?')"                                @click="bitir()"                                type="submit" class="btn btn-info float-right">Tamamla                        </button>                        <a href="../"                           class="btn btn-warning float-left">Vazgeç</a>                    </div>                </div>        </div>        </form>    </div></section>