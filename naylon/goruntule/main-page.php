<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

if ($_GET['id']) {

    $id = $_GET['id'];

    $sqlnaylon = "select  n.id as id, s.satirNo, naylonId1, s.siparisTuru, naylonId2,kullanilan1, kullanilan2, s1.barkod as barkod1, s2.barkod as barkod2, n.adet,
profilNo, profilAdi, boy, e.ad as eloksalAd, pr.ad as boyaAd
from tblnaylon n
INNER JOIN tblbaski t ON n.baskiId = t.id
INNER JOIN tblsiparis s on s.id = t.siparisId
INNER JOIN tblprofil p on p.id = s.profilId
LEFT JOIN tbleloksal e on s.eloksalId = e.id
LEFT JOIN tblprboya pr on s.boyaId = pr.id
LEFT JOIN   tblstokmalzeme s1 ON s1.id = n.naylonId1
LEFT JOIN   tblstokmalzeme s2 ON s2.id = n.naylonId2 WHERE n.id = '$id'";

    $naylon = mysqli_query($db, $sqlnaylon)->fetch_assoc();

} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Naylon Görüntüleme Alanı
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Satır No - Profil Adı - Boy - Yüzey Detay - Adet</label>
                            <input disabled
                                   value="<?php
                                   $satirNo = $naylon['satirNo'];
                                   $profil = $naylon['profilNo'];
                                   $boy = $naylon['boy'];
                                   $yuzey  = $naylon['siparisTuru'];
                                   $yuzeyDetay = $yuzey == "B" ? "Boyalı" : ($yuzey == "E" ? "Eloksal" : "Pres");
                                   $cins = $yuzey == "B" ? $naylon['boyaAd'] : ($yuzey == "E" ? $naylon['eloksalAd'] : "Pres");
                                   $adet = $naylon['adet'];
                                   $value = $satirNo . " - ". $profil ." - ". $boy . " - " . $yuzeyDetay . " - ". $cins . " - ". $adet;
                                   echo $value ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="">

                        </div>
                        <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Naylon </label>
                            <input disabled
                                   value="<?php echo $naylon['barkod1']; ?>"
                                   type="text" class="form-control form-control-lg"
                                   placeholder="">

                        </div>
                    </div>

                    <div class="col-sm-4">
                    <div class="form-group">
                        <label>Naylon Kullanılan Adet</label>
                        <input disabled value="<?php echo $naylon['kullanilan1']; ?>"
                               type="text" class="form-control form-control-lg"
                               placeholder="0">
                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label> Naylon </label>
                    <input disabled
                           value="<?php echo $naylon['barkod2']; ?>"
                           type="text" class="form-control form-control-lg"
                           placeholder="">

                </div>
            </div>

            <div class="col-sm-4">
            <div class="form-group">
                <label>Naylon Kullanılan Adet</label>
                <input disabled value="<?php echo $naylon['kullanilan2']; ?>"
                       type="text" class="form-control form-control-lg"
                       placeholder="0">
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div>
            <a href="../"
               class="btn btn-success float-right">Naylonlamaya Dön</a>
        </div>
    </div>
    </div>


    </form>
    </div>

</section>
