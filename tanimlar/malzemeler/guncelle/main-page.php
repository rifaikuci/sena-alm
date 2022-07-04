<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';
    include '../../../include/data.php';

    $sql = "SELECT * FROM tblmalzemeler WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Firma Türleri Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/malzemeler.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Malzemeler</label>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   value="<?php echo $row['ad'] ?>">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kullanıldığı Alan</label>
                            <select required name="kullanildigiAlanlar" class="select2" style="width: 100%;">
                                <option selected value="">Kullanıldığı Alan</option>
                                <?php for ($i = 0; $i < count($kullanildigiAlanlar); $i++) { ?>
                                    <option <?php echo $row['kullanildigiAlanlar'] == $kullanildigiAlanlar[$i] ? "selected" : "" ?>
                                            value="<?php echo $kullanildigiAlanlar[$i]; ?>"><?php echo $kullanildigiAlanlar[$i]; ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Birim</label>
                            <select required name="birim" class="select2" style="width: 100%;">
                                <option value="">Birimi Seçiniz</option>
                                <?php for ($i = 0; $i < count($birimler); $i++) { ?>
                                    <option <?php echo $row['birim'] == $birimler[$i] ? "selected" : "" ?>
                                            value="<?php echo $birimler[$i]; ?>"><?php echo $birimler[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Birim Miktarı</label>
                            <input required type="number" class="form-control form-control-lg" name="birimMiktari"
                                   value="<?php echo $row['birimMiktari'] ?>">
                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="malzemelerguncelleme" class="btn btn-info float-right">Güncelleme
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
