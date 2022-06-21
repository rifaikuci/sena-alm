<?php
include "../../netting/baglan.php";

$sql = "SELECT * FROM tblprofil order by id desc";
$result = $db->query($sql);

#TODO düzenle yerine görüntüle olacak
$islemArray = [1];
$sonuc = in_array($operatorId, $islemArray);
?>


<section class="content">

    <?php
    if ($_GET['durumekle'] == "ok") {
        durumSuccess("Profil Başarılı Bir Şekilde Eklendi. ");
    } else if ($_GET['durumekle'] == "no") {
        durumDanger("Profil Eklenirken Bir Hata Oluştu !");
    } else if ($_GET['durumsil'] == "ok") {
        durumSuccess("Profil Başarılı Bir Şekilde Silindi. ");
    } else if ($_GET['durumsil'] == "no") {
        durumDanger("Profil Silinirken Bir Hata Oluştu.");
    } else if ($_GET['durumguncelleme'] == "ok") {
        durumSuccess("Profil Başarılı Bir Şekilde Güncellendi. ");
    } else if ($_GET['durumguncelleme'] == "no") {
        durumDanger("Profil Güncellenirken Bir Hata Oluştu.");
    } else if ($_GET['hataboypdf'] == "ok") {
        durumDanger("Profil Resmi Pdf boyutu büyük daha küçük dosya ile tekrar deneyiniz. ");
    } else if ($_GET['gecersizturpdf'] == "ok") {
        durumDanger("Profil Resmi Yalnız pdf yüklenmelidir. ");
    } else if ($_GET['hatapdf'] == "ok") {
        durumDanger("Profil Resmi Yüklenirken bir hata oluştu. ");
    } else if ($_GET['hataboyimage'] == "ok") {
        durumDanger("Sepete dizilme veya Paketleme resimleri boyutu büyük daha küçük dosya ile tekrar deneyiniz. ");
    } else if ($_GET['gecersizturimage'] == "ok") {
        durumDanger("Sepete dizilme veya Paketleme resimleri  dosya türü desteklenmemektedir. jpg, png, jpeg  formatları ile tekrar deneyiniz. ");
    } else if ($_GET['hataimage'] == "ok") {
        durumDanger("Sepete dizilme veya Paketleme resimleri Yüklenirken bir hata oluştu. ");
    } ?>
    <div style="text-align: center">
        <h4 style="color: #0b93d5">Profiller</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if ($sonuc) { ?>
                    <div style="text-align: right;margin-right: auto">
                        <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                                Ekle</i></a>
                    </div>
                <?php } ?>
                <br>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 25px">#</th>
                                <th style="width: 100px;height: 50px;">Çizim</th>
                                <th>Profil</th>
                                <th>Alan</th>
                                <th>Çevre</th>
                                <th>Ağırlık</th>
                                <th>Çizim (Pdf)</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><img class="img-fluid" src="<?php echo base_url() . $row['cizim'] ?>"</td>
                                    <td><?php echo $row['profilNo'] . " - " . $row['profilAdi']; ?></td>
                                    <td><?php echo sayiFormatla($row['alan']); ?></td>
                                    <td><?php echo sayiFormatla($row['cevre']); ?></td>
                                    <td><?php echo sayiFormatla($row['gramaj']); ?></td>
                                    <td><a target="_blank" href="<?php echo base_url() . $row['resim']; ?>"> Çizim </a>
                                    </td>

                                    <td>
                                        <a href=<?php echo "guncelle/?id=" . $row['id']; ?> class="btn
                                           btn-outline-success">Görüntüle</a>
                                        <?php if ($sonuc) { ?>
                                            <a onclick="confirm('Profil Silinecek')"
                                               href=<?php echo base_url() . "netting/tanimlar/profil.php?profilsil=" . $row['id']; ?> class="btn
                                               btn-danger">Sil</a>
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


