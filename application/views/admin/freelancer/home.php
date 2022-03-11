<section class="content-header">
	<h1>Administrator<small>Freelancer</small></h1>
</section>

<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Freelancers</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover table-striped">
				<thead>
					<th>No</th>
					<th>Nama</th>
					<?php foreach ($this->criteria->read()->result() as $criteria) :?>
						<th><?= $criteria->name ?></th>
					<?php endforeach; ?>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php foreach ($freelancers as $key => $freelancer) : ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $freelancer->full_name ?></td>
						<?php foreach ($this->criteria->read()->result() as $criteria) :?>
							<td>
							<?php foreach ($this->alternative_data->read(array('user_id' => $freelancer->id, 'criteria_id' => $criteria->id))->result() as $alternative_data) : ?>
							<?= $alternative_data->weight ?>
							<?php endforeach; ?>
							</td>
						<?php endforeach; ?>
						<td><a href="<?= base_url($this->router->fetch_class().'/freelancer_criteria/edit/'.$freelancer->id) ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
