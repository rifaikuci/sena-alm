<div class="sidebar">

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

            if ($operatorId == 1) {
                require_once "sidebar/admin.php";
            } else if ($operatorId == 2) {
                require_once "sidebar/kesim.php";
            } else if ($operatorId == 3) {
                require_once "sidebar/sevk.php";
            } else if ($operatorId == 4) {
                require_once "sidebar/kalip.php";
            } else if ($operatorId == 5) {
                require_once "sidebar/kromat.php";
            } else if ($operatorId == 6) {
                require_once "sidebar/pres.php";
            } else if ($operatorId == 7) {
                require_once "sidebar/bpaket.php";
            } else if ($operatorId == 8) {
                require_once "sidebar/boya.php";
            }
            ?>
    </nav>