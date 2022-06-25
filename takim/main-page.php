<?php

include "../netting/baglan.php";
include "../include/sql.php";


$sql = "select t.id as id, takimNo, profilId, profilNo, cap, sonGramaj, netKilo, brutKilo, destek, durum, bolster from tbltakim t
INNER JOIN tblprofil p ON t.profilId = p.id where durum = 1 order by id desc ";

$result = $db->query($sql);


$islemArray = [1];
$sonuc = in_array($rolId, $islemArray);

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
                                <th>Çap</th>
                                <th>Gramaj</th>
                                <th>Basılan Kg</th>
                                <th>Brüt Kg</th>
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
                                    <td><?php echo $row['cap']; ?></td>
                                    <td><?php echo $row['sonGramaj'] ?></td>
                                    <td><?php echo sayiFormatla($row['netKilo']); ?></td>
                                    <td><?php echo sayiFormatla($row['brutKilo']); ?></td>
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
                                        <?php if($sonuc){  ?>
                                        <button type="button" @click="modaltrash($event)" class="btn btn-danger"
                                                data-parca1="<?php echo $row['parca1'] ?>"
                                                data-parca2="<?php echo $row['parca2'] ?>"
                                                data-takimno="<?php echo $row['takimNo'] ?>"
                                                data-toggle="modal"><i class="fa fa-trash"></i>
                                        </button>
                                        <?php } ?>
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