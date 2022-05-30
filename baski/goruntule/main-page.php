<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlbaski = "SELECT * FROM tblbaski WHERE id = '$id'";
    $baski = mysqli_query($db, $sqlbaski)->fetch_assoc();
    $satirNo = $baski['satirNo'];

    $sqlSiparis = "SELECT * FROM tblsiparis  where satirNo = '$satirNo'";
    $siparis = mysqli_query($db, $sqlSiparis)->fetch_assoc();
    $musteriAd = tablogetir("tblfirma", 'id', $siparis['musteriId'], $db)['firmaAd'];
    $profil = tablogetir('tblprofil', 'id', $siparis['profilId'], $db);
    $alasim = tablogetir('tblalasim', 'id', $siparis['alasimId'], $db);
    $takim = tablogetir('tbltakim', 'id', $baski['takimId'], $db);

    $biyetId = explode(";", $baski['biyetId']);
    $biyetBoy = explode(";", $baski['biyetBoy']);
    $verilenBiyet = explode(";", $baski['verilenBiyet']);
    $araIsFire = explode(";", $baski['araIsFire']);
    $konveyor = explode(";", $baski['konveyorBoy']);
    $boylamFire = explode(";", $baski['boylamFire']);
    $biyetFire = explode(";", $baski['biyetFire']);
    $baskiFire = explode(";", $baski['baskiFire']);
    $biyetBrut = explode(";", $baski['biyetBrut']);


} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Baskı Görüntüleme Alanı
        </div>
        <div class="card-body">

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
                                                <?php echo $satirNo; ?>
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
                                        <?php echo $musteriAd; ?>
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Profil: </span>
                                        <?php echo $profil['profilAdi'] . " - " . $profil['profilNo']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Alaşım: </span>
                                        <?php echo $alasim['ad']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Tolerans: </span>
                                        <?php echo $siparis['maxTolerans']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> İstenilen Termik: </span>
                                        <?php echo $siparis['istenilenTermik']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Boy: </span>
                                        <?php echo $siparis['boy']; ?>
                                    </h6>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Kilo: </span>
                                        <?php echo $siparis['kilo']; ?>
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Basılan Kg - Kalan Kg: </span>
                                        <?php echo $siparis['basilanKilo'] ." - ". $siparis['kalanKilo']; ?>
                                    </h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>
                                        <span style="color: darkcyan; font-weight: bold"> Adet: </span>
                                        <?php echo $siparis['adet']; ?>
                                    </h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">

                                </div>
                                <div class="col-sm-8">
                                    <h3 style="color: red">
                                        <?php echo $baski['aciklama']; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <label>
                            <?php echo "Başlama Zamanı: " . tarihsaat($baski['baslaZamani']); ?>
                        </label>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div style="text-align: right">
                        <label>
                            <?php echo "Bitiş Zamanı: " . tarihsaat($baski['bitisZamani']); ?>
                        </label>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Takım</label>
                        <input value="<?php echo $takim['takimNo'] ?>"
                               class="form-control"
                               type="text" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Kalıp</label>
                        <input value="<?php echo kalipBul($takim['kalipCins']); ?>"
                               class="form-control"
                               type="text" disabled>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Çap</label>
                        <input value="<?php echo $takim['cap'] ?>"
                               class="form-control"
                               type="text" disabled>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <br>

            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Detay Bilgileri</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">


                    <div class="row">

                    <div style="text-align: center" class="col-sm-12">
                        <h4 style="color: deepskyblue">Kullanılan Biyetler</h4>
                    </div>
                    <div class="card-body table-responsive p-0">


                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Biyet</th>
                                <th>Boy</th>
                                <th>Verilen Biyet</th>
                                <th>Araiş Fire</th>
                                <th>Konveyör Boy</th>
                                <th>Boylam Fire</th>
                                <th>Fire Biyet</th>
                                <th>Baskı Fire</th>
                                <th>Brüt Kg</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            for($i = 0; $i<count($biyetId); $i++) {

                                $biyetAd = tablogetir("tblstokbiyet", "id", $biyetId[$i],$db)['partino'];
                                ?>

                            <tr>
                                <td><?php echo $biyetAd; ?></td>
                                <td><?php echo $biyetBoy[$i]; ?></td>
                                <td><?php echo $verilenBiyet[$i]; ?></td>
                                <td><?php echo $araIsFire[$i]; ?></td>
                                <td><?php echo $konveyor[$i]; ?></td>
                                <td><?php echo $boylamFire[$i]; ?></td>
                                <td><?php echo $biyetFire[$i]; ?></td>
                                <td><?php echo $baskiFire[$i]; ?></td>
                                <td><?php echo $biyetBrut[$i]; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                </div>
            </div>

            <br>
            <br>
            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Güncel Gr</label>
                        <input 
                               disabled
                               class="form-control"
                               type="text" 
                               value="<?php echo $baski['guncelGr'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Basılan Net Adet</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['basilanNetAdet'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Basılan Net Kg</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['basilanNetKg'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Basılan Brüt Kg</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['basilanBrutKg'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Fire (Kg)</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['fire'] ?>">

                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Kovan Sıcaklığı (°C)</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['kovanSicaklik'] ?>">
                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Kalıp Sıcaklığı (°C)</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['kalipSicaklik'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Biyet Sıcaklığı (°C)</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['biyetSicaklik'] ?>">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Hız (A)</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['hiz'] ?>">
                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Takım Son Durum</label>

                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo
                               takimDurumBul( $baski['takimSonDurum']) ?>">

                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Açıklama</label>
                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['aciklama'] ?>">
                    </div>
                </div>
                
                <div v-if="!baskiDurum" class="col-sm-2">
                    <div class="form-group">
                        <label>Baskı Sonlanma Nedeni</label>

                        <input disabled
                                class="form-control"
                                type="text"
                                value="<?php echo $baski['sonlanmaNeden'] ?>">

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div>

                    <a href="../"
                       class="btn btn-outline-primary float-right">Baskılar Alanına Geri Dön</a>
                </div>
            </div>
        </div>


    </div>

</section>
