<?php

include "../netting/baglan.php";
include "../include/sql.php";
$sql = "SELECT * FROM tblhavuz where tur not  in ('kromat','asit') ";
$result = $db->query($sql);

?>

<section class="content">

    <?php
    if ($_GET['doldur'] == "ok") {
        durumSuccess("Kalıphane Havuzu Başarılı Bir Şekilde Dolduruldu. ");
    } else if ($_GET['doldur'] == "no") {
        durumDanger("Kalıphane Havuzu Doldurulurken Bir Hata Oluştu !");
    } else if ($_GET['durumbosalt'] == "ok") {
        durumSuccess("Kalıphane Havuzu Boşaltıldı . ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Kalıphane Havuzu Boşaltılırken Bir Hata Oluştu.");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Kalıphane Havuzu</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Havuz</th>
                                <th>İşlem. Tar.</th>
                                <th>Durum</th>
                            </tr>
                            </thead>

                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['tur'] == "kum" ? "Kum Havuzu " : ($row['tur'] == "kostik" ? "Kostik Havuzu"  : "Tenefer Havuzu" ); ?></td>
                                    <td><?php echo $row['islemTarih'] ? tarihsaat($row['islemTarih']) : "Daha kullanılmadı"; ?></td>
                                    <td>
                                        <?php
                                        if ($row['durum'] == 0) { ?>
                                            <a href=<?php echo "doldur/?id=" . $row['id']; ?> class="btn
                                               btn-success">Doldur</a>
                                        <?php } else { ?>
                                            <a
                                                    onclick="return confirm('Havuz Boşalmak istediğinizden emin misiniz?')"
                                                    href="<?php echo base_url() . "netting/havuz/index.php?havuzbosalt=" . $row['id']; ?>"
                                                    class="btn btn-danger">Boşalt </a>
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
</section>


