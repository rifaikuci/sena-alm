<?php
if ($_GET['id']) {

    $id = $_GET['id'];

    include '../../../netting/baglan.php';

    $sql = "SELECT * FROM tblpersonel WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    $sqlpersoneltur = "SELECT * FROM tblrol";
    $personeltur = $db->query($sqlpersoneltur);
} ?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Personel Güncelleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/personel.php' ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Persone Ad Soyad</label>
                            <input required type="hidden" class="form-control form-control-lg" name="id"
                                   value="<?php echo $row['id'] ?>">
                            <input required type="text" class="form-control form-control-lg" name="adsoyad"
                                   value="<?php echo $row['adsoyad'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Personel Türü</label>
                            <select required name="rolId" class="form-group select2" style="width: 100%;">
                                <option selected value="">Personel Türü Seçiniz</option>
                                <?php while ($rol = $personeltur->fetch_array()) { ?>
                                    <option <?php echo $rol['level'] == $row['rolId'] ? 'selected' : '' ?>
                                            value="<?php echo $rol['level']; ?>"><?php echo $rol['rol']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>T.C.</label>
                            <input required type="text" class="form-control form-control-lg" name="tc"
                                   value="<?php echo $row['tc'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input required type="text" class="form-control form-control-lg" name="telefon"
                                   value="<?php echo $row['telefon'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>İşe Giriş Tar.</label>
                            <input required type="date" class="form-control form-control-lg" name="isegiristarih"
                                   value="<?php echo date("Y-m-d", strtotime(explode(" ", $row['isegiristarih'])[0])) ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>İşe Çıkış Tar.</label>
                            <input type="date" class="form-control form-control-lg" name="isecikistarih"
                                   value="<?php echo $row['isecikistarih'] ? date("Y-m-d", strtotime(explode(" ", $row['isecikistarih'])[0])) : "" ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Mail</label>
                            <input required type="text" class="form-control form-control-lg" name="mail"
                                   value="<?php echo $row['mail'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Adres</label>
                            <input required type="text" class="form-control form-control-lg" name="adres"
                                   value="<?php echo $row['adres'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Tshirt Beden</label>
                            <input required type="text" class="form-control form-control-lg" name="bedentshirt"
                                   value="<?php echo $row['bedentshirt'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Pantalon</label>
                            <input required type="text" class="form-control form-control-lg" name="bedenpantalon"
                                   value="<?php echo $row['bedenpantalon'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Ayakkabi</label>
                            <input required type="text" class="form-control form-control-lg" name="bedenayakkabi"
                                   value="<?php echo $row['bedenayakkabi'] ?>">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="personelguncelleme" class="btn btn-info float-right">Güncelle
                        </button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
