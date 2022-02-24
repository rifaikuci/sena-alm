<?php

include '../netting/baglan.php';
require_once "../include/data.php";

$sql = "SELECT * FROM tblayar WHERE id = '1'";
$result = mysqli_query($db, $sql);
$row = $result->fetch_assoc();
?>

<?php
if ($_GET['ayarok'] == "ok") {
    durumSuccess("Ayarla başarılı bir şekilde Güncellendi.  ");
} else if ($_GET['ayarok'] == "no") {
    durumDanger("Ayarla Güncellenirken bir sorun oluştu !");
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Ayarlar Güncelleme
        </div>

        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/ayar/ayar.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Vardiya</label>
                            <select required name="vardiya" class="select2" style="width: 100%;">
                                <?php for ($i = 0; $i < count($vardiyalar); $i++) { ?>
                                    <option <?php echo $row['vardiya'] == $vardiyalar[$i] ? "selected" : "" ?>
                                            value="<?php echo $vardiyalar[$i] ?>"><?php echo $vardiyalar[$i] ?></option>
                                <?php } ?>
                            </select>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" name="ayarguncelleme" class="btn btn-info float-right">Güncelle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
