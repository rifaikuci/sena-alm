<?php
include "../../netting/baglan.php";

$siparissql = "SELECT * FROM tblsiparis where kalanKilo > 0 OR kalanAdet > 0 ";
$siparisler = $db->query($siparissql);
?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Baskı Oluşturma Alanı
        </div>
        <div class="card-body" id="baski-giris">
            <form method="post" action="<?php echo base_url() . 'netting/baski/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row" v-if="isSelected">
                    <div class="col-sm-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{satirNo}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                     <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>
                                                Profil :
                                                <span style="color: #2b6b4f">{{profilNo }} -  {{profilAd}} </span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>
                                                deneme
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>
                                                deneme
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Sipariş</label>
                            <select name="satirNo" required class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Baskıyı Seçiniz</option>
                                <?php while ($siparis = $siparisler->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $siparis['id']; ?>"><?php echo $siparis['satirNo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="baskiekle" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
