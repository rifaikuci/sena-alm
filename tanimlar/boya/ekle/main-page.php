<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boya Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/boya.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Boya Türü</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Boya Türü Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kod</label>
                            <input required type="text"  class="form-control form-control-lg" name="kod"
                                   placeholder="Boya Kodu Giriniz...">
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
