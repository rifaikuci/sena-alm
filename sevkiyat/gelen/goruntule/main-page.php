<?php
if ($_GET['id']) {

    $id = $_GET['id'];
    include '../../../netting/baglan.php';
    include "../../../include/sql.php";
    require_once "../../../include/helper.php";
    require_once "../../../include/data.php";

    $sql = "
    select s.id as id, kod, sevkiyatTarih,
       p1.adsoyad as p1adsoyad, p2.adsoyad as p2adsoyad,
       plaka, aciklama
from tblsevkiyat s
         INNER JOIN tblpersonel p1 ON p1.id = s.personelId1
         LEFT JOIN tblpersonel p2 ON p2.id = s.personelId2 where s.id = '$id'
    ";
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
                            $personel1 = $detail['p1adsoyad'];
                            echo $detail['p2adsoyad'] ? $personel1 . "- " . $detail['p2adsoyad'] :
                                $personel1; ?>

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

                <?php
                $sevkiyatId = $detail['id'];
                if (isTableSevkiyat($db, "tblstokbiyet", $detail['id']) > 0) {

                    $sqlbiyet = "
                     select s.id as id, sevkiyatId, partino, firmaAd, ad, cap, toplamKg, ortalamaBoy from tblstokbiyet s
INNER JOIN tblfirma f ON f.id = s.firmaId
INNER JOIN tblalasim a ON a.id = s.alasimId
                     where sevkiyatId ='$sevkiyatId' ";
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
                                    <th>Çap</th>
                                    <th>Toplam Kilo</th>
                                    <th>Ortalama Boy</th>
                                    <th>Detay</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sira = 1;
                                while ($biyet = $resultbiyet->fetch_array()) { ?>
                                    <tr>
                                        <td> <?php echo $sira; ?></td>
                                        <td> <?php echo $biyet['partino'] ?></td>
                                        <td> <?php echo $biyet['firmaAd'] ?></td>
                                        <td> <?php echo $biyet['ad'] ?></td>
                                        <td> <?php echo $biyet["cap"] ?></td>
                                        <td> <?php echo $biyet["toplamKg"] . " Kg" ?></td>
                                        <td> <?php echo $biyet["ortalamaBoy"] . " Cm" ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary biyetim"
                                                    data-toggle="modal" data-target="#biyet"
                                                    data-id="<?php echo $biyet['id'] ?>"
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

                <?php

                if (isTableSevkiyat($db, "tblstokboya", $detail['id']) > 0) {
                    $sqlboya = "
                    select s.id as id, sevkiyatId, partino, firmaAd, ad, sicaklik, cins, adet, kilo, firmaId, boyaTuru
                        from tblstokboya s
                        INNER JOIN tblfirma f ON f.id = s.firmaId
                        INNER JOIN tblprboya a ON a.id = s.boyaTuru 
                     where sevkiyatId =" . $sevkiyatId . " group  by partino, firmaId, boyaTuru,sicaklik,cins, kilo,adet";
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
                                        <td> <?php echo tablogetir('tblfirma', 'id', $boya['firmaId'], $db)['firmaAd'] ?></td>
                                        <td> <?php echo tablogetir('tblprboya', 'id', $boya["boyaTuru"], $db)['ad'] ?></td>
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

                    $sqlmalzeme = "select malzemeId, partino, firmaAd,ad, adet, birimMiktari, firmaId  from tblstokmalzeme s
INNER JOIN tblmalzemeler m ON m.id =s.malzemeId
INNER JOIN tblfirma f ON f.id = s.firmaId where sevkiyatId =" . $detail['id'] . " group  by partino, firmaId, malzemeId,adet";
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
                                while ($malzeme = $resultmalzeme->fetch_array()) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $sira; ?></td>
                                        <td> <?php echo $malzeme['partino'] ?></td>
                                        <td> <?php echo $malzeme['firmaAd'] ?></td>
                                        <td> <?php echo $malzeme['ad'] ?></td>
                                        <td> <?php echo $malzeme['adet'] ?></td>
                                        <td> <?php echo $malzeme['adet'] * $malzeme['birimMiktari']; ?></td>
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
