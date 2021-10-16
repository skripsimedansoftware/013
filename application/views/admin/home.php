<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Dashboard</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $this->user->read(array('role' => 'studio'))->num_rows() ?></h3>
					<p>Studio</p>
				</div>
				<div class="icon">
					<i class="fa fa-users"></i>
				</div>
				<a href="#" class="small-box-footer"><i class="fa fa-info"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $this->project->read()->num_rows() ?></h3>
					<p>Project</p>
				</div>
				<div class="icon">
					<i class="fa fa-map"></i>
				</div>
				<a href="#" class="small-box-footer"><i class="fa fa-info"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $this->user->read(array('role' => 'freelancer'))->num_rows() ?></h3>
					<p>Freelancer</p>
				</div>
				<div class="icon">
					<i class="fa fa-users"></i>
				</div>
				<a href="#" class="small-box-footer"><i class="fa fa-info"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
			<div class="small-box bg-purple">
				<div class="inner">
					<h3><?php echo $this->criteria->read()->num_rows() ?></h3>
					<p>Criteria</p>
				</div>
				<div class="icon">
					<i class="fa fa-puzzle-piece"></i>
				</div>
				<a href="#" class="small-box-footer"><i class="fa fa-info"></i></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Latest Project</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table no-margin">
							<thead>
								<tr>
									<th>Name</th>
									<th>Category</th>
									<th>Area</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($latest_project as $key => $project): ?>
								<tr>
									<td><?php echo $project['name'] ?></td>
									<td>
										<?php
										$project_category = $this->project_category->read(array('id' => $project['category']));

										echo ($project_category->num_rows() >= 1)?$project_category->row()->name:'-';
										?>
									</td>
									<td><?php echo $project['area'] ?></td>
									<td>Rp.<?php echo number_format($project['budget'], 2) ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Recently Freelance</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<ul class="products-list product-list-in-box">
						<?php foreach ($latest_freelancer as $key => $freelancer): ?>
						<li class="item">
							<div class="product-img">
								<img src="<?php echo (!empty($freelancer['photo']))?base_url('uploads/'.$freelancer['photo']):base_url('assets/adminlte/dist/img/user2-160x160.jpg') ?>" alt="User Image">
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title"><?php echo $freelancer['full_name'] ?><span class="label label-warning pull-right"><?php echo $this->freelancer_project->freelance($freelancer['id'])->num_rows() ?> project</span></a>
								<span class="product-description"><?php echo $freelancer['email'] ?></span>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<button></button>
	</div>
</section>