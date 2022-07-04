<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";

$sqlItems = "select  b.id as id, b.paketId, b.naylonId, b.boyaPaketId, b.naylonId from tblbaski b where  (b.paketId != '-1' AND b.paketId != '0' AND b.naylonId != '-1')
                                   or  (b.boyaPaketId != '0' AND b.boyaPaketId != '-1' AND b.naylonId !='-1')";

$items = $db->query($sqlItems);

$paketDizi = "";
$boyaPaketDizi = "";


while ($item = $items->fetch_array()) {

    $tempItem = $item['paketId'];
    if ($tempItem != -1) {
        $tempItem = str_replace(";", ",", $tempItem);
        $paketDizi = $paketDizi . $tempItem . ",";

    } else {
        $tempItem = $item['boyaPaketId'];
        $tempItem = str_replace(";", ",", $tempItem);
        $arrayItem = explode(",", $tempItem);
        $boyaPaketDizi = $boyaPaketDizi . $tempItem . ",";
    }

}

// tur eklenemesinin nedeni aynı id numaraları olabilir.
$paketDizi = rtrim($paketDizi, ',');
$boyaPaketDizi = rtrim($boyaPaketDizi, ',');
$sql = "";
if ($paketDizi == "" && $boyaPaketDizi != "") {
    $sql = "SELECT CONCAT ('B') as tur, bp.id as id, bp.netAdet,s.siparisTuru, bp.baskiId, bp.isNaylon, bp.naylonDurum, zaman, profilNo, profilAdi, s.satirNo, boy, e.ad as eloksalAd, pr.ad as boyaAd
from tblboyapaket bp
INNER  JOIN tblbaski b on b.id = bp.baskiId
INNER JOIN tblsiparis s on s.id = b.siparisId
INNER JOIN tblprofil p on p.id = s.profilId
LEFT JOIN tbleloksal e on s.eloksalId = e.id
LEFT JOIN tblprboya pr on s.boyaId = pr.id
where bp.id in ($boyaPaketDizi)
  and bp.isNaylon = 0";
}

if ($paketDizi != "" && $boyaPaketDizi == "") {
    $sql = "SELECT  CONCAT ('P') as tur, p.id as id, p.netAdet, s.siparisTuru, p.baskiId, p.isNaylon, p.naylonDurum, p.zaman, profilNo, profilAdi, s.satirNo, boy, e.ad as eloksalAd, pr.ad as boyaAd
from tblpaket p
         INNER  JOIN tblbaski b on b.id = p.baskiId
         INNER JOIN tblsiparis s on s.id = b.siparisId
         INNER JOIN tblprofil pro on pro.id = s.profilId
         LEFT JOIN tbleloksal e on s.eloksalId = e.id
         LEFT JOIN tblprboya pr on s.boyaId = pr.id
where p.id in ($paketDizi)
  and p.isNaylon = 0";
}

if ($paketDizi != "" && $boyaPaketDizi != "") {
    $sql = "
    SELECT CONCAT('B') as tur, bp.id as id, bp.netAdet,s.siparisTuru, bp.baskiId, bp.isNaylon, bp.naylonDurum, zaman, profilNo, profilAdi, s.satirNo, boy, e.ad as eloksalAd, pr.ad as boyaAd
from tblboyapaket bp
INNER  JOIN tblbaski b on b.id = bp.baskiId
INNER JOIN tblsiparis s on s.id = b.siparisId
INNER JOIN tblprofil p on p.id = s.profilId
LEFT JOIN tbleloksal e on s.eloksalId = e.id
LEFT JOIN tblprboya pr on s.boyaId = pr.id
where bp.id in ($boyaPaketDizi)
  and bp.isNaylon = 0
UNION ALL
select CONCAT('P') as tur, p.id as id, p.netAdet, s.siparisTuru, p.baskiId, p.isNaylon, p.naylonDurum, p.zaman, profilNo, profilAdi, s.satirNo, boy, e.ad as eloksalAd, pr.ad as boyaAd
from tblpaket p
         INNER  JOIN tblbaski b on b.id = p.baskiId
         INNER JOIN tblsiparis s on s.id = b.siparisId
         INNER JOIN tblprofil pro on pro.id = s.profilId
         LEFT JOIN tbleloksal e on s.eloksalId = e.id
         LEFT JOIN tblprboya pr on s.boyaId = pr.id
where p.id in ($paketDizi)
  and p.isNaylon = 0
  ";
}

