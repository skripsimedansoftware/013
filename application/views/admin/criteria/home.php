<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Criteria</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="col-lg-12">
		<?php if ($this->session->has_userdata('criteria')): ?>
			<?php if ($this->session->userdata('criteria')['status'] == 'success'): ?>
				<div class="alert alert-dismissible alert-success"><?php echo $this->session->userdata('criteria')['message']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php else: ?>
				<div class="alert alert-dismissible alert-danger"><?php echo $this->session->userdata('criteria')['message']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">List of Criteria</h3>
			</div>
			<div class="box-body">
				<table class="table table-hover table-striped">
					<thead>
						<th>No</th>
						<th>Name</th>
						<th>Weight</th>
						<th>Attribute</th>
						<th>Option</th>
					</thead>
					<tbody>
						<?php foreach ($criterias as $key => $criteria): ?>
						<tr>
							<td><?php echo $key+1 ?></td>
							<td><?php echo $criteria->name ?></td>
							<td><?php echo $criteria->weight ?></td>
							<td><?php echo ucfirst($criteria->attribute) ?></td>
							<td>
								<a href="<?php echo base_url($this->router->fetch_class().'/criteria/edit/'.$criteria->id) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
								<a href="<?php echo base_url($this->router->fetch_class().'/criteria/delete/'.$criteria->id) ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-lg-3">
						<a href="<?php echo base_url($this->router->fetch_class().'/criteria/add') ?>" class="btn btn-block btn-flat btn-success"><i class="fa fa-plus"></i> Add Criteria</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>