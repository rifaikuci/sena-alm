<?php

require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";

$takimId = 0;
if (isset($_GET['takimId'])) {
    $takimId = $_GET['takimId'];
    $sqlTurler = "select distinct newProcess from tblkaliphane where takimId = '$takimId'";
    $result = $db->query($sqlTurler);

    $takim = tablogetir("tbltakim", "id", $takimId, $db);

}

?>

<section class="content">

    <div style="text-align: center">
        <h4 style="color: #0b93d5"><?php echo $takim['takimNo'] . " - ". "Kalıp Geçmişi"?></h4>
    </div>
    <div class="card-body" id="kaliphane-goster" :takim="<?php echo $takimId; ?>">
        <div class="row">

            <?php
            $sira = 1;
            while ($row = $result->fetch_array()) {
                $id = "checkboxPrimary" . $sira;
                $rowName = $row['newProcess'];
                ?>
                <div class="col-sm-2">
                    <div class="form-group clearfix">
                        <div style="text-align: center">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="<?php echo $id ?>" name="checkboxPrimary"
                                        value="<?php echo $rowName ?>"
                                        checked
                                        @input="<?php echo 'degistir($event)' ?>"
                                        type="checkbox" id="<?php echo $id ?>">
                                <label style="color: #0e84b5" for="<?php echo $id ?>">
                                    <?php echo $rowName . " - " . takimDurumBul($row['newProcess']) ?>
                                </label>
                                <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">

                            </div>
                        </div>
                    </div>
                </div>
                <?php $sira++;
            } ?>


        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>işlem Tarihi</th>
                                <th>Konum</th>
                                <th>Açıklama</th>
                                <th>Basılan Net Kilo</th>
                                <th>Basılan Brüt Kilo</th>
                            </tr>
                            </thead>

                            <tr v-for="item in filter">
                                <td>{{item.datetime}}</td>
                                <td>{{item.newProcess}}</td>
                                <td>{{item.description}}</td>
                                <td>{{item.basilanNetKilo}}</td>
                                <td>{{item.basilanBrutKilo}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>


                </div>
            </div>
        </div>
</section>