<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
require_once "../../include/data.php";


if ($_GET['id']) {

    $id = $_GET['id'];
    $malzemeSql = "select sm.id as id,
       firmaAd,
       barkod,
       ad
from tblstokmalzeme sm
         INNER JOIN tblfirma f ON f.id = sm.firmaId
         INNER JOIN tblmalzemeler m ON sm.malzemeId = m.id
where durum = 1";
    $malzemeler = $db->query($malzemeSql);

} ?>


<section class="content">
    <div class="card card-info">
        <div class="card-header">
            <?php echo $id == 3 ? "Kum Havuz Doldurma Alanı" : ($id == 4 ? "Tenefer Havuz Doldurma Alanı" : "Kostik Havuz Doldurma Alanı") ?>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/havuz/index.php' ?>"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Malzemeler 1 Seçiniz</label>
                            <div class="select2-blue">
                                <select required name="malzemeler[]" class="select2" multiple="multiple"
                                        data-dropdown-css-class="select2-blue"
                                        data-placeholder="Barkod - Malzeme -  Firma "
                                        style="width: 100%;">
                                    <?php while ($malzeme = $malzemeler->fetch_array()) { ?>
                                        <option value="<?php echo $malzeme['id'] ?>">
                                            <?php
                                            $malzemeadi = $malzeme['ad'];


                                            echo $malzeme['barkod'] . " - " . $malzemeadi . " - " . $malzeme['firmaAd'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        <input type="hidden" value="havuzdoldur" name="havuzdoldur"/>
                        <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                        <input type="hidden" value="<?php echo $id == 3 ? "kum" : ($id  == 4 ? "tenefer" : "kostik"); ?>" name="tur"/>

                    </div>

                    <?php if ($id == 4) {
                        $malzemeSql2 = "SELECT * FROM tblstokmalzeme where durum = 1";
                        $malzemeler2 = $db->query($malzemeSql2);
                        ?>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Malzemeler 2 Seçiniz</label>
                                <div class="select2-blue">
                                    <select name="malzemeler2[]" class="select2" multiple="multiple"
                                            data-dropdown-css-class="select2-blue"
                                            data-placeholder="Barkod - Malzeme -  Firma "
                                            style="width: 100%;">
                                        <?php while ($malzeme2 = $malzemeler2->fetch_array()) { ?>
                                            <option value="<?php echo $malzeme2['id'] ?>">
                                                <?php
                                                $firma = tablogetir("tblfirma", 'id', $malzeme2['firmaId'], $db);
                                                $malzemeadi = tablogetir("tblmalzemeler", 'id', $malzeme2['malzemeId'], $db)['ad'];

                                                echo $malzeme2['barkod'] . " - " . $malzemeadi . " - " . $firma['firmaAd'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="card-footer">
                    <div>
                        <button onclick="return confirm('Doldurmak istediğinizden emin misiniz?')"
                                type="submit" class="btn btn-info float-right">Doldur
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>

        </div>


    </div>

</section>
