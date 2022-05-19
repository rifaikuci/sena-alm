<!DOCTYPE html>
<html>
<head>
    <?php require_once "../../../include/helper.php"; ?>
    <?php include "../../../include/head.php" ?>
    <title>SENA | Gid Sevk Ekle</title>
    <?php include "../../../include/style.php" ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <?php include "../../../include/sidebar-right.php" ?>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href=<?php echo base_url() ?> class="brand-link">
            <div style="text-align: center">

                <span style="color: #0b93d5;font-weight: bold" class="brand-text"><?php echo base_title(); ?></span>
            </div>

        </a>

        <div class="sidebar">
            <?php include '../../../include/sidebar-left.php' ?>
        </div>
    </aside>
    <div class="content-wrapper">
        <?php include "page-top-info.php"; ?>
        <?php include "main-page.php"; ?>
    </div>
    <?php include '../../../include/footer.php' ?>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src=<?php echo base_url() . "plugins/jquery/jquery.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/bootstrap/js/bootstrap.bundle.min.js" ?>></script>
<script src=<?php echo base_url() . "dist/js/adminlte.min.js" ?>></script>
<script src=<?php echo base_url() . "dist/js/demo.js" ?>></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/sevkiyat/veri-cikis.js" ?>></script>

<script src=<?php echo base_url() . "plugins/select2/js/select2.full.js" ?>></script>
<script src=<?php echo base_url() . "plugins/ekko-lightbox/ekko-lightbox.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables/jquery.dataTables.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-responsive/js/dataTables.responsive.min.js" ?>></script>
<script src=<?php echo base_url() . "plugins/datatables-responsive/js/responsive.bootstrap4.min.js" ?>></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src=<?php echo base_url() . "dist/js/datatable.js" ?>></script>

</body>
</html>