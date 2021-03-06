<?php
include "../../../netting/baglan.php";

$sql = "SELECT * FROM tblfirmatur";
$result = $db->query($sql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Firma Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/firma.php' ?>">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <input required type="text" class="form-control form-control-lg" name="firmaAd"
                                   placeholder="Firma Adı Giriniz...">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Kısa Kod</label>
                            <input required type="text" class="form-control form-control-lg" name="kisaKod"
                                   placeholder="Kod">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Firma Türü</label>
                            <select name="firmaTurId" class="form-control select2" required
                                    style="width: 100%;">
                                <option  disabled selected value="">Firma Türü Seçiniz</option>
                                <?php while ($row = $result->fetch_array()) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['ad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Vergi Dairesi</label>
                            <input required type="text" class="form-control form-control-lg" name="vergiDairesi"
                                   placeholder="Vergi Dairesi Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Vergi Numarası</label>
                            <input required type="number" class="form-control form-control-lg" name="vergiNumara"
                                   placeholder="Vergi Numara Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Yetkili Kişi</label>
                            <input required type="text" class="form-control form-control-lg" name="yetkiliKisi"
                                   placeholder="Yetkili Kisi...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input required
                                   type="text" class="form-control form-control-lg" name="telefon"
                                   minlength="10" maxlength="10"
                                   placeholder="Tel Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Mail</label>
                            <input required type="text" class="form-control form-control-lg" name="mail"
                                   placeholder="Mail Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Adres</label>
                            <input required type="text" class="form-control form-control-lg" name="adres"
                                   placeholder="Adres Bilgisi Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>İl</label>
                            <input required type="text" class="form-control form-control-lg" name="il"
                                   placeholder="İl Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>İlçe</label>
                            <input required type="text" class="form-control form-control-lg" name="ilce"
                                   placeholder="İlçe Giriniz...">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input required type="text" class="form-control form-control-lg" name="aciklama"
                                   placeholder="Açıklama Giriniz...">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="firmaekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
