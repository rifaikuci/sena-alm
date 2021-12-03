<!DOCTYPE html>
<html>
<head>
    <?php require_once "../../include/helper.php"; ?>
    <?php include "../../include/head.php" ?>
    <?php include "../../include/style.php" ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <?php include "../../include/sidebar-right.php" ?>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href=<?php echo base_url() ?> class="brand-link">
            <div style="text-align: center">

                <span style="color: #0b93d5;font-weight: bold" class="brand-text"><?php echo base_title(); ?></span>
            </div>

        </a>

        <div class="sidebar">
            <?php include '../../include/sidebar-left.php' ?>
        </div>
    </aside>
    <div class="content-wrapper">
        <?php require_once "page-top-info.php"; ?>
        <?php require_once "main-page.php"; ?>
    </div>
    <?php require_once '../../include/footer.php' ?>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<?php require_once('../../include/script.php') ?>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/baski/baski-yari-guncelle.js" ?>></script>

</body>
</html>