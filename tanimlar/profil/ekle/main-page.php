<?php

include '../../../netting/baglan.php';

$sql = "SELECT MAX(profilNo) as profil FROM tblprofil";
$result = mysqli_query($db, $sql);
$row = $result->fetch_assoc();
$profilNo = 1000;
if ($row['profil'] != "") {
    $profilNo = $row['profil'] + 1;
}

$sqlsektor = "SELECT * FROM tblsektor";
$sektorler = $db->query($sqlsektor);
?>


<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Profil Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/profil.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $profilNo ?>">

                            <input required type="hidden" class="form-control form-control-lg"
                                   value="<?php echo $profilNo ?>" name="profilNo">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Adı</label>
                            <input required type="text" class="form-control form-control-lg" name="profilAdi"
                                   placeholder="Profil Adı Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sektör</label>
                            <select required name="sektorId" class="form-group select2" style="width: 100%;">
                                <option selected value="">Sektör Seçiniz</option>
                                <?php while ($sektor = $sektorler->fetch_array()) { ?>
                                    <option value="<?php echo $sektor['id']; ?>"><?php echo $sektor['ad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Gramaj (Gr)</label>
                            <input required type="number" class="form-control form-control-lg" step="1"
                                   name="gramaj" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Alanı (mm2)</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="alan" placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Çevresi (mm)</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="cevre" placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paket Adet</label>
                            <input required type="number" class="form-control form-control-lg" step="1"
                                   name="paketAdet" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Paket En (cm)</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="paketEn" placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Paket Boy (cm)</label>
                            <input required type="number" class="form-control form-control-lg" step="0.1"
                                   name="paketBoy" placeholder="0.1">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Boya Max Adet</label>
                            <input required type="number" class="form-control form-control-lg" step="1"
                                   name="boyaMaxAdet" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Balya Adet</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="balyaAdet" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Max Gramaj (Gr)</label>
                            <input required type="number" class="form-control form-control-lg" step="1"
                                   name="maxGramaj" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Ezilme Katsayısı</label>
                            <input required type="number" class="form-control form-control-lg" step="1"
                                   name="ezilmeKatsayisi" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" class="form-control form-control-lg"
                                   name="aciklama" placeholder="Profil Açıklama giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Çizim (Pdf)</label>
                            <input required type="file" name="resim">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Paketleme Şekli</label>
                            <input type="file" name="paketlemeSekli">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Sepet Dizilme Şekli</label>
                            <input type="file" name="sepetDizilmeSekli">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Çizim (JPG) </label>
                            <input required type="file" name="cizim">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="profilekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
