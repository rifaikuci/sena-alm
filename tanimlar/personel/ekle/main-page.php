<?php
include "../../../netting/baglan.php";

$sql = "SELECT * FROM tblrol";
$result = $db->query($sql);

?>

<section class="content">
    <div class="card card-info">
        <div class="card-header">
            Personel Ekleme Alanı
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url() . 'netting/tanimlar/personel.php' ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Personel Ad Soyad</label>
                            <input required type="text" class="form-control form-control-lg" name="adsoyad"
                                   placeholder="Personel Adı Giriniz...">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>T.C.</label>
                            <input required type="text" class="form-control form-control-lg" name="tc" maxlength="11"
                                   placeholder="T.C. Bilgisi ">
                            <input type="hidden" name="operatorId" value="<?php echo $operatorId ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Personel Türü</label>
                            <select required name="rolId" class="form-group select2" style="width: 100%;">
                                <option selected disabled value="">Personel Türü Seçiniz</option>
                                <?php while ($row = $result->fetch_array()) { ?>
                                    <option value="<?php echo $row['level']; ?>"><?php echo $row['rol']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input reequired type="text" class="form-control form-control-lg" name="telefon"
                                   placeholder="Telefon ">
                        </div>
                    </div>



                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Mail</label>
                            <input type="text" class="form-control form-control-lg" name="mail"
                                   placeholder="Mail">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Adres</label>
                            <input required type="text" class="form-control form-control-lg" name="adres"
                                   placeholder="Adres">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Kullanıcı Adı</label>
                            <input type="text" class="form-control form-control-lg" name="username"
                                   placeholder="Kullanıcı Adı Giriniz">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Şifre</label>
                            <input type="text" class="form-control form-control-lg" name="password"
                                   placeholder="Şifre Giriniz">
                        </div>
                    </div>



                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>İşe Giriş Tar.</label>
                            <input required type="date" class="form-control form-control-lg" name="isegiristarih"
                                   value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>İşe Çıkış Tar.</label>
                            <input type="date" class="form-control form-control-lg" name="isecikistarih" >
                        </div>
                    </div>


                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Tshirt</label>
                            <input type="text" class="form-control form-control-lg" name="bedentshirt"
                                   placeholder="Tshirt ">
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Pantalon</label>
                            <input type="text" class="form-control form-control-lg" name="bedenpantalon"
                                   placeholder="Pantalon ">
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Ayakkabı</label>
                            <input type="text" class="form-control form-control-lg" name="bedenayakkabi"
                                   placeholder="Ayakkabı">
                        </div>
                    </div>



                </div>
                <div class="card-footer">
                    <div>
                        <button type="submit" name="personelekleme" class="btn btn-info float-right">Ekle</button>
                        <a href="../"
                           class="btn btn-warning float-left">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div>
</section>
