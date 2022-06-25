<!DOCTYPE html>
<html>
<head>
    <?php require "../include/helper.php"; ?>


    <link rel="stylesheet" href=<?php echo base_url() . "dist/css/adminlte.min.css" ?>>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
          href=<?php echo base_url() . "plugins/datatables-responsive/css/responsive.bootstrap4.min.css" ?>>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>SENA ALM</b> | Yönetim</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form action="../netting/login/index.php" method="post">
                <div class="input-group mb-3">
                    <input required type="text" class="form-control" name="name"
                           placeholder="Kullanıcı Adınız....">
                </div>

                <div class="input-group mb-3">
                    <input required type="password" class="form-control" name="password"
                           placeholder="
                            Şifreniz">
                </div>
                <div class="row" style="text-align: center">

                    <div class="col-4" style="text-align: center">
                        <button name="girisyap" type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                    </div>
                </div>
            </form>

        </div>
        <?php if($_GET['kullanici'] == "no") { ?>
            <div style="margin:10px" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Hata!</strong> Kullanıcı bulunamadı!!!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
</body>
</html>
