<?php
include "../../netting/baglan.php";
require_once "../../include/sql.php";
$siparissql = "SELECT * FROM tblsiparis where baskiDurum = 0 order by termimTarih asc";
$siparisler = $db->query($siparissql);

date_default_timezone_set('Europe/Istanbul');

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
                                            <span style="color: darkcyan; font-weight: bold"> Kilo: </span>
                                            {{kg}}
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Adet: </span>
                                            {{adet}}
                                        </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-8">
                                        <h3 style="color: red">
                                            {{aciklama}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="text-align: right">
                            <label>
                                <?php echo "Tarih: " . date("d.m.Y H:i"); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sipariş</label>

                            <select name="satirNo" required class="form-control select2" id="supplier_id"
                                    style="width: 100%;">
                                <option selected disabled value="">
                                    Sipariş No - Termim Tarih - Müşteri - Profil No - Profil Ad - Boy - Tür - Tür Detayı
                                    - İstenen/Basılan K/A
                                </option>

                                <?php while ($siparis = $siparisler->fetch_array()) { ?>

                                    <option
                                            value="<?php echo $siparis['id']; ?>">
                                        <?php
                                        $siparisTuru = $siparis['siparisTuru'] == "H" ? "Ham" :
                                            ($siparis['siparisTuru'] == "B" ? "Boyalı" : "Eloksal");

                                        $tur = $siparis['siparisTuru'] == "H" ? "Yok" :
                                            ($siparis['siparisTuru'] == "B" ? boyaBul($siparis['boyaId'], $db) :
                                                eloksalBul($siparis['eloksalId'], $db));
                                        $kiloVeyaAdet = $siparis['kiloAdet'] == "K" ? $siparis['kilo'] . "/" :
                                            $siparis['adet'] . "/";

                                        $basilanKiloVeyaAdet = $siparis['kiloAdet'] == "K" ? $siparis['basilanKilo'] . " Kilo" :
                                            $siparis['basilanAdet'] . " Adet";
                                        echo
                                            $siparis['satirNo'] . " - " .
                                            tarih($siparis['termimTarih']) . " - " .
                                            firmaBul($siparis['musteriId'], $db, 'firmaAd') . " - " .
                                            profilbul($siparis['profilId'], $db, 'profilNo') . " -" .
                                            profilbul($siparis['profilId'], $db, 'profilAdi') . " -" .
                                            $siparis['boy'] . " - " .
                                            alasimBul($siparis['alasimId'], $db, 'ad') . " - " .
                                            $siparisTuru . " - " . $tur . " - " . $kiloVeyaAdet . $basilanKiloVeyaAdet;;

                                        ?>

                                    </option>

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
