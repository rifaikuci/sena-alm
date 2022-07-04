<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';

    $sql = "SELECT * FROM tblprboya WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Boya Türleri Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/boya.php' ?>">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Renk</label>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                            <input required type="text" class="form-control form-control-lg" name="ad"
                                   value="<?php echo $row['ad'] ?>">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>RAL</label>
                            <input required type="text" step="0.01" class="form-control form-control-lg"  name="kod"
                                   value="<?php echo $row['kod'] ?>">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="boyaguncelleme" class="btn btn-info float-right">Güncelleme
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
