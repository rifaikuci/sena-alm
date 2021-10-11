

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Parça Ekleme Alanı
        </div>
        <div class="card-body" id="baski-giris">
            <form method="post" action="<?php echo base_url() . 'netting/kalipci/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{deneme}}</label>
                            <select id="supplier_id" required class="form-control select2" style="width: 100%">
                                    <option value="123">123</option>
                                    <option value="1234">1234</option>
                                    <option value="1235">1235</option>
                                    <option value="123467">123467</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" v-on:click="onChangeParca($event)" class="btn btn-info float-right">Ekle</button>


                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="kalipciekle" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
