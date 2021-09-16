<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login Page</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style type="text/css">
		.help-block.error {
			color: red;
		}
	</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo base_url() ?>">Welcome to <b>Codeigniter Starter</b></a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg">Masuk untuk memulai sesi anda</p>
		<?php 
		if (!empty($this->session->userdata('login')))
		{
			?>
			<div class="alert alert-danger"><?php echo $this->session->userdata('login'); ?></div>
			<?php
		}

		if (!empty($this->session->userdata('register')))
		{
			?>
			<div class="alert alert-success"><?php echo $this->session->userdata('register'); ?></div>
			<?php
		}
		?>
		<form action="<?php echo base_url($this->router->fetch_class().'/login') ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="Email / Nama Pengguna" name="identity" value="<?php echo set_value('identity') ?>">
				<span class="fa fa-user form-control-feedback"></span>
				<?php echo form_error('identity', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Kata Sandi" name="password">
				<span class="fa fa-lock form-control-feedback"></span>
				<?php echo form_error('password', '<span class="help-block error">', '</span>'); ?>
			</div>
			<div class="row">
				<div class="col-lg-6 col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
				</div>
				<div class="col-lg-6 col-xs-12" style="margin-top: 2%;">
					<a href="<?php echo base_url('admin/register') ?>" class="btn btn-default btn-block btn-flat">Mendaftar</a>
				</div>
			</div>
		</form>
		<br>
		<a href="<?php echo base_url() ?>" class="text-center">Beranda</a>
		<a href="<?php echo base_url('admin/forgot_password') ?>" class="text-center pull-right">Lupa Kata Sandi</a>

	</div>
</div>

<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/icheck.min.js"></script>
</body>
</html>