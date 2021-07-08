<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Alaşım Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/alasim.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Alaşım Türü</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Alaşım Türü Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Özkütle</label>
                            <input required type="number" step="0.01" class="form-control form-control-lg"
                                   name="ozkutle"
                                   placeholder="0,00">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="alasimekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../alasim"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
