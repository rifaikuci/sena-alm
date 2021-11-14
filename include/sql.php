<?php
include_once '../netting/baglan.php';
include_once '../include/sql.php';


function firmaTurBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblfirmatur WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function firmaBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblfirma WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}


function personelTur($id, $db)
{
    $sql = "SELECT * FROM tblrol WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['rol'];
}

function alasimBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblalasim WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}


function personelBul($id, $db)
{
    $sql = "SELECT * FROM tblpersonel WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['adsoyad'];
}

function profilbul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblprofil WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function maxIdBul($db, $table)
{
    $sql = "SELECT MAX(id) as id FROM  $table";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['id'];
}


function isTableSevkiyat($db, $table, $sevkiyatId)
{

    $sql = "SELECT COUNT(*)  FROM $table where sevkiyatId = '$sevkiyatId'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_row();

    return $row[0];
}


function boyaBul($id, $db)
{
    $sql = "SELECT * FROM tblboya WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function malzemeBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblmalzemeler WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function kalipBul($id)
{
    $arrayKalip = array("Köprülü" => 0, "Bindirmeli" => 1, "Solid" => 2, "Hazneli" => 3, "Bolster" => 4);

    return array_search($id, $arrayKalip);
}

function parcaBul($id)
{
    $arrayKalip = array("Zıvana " => 0, "Kapak " => 1, "Destek " => 2, "Zıvana" => 3, "Kapak" => 4, "Destek  " => 5,
        "Hazne" => 6, "Kalıp" => 7, "Destek   " => 8, "Hazneli Kalıp" => 9, "Destek     " => 10);

    return array_search($id, $arrayKalip);
}

function firmaTakimNoBul($db, $table, $firmaId, $profilId)
{

    $sql = "SELECT COUNT(*)  FROM $table where firmaId = '$firmaId' AND profilId = '$profilId'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_row();

    return $row[0] + 1;
}


function parcalarsqlbul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblkalipparcalar WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function siparisGunBul($db, $yil, $hafta, $gun)
{

    $sql = "select * from tblsiparis where yil ='$yil' AND hafta = '$hafta' AND gun = '$gun'";
    $result = mysqli_query($db, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $sql2 = "SELECT * from tblsiparis order by id desc";
        $resultfirst = $db->query($sql2);
        $firstrow = mysqli_fetch_assoc($resultfirst);
        $num_rows = substr($firstrow['satirNo'], -2);

    }
    return $num_rows + 1;
}

function siparisHaftaBul($db, $yil, $hafta)
{
    $sql = "select * from tblsiparis where yil ='$yil' AND hafta = '$hafta'  group by yil,hafta";
    $result = mysqli_query($db, $sql);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $sql2 = "SELECT * from tblsiparis order by id desc";
        $resultfirst = $db->query($sql2);
        $firstrow = mysqli_fetch_assoc($resultfirst);
        $num_rows = substr($firstrow['siparisNo'], -3);

    }

    return $num_rows + 1;

}

function eloksalBul($id, $db)
{
    $sql = "SELECT * FROM tbleloksal WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function ayarSqlBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblayar WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function takimBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tbltakim WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function baskiBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblbaski WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function siparisBul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblsiparis WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

function biyetbul($id, $db, $sutun)
{
    $sql = "SELECT * FROM tblstokbiyet WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

?>