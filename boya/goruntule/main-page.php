<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];


    $sqlboya = "select boya.id as id, partino, barkodNo, kullanilanBoya, siklonKullanilanKg, askiId, rutusId, profilAdi, profilId, profilNo, rutusAdet,siklonAyrilanKg,
            netBoya, topAski, ortAskiAdet, siklonId, topAdet, sepetler, adetler,baskilar, hurdaAdetler, hurdaSebepler
            from tblboya as boya
            LEFT JOIN tblstokboya as stokboya ON boya.boyaId = stokboya.id
            LEFT  JOIN tblrutusprofil on rutusId = tblrutusprofil.id
            left  JOIN tblprofil on tblrutusprofil.profilId = tblprofil.id where boya.id = '$id'";

    $boya = mysqli_query($db, $sqlboya)->fetch_assoc();

    $sepetler = explode(";", $boya['sepetler']);
    $baskilar = explode(";", $boya['baskilar']);
    $adetler = explode(";", $boya['adetler']);
    $hurdaAdetler = explode(";", $boya['hurdaAdetler']);
    $hurdaSebepler = explode(";", $boya['hurdaSebepler']);

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boyanma (Fırınlama) Alanı
        </div>
        <div class="card-body">
            <form enctype="multipart/form-data">

                <div class="row">
                    <div style="text-align: center" class="col-sm-12">
                        <h4 style="color: deepskyblue">Alınan Malzemeler</h4>
                    </div>
                    <div class="card-body table-responsive p-0">


                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Sepet No</th>
                                <th>Baskı Id</th>
                                <th>Satır No</th>
                                <th>Profil No/Profil Ad</th>
                                <th>Boy</th>
                                <th>Boya</th>
                                <th>Alınan Adet</th>
                                <th>Hurda Adet</th>
                                <th>Hurda Sebep</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php for ($i = 0; $i < count($adetler); $i++) {
                                $baskiId = $baskilar[$i];
                                $baskiSql = "SELECT t.id as 
                                            siparisId, tblbaski.id as id, profilId,t.satirNo, 
                                                       profilAdi, profilNo, t.boy, sp.ad, t.adet 
                                        from tblbaski
                                            INNER JOIN tblsiparis t on t.id =tblbaski.siparisId
                                            INNER JOIN tblprofil p on p.id = t.profilId
                                            INNER JOIN tblprboya sp on sp.id = t.boyaId 
                                        where tblbaski.id = '$baskiId'";
                                $baski = mysqli_query($db, $baskiSql)->fetch_assoc();

                                ?>
                                <tr>
                                    <td><?php echo $sepetler[$i] ?></td>
                                    <td><?php echo $baskilar[$i] ?></td>
                                    <td><?php echo $baski['satirNo'] ?></td>
                                    <td><?php echo $baski['profilNo'] . "/" . $baski['profilAdi'] ?></td>
                                    <td><?php echo $baski['boy'] ?></td>
                                    <td><?php echo $baski['ad'] ?></td>
                                    <td><?php echo $adetler[$i] ?></td>
                                    <td><?php echo $hurdaAdetler[$i] ?></td>
                                    <td><?php echo $hurdaSebepler[$i] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>


                    <div class="col-sm-12">
                        <div style="text-align: center">

                            <h3 style="color: #0c525d">
                                Bilgiler
                            </h3>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Boya Barkod</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['barkodNo'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Parti No</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['partino'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kullanılan Boya (Kg)</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['kullanilanBoya'] ?>">
                        </div>
                    </div>

                    <?php
                    $siklon = tablogetir("tblsiklon", 'id', $boya['siklonId'], $db);
                    $siklonBoya = tablogetir("tblstokboya", "id", $siklon['boyaId'], $db);
                    ?>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Siklon Boya Barkod</label>
                            <input class="form-control" disabled
                                   value="<?php echo $siklonBoya['barkodNo'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Parti No</label>
                            <input class="form-control" disabled
                                   value="<?php echo $siklonBoya['partino'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>S. Altı Kullanılan Boya (KG)</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['siklonKullanilanKg'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Askı Tipi</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['askiId'] ?>">
                        </div>
                    </div>

                    <?php
                    if ($boya['rutusId'] > 0) {

                        ?>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Rutuş Profil</label>
                                <input class="form-control" disabled
                                       value="<?php echo $boya['profilNo'] ?>">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Rutuş Adet</label>
                                <input class="form-control" disabled
                                       value="<?php echo $boya['rutusAdet'] ?>">
                            </div>
                        </div>

                    <?php } ?>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>S. Altına Ayrılan Boya (KG)</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['siklonAyrilanKg'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Net Boya (KG)</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['netBoya'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Top. Askı</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['topAski'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Top. Adet</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['topAdet'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Ort. Askı Adet</label>
                            <input class="form-control" disabled
                                   value="<?php echo $boya['ortAskiAdet'] ?>">
                        </div>
                    </div>

                </div>


                <div class="card-footer">
                    <div>

                        <a href="../"
                           class="btn btn-outline-primary float-right">Boyanma Alanına Geri Dön</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
