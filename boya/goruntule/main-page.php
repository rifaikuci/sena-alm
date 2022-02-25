<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlboya = "SELECT * FROM tblboya WHERE id = '$id'";
    $boya = mysqli_query($db, $sqlboya)->fetch_assoc();

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boyanma (Fırınlama) Alanı
        </div>
        <div class="card-body" >
            <form enctype="multipart/form-data">

                <div class="row">

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Sepet - Kesim </label>
                            <input disabled value="<?php
                            $sepet = tablogetir('tblsepet', 'id', $boya['sepetId'], $db);
                          echo  $sepet['ad'] . " - " .  $boya['kesimId'] ?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Askı Tipi</label>
                            <input disabled value="<?php echo $boya['askiId']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Fırın Sıcaklığı</label>
                            <input disabled value="<?php echo $boya['firinSicaklik']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kürlenme Dakikası</label>
                            <input disabled value="<?php echo $boya['kurlenmeDakikasi']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Boyalar</label>
                            <input disabled value="<?php echo tablogetir("tblstokboya", 'id', $boya['boyaId'], $db)['barkodNo']  ?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kullanılan Boya</label>
                            <input disabled value="<?php echo $boya['kullanilanBoya']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Siklon Boya</label>
                            <input disabled value="<?php
                            $tempboya = tablogetir("tblstokboya", "id", $boya['boyaId'], $db);

                            echo $tempboya['barkodNo'] ?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2" v-if="siklonId > 0">
                        <div class="form-group">
                            <label>S. Altı Kullanılan Boya (KG)</label>
                            <input disabled value="<?php echo $boya['siklonKullanilanKg']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>S. Altına Ayrılan Boya (KG)</label>
                            <input disabled value="<?php echo $boya['siklonAyrilanKg']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Net Boya (KG)</label>
                            <input disabled value="<?php echo $boya['netBoya']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                <br><br><br>

                <div class="row">

                    <div class="col-sm-12">
                        <div style="text-align: center">

                            <h3 style="color: #0c525d">
                                Kesim Bilgileri
                            </h3>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Atılabilecek Max</label>
                            <input disabled value="<?php echo $boya['maxAdet']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Top. Askı</label>
                            <input disabled value="<?php echo $boya['topAski']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Top. Adet</label>
                            <input disabled value="<?php echo $boya['topAdet']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Oran</label>
                            <input disabled value="<?php echo $boya['oran']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Alt Sebep</label>
                            <input disabled value="<?php echo $boya['altSebep']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Ort. Askı Adet</label>
                            <input disabled value="<?php echo $boya['ortAskiAdet']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Rutuş Profil</label>
                            <input disabled value="<?php  $rutus =  $boya['rutusId']  != "0" ? tablogetir('tblrutusprofil', 'id', $boya['rutusId']) : "0";
                                    $profil =  $rutus != "0" ? tablogetir("tblprofil", 'id',$rutus['profilId'], $db) : "Yok";
                                    echo $profil != "Yok" ? $profil['profilAdi'] : "Kullanılmadı";
                            ?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Rutuş Adet</label>
                            <input disabled value="<?php echo $boya['rutusAdet']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Hurda Adet</label>
                            <input disabled value="<?php echo $boya['hurdaAdet']?>"
                                   class="form-control" type="text"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2>
                        <div class="form-group">
                            <label>Hurda Sebebi</label>
                    <input disabled value="<?php echo $boya['hurdaAdet'] > 0 ? $boya['hurdaSebep'] : "-" ?>"
                           class="form-control" type="text"
                           placeholder="0">
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
