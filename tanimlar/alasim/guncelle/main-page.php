<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';

    $sql = "SELECT * FROM tblalasim WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    $firmasql = "SELECT * FROM tblfirma where firmaTurId = 10 ";
    $firmalar = $db->query($firmasql);
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Firma Türleri Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/alasim.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Alaşım Türü</label>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   value="<?php echo $row['ad'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Biyet Br Gramaj (Cm)</label>
                            <input required type="number" step="0.01" class="form-control form-control-lg"
                                   value="<?php echo $row['biyetBirimGramaj'] ?>"
                                   name="biyetBirimGramaj"
                                   placeholder="0,00">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <select name="firmaId" required class="form-control select2" style="width: 100%;">
                                <option  disabled value="">Firma Seçiniz</option>
                                <?php while ($firma = $firmalar->fetch_array()) { ?>
                                    <option <?php echo  $firma['id'] == $row['firmaId'] ? "selected" : ""?>
                                            value="<?php echo $firma['id']; ?>"><?php echo $firma['firmaAd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="alasimguncelleme" class="btn btn-info float-right">Güncelleme
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