$items = $db->query($sql);


//$pakets = $db->query($sql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Paket Alanı
        </div>
        <div class="card-body" id="naylon-giris">
            <form method="post" action="<?php echo base_url() . 'netting/naylon/index.php' ?>">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label> Satır No - Profil Adı - Boy - Yüzey Detay - Adet</label>
                            <select required id="naylon-select" class="select2"
                                    data-dropdown-css-class="select2-gray" name="item"
                                    data-placeholder="Satır No - Profil Adı - Boy - Yüzey Detay - Adet"
                                    style="width: 100%;">
                                <option selected disabled value="0">Satır No - Profil No - Boy - Yüzey Detay - Adet</option>
                                <?php while ($item = $items->fetch_array()) {
                                    $tur = $item['naylonDurum'] == 1 ? "Baskılı" : ($item['naylonDurum'] == 2 ? "Baskısız" : "Yok");
                                    $satirNo = $item['satirNo'];
                                    $profil = $item['profilNo'];
                                    $boy = $item['boy'];
                                    $yuzey  = $item['siparisTuru'];
                                    $yuzeyDetay = $yuzey == "B" ? "Boyalı" : ($yuzey == "E" ? "Eloksal" : "Pres");
                                    $cins = $yuzey == "B" ? $item['boyaAd'] : ($yuzey == "E" ? $item['eloksalAd'] : "Pres");
                                    $adet = $item['netAdet'];
                                    $value = $satirNo . " - ". $profil ." - ". $boy . " - " . $yuzeyDetay . " - ". $cins . " - ". $adet;
                                    ?>
                                    <option
                                            value="<?php echo $item['baskiId'] . ";" . $item['netAdet'] . ";" . $item['naylonDurum'] . ";" . $item['tur'] . ";" . $item['id'] ?>">
                                        <?php echo $value ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="naylonbaslat" value="naylonbaslat">
                            <input name="naylon1Adet" :value="naylon1Adet" type="hidden">
                            <input name="naylon2Adet" :value="naylon2Adet" type="hidden">
                            <input name="baskiId" :value="baskiId" type="hidden">
                            <input name="satirNo" :value="satirNo" type="hidden">
                            <input name="netAdet" :value="netAdet" type="hidden">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label> Naylon </label>
                            <select class="select2" id="naylon1-selected"
                                    data-dropdown-css-class="select2-gray"
                                    data-placeholder="Parti No - Adet / Kalan"
                                    name="naylonId1"
                                    style="width: 100%;">
                                <option selected disabled value="0">Naylon Seçiniz</option>

                                <option v-for="naylon in naylonlar" v-bind:value="naylon.id">
                                    {{naylon.barkod}} - {{naylon.partino}} - {{naylon.adet}}/{{naylon.kalan}}
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="naylon1Max && naylon1Max > 0">
                        <div class="form-group">
                            <label>Naylon Kullanılan Adet</label>
                            <input required v-model="naylon1Adet"
                                   type="number" class="form-control form-control-lg"
                                   min="0.25" step="0.25" :max="naylon1Max"
                                   @input="check($event)"
                                   placeholder="0.1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label> Naylon </label>
                            <select required class="select2" id="naylon2-selected"
                                    data-dropdown-css-class="select2-gray"
                                    name="naylonId2"
                                    data-placeholder="Parti No - Adet / Kalan"
                                    style="width: 100%;">
                                <option selected value="0">Naylon Seçiniz</option>

                                <option v-for="naylon2 in naylonlar2" v-bind:value="naylon2.id">
                                    {{naylon2.barkod}} - {{naylon2.partino}} - {{naylon2.adet}}/{{naylon2.kalan}}
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="col-sm-2" v-if="naylon2Max && naylon2Max > 0">
                        <div class="form-group">
                            <label>Kullanılan Adet</label>
                            <input required v-model="naylon2Adet"
                                   type="number" class="form-control form-control-lg"
                                   min="0.25" step="0.25" :max="naylon2Max"
                                   placeholder="0.1">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" :disabled=" id == 0  || naylon1Adet == 0"
                                class="btn btn-info float-right">İşlemi Bitir
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
