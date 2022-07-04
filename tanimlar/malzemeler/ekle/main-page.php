<?
require_once "../../../include/data.php";

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Malzeme Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/malzemeler.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Malzeme Adı</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Malzeme Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kullanıldığı Alan</label>
                            <select required name="kullanildigiAlanlar" class="select2" style="width: 100%;">
                                <option selected value="">Kullanıldığı Alan</option>
                                <?php for($i = 0; $i < count($kullanildigiAlanlar); $i++) {   ?>
                                    <option value="<?php echo $kullanildigiAlanlar[$i]; ?>"><?php echo $kullanildigiAlanlar[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Birim</label>
                            <select required name="birim" class="select2" style="width: 100%;">
                                <option selected value="">Birimi Seçiniz</option>
                              <?php for($i = 0; $i < count($birimler); $i++) {   ?>
                                <option value="<?php echo $birimler[$i]; ?>"><?php echo $birimler[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Birim Miktarı</label>
                            <input required type="number" class="form-control form-control-lg" name="birimMiktari"
                                   placeholder="0">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="malzemelerekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
