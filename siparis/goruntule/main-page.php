<?php

if ($_GET['siparisno']) {

    $siparisNo = $_GET['siparisno'];
    include '../../netting/baglan.php';
    include "../../include/sql.php";
    require_once "../../include/helper.php";

    $sql = "SELECT * FROM tblsiparis WHERE siparisno = '$siparisNo' group by siparisNo";
    $result = mysqli_query($db, $sql);
    $detail = $result->fetch_assoc();

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

    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 0) {
        echo "<script>window.location.href='../index.php';</script>";
        exit();

    }

} ?>

<section class="content" id="siparis-guncelleme">
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group-sm">
                        <label style="color: #7f8c8d">Müşteri
                            Sipariş No: <?php echo $detail['siparisNo'] ?></label>
                        <br>
                        <label style="color: #7f8c8d">Müşteri
                            Adı: <?php echo firmaBul($detail['musteriId'], $db, 'firmaAd') ?></label>
                        <br>
                        <label style="color: #7f8c8d">Sipariş
                            Tarihi: <?php echo tarih($detail['siparisTarih']) ?></label>

                    </div>
                </div>
            </div>
            <div style="text-align: center" class="col-sm-12">
                <h4 style="color: deepskyblue">Siparişler</h4>
            </div>
            <div class="card-body table-responsive p-0">


                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Profil</th>
                        <th>Boy (mm)</th>
                        <th>Adet</th>
                        <th>Kilo</th>
                        <th>Alaşım</th>
                        <th>Termim T.</th>
                        <th>Tolerans</th>
                        <th>Ara K.</th>
                        <th>Krepe K.</th>
                        <th>Naylon</th>
                        <th>Açıklama</th>
                        <th>###</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(row,index) in arraySiparisler">
                        <td style="font-weight: bold;"
                            :style=" selectedRow!= null && index == selectedRow ? { color :  'green'} : {color :  'black'}"
                            @click="rowSelected(index)">{{row.satirNo}}
                        </td>
                        <td>{{row.profilAdi}}</td>
                        <td>{{row.boy}}</td>
                        <td>{{row.adet}}</td>
                        <td>{{row.kilo}}</td>
                        <td>{{row.alasimAd}}</td>
                        <td>{{row.tabloTarih}}</td>
                        <td>% {{row.maxTolerans}}</td>
                        <td>{{row.araKagitAd}}</td>
                        <td>{{row.krepeKagitAd}}</td>
                        <td>{{row.naylonAd}}</td>
                        <td>{{row.aciklama}}</td>
                        <td><a onclick="return confirm('Silmek istediğinizden emin misiniz?')"
                               :href="row.silmeLinki" class="btn btn-outline-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card card-info" v-if="selectedRow != null">
        <div class="row">
            <div class="col-md-6" >
                    <div style="text-align: right; margin: 5px"  >
                        <h5 style="color: #2b6b4f">Sipariş Detayı</h5>
                    </div>
            </div>

            <div class="col-md-5">
                <div style="text-align: center;padding: 5px">
                    <div style="text-align: right">
                        <button style="margin: 5px" @click="trashrow()" class="btn btn-outline-danger" > <i class="fa fa-trash"></i>  Temizle
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>No</label>
                                    <input v-model="siparis.satirNo" type="text"
                                           class="form-control form-control-lg"
                                          disabled>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Profiller</label>
                                    <select @change="profilOnChange($event)" v-model="siparis.profil"
                                            name="profilId" class="form-control">
                                        <option selected disabled value="">Profil Seçiniz</option>
                                        <?php while ($profil = $profiller->fetch_array()) { ?>
                                            <option
                                                    value="<?php echo $profil['id'] . ";" . $profil['profilNo'] . "-" . $profil['profilAdi'] ?>"><?php echo $profil['profilNo'] . "-" . $profil['profilAdi']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Boy</label>
                                    <input v-model="siparis.boy" type="number" placeholder="1 mm"
                                           @input="checkBoy($event)"
                                           class="form-control form-control-lg" name="boy">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Adet</label>
                                    <input :disabled="adetDisabled" v-model="siparis.adet" type="number"
                                           class="form-control form-control-lg" name="adet"
                                           @input="checkAdet($event)"
                                           placeholder="1" step="1">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kilo</label>
                                    <input :disabled="kiloDisabled" v-model="siparis.kilo" step="0.1"
                                           placeholder="0.1 kg" type="number"
                                           @input="checkKilo($event)"
                                           class="form-control form-control-lg" name="kilo">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Sipariş Türü</label>
                                    <select @change="onChangeSiparis($event)" v-model="siparis.siparisTur"
                                            name="siparisTur" class="form-control">
                                        <option selected disabled value="">Sipariş Türü Seçiniz</option>
                                        <option value="Ham">Ham</option>
                                        <option value="Boyalı">Boyalı</option>
                                        <option value="Eloksal">Eloksal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3" v-if="isBoya">
                                <div class="form-group">
                                    <label>Boyalar </label>
                                    <select v-model="siparis.boyaId" name="boyaId" class="form-control">
                                        <option selected disabled value="">Boya Seçiniz</option>
                                        <?php while ($boya = $boyalar->fetch_array()) { ?>
                                            <option
                                                    value="<?php echo $boya['id']; ?>"><?php echo $boya['ad']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3" v-if="isEloksal">
                                <div class="form-group">
                                    <label>Eloksal </label>
                                    <select v-model="siparis.eloksalId" name="eloksalId" class="form-control">
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
                                    <select v-model="siparis.alasim" name="alasimlId" class="form-control"
                                            @change="alasimOnChange($event)">
                                        <option selected disabled value="">Alaşım Seçiniz</option>
                                        <?php while ($alasim = $alasimlar->fetch_array()) { ?>
                                            <option
                                                    value="<?php echo $alasim['id'] . ";" . $alasim['ad']; ?>"><?php echo $alasim['ad']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Termim Tarihi</label>
                                    <input v-model="siparis.termimTarih" type="date"
                                           class="form-control form-control-lg" name="termimTarih">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tolerans (%)</label>
                                    <input v-model="siparis.maxTolerans" placeholder="1 (%)" type="number"
                                           @input="checkTolerans($event)"
                                           class="form-control form-control-lg" name="maxTolerans">
                                    <span v-if="errorShow" style="color: red" class="help-block"> Mevcut Kalıplar ile istenilen tolerans yakalanamaz. </span>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>~~</label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input v-model="siparis.araKagit" name="araKagit" type="checkbox"
                                                   id="checkboxPrimary1"
                                                   @input="checkKagit()">
                                            <label style="color: #0e84b5" for="checkboxPrimary1">
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
                                            <input v-model="siparis.krepeKagit" name="krepeKagit"
                                                   type="checkbox" id="checkboxPrimary2"
                                                   @input="checkKagit()">
                                            <label style="color: #0e84b5" for="checkboxPrimary2">
                                                Krepe Kağıt
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Naylon</label>
                                    <select v-model="siparis.naylonId" name="naylonDurum" class="form-control">
                                        <option selected disabled value="">Naylon Seçiniz</option>
                                        <option value="1">Baskılı</option>
                                        <option value="2">Baskısız</option>
                                        <option value="3">Yok</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Açıklama</label>
                                    <input v-model="siparis.aciklama" type="text"
                                           class="form-control form-control-lg" name="aciklama"
                                           @input="checkAciklama($event)"
                                           placeholder="Açıklama Giriniz ">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div style="text-align: right">
                                    <button @click="guncelle($event)"  class="btn btn-dark float-right">Güncelle
                                    </button>
                                </div>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>
