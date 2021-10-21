<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Forgot Password</title>
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
		<p class="login-box-msg">Masukan email/username anda</p>
		<?php 
		if ($this->session->has_userdata('forgot_password'))
		{
			?>
			<?php if ($this->session->userdata('forgot_password')['status'] == 'success') : ?>
				<div class="alert alert-success alert-dismissible" role="alert"><?php echo $this->session->userdata('forgot_password')['message']; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
			<?php else : ?>
				<div class="alert alert-warning alert-dismissible" role="alert"><?php echo $this->session->userdata('forgot_password')['message']; ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
			<?php endif; ?>
			<?php
		}
		?>
		<form action="<?php echo base_url($this->router->fetch_class().'/forgot_password') ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="Email / Nama Pengguna" name="identity" value="<?php echo set_value('identity') ?>">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<?php echo form_error('identity', '<span class="help-block error">', '</span>'); ?>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-recycle"></i> Atur Ulang Kata Sandi</button>
				</div>
			</div>
		</form>

		<!-- <a href="#">I forgot my password</a><br> -->
		<br>
		<a href="<?php echo base_url('admin/register') ?>" class="text-center"><i class="fa fa-users"></i> Mendaftar</a>
		<a href="<?php echo base_url('admin/login') ?>" class="text-center pull-right"><i class="fa fa-sign-in"></i> Masuk</a>

	</div>
</div>

<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/icheck.min.js"></script>
</body>
</html>