<?php

include "../netting/baglan.php";
include "../include/sql.php";


?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Boya Paketleme Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Boya Paketleme Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumdevam'] == "ok") {
        durumSuccess("Boya Paketleme Başarılı Bir Şekilde Tamamlandı. ");
    } else if ($_GET['durumdevam'] == "no") {
        durumDanger("Boya Paketleme Tamamlanırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Boya Paketleme</h4>
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
                                <th>Başlama Tarih</th>
                                <th>Sepet</th>
                                <th>Havuz Boya Paketleme</th>
                                <th>Havuz Asidi</th>
                                <th>Durum</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


