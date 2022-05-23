<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>

<table class="table table-hover table-bordered table-striped">
	<thead>
		<th>Nama Project</th>
		<th>Deadline</th>
		<th>Budget Project</th>
		<th>Rating</th>
	</thead>
	<tbody>
	<?php foreach ($project_on_going->result() as $project) : ?>
		<?php $project_detail = $this->project->read(array('id' => $project->project_id)); ?>
		<?php if ($project_detail->num_rows() > 0) : ?>
			<?php $project_detail = $project_detail->row() ?>
			<tr>
				<td><?php echo $project_detail->name ?></td>
				<td><?php echo nice_date($project_detail->deadline, 'd-m-Y') ?></td>
				<td>Rp.<?php echo number_format($project_detail->budget, 2) ?></td>
				<td><?php echo $project->rating ?></td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
	</tbody>
</table>
</body>
</html>
