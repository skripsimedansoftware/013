<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Project</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Detail Project : <?php echo (set_value('name', $project->name) == $project->name)?$project->name:$project->name.' --- '.set_value('name', $project->name) ?></h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped">
						<tr>
							<td>Name</td><td><?php echo $project->name ?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>
								<?php
								$category = $this->project_category->read(array('id' => $project->category));
								if ($category->num_rows() > 0)
								{
									$category = $category->row();
									echo $category->name;
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Area</td><td><?php echo $project->area ?></td>
						</tr>
						<tr>
							<td>Budget</td><td>Rp.<?php echo number_format($project->budget, 2) ?></td>
						</tr>
						<tr>
							<td>Deadline</td><td><?php echo $project->deadline ?></td>
						</tr>
					</table>
				</div>
				<div class="box-footer">
					<div class="row">
						<div class="col-lg-3">
							<a href="<?php echo base_url($this->router->fetch_class().'/project') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>