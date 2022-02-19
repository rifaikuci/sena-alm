<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Malzeme Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/malzemeler.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Malzeme Adı</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Malzeme Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Birim</label>
                            <select required name="birim" class="select2" style="width: 100%;">
                                <option selected value="">Birimi Seçiniz</option>
                                <option value="kg">Kg</option>
                                <option value="lt">Lt</option>
                                <option value="adet">Adet</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Birim Miktarı</label>
                            <input required type="number" class="form-control form-control-lg" name="birimMiktari"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kullanıldığı Alan</label>
                            <select required name="kullanildigiAlanlar" class="select2" style="width: 100%;">
                                <option selected value="">Kullanıldığı Alan</option>
                                <option value="kaliphane">Kalıphane</option>
                                <option value="boyahane">Boyahane</option>
                                <option value="kromat">Kromat</option>
                                <option value="pres">Pres</option>
                                <option value="stok">Stok</option>
                                <option value="paketleme">Paketleme</option>
                                <option value="sevkiyat">Sevkiyat</option>
                            </select>
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
