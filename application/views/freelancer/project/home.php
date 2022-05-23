<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Freelancer<small>Project</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="col-lg-12">
		<?php if ($this->session->has_userdata('project')): ?>
			<?php if ($this->session->userdata('project')['status'] == 'success'): ?>
				<div class="alert alert-dismissible alert-success"><?php echo $this->session->userdata('project')['message']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<?php else: ?>
				<div class="alert alert-dismissible alert-danger"><?php echo $this->session->userdata('project')['message']; ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">List of Project</h3>
			</div>
			<div class="box-body">
				<table class="table table-hover table-striped datatable">
					<thead>
						<th>No</th>
						<th>Name</th>
						<th>Studio</th>
						<th>Category</th>
						<th>Area</th>
						<th>Budget</th>
						<th>Deadline</th>
						<th>Status</th>
						<th>Option</th>
					</thead>
					<tbody>
						<?php foreach ($projects as $key => $project): ?>
						<tr>
							<td><?php echo $key+1 ?></td>
							<td><?php echo $project->name ?></td>
							<td>
								<?php
								$studio = $this->user->read(array('id' => $project->owner));
								if ($studio->num_rows() >= 1)
								{
									$studio = $studio->row();
									echo $studio->full_name;
								}
								?>
							</td>
							<td>
								<?php
								$project_category = $this->project_category->read(array('id' => $project->category));

								echo ($project_category->num_rows() >= 1)?$project_category->row()->name:'-';
								?>
							</td>
							<td><?php echo $project->area ?>m²</td>
							<td>Rp.<?php echo number_format($project->budget, 2) ?></td>
							<td>
								<?php
								if (!empty($project->deadline))
								{
									$deadline = explode('-', $project->deadline);
									echo $deadline[2].'-'.$deadline[1].'-'.$deadline[0];
								}
								else
								{
									echo '-';
								}
								?>
							</td>
							<td>
								<?php switch ($project->status) {
									case 'search-freelance':
										?>
										<a href="<?php echo base_url($this->router->fetch_class().'/saw_freelance/'.$project->id) ?>" class="btn btn-block btn-flat btn-xs btn-primary">Cari Pekerja</a>
										<?php
									break;

									case 'pending':
										?>
										<a href="#" class="btn btn-block btn-flat btn-xs btn-warning">Menunggu Konfirmasi</a>
										<?php
									break;

									case 'in-progress':
										?>
										<a href="#" class="btn btn-block btn-flat btn-xs bg-navy">Dalam Proses</a>
										<?php
									break;

									case 'not-completed':
										?>
										<a href="#" class="btn btn-block btn-flat btn-xs btn-warning">Tidak Selesai</a>
										<?php
									break;

									case 'canceled':
										?>
										<a href="#" class="btn btn-block btn-flat btn-xs btn-danger">Dibatalkan</a>
										<?php
									break;
									
									// finished
									default:
										?>
										<a href="#" class="btn btn-block btn-flat btn-xs btn-success">Selesai</a>
										<?php
									break;
								} ?>
							</td>
							<td>
								<a href="<?php echo base_url($this->router->fetch_class().'/project/detail/'.$project->id) ?>" class="btn btn-flat btn-xs btn-info">Detail</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="box-footer">
				<a class="btn bg-navy" href="<?= base_url('report/index/'.$this->router->fetch_class().'/'.$this->session->userdata($this->router->fetch_class())) ?>"><i class="fa fa-print"></i> Cetak Laporan</a>
			</div>
		</div>
	</div>
</section>
