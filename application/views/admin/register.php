<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registration Page</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/square/blue.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style type="text/css">
		.help-block.error {
			color: red;
		}
	</style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
	<div class="register-logo">
		<a href="<?php echo base_url() ?>">Welcome to <b><br>SPK Pembagian Project</b></a>
	</div>

	<div class="register-box-body">
		<p class="login-box-msg">Pendaftaran</p>

		<form action="<?php echo base_url($this->router->fetch_class().'/register') ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="Nama Lengkap" name="full_name" value="<?php echo set_value('full_name') ?>">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
				<?php echo form_error('full_name', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo set_value('email') ?>">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<?php echo form_error('email', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Kata Sandi" name="password" value="<?php echo set_value('password') ?>">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<?php echo form_error('password', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-users"></i> Mendaftar</button>
				</div>
				<!-- /.col -->
			</div>
		</form>

		<br>
		<a href="<?php echo base_url('admin/login') ?>" class="text-center"><i class="fa fa-user-circle"></i> Saya sudah terdaftar</a>
	</div>
	<!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/icheck.min.js"></script>
</body>
</html>