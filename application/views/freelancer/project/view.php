<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Freelancer<small>Project</small></h1>
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
							<td>Area</td><td><?php echo $project->area ?>m²</td>
						</tr>
						<tr>
							<td>Budget</td><td>Rp.<?php echo number_format($project->budget, 2) ?></td>
						</tr>
						<tr>
							<td>Deadline</td><td><?php echo nice_date($project->deadline, 'd-m-Y') ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>
								<?php
								if ($project->status == 'search-freelance')
								{
									?>
									<label class="label label-primary">Mencari Pekerja</label>
									<?php
								}
								elseif ($project->status == 'canceled')
								{
									?>
									<label class="label label-warning">Dibatalkan</label>
									<?php
								}
								elseif ($project->status == 'in-progress')
								{
									?>
									<label class="label bg-navy">Mencari Pekerja</label>
									<?php
								}
								elseif ($project->status == 'not-completed')
								{
									?>
									<label class="label label-warning">Mencari Pekerja</label>
									<?php
								}
								else
								{
									?>
									<label class="label label-success">Selesai</label>
									<?php
								}
								?>
							</td>
						</tr>
						<?php if ($project->status == 'not-completed') : ?>
						<tr>
							<td>Percent Progress</td><td><?php echo $project->percent ?>%</td>
						</tr>
						<?php endif; ?>
						<?php if (isset($freelancer)) : ?>
						<tr>
							<input type="hidden" name="rating" value="<?php echo $freelancer->rating ?>">
							<td>Rating</td><td><input type="text" class="rating-view kv-svg rating-loading" data-size="xs"></td>
						</tr>
						<?php endif; ?>
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