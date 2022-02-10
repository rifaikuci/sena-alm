<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblboya order by id desc ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Boyanma Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Boyanma Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Boyanma Başarılı Bir Şekilde Bitirildi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Boyanma Bitirilirken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Boyanmalar</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Baş. Tar.</th>
                                <th>Sepetler</th>
                                <th>Kesimler</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem /Bitirilme Zam.</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


