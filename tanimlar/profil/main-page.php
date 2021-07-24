<?php
include "../../netting/baglan.php";

$sql = "SELECT * FROM tblprofil";
$result = $db->query($sql);

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
                <div style="text-align: right;margin-right: auto">
                    <a href="ekle/" class="btn btn-primary"><i class="fa fa-plus"><?php echo "\t\t\t\t" ?>
                            Ekle</i></a>
                </div>
                <br>
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Profil Adı</th>
                                <th>Alan</th>
                                <th>Çevre</th>
                                <th>Ağırlık</th>
                                <th>Resim</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sira = 1;
                            while ($row = $result->fetch_array()) { ?>
                                <tr>
                                    <td style="font-weight: bold"><?php echo $sira; ?></td>
                                    <td><?php echo $row['profilAdi']; ?></td>
                                    <td><?php echo $row['alan']; ?></td>
                                    <td><?php echo $row['cevre']; ?></td>
                                    <td><?php echo $row['gramaj']; ?></td>
                                    <td><a target="_blank" href="<?php echo base_url() . $row['resim']; ?>"> Resim için
                                            tıklayınız </a></td>
                                    <td>
                                        <a href=<?php echo "guncelle/?id=" . $row['id']; ?> class="btn
                                           btn-warning">Düzenle</a>
                                        <a href=<?php echo base_url() . "netting/tanimlar/profil.php?profilsil=" . $row['id']; ?> class="btn
                                           btn-danger">Sil</a>
                                    </td>

                                    <td style="text-align: center">
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


