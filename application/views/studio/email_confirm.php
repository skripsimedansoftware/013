<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email Confirm</title>
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
		<a href="<?php echo base_url() ?>">Welcome to <b><br>SPK Pembagian Project</b></a>
	</div>
	<div class="login-box-body">
		<?php if (isset($email_confirm_detail) OR $this->session->has_userdata('reset_password')) : ?>
			<?php
			if (!isset($email_confirm_detail))
			{
				$email_confirm_detail = $this->email_confirm->detail(array('confirm_code' => $this->session->userdata('reset_password')['confirm_code']));
			}
			if ($email_confirm_detail->num_rows() === 1)
			{
				if ($email_confirm_detail->row()->status == 'unconfirmed')
				{
					$this->session->set_userdata('reset_password', array(
						'user_id' => $email_confirm_detail->row()->user_uid,
						'confirm_code' => $email_confirm_detail->row()->confirm_code
					));
					?>
					<?php if ($email_confirm_detail->row()->type == 'reset-password'): ?>
						<p class="login-box-msg text-green">Masukkan kata sandi yang baru</p>
						<form action="<?php echo base_url($this->router->fetch_class().'/reset_password') ?>" method="post">
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Kata Sandi Baru" name="new_password" value="<?php echo set_value('new_password') ?>">
								<span class="fa fa-key form-control-feedback"></span>
								<?php echo form_error('new_password', '<span class="help-block error">', '</span>'); ?>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" placeholder="Masukkan Ulang Kata Sandi Baru" name="repeat_new_password" value="<?php echo set_value('repeat_new_password') ?>">
								<span class="fa fa-key form-control-feedback"></span>
								<?php echo form_error('repeat_new_password', '<span class="help-block error">', '</span>'); ?>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<button type="submit" class="btn btn-primary btn-block btn-flat">Ubah Kata Sandi</button>
								</div>
							</div>
						</form>
					<?php endif; ?>
					<?php
				}
				else
				{
					?>
					<p class="login-box-msg text-red">Kode konfirmasi sudah pernah digunakan, silahkan masukkan kode konfirmasi terbaru</p>
					<form action="<?php echo base_url($this->router->fetch_class().'/email_confirm') ?>" method="post">
						<div class="form-group has-feedback">
							<input type="text" class="form-control" placeholder="Kode Konfirmasi" name="confirm_code" value="<?php echo set_value('confirm_code') ?>">
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							<?php echo form_error('confirm_code', '<span class="help-block error">', '</span>'); ?>
						</div>

						<div class="row">
							<div class="col-xs-12">
								<button type="submit" class="btn btn-primary btn-block btn-flat">Konfirmasi Kode</button>
							</div>
						</div>
					</form>
					<?php
				}
			}
			else
			{
				?>
				<p class="login-box-msg text-red">Kode konfirmasi yang anda masukkan salah</p>
				<form action="<?php echo base_url($this->router->fetch_class().'/email_confirm') ?>" method="post">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="Kode Konfirmasi" name="confirm_code" value="<?php echo set_value('confirm_code') ?>">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						<?php echo form_error('confirm_code', '<span class="help-block error">', '</span>'); ?>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Konfirmasi Kode</button>
						</div>
					</div>
				</form>
				<?php
			}
			?>
		<?php else: ?>
			<p class="login-box-msg">Masukan kode yang anda dapatkan dari email</p>
				<form action="<?php echo base_url($this->router->fetch_class().'/email_confirm') ?>" method="post">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="Kode Konfirmasi" name="confirm_code" value="<?php echo set_value('confirm_code') ?>">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						<?php echo form_error('confirm_code', '<span class="help-block error">', '</span>'); ?>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Konfirmasi Kode</button>
						</div>
					</div>
				</form>
		<?php endif ?>
		<br>
		<a href="<?php echo base_url('admin/register') ?>" class="text-center">Mendaftar</a>
		<a href="<?php echo base_url('admin/login') ?>" class="text-center pull-right">Masuk</a>

	</div>
</div>

<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/') ?>plugins/iCheck/icheck.min.js"></script>
</body>
</html>