<?php
include "../../netting/baglan.php";
include "../../include/data.php";


$firmasql = "SELECT * FROM tblfirma  ";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);

#todo burada kaldık.
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Parça Ekleme Alanı
        </div>
        <div class="card-body" id="kalip-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kalipci/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <select name="firmaId" required class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Firma Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalıp Cinsi</label>
                            <select name="kalipCins" required @change="onChangeKalipCins($event)" class="form-control"
                                    style="width: 100%;">
                                <option selected value="">Kalıp Cinsi Seçiniz</option>
                                <option value="0">Köprülü</option>
                                <option value="1">Bindirmeli</option>
                                <option value="2">Solid</option>
                                <option value="3">Hazneli</option>
                                <option value="4">Bolster</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6" v-if="filterParca.length > 0 ? true : false">
                        <input name="prefix" :value="prefix" type="hidden">
                        <div class="form-group">
                            <label>Parça</label>
                            <select @change="onChangeParca($event)" name="parca"
                                    :required="filterParca.length > 0 ? true : false" class="form-control"
                                    style="width: 100%;">
                                <option selected value="">Parça Seçiniz</option>
                                <option v-for="parca in filterParca" v-bind:value="parca.id">{{parca.name}}</option>
                            </select>
                        </div>
                    </div>


                    <div v-if="kalipCins == 4  ? false : true && ['0', '1', '3', '4','6','7','9'].includes(parca) "
                         class="col-sm-6">
                        <div class="form-group">
                            <label>Profiller</label>
                            <select name="profilId"
                                    class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Profil Seçiniz</option>
                                <?php while ($profil = $profiller->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $profil['id']; ?>"><?php echo $profil['profilNo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalıpçı No</label>
                            <input required type="text" class="form-control form-control-lg" name="kalipciNo"
                                   placeholder="Kalıpçı No giriniz..">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Çap</label>
                            <select name="cap" required class="form-control" style="width: 100%;">
                                <option selected value="">Çap Seçiniz</option>
                                <option v-for="cap in caplar" v-bind:value="cap.id">{{cap.id}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Boy (mm)</label>
                            <input required type="number" class="form-control form-control-lg" name="boy" min="1"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kalite</label>
                            <select name="kalite" required class="form-control" style="width: 100%;">
                                <option selected value="">Kalite</option>
                                <?php for ($i = 0; $i < count($kaliteler); $i++) { ?>
                                    <option value="<?php echo $kaliteler[$i] ?>"><?php echo $kaliteler[$i] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Figür Sayı</label>
                            <input required type="number" class="form-control form-control-lg" name="figurSayi" min="1"
                                   max="10"
                                   placeholder="1">
                        </div>
                    </div>

                    <div class="col-sm-6" v-if="kalipCins == 4">
                        <div style="text-align: center">
                            <div class="form-group">
                                <label>Çizim Yükleyiniz...</label>
                                <input required type="file" name="cizim">
                            </div>
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


        </form>
    </div>

</section>
