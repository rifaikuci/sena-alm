<?php

include '../../../netting/baglan.php';

$sql = "SELECT MAX(profilAdi) as profil FROM tblprofil";
$result = mysqli_query($db, $sql);
$row = $result->fetch_assoc();
$profilAdi = 1000;
if ($row['profil'] != "") {
    $profilAdi = $row['profil'] + 1;
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
                            <label>Profil Adı</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $profilAdi ?>">

                            <input required type="hidden" class="form-control form-control-lg"
                                   value="<?php echo $profilAdi ?>" name="profilAdi">
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
                            <label>Profil Gramaj</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="gramaj" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Alanı</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="alan" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil Çevresi</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="cevre" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paket Adet</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="paketAdet" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paket Ebadı</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="paketEbat" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Balya Adet</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="balyaAdet" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Max Gramaj</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="maxGramaj" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Ezilme Katsayısı</label>
                            <input required type="number" class="form-control form-control-lg"
                                   name="ezilmeKatsayisi" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" class="form-control form-control-lg"
                                   name="aciklama" placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profilin Çizimleri</label>
                            <input required type="file" name="resim">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paketleme Şekli</label>
                            <input type="file" name="paketlemeSekli">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sepet Dizilme Şekli</label>
                            <input type="file" name="sepetDizilmeSekli">
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
