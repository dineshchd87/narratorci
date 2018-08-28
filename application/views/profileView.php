<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form action="<?php echo base_url();?>users/profile" method="post" class="editform">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3>Edit Account Info</h3>
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
								<div class="col-sm-2 text-right">
									Username:
								</div>
								<div class="col-sm-4">
									<input type="text" value="<?php echo set_value('user_name', $userDetail[0]['user_name']); ?>" name="user_name" readonly class="form-control" />
								</div>
								<div class="col-sm-5">
									<a href="<?php echo base_url();?>users/changepassword" class="link">Change Password</a>
								</div>
								<div class="col-sm-12 offset-sm-2">
								<?php echo form_error('user_name', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						
						<div class="row form-group">
							<div class="col-sm-2 text-right">
									First Name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value="<?php echo set_value('user_fname', $userDetail[0]['user_fname']); ?>" name="user_fname" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<?php echo form_error('user_fname', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Last name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="user_lname" value="<?php echo set_value('user_lname', $userDetail[0]['user_lname']); ?>" class="form-control"/>
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<?php echo form_error('user_lname', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Email address : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="user_email" value="<?php echo set_value('user_email', $userDetail[0]['user_email']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
              <?php echo form_error('user_email', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Phone : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="user_phone"  value="<?php echo set_value('user_phone', $userDetail[0]['user_phone']); ?>" class="form-control"  />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<?php echo form_error('user_phone', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Address line 1:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_address1"  value="<?php echo set_value('csrm_address1', $userDetail[0]['csrm_address1']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
								<span class="text-danger"></span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
									Address line 2:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_address2" value="<?php echo set_value('csrm_address2', $userDetail[0]['csrm_address2']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<span class="text-danger"></span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
									City:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_city" value="<?php echo set_value('csrm_city', $userDetail[0]['csrm_city']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<span class="text-danger"></span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								State:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_state" value="<?php echo set_value('csrm_state', $userDetail[0]['csrm_state']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<span class="text-danger"></span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								ZIP/PIN:
							</div>
							<div class="col-sm-4">
								<input type="text" name="csrm_zip" value="<?php echo set_value('csrm_zip', $userDetail[0]['csrm_zip']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<span class="text-danger"></span>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Country:
							</div>
							<div class="col-sm-4">
								<select name="csrm_country"  id="country" class="form-control">
					                <option value="" id="select-any">Select country</option>
					                <?php 
					                 if(!empty($countries)){
					                   foreach($countries as $opt){
					                  ?>
					                  <option <?php if($userDetail[0]['csrm_country'] == $opt['iso']){ echo 'selected'; }?> id="<?php echo $opt['iso'];?>" value="<?php echo $opt['iso'];?>"><?php echo $opt['printable_name'];?></option>
					                 <?php
					                    }
					                  }
					                  ?>     
								</select>
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<?php echo form_error('csrm_country', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12">
									To prove your authenticity please enter the current password
							</div>

						</div>
						<div class="row form-group">
							<div class="col-sm-2 text-right">
								Password : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="password" name="password" class="form-control" />
							</div>
							<div class="col-sm-5">
							</div>
							<div class="col-sm-12 offset-sm-2">
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-9 offset-sm-2">
								<button type="submit" class="btn btn-info" value="Save" ><i class="fas fa-save"></i> Save</button>
							</div>
						</div>
					</form>
				</div>
		</section>