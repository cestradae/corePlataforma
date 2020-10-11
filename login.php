<?php
include_once("bin/main.php");
bin_checkFormLogin();

//bin_only_header();

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Plataforma</title>

  <!-- Custom fonts for this template-->
  <link href="<?php print URL; ?>assets/dist/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php print URL; ?>assets/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css" rel="stylesheet" type="text/css">

  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php print URL; ?>assets/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="<?php print URL; ?>assets/dist/css/login.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel = "icon" href =
    ""
          type = "image/x-icon">
</head>
<body class="hold-transition login-page" id="LoginForm">

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>PLATAFORMA </b>Estudiantil</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login</p>

            <form action="login.php" id="loginForm" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="user" id="exampleInputEmail" placeholder="Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" id="exampleInputPassword" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">

                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-info btn-block" name="goLogin">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

  <!-- Bootstrap core JavaScript-->
  <script src="<?php print URL; ?>assets/dist/plugins/jquery/jquery.min.js"></script>
  <script src="<?php print URL; ?>assets/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- Custom scripts for all pages-->
  <script src="<?php print URL; ?>assets/dist/js/adminlte.min.js"></script>

</body>

</html>
<?php
//bin_only_footer();
//bin_debug($_SESSION);
?>
