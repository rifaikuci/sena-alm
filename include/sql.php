<?php
include_once '../netting/baglan.php';
include_once '../include/sql.php';


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

function deleteRow($tablename, $id)
{
    return "DELETE FROM " . $tablename . " WHERE id =  '$id'";
}

function tablogetir($table, $kriter, $deger, $db)
{
    $sql = "SELECT * FROM $table WHERE $kriter = '$deger'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row;
}

function kiloBul($baskiId, $adet, $db)
{
    $baski = tablogetir("tblbaski", 'id', $baskiId, $db);
    $gr = $baski['guncelGr'];
    $kesimId = $baski['kesimId'];
    $boy = tablogetir("tblkesim", 'id', $kesimId, $db)['kesilenBoy'];
    $kilo = $adet * $boy * $gr;
    return $kilo;
}

function teneferSayisiGetir($db,$takimId) {
    $sql = "select COUNT(*) AS teneferSayisi FROM  tblkaliphane where newProcess = 'N' AND takimId = '$takimId'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['teneferSayisi'];

}



?>