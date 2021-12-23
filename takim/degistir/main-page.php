<?php
include "../../netting/baglan.php";
include "../../include/sql.php";
if ($_GET['takimno']) {
    $takimno = $_GET['takimno'];
    $sql = "SELECT * FROM tbltakim WHERE takimNo = '$takimno'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    $parca1 = $row['parca1'];
    $parca2 = $row['parca2'];
    $sqlParca1 = "select * from tblkalipparcalar where  senaNo ='$parca1'";
    $result1 = mysqli_query($db, $sqlParca1);
    $row1 = $result1->fetch_assoc();
    $parca1Adi = parcaBul($row1['parca']);

    $sqlParca2 = "select * from tblkalipparcalar where  senaNo ='$parca2'";
    $result2 = mysqli_query($db, $sqlParca2);
    $row2 = $result2->fetch_assoc();
    $parca2Adi = parcaBul($row2['parca']);
}


?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Takım Güncelleme Alanı
        </div>
        <div class="card-body" id="takim-degistir">
            <form method="post" action="<?php echo base_url() . 'netting/takim/index.php' ?>">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Takım No</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['takimNo'] ?>">
                            <input type="hidden" name="sonGramaj" value="<?php echo $row['sonGramaj']?>">

                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Profil</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo tablogetir('tblprofil','id',$row['profilId'], $db)['profilNo']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Firma</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo tablogetir('tblfirma','id',$row['firmaId'], $db)['firmaAd']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kalıp Türü</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo kalipBul($row['kalipCins']); ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Parça 1</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['parca1']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Parça 2</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['parca2']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Çap</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row['cap'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Figür</label>
                            <input disabled type="text" class="form-control form-control-lg"
                                   value="<?php echo $row1['figurSayi'] ?>">
                        </div>
                    </div>


                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Değiştirmek istediğniz parçayı seçiniz</label>
                            <select v-model="selectedParca"
                                    data-cap="<?php echo $row1['cap'] ?>"
                                    data-kalipcins="<?php echo $row1['kalipCins'] ?>"
                                    data-figursayi="<?php echo $row1['figurSayi'] ?>"
                                    data-firmaid="<?php echo $row1['firmaId'] ?>"
                                    data-profilid="<?php echo $row1['profilId'] ?>"
                                    required @change="parcasec($event.target.dataset)" class="form-control"
                                    style="width: 100%;">
                                <option selected value="">Değiştirmek istediğiniz Parçayı Seçiniz</option>
                                <option value=<?php echo $parca1 . ';' . $row1["parca"] . ';1' ?>><?php echo $parca1Adi ?></option>
                                <option value=<?php echo $parca2 . ';' . $row2["parca"] . ';2' ?>><?php echo $parca2Adi ?></option>
                            </select>
                        </div>
                    </div>

                    <div v-if="parcagoster" style="text-align: center" class="col-sm-12">
                        <br>
                        <div class="form-group">
                            <label>Parçayı Seç </label>
                            <br>
                            <button type="button" v-on:click="parcamodal($event)"
                                    data-toggle="modal" class="btn btn-info">{{parcaSenaNoYeni}}
                            </button>

                        </div>
                    </div>

                    <div v-if="parcagoster" class="col-sm-12">
                        <div class="form-group">
                            <label><?php echo $parca2Adi ?></label>
                            <input v-model="commentText" @change="comment($event)" type="text"
                                   class="form-control form-control-lg" name="commentText"
                                   placeholder="Çöpe Çıkarılma Nedeni">
                            <input name="parcaeski" :value="eskiSenaNo" type="hidden">
                            <input name="parcayeni" :value="parcaSenaNoYeni" type="hidden">
                            <input name="parcaNo" :value="parcaNo" type="hidden">
                            <input name="takimNo" value="<?php echo $row['takimNo'] ?>" type="hidden">
                        </div>
                    </div>


                    <div id="parcaselectview" class="modal fade" role="dialog">
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

                <div class="card-footer">
                    <div>
                        <button v-if="ekle" type="submit" name="takimdegistir" class="btn btn-info float-right">Kaydet
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
        </div>


        </form>
    </div>

</section>
