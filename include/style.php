
<?php

include "../netting/baglan.php";
session_start();
if (!isset($_SESSION['operatorId'])) {
    header("Location:" . base_url() . "login/");
}
$operatorId = $_SESSION['operatorId'];


?>

<link rel="stylesheet" href=<?php echo base_url() . "plugins/fontawesome-free/css/all.min.css" ?>>
<link rel="stylesheet" href=<?php echo base_url() . "dist/css/adminlte.min.css" ?>>
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href=<?php echo base_url() . "plugins/ekko-lightbox/ekko-lightbox.css" ?>>
<link rel="stylesheet" href=<?php echo base_url() . "plugins/icheck-bootstrap/icheck-bootstrap.min.css" ?>>
<link rel="stylesheet" href=<?php echo base_url() . "plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" ?>>
<link rel="stylesheet" href=<?php echo base_url() . "plugins/select2/css/select2.min.css" ?>>
<link rel="stylesheet" href=<?php echo base_url() . "plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css" ?>>
<link rel="stylesheet"
      href=<?php echo base_url() . "plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" ?>>
<link rel="stylesheet"
      href=<?php echo base_url() . "plugins/datatables-responsive/css/responsive.bootstrap4.min.css" ?>>

