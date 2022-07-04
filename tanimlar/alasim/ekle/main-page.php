<?php
include "../../../netting/baglan.php";


$firmasql = "SELECT * FROM tblfirma WHERE firmaTurId = '10' ";
$firmalar = $db->query($firmasql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Alaşım Türleri Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/alasim.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Alaşım Türü</label>
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   placeholder="Alaşım Türü Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyet Br Gramaj (Cm)</label>
                            <input required type="number" step="0.01" class="form-control form-control-lg"
                                   name="biyetBirimGramaj"
                                   placeholder="0,00">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <select name="firmaId" required class="form-control select2" style="width: 100%;">
                                <option selected disabled value="">Firma Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="alasimekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
