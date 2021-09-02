<?php
if ($_GET['id']) {

    $id = $_GET['id'];
    include '../../../netting/baglan.php';
    include "../../../include/sql.php";
    require_once "../../../include/helper.php";

    $sql = "SELECT * FROM tblSevkiyat WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $detail = $result->fetch_assoc();

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sevkiyat Görüntüleme
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/personel.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Kodu: </label> <?php echo $detail['kod'] ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sevkiyat Tarih: </label> <?php echo $detail['sevkiyatTarih'] ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Şoförler: </label> <?php
                            echo $detail['personelId2'] ? personelBul($detail['personelId1'], $db) . "- " . personelBul($detail['personelId2'], $db) :
                                personelBul($detail['personelId1'], $db); ?>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Plaka: </label> <?php echo $detail['plaka'] ?>

                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Açıklama: </label> <?php echo $detail['aciklama'] ?>

                        </div>
                    </div>
                </div>

                <?php if (isTableSevkiyat($db, "tblstokbiyet", $detail['id']) > 0) {
                    $sqlbiyet = "SELECT * FROM `tblstokbiyet` where sevkiyatId =" . $detail['id'] . " group  by cap, boy, adet,alasimId,firmaId, partino";
                    $resultbiyet = $db->query($sqlbiyet);

                    ?>
                    <div style="text-align: center">
                        <h4 style="color: #0e84b5;">
                            Biyetler
                        </h4>
                    </div>

                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Parti No</th>
                                    <th>Firma</th>
                                    <th>Alaşım</th>
                                    <th>Adet</th>
                                    <th>Çap</th>
                                    <th>Boy</th>
                                    <th>Toplam Kilo</th>
                                    <th>Toplam Boy</th>
                                    <th>Detay</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sira = 1;
                                while ($biyet = $resultbiyet->fetch_array()) { ?>
                                    <tr>
                                        <td> <?php echo $sira; ?></td>
                                        <td> <?php echo $biyet['partino'] ?></td>
                                        <td> <?php echo firmaBul($biyet["firmaId"], $db, 'firmaAd') ?></td>
                                        <td> <?php echo alasimBul($biyet["alasimId"], $db, 'ad') ?></td>
                                        <td> <?php echo $biyet['adet'] ?></td>
                                        <td> <?php echo $biyet["cap"] ?></td>
                                        <td> <?php echo $biyet["boy"] ?></td>
                                        <td> <?php echo biyetToplamKilo($biyet['alasimId'], $biyet['adet'], $biyet["cap"], $biyet["boy"], $db) ?>
                                            Kg
                                        </td>
                                        <td> <?php echo biyetToplamBoy($biyet['adet'], $biyet["boy"]) ?> Cm</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary biyetim"
                                                    data-toggle="modal" data-target="#biyet"
                                                    data-cap="<?php echo $biyet['cap'] ?>"
                                                    data-boy="<?php echo $biyet['boy'] ?>"
                                                    data-adet="<?php echo $biyet['adet'] ?>"
                                                    data-alasim="<?php echo $biyet['alasimId'] ?>"
                                                    data-firma="<?php echo $biyet['firmaId'] ?>"
                                                    data-partino="<?php echo $biyet['partino'] ?>"
                                            ><i class="fa fa-expand"></i></button>
                                        </td>
                                    </tr>
                                    <?php $sira++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br><br>
                <?php } ?>

                <?php if (isTableSevkiyat($db, "tblstokboya", $detail['id']) > 0) {
                    $sqlboya = "SELECT * FROM `tblstokboya` where sevkiyatId =" . $detail['id'] . " group  by partino, firmaId, boyaTuru,sicaklik,cins, kilo,adet";
                    $resultboya = $db->query($sqlboya);
                    ?>
                    <div style="text-align: center">
                        <h4 style="color: #0e84b5;">
                            Boyalar
                        </h4>
                    </div>

                    <div class="card">

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Parti No</th>
                                    <th>Firma</th>
                                    <th>Boya</th>
                                    <th>Sıcaklık</th>
                                    <th>Cins</th>
                                    <th>Adet</th>
                                    <th>Kilo</th>
                                    <th>Toplam Kilo</th>
                                    <th>Detay</th>
                                </thead>
                                <tbody>
                                <?php $sira = 1;
                                while ($boya = $resultboya->fetch_array()) { ?>
                                    <tr>
                                        <td> <?php echo $sira; ?></td>
                                        <td> <?php echo $boya['partino'] ?></td>
                                        <td> <?php echo firmaBul($boya["firmaId"], $db, 'firmaAd') ?></td>
                                        <td> <?php echo boyaBul($boya["boyaTuru"], $db) ?></td>
                                        <td> <?php echo $boya['sicaklik'] ?></td>
                                        <td> <?php echo $boya['cins'] ?></td>
                                        <td> <?php echo $boya['adet'] ?></td>
                                        <td> <?php echo $boya['kilo']; ?></td>
                                        <td> <?php echo $boya['kilo'] * $boya['adet']; ?></td>
                                        <td>
                                            <button id="boyabilgi" type="button" class="btn btn-outline-primary boyam"
                                                    data-toggle="modal" data-target="#boya"
                                                    data-partino="<?php echo $boya['partino'] ?>"
                                                    data-firma="<?php echo $boya['firmaId'] ?>"
                                                    data-boya="<?php echo $boya['boyaTuru'] ?>"
                                                    data-sicaklik="<?php echo $boya['sicaklik'] ?>"
                                                    data-cins="<?php echo $boya['cins'] ?>"
                                                    data-kilo="<?php echo $boya['kilo'] ?>"
                                                    data-adet="<?php echo $boya['adet'] ?>"
                                            ><i class="fa fa-expand"></i></button>
                                        </td>
                                    </tr>
                                    <?php $sira++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br><br>
                <?php } ?>

                <?php if (isTableSevkiyat($db, "tblstokmalzeme", $detail['id']) > 0) {

                    $sqlmalzeme = "SELECT * FROM `tblstokmalzeme` where sevkiyatId =" . $detail['id'] . " group  by partino, firmaId, malzemeId,adet";
                    $resultmalzeme = $db->query($sqlmalzeme);
                    ?>
                    <div class="card">
                        <div style="text-align: center">
                            <h4 style="color: #0e84b5;">
                                Malzemeler
                            </h4>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Parti No</th>
                                    <th>Firma</th>
                                    <th>Malzeme</th>
                                    <th>Adet</th>
                                    <th>Toplam</th>
                                    <th>Detay</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sira = 1;
                                while ($malzeme = $resultmalzeme->fetch_array()) { ?>
                                    <tr>
                                        <td> <?php echo $sira; ?></td>
                                        <td> <?php echo $malzeme['partino'] ?></td>
                                        <td> <?php echo firmaBul($malzeme["firmaId"], $db, 'firmaAd') ?></td>
                                        <td> <?php echo malzemeBul($malzeme["malzemeId"], $db, "ad") ?></td>
                                        <td> <?php echo $malzeme['adet'] ?></td>
                                        <td> <?php echo $malzeme['adet'] * malzemeBul($malzeme["malzemeId"], $db, "birimMiktari") ?></td>
                                        <td>
                                            <button id="malzemebilgi" type="button"
                                                    class="btn btn-outline-primary malzemem"
                                                    data-toggle="modal" data-target="#malzeme"
                                                    data-partino="<?php echo $malzeme['partino'] ?>"
                                                    data-malzeme="<?php echo $malzeme['malzemeId'] ?>"
                                                    data-firma="<?php echo $malzeme['firmaId'] ?>"
                                                    data-adet="<?php echo $malzeme['adet'] ?>"
                                            ><i class="fa fa-expand"></i></button>
                                        </td>

                                    </tr>
                                    <?php $sira++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br><br>
                <?php } ?>

                <?php if (isTableSevkiyat($db, "tblstokprofil", $detail['id']) > 0) {
                    $sqlprofil = "SELECT * FROM `tblstokprofil` where sevkiyatId =" . $detail['id'] . "";
                    $resultprofil = $db->query($sqlprofil);
                    ?>
                    <div class="card">
                        <div style="text-align: center">
                            <h4 style="color: #0e84b5;">
                                Profiller
                            </h4>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sipariş No</th>
                                    <th>Profil</th>
                                    <th>Boy (mm)</th>
                                    <th>Firma</th>
                                    <th>Müşteri</th>
                                    <th>İç adet</th>
                                    <th>Paket Adet</th>
                                    <th>Adet</th>
                                    <th>Toplam Kg</th>
                                    <th>M/Gr</th>
                                    <th>Tolerans</th>
                                    <th>Detay</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sira = 1;
                                while ($profil = $resultprofil->fetch_array()) {
                                    $mgr = mGrBul($profil['toplamKg'], $profil['toplamAdet'], $profil['boy']);
                                    $tolerans = toleransBul($mgr, $profil['profilId'], $db);
                                    ?>
                                    <tr>
                                        <td style="font-weight: bold"><?php echo $sira; ?></td>
                                        <td><?php echo $profil['siparisNo'] ?></td>
                                        <td><?php echo profilbul($profil['profilId'], $db, "profilAdi"); ?></td>
                                        <td><?php echo $profil['boy'] ?></td>
                                        <td><?php echo firmaBul($profil["firmaId"], $db, 'firmaAd') ?></td>
                                        <td><?php echo firmaBul($profil['musteriId'], $db, 'firmaAd') ?></td>
                                        <td><?php echo $profil['icAdet'] ?></td>
                                        <td><?php echo $profil['paketAdet'] ?></td>
                                        <td><?php echo $profil['toplamAdet'] ?></td>
                                        <td><?php echo $profil['toplamKg'] ?></td>
                                        <td><?php echo $mgr ?></td>
                                        <td style="color:<?php echo $tolerans < 0 ? '#00b44e' : '#ff2400' ?>"> <?php echo "% " . $tolerans ?></td>
                                        <td>
                                            <button id="profilbilgi" type="button"
                                                    class="btn btn-outline-primary profilim"
                                                    data-toggle="modal" data-target="#profil"
                                                    data-id="<?php echo $profil['id'] ?>"
                                            ><i class="fa fa-expand"></i></button>
                                        </td>

                                    </tr>
                                    <?php $sira++;
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br><br>
                <?php } ?>


                <!-- Profiller -->
                <div id="profil" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div style="text-align: center">
                                <h4 style="color: #0e84b5">
                                    Profiller
                                </h4>
                            </div>

                            <div class="modal-body"></div>
                        </div>

                    </div>
                </div

                        <!-- Malzemeler -->

                <div id="malzeme" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div style="text-align: center">
                                <h4 style="color: #0e84b5">
                                    Malzemeler
                                </h4>
                            </div>

                            <div class="modal-body"></div>
                        </div>

                    </div>
                </div


                        <!-- Biyetler -->
                <div id="biyet" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div style="text-align: center">
                                <h4 style="color: #0e84b5">
                                    Biyetler
                                </h4>
                            </div>

                            <div class="modal-body"></div>
                        </div>

                    </div>
                </div


                        <!-- boya -->
                <div id="boya" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-xl">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="margin: 10px">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div style="text-align: center">
                                <h4 style="color: #0e84b5">
                                    Boyalar
                                </h4>
                            </div>

                            <div class="modal-body">
                            </div>
                        </div>

                    </div>
                </div


            </form>
        </div>
</section>
