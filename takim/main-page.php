<?php

include "../netting/baglan.php";
include "../include/sql.php";


$sql = "SELECT * FROM tbltakim where durum = 1 order by id desc ";

$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Takım Stoğa Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Takım Stoğa Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumcop'] == "ok") {
        durumSuccess("Takım Çöpe Çıkarıldı. ");
    } else if ($_GET['durumcop'] == "no") {
        durumDanger("Takım Çöpe Çıkarılırken Bir Hata Oluştu.");
    } else if ($_GET['desbols'] == "ok") {
        durumSuccess("Takıma ait Destek ve Bolster Güncellendi");
    } else if ($_GET['desbols'] == "no") {
        durumDanger("Takıma ait Destek ve Bolster Güncellenirken bir hata oluştu");
    } else if ($_GET['durumdegis'] == "ok") {
        durumSuccess("Takıma parçası değiştirildi");
    } else if ($_GET['durumdegis'] == "no") {
        durumDanger("Takıma parçası değiştirilirken bir hata oluştu");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Takımlar</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <br>
                <div class="card" id="takim-goster">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sena No</th>
                                <th>Profil</th>
                                <th>Firma</th>
                                <th>Kalıp Cinsi</th>
                                <th>Çap</th>
                                <th>Parça 1</th>
                                <th>Parça 2</th>
                                <th>Gramaj</th>
                                <th>Destekler</th>
                                <th>Bolsterler</th>
                                <th></th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td><?php echo $row['takimNo']; ?></td>
                                    <td><?php echo $row['profilId'] ?
                                            tablogetir('tblprofil', 'id', $row['profilId'], $db)['profilNo'] : "-"; ?></td>
                                    <td><?php echo tablogetir('tblfirma', 'id', $row['firmaId'], $db)['firmaAd']; ?></td>
                                    <td><?php echo trim(kalipBul($row['kalipCins'])); ?></td>
                                    <td><?php echo $row['cap']; ?></td>
                                    <td><?php echo $row['parca1'] ?></td>
                                    <td><?php echo $row['parca2'] ?></td>
                                    <td><?php echo $row['sonGramaj'] ?></td>
                                    <td>
                                        <button type="button" v-on:click="destekgoster($event)" class="btn btn-success"
                                                data-toggle="modal" data-parca="<?php echo $row['destek'] ?>">Destekler
                                        </button>
                                    </td>

                                    <td>
                                        <button type="button" v-on:click="bolstergoster($event)" class="btn btn-dark"
                                                data-toggle="modal" data-parca="<?php echo $row['bolster'] ?>">
                                            Bolsterler
                                        </button>
                                    </td>

                                    <td>
                                        <button type="button" @click="modaltrash($event)" class="btn btn-danger"
                                                data-parca1="<?php echo $row['parca1'] ?>"
                                                data-parca2="<?php echo $row['parca2'] ?>"
                                                data-takimno="<?php echo $row['takimNo'] ?>"
                                                data-toggle="modal"><i class="fa fa-trash"></i>
                                        </button>
                                        <a href="<?php echo "desbols/?takimno=" . $row['takimNo']; ?>"
                                           class="btn btn-outline-dark"><i class="fa fa-list"></i></a>
                                        <?php if ($row['kalipCins'] != 3) { ?>
                                            <a href="<?php echo "degistir/?takimno=" . $row['takimNo']; ?>"
                                               class="btn btn-primary"><i class="fa fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                    </td>


                                </tr>
                                <?php $sira++;

                            } ?>
                            </tbody>
                        </table>

                        <div id="modalview" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-xl">

                                <div class="modal-content">
                                    <div style="margin: 10px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
</section>