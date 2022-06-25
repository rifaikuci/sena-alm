<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

if (isset($_POST['girisyap'])) {
    session_start();
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tblpersonel WHERE mail = '$name'  AND password = '$password' ";
    $sonuc = mysqli_query($db, $sql);
    $row = $sonuc->fetch_assoc();

    if (count($row) > 0) {
        $_SESSION['operatorId'] = $row['id'];
        $_SESSION['rolId'] = $row['rolId'];
        $_SESSION['adsoyad'] = $row['adsoyad'];
        header("Location:" . base_url() );
        exit();
    } else {
        header("Location:" . base_url() . "login/?kullanici=no");
        exit();
    }

}

if (isset($_GET['cikisyap']) == true) {
    session_start();

    session_destroy();
    header("Location:" . base_url() . "login");
}
