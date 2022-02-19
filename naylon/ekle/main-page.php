<?php
include "../../netting/baglan.php";
include "../../include/sql.php";

$sqlItems = "select id,
       hurdaAdet,
       hurdaSebep,
       netAdet,
       satirNo,
       kesimId,
       naylonDurum,
       isNaylon,
       operatorId,
       zaman,
       vardiya
from tblboyapaket
where naylonDurum in (1, 2)
  and isNaylon = 0
union ALL
select id,
       hurdaAdet,
       hurdaSebep,
       netAdet,
       satirNo,
       kesimId,
       naylonDurum,
       isNaylon,
       operatorId,
       zaman,
       vardiya
from tblpaket
where naylonDurum in (1, 2)
  and isNaylon = 0";
$items = $db->query($sqlItems);

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
                            <label> Ürünü seçiniz</label>
                            <select required id="naylon-select" class="select2"
                                    data-dropdown-css-class="select2-gray"
                                    data-placeholder="Satır No - Kesim Id - Adet "
                                    style="width: 100%;">
                                <option selected disabled value="0">Ürün Seçiniz</option>
                                <?php while ($item = $items->fetch_array()) {
                                    $tur = $item['naylonDurum'] == 1 ? "Baskılı" : ($item['naylonDurum'] == 2 ? "Baskısız" : "Yok")
                                    ?>
                                    <option value="<?php echo $item['id'] . ";" . $item['kesimId'] . ";" . $item['netAdet'] . ";" . $item['naylonDurum'] . ";" . $item['satirNo'] ?>">
                                        <?php echo $item['satirNo'] . " - " . $item['kesimId'] . " - " . $item['netAdet'] . " - " . $tur ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="naylonbaslat" value="naylonbaslat">
                            <input name="naylon1Adet" :value="naylon1Adet" type="hidden">
                            <input name="id" :value="id" type="hidden">
                            <input name="naylon2Adet" :value="naylon2Adet" type="hidden">
                            <input name="kesimId" :value="kesimId" type="hidden">
                            <input name="satirNo" :value="satirNo" type="hidden">
                            <input name="netAdet" :value="netAdet" type="hidden">
                            <input type="hidden" name="operatorId" value="<?php echo $_SESSION['operatorId'] ?>">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
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

                    <div class="col-sm-4" v-if="naylon1Max && naylon1Max > 0">
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
                    <div class="col-sm-8">
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

                    <div class="col-sm-4" v-if="naylon2Max && naylon2Max > 0">
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
                                class="btn btn-info float-right">Ekle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
