<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlpaket = "
           select bp.id as id,
       b.id      as baskiId,
       s.id      as siparisId,
       s.satirNo as satirNo,
       firmaAd,
       profilNo,
       ad,
       maxTolerans,
       boy,
       korumaBandi,
       araKagit,
       paketAciklama,
       bp.hurdaAdet,
       bp.hurdaSebep,
       bp.rutusAdet,
       bp.rutusSebep,
       paketAdet,
       netAdet,
       bp.boyaId,
       firinId
from tblboyapaket bp
         INNER JOIN tblbaski b ON bp.baskiId = b.id
         INNER JOIN tblsiparis s ON b.siparisId = s.id
         INNER JOIN tblprofil p ON s.profilId = p.id
         INNER JOIN tblalasim a On a.id = s.alasimId
         INNER JOIN tblfirma f ON s.musteriId = f.id
         INNER JOIN tblboya  boya ON boya.id =bp.boyaId
            where bp.id = '$id'";
    $paket = mysqli_query($db, $sqlpaket)->fetch_assoc();


    $paketIcAdet = $paket['paketAdet'];
    $netAdet = $paket['netAdet'] ? $paket['netAdet'] : 0;
    $rutusAdet = $paket['rutusAdet'] ? $paket['rutusAdet'] : 0;
    $rutusAdet = $paket['rutusAdet'] ? $paket['rutusAdet'] : 0;
    $rutusAdet = $paket['hurdaAdet'] ? $paket['hurdaAdet'] : 0;
    $tamPaket = 0;
    $tamAdet = 0;
    $yarimPaket = 0;
    $yarimAdet = 0;
    $kalanAdet = 0;
    $toplamPaket = 0;


    if ($netAdet % $paketIcAdet == 0) {
        $tamPaket = $netAdet / $paketIcAdet;
        $yarimPaket = 0;
        $kalanAdet = 0;
        $toplamPaket = $tamPaket + $yarimPaket;
    } else {
        $kalanAdet = $netAdet % $paketIcAdet;
        $kalanTam = $netAdet - $kalanAdet;
        $tamPaket = $kalanTam / $paketIcAdet;
        $yarimPaket = 1;
        $toplamPaket = $tamPaket + $yarimPaket;
    }

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boya Paket Alanı
        </div>
        <div class="card-body">
            <form>
                <div class="row">
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

                                                    <?php echo $paket['satirNo']; ?>
                                                    <span style="color: #2b6b4f"> </span>
                                                </H2>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Fırın ID: </span>
                                            <?php echo $paket['firinId'] ?>
                                        </h6>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Müşteri: </span>
                                            <?php echo $paket['firmaAd'] ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                            <?php echo $paket['profilNo'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Alaşım: </span>
                                            <?php echo $paket['ad'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Tolerans: </span>
                                            <?php echo $paket['maxTolerans'] ?>
                                        </h6>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Boy: </span>
                                            <?php echo $paket['boy'] ?>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Net Adet: </span>
                                            <?php echo $netAdet ?>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Paket Iç Adet: </span>
                                            <?php echo $paketIcAdet ?>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Koruma Bandı: </span>
                                            <?php

                                            echo $paket['korumaBandi'] == 1 ? "Baskılı" : ($paket['korumaBandi'] == 2 ? "Baskısız" : "Yok");
                                            ?>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Ara Kağıt: </span>
                                            <?php

                                            echo $paket['araKagit'] == 1 ? "Var " : "Yok";
                                            ?>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <h6>
                                            <span style="color: darkcyan; font-weight: bold"> Paket Detayı: </span>
                                            <span style="color: green"> <?php echo $tamPaket; ?> </span> Tam Paket,
                                            <span
                                                    style="color: red"><?php echo $yarimPaket; ?> </span> Yarım Paket
                                            olmak üzere
                                            toplam
                                            <span style="color: dimgray">  <?php echo $toplamPaket; ?> </span>
                                            Oluşturulmuştur.
                                            Yarım Pakette bulunan Adet : <span
                                                    style="color: red"><?php echo $kalanAdet; ?> </span>
                                        </h6>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-8">
                                        <h3 style="color: red">
                                            <?php echo $paket['paketAciklama'] ?>
                                        </h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input disabled value="<?php echo $paket['hurdaAdet'] ?>"
                                   class="form-control"
                                   placeholder="0">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="hurdaAdet && hurdaAdet > 0">
                        <div class="form-group">
                            <label>Hurda Sebebi</label>
                            <input disabled value="<?php echo $paket['hurdaSebep'] ?>"
                                   class="form-control"
                                   placeholder="">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Rutuş Adet</label>
                            <input disabled value="<?php echo $paket['rutusAdet'] ?>"
                                   class="form-control"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2" v-if="rutusAdet && rutusAdet > 0">
                        <div class="form-group">
                            <label>Rütuş Sebebi</label>
                            <input disabled value="<?php echo $paket['rutusSebep'] ?>"
                                   class="form-control"
                                   placeholder="">
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div>
                        <a href="../"
                           class="btn btn-success float-right">Boya Paketlerine Dön</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
