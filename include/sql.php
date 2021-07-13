<?php
include '../netting/baglan.php';

function firmaTur($id, $db)
{
    $sql = "SELECT * FROM tblfirmatur WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function firmaTurSeo($seo, $db)
{
    $sql = "SELECT * FROM tblfirmatur WHERE seo = '$seo'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function personelTur($id, $db)
{
    $sql = "SELECT * FROM tblrol WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['rol'];
}

function alasimTur($id, $db)
{
    $sql = "SELECT * FROM tblalasim WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function alasimTurSeo($seo, $db)
{
    $sql = "SELECT * FROM tblalasim WHERE seo = '$seo'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['ad'];
}

function personelBul($id, $db)
{
    $sql = "SELECT * FROM tblpersonel WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();
    return $row['adsoyad'];
}

?>