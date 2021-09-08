<?php
include "../../netting/baglan.php";


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
                            <button type="button" data-target="#parca1modal" v-on:click="parca1ekle($event)"
                                    data-toggle="modal" class="btn btn-info">Parçayı Seç
                            </button>

                        </div>
                    </div>

                    <div v-if="label2" class="col-sm-12">
                        <br>
                        <div class="form-group">
                            <label>{{label2}} </label>
                            <br>
                            <button type="button" data-target="#parca2modal" v-on:click="parca2ekle($event)"
                                    data-toggle="modal" class="btn btn-info">Parçayı Seç
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
                                        Parçaları tamamladıktan sonra seçeneği işaretleyerek takım oluşturma işlemini
                                        tamamlayabilirsiniz.
                                    </label>
                                </div>
                            </div>
                        </div>
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
                </div
        </div>


        </form>
    </div>

</section>
