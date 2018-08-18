<section id="content">
				<div class="editAccount">
					
					<h3>Edit Account Info</h3>
					<form action="<?php echo base_url();?>users/profile" method="post" class="editform">
						<div class="form-row">
							<div class="width100">
								<?php if($this->session->flashdata('errorMsg')){ ?>
								<h1 style="text-align: center;color:#BC371A"><?php echo $this->session->flashdata('errorMsg'); } ?></h1>

								<?php if($this->session->flashdata('successMsg')){ ?>
								<h1 style="text-align: center;color:green"><?php echo $this->session->flashdata('successMsg'); } ?></h1>
							</div>
							<div class="width25">
								User Name:
							</div>
							<div class="width50">
								<input type="text" value="<?php echo set_value('user_name', $userDetail[0]['user_name']); ?>" name="user_name" readonly class="form-input" />
							</div>
							<div class="width25">
								<a href="<?php echo base_url();?>users/changepassword" class="link">Change Password</a>
							</div>
							<div class="width100">
              <?php echo form_error('user_name', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
									First Name:*
							</div>
							<div class="width50">
								<input type="text"  value="<?php echo set_value('user_fname', $userDetail[0]['user_fname']); ?>" name="user_fname" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<?php echo form_error('user_fname', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								Last name:*
							</div>
							<div class="width50">
								<input type="text" name="user_lname" value="<?php echo set_value('user_lname', $userDetail[0]['user_lname']); ?>" class="form-input"/>
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<?php echo form_error('user_lname', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								Email address:*
							</div>
							<div class="width50">
								<input type="text" name="user_email" value="<?php echo set_value('user_email', $userDetail[0]['user_email']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
              <?php echo form_error('user_email', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								Phone:*
							</div>
							<div class="width50">
								<input type="text" name="user_phone"  value="<?php echo set_value('user_phone', $userDetail[0]['user_phone']); ?>" class="form-input"  />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<?php echo form_error('user_phone', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								Address line 1:
							</div>
							<div class="width50">
								<input type="text" name="csrm_address1"  value="<?php echo set_value('csrm_address1', $userDetail[0]['csrm_address1']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<span class="error"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
									Address line 2:
							</div>
							<div class="width50">
								<input type="text" name="csrm_address2" value="<?php echo set_value('csrm_address2', $userDetail[0]['csrm_address2']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<span class="error"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
									City:
							</div>
							<div class="width50">
								<input type="text" name="csrm_city" value="<?php echo set_value('csrm_city', $userDetail[0]['csrm_city']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<span class="error"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								State:
							</div>
							<div class="width50">
								<input type="text" name="csrm_state" value="<?php echo set_value('csrm_state', $userDetail[0]['csrm_state']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<span class="error"></span>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								ZIP/PIN:
							</div>
							<div class="width50">
								<input type="text" name="csrm_zip" value="<?php echo set_value('csrm_zip', $userDetail[0]['csrm_zip']); ?>" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<span class="error"></span>
							</div>
						</div>
						
						<div class="form-row">
							<div class="width25">
								Country:
							</div>
							<div class="width50">
								<select name="csrm_country"  id="country" class="form-input">
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
							<div class="width25">
							</div>
							<div class="width100">
							<?php echo form_error('csrm_country', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width100">
									To prove your authenticity please enter the current password
							</div>

						</div>
						<div class="form-row">
							<div class="width25">
								Password:*
							</div>
							<div class="width50">
								<input type="password" name="password" class="form-input" />
							</div>
							<div class="width25">
							</div>
							<div class="width100">
							<?php echo form_error('password', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								<input type="submit" class="button button-aqua" value="submit"/>
							</div>
						</div>
					</form>
				</div>
		</section>