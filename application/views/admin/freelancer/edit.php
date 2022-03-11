<section class="content-header">
	<h1>Administrator<small>Freelancer Criteria</small></h1>
</section>

<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Freelancer Criteria</h3>
		</div>
		<form method="post" action="<?= base_url($this->router->fetch_class().'/freelancer_criteria/edit/'.$freelancer->id) ?>">
			<div class="box-body">
				<div class="row">
					<div class="col-lg-6">
						<?php foreach ($this->criteria->read()->result() as $criteria) :?>
							<?php
							$user_weight = $this->alternative_data->read(array('user_id' => $freelancer->id, 'criteria_id' => $criteria->id));
							if ($user_weight->num_rows() >= 1)
							{
								$user_weight = $user_weight->row()->weight;
							}
							else
							{
								$user_weight = 0;
							}
							?>
							<div class="form-group">
								<label><?= $criteria->name ?></label>
								<input class="form-control" type="text" name="criteria_<?= $criteria->id ?>" placeholder="<?= $criteria->name ?>" value="<?= set_value('criteria_'.$criteria->id, $user_weight) ?>">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
			</div>
		</form>
	</div>
</section>
