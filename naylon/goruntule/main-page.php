<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlnaylon = "SELECT * FROM tblnaylon WHERE id = '$id'";
    $naylon = mysqli_query($db, $sqlnaylon)->fetch_assoc();


} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Naylon Görüntüleme Alanı
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Satır No - Kesim - Adet</label>
                            <input disabled
                                   value="<?php echo $naylon['satirNo'] . " -  " . $naylon['kesimId'] . " -  " . $naylon['adet'] ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Naylon </label>
                            <input disabled
                                   value="<?php echo $naylon['naylonId1'] > 0 ? tablogetir('tblstokmalzeme', 'id', $naylon['naylonId1'], $db)['barkod'] : ""; ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="">

                        </div>
                    </div>

                    <div class="col-sm-4">
                    <div class="form-group">
                        <label>Naylon Kullanılan Adet</label>
                        <input disabled value="<?php echo $naylon['kullanilan1']; ?>"
                               type="text" class="form-control form-control-lg"
                               placeholder="0">
                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label> Naylon </label>
                    <input disabled
                           value="<?php echo $naylon['naylonId2'] > 0 ? tablogetir('tblstokmalzeme', 'id', $naylon['naylonId2'], $db)['barkod'] : ""; ?>"
                           type="text" class="form-control form-control-lg"
                           placeholder="">

                </div>
            </div>

            <div class="col-sm-4">
            <div class="form-group">
                <label>Naylon Kullanılan Adet</label>
                <input disabled value="<?php echo $naylon['kullanilan2']; ?>"
                       type="text" class="form-control form-control-lg"
                       placeholder="0">
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div>
            <a href="../"
               class="btn btn-success float-right">Naylonlamaya Dön</a>
        </div>
    </div>
    </div>


    </form>
    </div>

</section>
