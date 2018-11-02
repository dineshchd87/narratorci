<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form autocomplete="off" action="<?php echo base_url();?>representative/add" method="post" class="add_customer_form">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3>Add CS Representative</h3>
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
									User name : <span class="text-danger">*</span>
								</div>
								<div class="col-sm-4">
									<input type="text" value="<?php echo set_value('user_name') ?>" name="user_name"  class="form-control" />
								</div>
								<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('user_name', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								First name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value="<?php  echo set_value('user_fname'); ?>" name="user_fname" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('user_fname', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Last name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="user_lname" value="<?php echo set_value('user_lname'); ?>" class="form-control"/>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('user_lname', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Email address : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input id="user_email" type="text" name="user_email" value="<?php echo set_value('user_email'); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('user_email', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Rate per page : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input id="csrm_rate" type="text" name="csrm_rate" value="<?php echo set_value('csrm_rate'); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('csrm_rate', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Phone number: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input id="user_phone" type="text" name="user_phone" value="<?php echo set_value('user_phone'); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('user_phone', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Address line 1:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_address1"  value="<?php echo set_value('csrm_address1'); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									Address line 2:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_address2" value="<?php echo set_value('csrm_address2'); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									City:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_city" value="<?php echo set_value('csrm_city'); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								State:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_state" value="<?php echo set_value('csrm_state'); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								ZIP/PIN:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_zip" value="<?php echo set_value('csrm_zip'); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('csrm_zip', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Country: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="csrm_country"  id="country" class="form-control">
									<option value="" selected>Select country</option>
									<?php foreach ($countries as $opt) { ?>
									<option value="<?php echo $opt['iso'] ; ?>" <?php echo set_select('csrm_country', $opt['iso'], False); ?> ><?php echo $opt['printable_name'] ; ?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('csrm_country', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-9 offset-sm-2">
								<button type="submit" class="btn btn-info" value="Save" ><i class="fas fa-save"></i> Save</button>
								<a href="<?php echo base_url();?>representative" class="btn btn-outline-info"><i class="fas fa-arrow-left"></i> Back</a>
							</div>
						</div>
					</form>
				</div>
		</section>