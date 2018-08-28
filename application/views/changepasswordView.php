<section id="content" class="col-sm-12">
				<div class="editAccount">
					<form action="<?php echo base_url();?>users/changepassword" method="post" class="editform">
						<div class="row form-group">
							<div class="col-sm-9 offset-sm-3">
								<h3>Change Your Access Password</h3>
							</div>
							<div class="col-sm-12">
									<?php if($this->session->flashdata('errorMsg')){ ?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Error!</strong><?php echo $this->session->flashdata('errorMsg'); ?>
								</div>
								<?php } ?>
								<?php if($this->session->flashdata('successMsg')){ ?>
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Success!</strong><?php echo $this->session->flashdata('successMsg'); ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Current Password: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-5">
								<input type="password" value="<?php echo set_value('current_password'); ?>" name="current_password"  class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
              				<?php echo form_error('current_password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
							New Password: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-5">
								<input type="password"  value="<?php echo set_value('new_password'); ?>" name="new_password" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
							<?php echo form_error('new_password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Confirm New Password: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-5">
								<input type="password"  value="<?php echo set_value('confirm_password'); ?>" name="confirm_password" class="form-control" />
							</div>
							<div class="col-sm-9 offset-sm-3">
							<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-9 offset-sm-3">
								<button type="submit" class="btn btn-info mr-2" value="Save"><i class="fas fa-save"></i> Save</button>
								<a href="<?php echo base_url();?>users/profile" class="btn btn-outline-info"><i class="fas fa-arrow-left"></i> Back</a>
								
							</div>
						</div>
					</form>
				</div>
		</section>   