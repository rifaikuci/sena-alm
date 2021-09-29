<?php
include "../../netting/baglan.php";


$firmasql = "SELECT * FROM tblfirma where firmaTurId =24 ";
$firmalar = $db->query($firmasql);

$profillerrsql = "SELECT * FROM tblprofil";
$profiller = $db->query($profillerrsql);

$boyasql = "SELECT * FROM tblboya";
$boyalar = $db->query($boyasql);

$eloksalsql = "SELECT * FROM tbleloksal";
$eloksallar = $db->query($eloksalsql);

$alasimsql = "SELECT * FROM tblalasim";
$alasimlar = $db->query($alasimsql);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sipariş Ekleme Alanı
        </div>
        <div class="card-body" id="siparis-giris">
            <form method="post" action="<?php echo base_url() . 'netting/siparis/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Müşteri</label>
                            <select required name="musteriId" class="form-control">
                                <option selected disabled value="">Müşteri Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tarih</label>
                            <input disabled type="date" class="form-control form-control-lg" name="siparisTarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>

                </div>

                <br>
                <div class="row">

                    <p>
                        <span style="color: red">*</span> Adet veya Kilodan dilediğinizi girebilirsiniz.
                    </p>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title" style="color: #0e84b5;font-weight: bold">
                                    <i class="fas fa-list"></i>
                                    Sipariş Detayları
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Profiller</label>
                                            <select name="musteriId" class="form-control">
                                                <option selected disabled value="">Profil Seçiniz</option>
                                                <?php while ($profil = $profiller->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $profil['id']; ?>"><?php echo $profil['profilNo'] . "-" . $profil['profilAdi']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Boy</label>
                                            <input type="number" step="0.1" placeholder="0.1"
                                                   class="form-control form-control-lg" name="boy">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Adet</label>
                                            <input type="number" class="form-control form-control-lg" name="adet"
                                                   placeholder="1" step="1">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Kilo</label>
                                            <input step="0.1" placeholder="0.1" type="number"
                                                   class="form-control form-control-lg" name="kilo">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Sipariş Türü</label>
                                            <select name="siparisTuru" class="form-control">
                                                <option selected disabled value="">Sipariş Türü Seçiniz</option>
                                                <option value="Ham">Ham</option>
                                                <option value="Boyalı">Boyalı</option>
                                                <option value="Eloksal">Eloksal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Boyalar </label>
                                            <select name="boyaId" class="form-control">
                                                <option selected disabled value="">Boya Seçiniz</option>
                                                <?php while ($boya = $boyalar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $boya['id']; ?>"><?php echo $boya['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Eloksal </label>
                                            <select name="eloksalId" class="form-control">
                                                <option selected disabled value="">Eloksal Seçiniz</option>
                                                <?php while ($eloksal = $eloksallar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $eloksal['id']; ?>"><?php echo $eloksal['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Alaşımlar </label>
                                            <select name="alasimlId" class="form-control">
                                                <option selected disabled value="">Alaşım Seçiniz</option>
                                                <?php while ($alasim = $alasimlar->fetch_array()) { ?>
                                                    <option
                                                            value="<?php echo $alasim['id']; ?>"><?php echo $alasim['ad']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Termim Tarihi</label>
                                            <input type="date" class="form-control form-control-lg" name="termimTarih"
                                                   value="<?php echo date("Y-m-d", strtotime(date() . ' + 26 days')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Tolerans (%)</label>
                                            <input step="0.1" placeholder="0.1" type="number"
                                                   class="form-control form-control-lg" name="maxTolerans">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>~~</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input name="araKagit" type="checkbox" id="checkboxPrimary2">
                                                    <label style="color: #0e84b5" for="checkboxPrimary2">
                                                        Ara Kağıt
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>~~</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input name="krepKagit" type="checkbox" id="checkboxPrimary2">
                                                    <label style="color: #0e84b5" for="checkboxPrimary2">
                                                        Krep Kağıt
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Naylon</label>
                                            <select name="naylonDurum" class="form-control">
                                                <option selected disabled value="">Naylon Seçiniz</option>
                                                <option value="Baskılı">Baskılı</option>
                                                <option value="Baskısız">Baskısız</option>
                                                <option value="Yok">Yok</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Açıklama</label>
                                            <input required type="text" class="form-control form-control-lg"
                                                   name="aciklama"
                                                   placeholder="Açıklama Giriniz ">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="siparisekle" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
