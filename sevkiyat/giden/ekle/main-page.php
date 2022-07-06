<?php
include "../../../netting/baglan.php";
include "../../../include/data.php";

$personelsql = "SELECT * FROM tblpersonel where rolId = 10 AND isecikistarih = '0000-00-00 00:00:00' ";
$personeller = $db->query($personelsql);

$personelsql2 = "SELECT * FROM tblpersonel where rolId = 10 AND isecikistarih = '0000-00-00 00:00:00' " ;
$personeller2 = $db->query($personelsql2);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sevkiyat Gönderim Ekleme Alanı
        </div>
        <div class="card-body" id="stok-cikis">
            <form method="post" action="<?php echo base_url() . 'netting/sevkiyat/giden.php' ?>">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>1. Şoför</label>
                            <select required name="personelId1" class="form-control select2" style="width: 100%;">
                                <option selected value="">Personel 1</option>
                                <?php while ($personel = $personeller->fetch_array()) { ?>
                                    <option value="<?php echo $personel['id']; ?>"><?php echo $personel['adsoyad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>2. Şoför</label>
                            <select name="personelId2" class="form-control select2" style="width: 100%;">
                                <option selected value="0">2. Şoför Seçiniz</option>
                                <?php while ($personel2 = $personeller2->fetch_array()) { ?>
                                    <option value="<?php echo $personel2['id']; ?>"><?php echo $personel2['adsoyad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Plaka</label>
                            <input required type="text" class="form-control form-control-lg" name="plaka"
                                   placeholder="Plaka Bilgisi ">
                            <input type="hidden" value="sevkiyatcikisekle" name="sevkiyatcikisekle">
                            <input type="hidden" name="balyalaArray" v-model="balyalaArray">
                            <input type="hidden" name="balyaNoArray" v-model="balyaNoArray">
                            <input type="hidden" name="tonaj" v-model="tonaj">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">



                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Sevkiyat Tarihi</label>
                            <input required type="date" class="form-control form-control-lg" name="sevkiyatarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Sevkiyat Zamanı</label>
                            <input required type="time" class="form-control form-control-lg" name="sevkiyatsaat">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" class="form-control form-control-lg" name="aciklama"
                                   placeholder="Sevkiyat Açıklaması">
                        </div>
                    </div>

                </div>
                <br>
                <hr style="color: #fff0f0">
                <br>


                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <div style="text-align: center">
                            <h3 style="color: #0c525d" class="card-title">Balyalar</h3>

                        </div>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Balya No</th>
                                <th>Kilo</th>
                                <th>Boy</th>
                                <th>Müşteri</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tr v-for="item in balyalar" v-if="item.selected == false">
                                <td>{{item.tarih}}</td>
                                <td>{{item.balyaNo}}</td>
                                <td>{{item.balyaKilo}}</td>
                                <td>{{item.balyaBoy}}</td>
                                <td>{{item.musteri}}</td>
                                <td style="text-align: center">
                                    <button type="submit" v-on:click="ekle($event,item.id)"
                                            class="btn btn-outline-primary"><i class="fa fa-plus"
                                                                               aria-hidden="true"></i></button>
                                    <button type="button" v-on:click="detayGoster($event,item)"
                                            class="btn btn-outline-dark"
                                            data-toggle="modal">
                                        <i class="fa fa-expand"></i>
                                    </button>
                                </td>

                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sevkiyata Alınanlar</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Balya No</th>
                                <th>Kilo</th>
                                <th>Boy</th>
                                <th>Müşteri</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>
                            <tr v-for="item in balyalar" v-if="item.selected == true">
                                <td>{{item.tarih}}</td>
                                <td>{{item.balyaNo}}</td>
                                <td>{{item.balyaKilo}}</td>
                                <td>{{item.balyaBoy}}</td>
                                <td>{{item.musteri}}</td>
                                <td style="text-align: center">
                                    <button type="submit" v-on:click="cikar($event,item.id)"
                                            class="btn btn-outline-danger"><i class="fa fa-minus"
                                                                              aria-hidden="true"></i></button>
                                    <button type="button" v-on:click="detayGoster($event,item)"
                                            class="btn btn-outline-dark"
                                            data-toggle="modal">
                                        <i class="fa fa-expand"></i>
                                    </button>
                                </td>

                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>


                <div id="balyalar" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>


                            <div class="modal-body"></div>
                        </div>

                    </div>
                </div


                <div class="card-footer" v-if="balyalar.find(x=>x.selected)">
                    <div>
                        <button @click="bitir()" type="submit"
                                onclick="return confirm('Sevkiyat Kaydediliyor...?')"
                                class="btn btn-info float-right">Tamamla
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>


        </form>
    </div>

</section>
