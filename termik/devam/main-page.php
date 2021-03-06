<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

error_reporting(1);
ini_set('display_errors', 1);
$termikId = 0;
if (isset($_GET['termik'])) {
    $termikId = $_GET['termik'];

    $sql = "SELECT * FROM tbltermik WHERE id = '$termikId'";
    $termik = mysqli_query($db, $sql)->fetch_assoc();

    $baskilarTemp = explode(";", $termik['baskilar']);
    $uzunluk = count($baskilarTemp);
    $baskilarTemp = array_unique($baskilarTemp);

    $baskilar = array();
    for($i = 0 ; $i<$uzunluk; $i++) {
        if($baskilarTemp[$i]) {
            array_push($baskilar,$baskilarTemp[$i]);
        }
    }

}

date_default_timezone_set('Europe/Istanbul');


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Termik Bitirme Alanı
        </div>
        <div class="card-body" id="termik-guncelle">
            <form method="post" action="<?php echo base_url() . 'netting/termik/index.php' ?>"
                  enctype="multipart/form-data">
                <div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div style="text-align: right">
                                    <label> Termik Başlama Zamanı: <span
                                                style="color: #0b93d5"> <?php echo $termik['baslaTarih'] ?> </span></label>
                                </div>
                                <input type="hidden" value="true" name="termikbitir">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div style="text-align: right">

                                    <div style="text-align: center">
                                        <label style="color: darkgreen;font-size: 25px">Baskılar için Termik
                                            Değerleri</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $termik = "";
                    $siparisler = "";
                    $tur = "";
                    $baskiekle = "";
                    for ($i = 0; $i < count($baskilar); $i++) { ?>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">

                                    <label><?php

                                        $baskiId = $baskilar[$i];
                                        $sql2 = "Select b.id, b.satirNo, boy,s.id as siparisId, istenilenTermik,siparisTuru  from tblbaski b
                                            INNER JOIN tblsiparis s on s.id = b.siparisId
where b.id = '$baskiId'";
                                        $item = mysqli_query($db, $sql2)->fetch_assoc();


                                        $satirNo =  $item['satirNo'];
                                        $siparisId = $item['siparisId'];

                                        $siparisler = $siparisler .$siparisId . ",";
                                        $tur = $tur . $item['siparisTuru'] . ",";
                                        $baskiekle = $baskiekle . $baskiId . ",";
                                        $termik = $termik . $item['istenilenTermik'] . ",";
                                        echo "Satır No : " . $satirNo.  " Baskı Numarası  : " . $baskilar[$i] . " Boy : " . $item['boy']. " Termik Değeri : " . $item['istenilenTermik'] ;
                                        ?></label>
                                    <input name="<?php echo "baski" . $item['id'] ?>" required class="form-control"
                                           type="number" placeholder="1">
                                    <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                    $baskiekle = rtrim($baskiekle, ',');
                    $tur = rtrim($tur, ',');
                    $termik = rtrim($termik, ',');
                    $siparisler = rtrim($siparisler, ',');
                    ?>
                    <input type="hidden" name="baskilar" value="<?php echo $baskiekle ?>">
                    <input type="hidden" name="id" value="<?php echo $_GET['termik'] ?>">
                    <input type="hidden" name="siparisler" value="<?php echo $siparisler ?>">


                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" class="btn btn-info float-right">Bitir</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>

                </div>
            </form>

        </div>


    </div>

</section>
