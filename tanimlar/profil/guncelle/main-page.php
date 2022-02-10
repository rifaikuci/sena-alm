<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';

    $sql = "SELECT * FROM tblprofil WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    $sqlsektor = "SELECT * FROM tblsektor";
    $sektorler = $db->query($sqlsektor);
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Profil Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/profil.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['profilNo'] ?>">
                            <input type="hidden" class="form-control form-control-lg" name="profilNo"
                                   value="<?php echo $row['profilNo'] ?>">

                            <input type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">

                            <input type="hidden" class="form-control form-control-lg" name="resimyol"
                                   value="<?php echo $row['resim'] ?>">


                            <input type="hidden" class="form-control form-control-lg" name="paketyol"
                                   value="<?php echo $row['paketlemeSekli'] ?>">

                            <input type="hidden" class="form-control form-control-lg" name="sepetyol"
                                   value="<?php echo $row['sepetDizilmeSekli'] ?>">

                            <input type="hidden" class="form-control form-control-lg" name="cizimyol"
                                   value="<?php echo $row['cizim'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Adı</label>
                            <input required type="text" class="form-control form-control-lg" name="profilAdi"
                                   value="<?php echo $row['profilAdi'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sektör</label>
                            <select required name="sektorId" class="form-group select2" style="width: 100%;">
                                <option value="">Sektör Seçiniz</option>
                                <?php while ($sektor = $sektorler->fetch_array()) { ?>
                                    <option <?php echo $row['sektorId'] == $sektor['id'] ? "selected" : "" ?>
                                            value="<?php echo $sektor['id']; ?>"><?php echo $sektor['ad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>



                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Gramaj</label>
                            <input required type="number" class="form-control form-control-lg"  step="0.1"
                                   name="gramaj" value="<?php echo $row['gramaj'] ?>">

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Alanı</label>
                            <input required type="number" class="form-control form-control-lg"  step="0.1"
                                   name="alan" value="<?php echo $row['alan'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Çevresi</label>
                            <input required type="number" class="form-control form-control-lg"  step="0.1"
                                   name="cevre" value="<?php echo $row['cevre'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paket Adet</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="paketAdet" value="<?php echo $row['paketAdet'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Paket En</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="paketEn" value="<?php echo $row['paketEn'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Paket Boy</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="paketBoy"value="<?php echo $row['paketBoy'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Boya Max Adet</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="boyaMaxAdet" value="<?php echo $row['boyaMaxAdet'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Balya Adet</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="balyaAdet" value="<?php echo $row['balyaAdet'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Max Gramaj</label>
                            <input required type="number" class="form-control form-control-lg"  step="0.1"
                                   name="maxGramaj" value="<?php echo $row['maxGramaj'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Ezilme Katsayısı</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="ezilmeKatsayisi" value="<?php echo $row['ezilmeKatsayisi'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" class="form-control form-control-lg"
                                   name="aciklama" value="<?php echo $row['aciklama'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label></label>
                            <?php if ($row['resim'] != "") { ?>
                                <div style="text-align: center">
                                    <h4 style="color: #0e84b5">
                                        <a href="<?php echo base_url() . $row['resim']; ?>" target="_blank">
                                           Çizim (Pdf) </a>
                                    </h4>
                                </div>
                            <?php } ?>
                            <input type="file" name="resim">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group" style="margin-top: 30px; text-align: center">

                            <?php if ($row['paketlemeSekli'] != "") { ?>
                                <a href="<?php echo base_url() . $row['paketlemeSekli']; ?>" data-toggle="lightbox"
                                   data-title="<?php echo $row['profilNo'] . " - Paketleme Şekli" ?>"
                                   data-gallery="gallery">
                                    <img width="200px" src="<?php echo base_url() . $row['paketlemeSekli']; ?>"
                                         class="img-fluid mb-4"
                                         alt="<?php echo $row['profilNo'] . " - Paketleme Şekli" ?>"/>
                                </a>
                                <p style="color: #00bfff; font-weight: bold"> Eğer tekrar Paketleme Şeklini yüklemek isterseniz
                                    resim seçin.</p>
                                <input type="file" name="paketlemeSekli">
                            <?php } else { ?>
                                <label>Paketleme Şekli</label>
                                <input type="file" name="paketlemeSekli">
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-sm-3" style="">
                        <div class="form-group" style="margin-top: 30px; text-align: center">
                            <?php if ($row['sepetDizilmeSekli'] != "") { ?>
                                <a href="<?php echo base_url() . $row['sepetDizilmeSekli']; ?>" data-toggle="lightbox"
                                   data-title="<?php echo $row['profilNo'] . " - Sepete Dizilme Şekli" ?>">
                                    <img width="200px" src="<?php echo base_url() . $row['sepetDizilmeSekli']; ?>"
                                         class="img-fluid mb-4"
                                         alt="<?php echo $row['profilNo'] . " - Sepete Dizilme Şekli Şekli" ?>"/>
                                </a>
                                <p style="color: #00bfff; font-weight: bold"> Eğer tekrar Sepete Dizilme Şekli Yüklemek isterseniz
                                    resim seçin.</p>
                                <input type="file" name="sepetDizilmeSekli">
                            <?php } else { ?>
                                <label>Sepet Şekli</label>
                                <input type="file" name="sepetDizilmeSekli">
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-sm-3" style="">
                        <div class="form-group" style="margin-top: 30px; text-align: center">
                            <?php if ($row['cizim'] != "") { ?>
                                <a href="<?php echo base_url() . $row['cizim']; ?>" data-toggle="lightbox"
                                   data-title="<?php echo $row['cizim'] . " - Çizimler" ?>">
                                    <img width="200px" src="<?php echo base_url() . $row['cizim']; ?>"
                                         class="img-fluid mb-4"
                                         alt="<?php echo $row['profilNo'] . " - Çizimleri" ?>"/>
                                </a>
                                <p style="color: #00bfff; font-weight: bold"> Eğer tekrar Çizim Yüklemek İsterseniz Yükleyiniz.</p>
                                <input type="file" name="cizim">
                            <?php } else { ?>
                                <label>Çizim</label>
                                <input type="file" name="cizim">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="profilguncelleme" class="btn btn-info float-right">Güncelleme
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
