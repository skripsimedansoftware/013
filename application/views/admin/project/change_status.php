<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Project</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="row">
		<form method="post" action="<?php echo base_url($this->router->fetch_class().'/end_project/'.$project->id) ?>">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Edit Project : <?php echo (set_value('name', $project->name) == $project->name)?$project->name:$project->name.' --- '.set_value('name', $project->name) ?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label>Status</label>
							<select name="status" class="form-control">
								<option value="finished">Finished</option>
								<option value="not-completed">Not Completed</option>
							</select>
							<?php echo form_error('status', '<span class="help-block error">', '</span>'); ?>
						</div>
						<div class="form-group">
							<label>Percent Progress</label>
							<input type="text" name="percent_progress" class="form-control" placeholder="%">
							<?php echo form_error('percent_progress', '<span class="help-block error">', '</span>'); ?>
						</div>
						<div class="form-group">
							<label>Rating</label>
							 <input type="text" class="rating kv-svg rating-loading" data-size="md">
							 <br>
							<?php echo form_error('rating', '<span class="help-block error">', '</span>'); ?>
						</div>
						<input type="hidden" name="rating" value="<?php echo set_value('rating', 0) ?>">
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-lg-3">
								<button type="submit" class="btn btn-block btn-flat btn-success"><i class="fa fa-save"></i> Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">

</script>