<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

$firmasql = "SELECT * FROM tblfirma where firmaTurId =1 ";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Takım Ekleme Alanı
        </div>
        <div class="card-body" id="takim">
            <form method="post" action="<?php echo base_url() . 'netting/takim/index.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalıp Cinsi</label>
                            <select name="kalipCins" required @change="onChangeKalipCins($event)" class="form-control"
                                    style="width: 100%;">
                                <option selected value="">Kalıp Cinsi Seçiniz</option>
                                <option value="0">Köprülü</option>
                                <option value="1">Bindirmeli</option>
                                <option value="2">Solid</option>
                                <option value="3">Hazneli Solid</option>
                            </select>
                        </div>
                        <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        <input name="parca1SenaNo" :value="parca1SenaNo" type="hidden">
                        <input name="parca2SenaNo" :value="parca2SenaNo" type="hidden">
                        <input name="profilId" :value="profilId" type="hidden">
                        <input name="profil" :value="profil" type="hidden">
                        <input name="firmaId" :value="firmaId" type="hidden">
                        <input name="cap" :value="cap" type="hidden">
                        <input name="kalipCins" :value="kalipCins" type="hidden">
                    </div>
                    <div class="col-sm-6"></div>

                    <div v-if="label1" class="col-sm-12">
                        <br>
                        <div class="form-group">
                            <label>{{label1}} </label>
                            <br>
                            <button type="button" v-on:click="parca1ekle($event)"
                                    data-toggle="modal" class="btn btn-info">{{parca1SenaNo }}
                            </button>

                        </div>
                    </div>

                    <div v-if="label2" class="col-sm-12">
                        <br>
                        <div class="form-group">
                            <label>{{label2}} </label>
                            <br>
                            <button type="button" v-on:click="parca2ekle($event)"
                                    data-toggle="modal" class="btn btn-info">{{parca2SenaNo }}
                            </button>

                        </div>
                    </div>

                    <div v-if="profil" class="col-sm-3">
                        <br>
                        <div class="form-group">
                            <label>Profil : {{profil}} </label>

                        </div>
                    </div>

                    <div v-if="firmaAd" class="col-sm-3">
                        <br>
                        <div class="form-group">
                            <label>Firma : {{firmaAd}} </label>

                        </div>
                    </div>

                    <div v-if="cap" class="col-sm-3">
                        <br>
                        <div class="form-group">
                            <label>Çap : {{cap}}</label>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <br>
                        <div v-if="figur" class="form-group">
                            <label>Figür Sayısı : {{figur}} </label>

                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group clearfix">
                            <div style="text-align: center">
                                <div class="icheck-primary d-inline">
                                    <input @change="takimOnay()" type="checkbox" id="checkboxPrimary1">
                                    <label style="color: #0e84b5" for="checkboxPrimary1">
                                       Destek ve bolsterleri seçmek için tıklayınız
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group" >
                            <label>Bolster Seçiniz</label>
                            <div class="select2-blue">
                                <select required name="bolsterler[]" class="select2" multiple="multiple"
                                        data-dropdown-css-class="select2-blue"
                                        data-placeholder="Sena No - Firma Adı -Kalıpçı No - Kalite - Figür Sayı"
                                        style="width: 100%;">

                                    <option v-for="(bolster,index) in bolsterler" :value="bolster.id">
                                        {{bolster.senaNo}} - {{bolster.firmaAdi}} - {{bolster.cap}} - {{bolster.kalipciNo}} -  {{bolster.kalite}} - {{bolster.figurSayi}}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Destek Seçiniz</label>
                            <div class="select2-blue">
                                <select  required name="destekler[]" class="select2" multiple="multiple"
                                        data-dropdown-css-class="select2-blue"
                                        data-placeholder="Sena No - Firma Adı - Çap - Kalıpçı No - Kalite - Figür Sayı"
                                        style="width: 100%;">
                                        <option v-for="(destek,index) in destekler" :value="destek.id">
                                            {{destek.senaNo}} - {{destek.firmaAdi}} - {{destek.cap}} - {{destek.kalipciNo}} -  {{destek.kalite}} - {{destek.figurSayi}}
                                        </option>
                                </select>
                            </div>
                        </div>



                    <div class="card-footer">
                        <div>
                            <button v-if="ekle" type="submit" name="kalipciekle" class="btn btn-info float-right">Ekle
                            </button>
                            <a href="../"
                               class="btn btn-warning float-left">Vazgeç</a>
                        </div>
                    </div>


                    <div id="parca1modal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-xl">

                            <div class="modal-content">
                                <div style="margin: 10px">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </form>
        </div>

</section>
