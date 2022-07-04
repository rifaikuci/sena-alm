<?php


$operatorId = $_SESSION['operatorId'];
$rolId = $_SESSION['rolId'];
$adsoyad = $_SESSION['adsoyad'];

?>
<div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <h4 style="color: #0d6efd"><?php echo $adsoyad; ?></h4>
    </div>

    <nav class="mt-2">
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
            <?php

            if ($rolId == 1) {
                require_once "sidebar/admin.php";
            } else if ($rolId == 2) {
                require_once "sidebar/kesim.php";
            } else if ($rolId == 3) {
                require_once "sidebar/sevk.php";
            } else if ($rolId == 4) {
                require_once "sidebar/kalip.php";
            } else if ($rolId == 5) {
                require_once "sidebar/kromat.php";
            } else if ($rolId == 6) {
                require_once "sidebar/pres.php";
            } else if ($rolId == 7) {
                require_once "sidebar/bpaket.php";
            } else if ($rolId == 8) {
                require_once "sidebar/boya.php";
            } else {

                require_once "sidebar/noUser.php";
             } ?>
    </nav>