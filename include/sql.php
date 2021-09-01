<?php
include '../netting/baglan.php';
include '../include/sql.php';


function firmaTurBul($id, $db,$sutun)
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

function alasimBul($id, $db,$sutun)
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

function isTableSevkiyat($db,$table, $sevkiyatId) {

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

function malzemeBul($id, $db,$sutun)
{
    $sql = "SELECT * FROM tblmalzemeler WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row[$sutun];
}

?>