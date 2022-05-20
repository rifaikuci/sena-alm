<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tbltakim order by sonIslemZamani DESC";
$result = $db->query($sql);

$operatorId = isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0;

?>


<section class="content">

    <?php
    if ($_GET['durum'] == "ok") {
        durumSuccess("Kalıp İşlemi Başarılı Bir Şekilde Yapıldı. ");
    } else if ($_GET['durum'] == "no") {
        durumDanger("Kalıp İşlemi Yapılırken Bir Hata Oluştu !");
    } else if ($_GET['durum'] == "cancel") {
        durumDanger("Kalıp İşlemi iptal edildi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kalıp İşlemi Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Kalıp İşlemi Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Kalıp İşlemi Güncellenirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kalıp İşlemleri</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-primary " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Prese Ver
                </h6>
            </div>
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-dark " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Kostik
                </h6>
            </div>
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-default " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Kumlama
                </h6>
            </div>
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-warning " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Tashihat
                </h6>
            </div>
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-success " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Sevk Giriş
                </h6>
            </div>
            <div class="col-2">
                <h6 style="color: #0b93d5">
                    <a class="btn btn-danger " target="_blank"
                       href="#"><i class="fa fa-print" aria-hidden="true"></i></a> Sevk Çıkış
                </h6>
            </div>

        </div>
        <br>


        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Takım</th>
                            <th>Son İşlem Zamanı</th>
                            <th>Konumu</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>

                        <?php $sira = 1;
                        while ($row = $result->fetch_array()) { ?>
                            <tr>
                                <td style="font-weight: bold"><?php echo $sira; ?></td>
                                <td><?php echo $row['takimNo']; ?></td>
                                <td><?php echo tarihsaat($row['sonIslemZamani']); ?></td>
                                <td><?php echo takimDurumBul($row['konum']) ?></td>
                                <td>
                                    <?php
                                    $takimId = $row['id'];
                                    if ($row['konum'] == "P") {
                                        "";
                                    } else if ($row['konum'] == "R1") {
                                        $olProcess = "R1";
                                        $newProcess = "P";
                                        ?>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "K1") {
                                        $olProcess = "K1";
                                        $newProcess = "K2";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-dark" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "K2") {
                                        $olProcess = "K2";
                                        $newProcess = "K3";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-default" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>
                                    <?php } else if ($row['konum'] == "K3") {
                                        $olProcess = "K3";
                                        $newProcess = "P";
                                        ?>

                                        <button class="btn btn-default" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T1") {
                                        $olProcess = "T1";
                                        $newProcess = "T2";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-dark" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T2") {

                                        $olProcess = "T2";
                                        $newProcess = "T3";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-default" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T3") {

                                        $olProcess = "T3";
                                        $newProcess2 = "T6";
                                        $newProcess = "T4";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-warning" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess2'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-danger" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T4") {

                                        $olProcess = "T4";
                                        $newProcess = "T5";
                                        $defaultProcess = "P"
                                        ?>

                                        <button class="btn btn-success" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$defaultProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T5") {
                                        $olProcess = "T5";
                                        $newProcess = "P";
                                        ?>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>

                                    <?php } else if ($row['konum'] == "T6") {
                                        $olProcess = "T6";
                                        $newProcess = "P";
                                        ?>

                                        <button class="btn btn-primary" onclick="<?php
                                        $function = 'myFunction(' . $takimId . ',' . $operatorId . ",'$olProcess','$newProcess'" . ')';
                                        echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php $sira++;
                        } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function myFunction(takimId, operatorId, oldProcess, newProcess) {

            if (oldProcess == "T3" || oldProcess == "T4") {
                let description = prompt("Lütfen açıklama giriniz");
                if (description) {

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>netting/kaliphane/index.php",
                        data: {
                            takimId: takimId,
                            operatorId: operatorId,
                            oldProcess: oldProcess,
                            newProcess: newProcess,
                            description: description
                        },
                        success: function (response) {
                            var url = location.protocol + '//' + location.host + location.pathname;
                            if (response == "true") {
                                url += "?durum=ok";
                                window.location.href = url;
                            } else {
                                url += "?durum=no";
                                window.location.href = url;
                            }
                        }
                    });
                } else {
                    var url = location.protocol + '//' + location.host + location.pathname;
                    url += "?durum=cancel";
                    window.location.href = url;
                }

            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>netting/kaliphane/index.php",
                    data: {
                        takimId: takimId,
                        operatorId: operatorId,
                        oldProcess: oldProcess,
                        newProcess: newProcess,
                        description: ""
                    },
                    success: function (response) {
                        var url = location.protocol + '//' + location.host + location.pathname;
                        if (response == "true") {
                            url += "?durum=ok";
                            window.location.href = url;
                        } else {
                            url += "?durum=no";
                            window.location.href = url;
                        }
                    }
                });
            }
        }

    </script>
</section>


