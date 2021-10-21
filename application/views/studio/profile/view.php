<section class="content-header">
	<h1>Administrator<small>Profile</small></h1>
</section>

<section class="content container-fluid">
	<div class="row">
		<div class="col-lg-4 col-xs-12">
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?php echo (!empty($profile->photo))?$profile->photo:base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" alt="User profile picture">
					<h3 class="profile-username text-center"><?php echo $profile->full_name ?></h3>
					<p class="text-muted text-center"><?php echo $profile->email ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<a href="#" class="btn btn-primary btn-block" onclick="window.history.back()"><b><i class="fa fa-arrow-left"></i> Kembali</b></a>
				</div>
				<div class="col-lg-6">
					<?php if ($profile->id == $this->session->userdata(strtolower($this->router->fetch_class()))) : ?>
					<a href="<?php echo base_url($this->router->fetch_class().'/profile/'.$profile->id.'/edit') ?>" class="btn btn-warning btn-block"><b><i class="fa fa-edit"></i> Sunting</b></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>