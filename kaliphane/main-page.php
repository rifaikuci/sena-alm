<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tbltakim order by sonIslemZamani DESC";
$result = $db->query($sql);

$operatorId =  isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0;

?>


<section class="content">

    <?php
    if ($_GET['durum'] == "ok") {
        durumSuccess("Kalıp İşlemi Başarılı Bir Şekilde Yapıldı. ");
    } else if ($_GET['durum'] == "no") {
        durumDanger("Kalıp İşlemi Yapılırken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Kalıp İşlemi Başarılı Bir Şekilde Silindi. ");
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
                                        $olProcess = "R2";
                                        $newProcess = "R3";
                                        ?>

                                          <button  class="btn btn-primary" onclick="<?php
                                          $function = 'myFunction(' . $takimId . ','. $operatorId . ",'R1','R2'" .')';
                                          echo $function ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </button>
                                    <?php } else if ($row['konum'] == "K1") { ?>
                                        <a class="btn btn-dark"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=K1&newProcess=K2&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=K1&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    <?php } else if ($row['konum'] == "K2") { ?>
                                        <a class="btn btn-default"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=K2&newProcess=K3&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=K2&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    <?php } else if ($row['konum'] == "K3") { ?>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=K3&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>

                                    <?php } else if ($row['konum'] == "T1") { ?>
                                        <a class="btn btn-dark"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T1&newProcess=T2&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T1&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>

                                    <?php } else if ($row['konum'] == "T2") { ?>
                                        <a class="btn btn-default"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T2&newProcess=T3&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T2&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>

                                    <?php } else if ($row['konum'] == "T3") { ?>
                                        <a class="btn btn-warning"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T3&newProcess=T6&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-danger"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T3&newProcess=T4&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T3&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>

                                   <?php } else if ($row['konum'] == "T4") { ?>
                                        <a class="btn btn-success"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T4&newProcess=T5&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T4&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>

                                    <?php } else if ($row['konum'] == "T5") { ?>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T5&newProcess=P&operatorId=$operatorId"  ?>">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    <?php } else if ($row['konum'] == "T6") { ?>
                                    <a class="btn btn-primary"
                                       href="<?php echo base_url(). "netting/kaliphane/index.php/?takimId=$takimId&oldProcess=T6&newProcess=P&operatorId=$operatorId"  ?>">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </a>
                                    <?php }  ?>

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
            console.log(takimId, operatorId, oldProcess, newProcess);
            debugger;
            let person = prompt("Please enter your name", "Harry Potter");
            if (person != null) {
                document.getElementById("demo").innerHTML =
                    "Hello " + person + "! How are you today?";
            }
        }
    </script>
</section>


