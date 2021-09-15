<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';

    $sql = "SELECT * FROM tblfirma WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    $sqlfirmatur = "SELECT * FROM tblfirmatur";
    $firmatur = $db->query($sqlfirmatur);
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Firma Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/firma.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                            <input required type="text" class="form-control form-control-lg" name="firmaAd"
                                   value="<?php echo $row['firmaAd'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Kısa Kod</label>
                            <input required type="text" class="form-control form-control-lg" name="kisaKod"
                                   value="<?php echo $row['kisaKod'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Firma Türü</label>
                            <select disabled name="firmaTurId" class="form-control form-control-lg" style="width: 100%;">
                                <option value="">Firma Türü Seçiniz</option>
                                <?php while ($firma = $firmatur->fetch_array()) { ?>
                                    <option <?php echo $row['firmaTurId'] == $firma['id'] ? 'selected' : '' ?>
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['ad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Vergi Dairesi</label>
                            <input required type="text" class="form-control form-control-lg" name="vergiDairesi"
                                   value="<?php echo $row['vergiDairesi'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Vergi Numarası</label>
                            <input required type="text" class="form-control form-control-lg" name="vergiNumara"
                                   value="<?php echo $row['vergiNumara'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Yetkili Kişi</label>
                            <input required type="text" class="form-control form-control-lg" name="yetkiliKisi"
                                   value="<?php echo $row['yetkiliKisi'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input required type="text" class="form-control form-control-lg" name="telefon"
                                   value="<?php echo $row['telefon'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Mail</label>
                            <input required type="text" class="form-control form-control-lg" name="mail"
                                   value="<?php echo $row['mail'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Adres</label>
                            <input required type="text" class="form-control form-control-lg" name="adres"
                                   value="<?php echo $row['adres'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>İl</label>
                            <input required type="text" class="form-control form-control-lg" name="il"
                                   value="<?php echo $row['il'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>İlçe</label>
                            <input required type="text" class="form-control form-control-lg" name="ilce"
                                   value="<?php echo $row['ilce'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input required type="text" class="form-control form-control-lg" name="aciklama"
                                   value="<?php echo $row['aciklama'] ?>">
                        </div>
                    </div>
                    <?php if($row['firmaTurId'] == 24) { ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Naylon Durumu</label>
                            <select required name="naylon" class="form-control form-control-lg" style="width: 100%;">
                                <option value="">Naylon Durumu</option>
                                <option <?php echo $row['naylon'] == 1 ? "selected" : "" ?> value="1">Evet</option>
                                <option <?php echo $row['naylon'] == 0 ? "selected" : "" ?> value="0">Hayır</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="firmaguncelleme" class="btn btn-info float-right">Güncelle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
