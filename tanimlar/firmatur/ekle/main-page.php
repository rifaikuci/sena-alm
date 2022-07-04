<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Firma Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/firmatur.php' ?>">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Firma Türü</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Firma Türü Giriniz...">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="firmaturekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
