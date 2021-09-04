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
                    </div>
                    <div class="col-sm-6"></div>

                    <div v-if="label1" class="col-sm-3">
                        <br>
                        <br>
                        <div class="form-group">
                            <label>{{label1}} </label>
                            <br>
                                <button type="button" data-target="#parca1modal" v-on:click="parca1ekle($event)" data-toggle="modal"  class="btn btn-info">Parçayı Seç</button>

                        </div>
                    </div>

                    <div v-if="label2" class="col-sm-3">
                        <br>
                        <br>
                        <div class="form-group">
                            <label>{{label2}} </label>
                            <br>
                                <button class="btn btn-info">Parçayı Seç</button>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="kalipciekle" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        <!-- Parça 1  -->
        <div id="parca1modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">

                <!-- Modal content-->
                <div class="modal-content">
                    <div style="margin: 10px">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div style="text-align: center">
                        <h4 style="color: #0e84b5">
                            Parçalar
                        </h4>
                    </div>

                    <div class="modal-body"></div>
                </div>

            </div>
        </div



        </form>
    </div>

</section>
