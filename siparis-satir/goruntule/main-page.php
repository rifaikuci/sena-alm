<?php
include '../../netting/baglan.php';
include "../../include/sql.php";
require_once "../../include/helper.php";
require_once "../../include/data.php";

$satirno = 0;
if (isset($_GET['satirno'])) {
    $satirno = $_GET['satirno'];

    $sql = "Select s.id,
       s.satirNo,
       s.siparisNo,
       m.firmaAd,
       s.siparisTarih,
       profilAdi,
       profilNo,
       boy,
       adet,
       kilo,
       siparisTuru,
       pr.ad as boyaAd,
       a.ad as alasimAd,
       termimTarih,
       maxTolerans,
       araKagit,
       krepeKagit,
       korumaBandi,
       naylonDurum,
       istenilenTermik,
       baskiAciklama, paketAciklama, boyaAciklama, e.ad as eloksalAd
from tblsiparis s
         INNER JOIN tblfirma m on s.musteriId = m.id
         INNER JOIN tblprofil t on s.profilId = t.id
         LEFT JOIN tblprboya pr on s.boyaId = pr.id
        LEFT JOIN tbleloksal e on s.eloksalId =e.id
         LEFT JOIN tblalasim a on s.alasimId = a.id
where  s.satirNo = '$satirno'";
    $row = mysqli_query($db, $sql)->fetch_assoc();


}
?>

<section class="content" id="siparisguncelleneceksatir" satirno="<?php echo $satirno ?>">
    <form action="<?php echo base_url() . 'netting/siparis-satir/index.php' ?>" method="post">
        <div class="card card-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group-sm">
                            <label style="color: #7f8c8d">Müşteri
                                Sipariş No: <?php echo $row['siparisNo'] ?></label>
                            <br>
                            <label style="color: #7f8c8d">Müşteri
                                Adı: <?php echo $row['firmaAd'] ?></label>
                            <br>
                            <label style="color: #7f8c8d">Sipariş
                                Tarihi: <?php echo tarih($row['siparisTarih']) ?></label>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="card card-info">
            <div class="row">
                <div class="col-md-6">
                    <div style="text-align: right; margin: 5px">
                        <h5 style="color: #2b6b4f">Sipariş Detayı</h5>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> Satır No</label>
                                        <input value="<?php echo $row['satirNo']?>" type="text"
                                               class="form-control form-control-lg"
                                               disabled>
                                        <input type="hidden" name="satirNo" :value="satirno">
                                        <input type="hidden" name="id" :value="id">
                                        <input type="hidden" name="kilo" :value="kilo">
                                        <input type="hidden" name="adet" :value="adet">
                                        <input type="hidden" name="profilId" :value="profilId">
                                        <input type="hidden" name="alasimId" :value="alasimId">
                                        <input type="hidden" name="araKagit" :value="araKagit">
                                        <input type="hidden" name="krepeKagit" :value="krepeKagit">
                                        <input type="hidden" name="kiloAdet" :value="kiloAdet">
                                        <input type="hidden" value="<?php echo isset($_SESSION['operatorId']) ?  $_SESSION['operatorId'] : 0; ?>" name="operatorId">

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Profil</label>
                                        <input value="<?php echo $row['profilNo'] . " - " . $row['profilAdi']?>" type="text"
                                               class="form-control form-control-lg"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Boy (mm)</label>
                                        <input  type="number" disabled value="<?php  echo $row['boy']?>"
                                               class="form-control form-control-lg" name="boy">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Adet</label>
                                        <input disabled value="<?php  echo $row['adet']?>"
                                               class="form-control form-control-lg" name="adet"
                                               placeholder="1" step="1">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Kilo</label>
                                        <input disabled value="<?php  echo sayiFormatla($row['kilo'])?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Sipariş Türü</label>
                                        <input disabled value="<?php echo $row['siparisTuru'] == 'B' ? "Boyalı" : ($row['siparisTuru'] == 'E' ? "Eloksal" : "Pres")?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Sipariş Detay</label>
                                        <input disabled value="<?php echo $row['siparisTuru'] == 'B' ? $row['boyaAd'] : ($row['siparisTuru'] == 'E' ? $row['eloksalAd'] : "")?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>



                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Alaşım </label>
                                        <input disabled value="<?php echo $row['alasimAd'] ?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Termin Tarihi</label>
                                        <input value="<?php echo tarih($row['termimTarih'])?>" disabled
                                               class="form-control form-control-lg" name="termimTarih">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tolerans (%)</label>
                                        <input value="<?php echo $row['maxTolerans']?>" disabled
                                               class="form-control form-control-lg" name="termimTarih">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>~~</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" disabled
                                                       <?php echo $row['araKagit'] == '1' ? "checked" : "" ?>
                                                       id="checkboxPrimary1"
                                                      >
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
                                                <input disabled
                                                       type="checkbox" id="checkboxPrimary2"
                                                    <?php echo $row['krepeKagit'] == '1' ? "checked" : "" ?>>
                                                <label style="color: #0e84b5" for="checkboxPrimary2">
                                                    Krepe Kağıt
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Naylon</label>
                                        <input disabled value="<?php echo $row['naylonDurum'] == '1' ? "Baskılı" : ($row['naylonDurum'] == '2' ? "Baskısız" : "Yok")?>"
                                               class="form-control form-control-lg" name="kilo">

                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Koruma Bandı</label>
                                        <input disabled value="<?php echo $row['korumaBandi'] == '1' ? "Baskılı" : ($row['korumaBandi'] == '2' ? "Baskısız" : "Yok")?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>İstenilen Termik</label>
                                        <input disabled value="<?php echo $row['istenilenTermik'] == 'Termiksiz' ? "0" : ($row['istenilenTermik'] == 'Yarı Termikli' ? "4 - 7" : "10 - 14")?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Baskı Açıklama</label>
                                        <input disabled value="<?php  echo $row['baskiAciklama']?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Paket Açıklama</label>
                                        <input disabled value="<?php  echo $row['paketAciklama']?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>

                                <div v-if="siparisTur == 'Boyalı' " class="col-sm-4">
                                    <div class="form-group">
                                        <label>Boya Açıklama</label>
                                        <input disabled value="<?php  echo $row['boyaAciklama']?>"
                                               class="form-control form-control-lg" name="kilo">
                                    </div>
                                </div>
                                <div class="col-sm-12" v-if="isFullSiparisData">
                                    <div style="text-align: right" name="siparissaitrguncelle">
                                        <button type="submit" class="btn btn-dark float-right">Güncelle
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
    </form>

</section>


