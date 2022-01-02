<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);


if (isset($_POST['havuzdoldur'])) {
    $operator = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;
    $tur = isset($_POST['tur']) ? $_POST['tur'] : "kromat";
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $malzemeler = isset($_POST['malzemeler']) ? $_POST['malzemeler'] : array() ;
    $dolumTarih = date("Y-m-d H:i:s");
    $malzemeString ="";

    foreach ($malzemeler as $m) {
        $malzemeString = $malzemeString.$m.",";
    }

    $malzemeString = rtrim($malzemeString, ",");

    $sqlstokmalzeme = "UPDATE tblstokmalzeme set durum = 0 where id  in (".$malzemeString.")";
    mysqli_query($db, $sqlstokmalzeme);


    $sqlHavuzLog = "INSERT INTO tblhavuzlog (tur, malzemeler, dolumTarih, dolumOperatorId)
                            VALUES ( '$tur','$malzemeString', '$dolumTarih','$operator')";

    mysqli_query($db, $sqlHavuzLog);
    $logId = mysqli_insert_id($db);

    $sqlHavuz = "UPDATE tblhavuz set durum = '1', islemTarih = '$dolumTarih', operatorId = '$operator', logHavuzId = '$logId' where id = '$id'";

    if (mysqli_query($db,$sqlHavuz)) {
        header("Location:../../havuz/?doldur=ok");
        exit();
    } else {
        header("Location:../../havuz/?doldur=no");
        exit();
    }

}


if (isset($_GET['havuzbosalt'])) {

    $id = $_GET['havuzbosalt'];
    $operator = isset($_SESSION['operatorId']) ? $_SESSION['operatorId'] : 0;
    $bosTarih = date("Y-m-d H:i:s");

    $logId = tablogetir("tblhavuz", 'id', $id, $db)['logHavuzId'];
    $sqlHavuzLog = "UPDATE tblhavuzlog set bosTarih = '$bosTarih', bosOperatorId  = '$operator' where id = '$logId'";
    mysqli_query($db,$sqlHavuzLog);

    $sqlHavuz = "UPDATE tblhavuz set durum = '0', islemTarih = '$bosTarih', operatorId = '$operator' where id = '$id'";

    if (mysqli_query($db, $sqlHavuz)) {

        header("Location:../../havuz/?durumbosalt=ok");
        exit();
    } else {
        header("Location:../../havuz/?durumbosalt=no");
        exit();
    }

}






?>