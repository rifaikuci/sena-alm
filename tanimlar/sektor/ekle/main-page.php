<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Sektör Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/sektor.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Sektör Türü</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Sektör Türü Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kısa Kod</label>
                            <input required type="text" class="form-control form-control-lg"
                                   name="kisakod"
                                   placeholder="Kısa Kod">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="sektorekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
