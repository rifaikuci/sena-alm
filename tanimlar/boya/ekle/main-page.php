,<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boya Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/boya.php' ?>">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Renk</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Renk Giriniz...">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>RAL</label>
                            <input required type="text"  class="form-control form-control-lg" name="kod"
                                   placeholder="RAL Kodu Giriniz...">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="boyaekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
