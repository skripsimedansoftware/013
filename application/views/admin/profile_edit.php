<section class="content-header">
	<h1>Administrator<small>Profile Edit</small></h1>
</section>

<section class="content container-fluid">
	<div class="box">
		<form method="POST" action="<?php echo base_url($this->router->fetch_class().'/profile/'.$this->uri->segment(3).'/edit') ?>" enctype="multipart/form-data">
			<div class="box-body">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap" value="<?php echo set_value('full_name', $profile->full_name) ?>">
						<?php echo form_error('full_name', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input class="form-control" type="text" name="email" placeholder="Email" value="<?php echo set_value('email', $profile->email) ?>">
						<?php echo form_error('email', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input class="form-control" type="text" name="username" placeholder="Username" value="<?php echo set_value('username', $profile->username) ?>">
						<?php echo form_error('username', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input class="form-control" type="text" name="password" placeholder="Password" value="<?php echo set_value('password') ?>">
						<?php echo form_error('password', '<span class="help-block error">', '</span>'); ?>
					</div>
					<div class="form-group">
						<img  class="img img-responsive img-circle" id="profile-upload-preview" src="<?php echo (!empty($profile->photo))?base_url('uploads/'.$profile->photo):base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" alt="your image" style="margin-bottom: 2%; height:160px;width: 160px;">
						<input type="file" onchange="readURL(this);" name="photo">
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-lg-2 col-sm-12">
					<button type="submit" class="btn btn-block btn-success">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</section>