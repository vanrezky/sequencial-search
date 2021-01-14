<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Lupa Password | <?php $nama = get_informasi('nama'); echo $nama;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Vanrezky | Online Shop">
<meta name="description" content="<?= get_informasi('deskripsi');?>">
<meta name="keywords" content="<?= get_informasi('keyword');?>">
<meta name="google-site-verification" content="<?= get_informasi('google_site_verification');?>" /> 

<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url('assets/')?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- <link rel="stylesheet" href="<?= base_url('assets/')?>plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
<link rel="stylesheet" href="<?= base_url('assets/')?>dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="login-logo">
	<a href="<?= base_url('assets/')?>index2.html"><b><?= $nama;?></b></a>
</div>
<!-- /.login-logo -->
<div class="card">
	<div class="card-body login-card-body">
	<p class="login-box-msg">Masukkan email recovery password</p>

	<form action="<?= base_url('assets/')?>index3.html" method="post">
		<div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
		</div>
		<div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
            </div>
		</div>
	</form>

	<p class="mb-1">
		<a href="<?= base_url('auth/');?>"><i>Halaman Login</i></a>
	</p>
	</div>
</div>
</div>
<script src="<?= base_url('assets/')?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/')?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/')?>dist/js/adminlte.min.js"></script>

</body>
</html>
