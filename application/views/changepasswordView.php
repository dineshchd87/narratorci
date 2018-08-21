<section id="content">
				<div class="editAccount">
					
					<h3>Edit Account Info</h3>
					<form action="<?php echo base_url();?>users/changepassword" method="post" class="editform">
						<div class="form-row">
							<div class="width100">
								<h1>Change Your Access Password</h1>
							</div>
							<div class="width100">
								<?php if($this->session->flashdata('errorMsg')){ ?>
								<h1 style="text-align: center;color:#BC371A"><?php echo $this->session->flashdata('errorMsg'); } ?></h1>
								<?php if($this->session->flashdata('successMsg')){ ?>
								<h1 style="text-align: center;color:green"><?php echo $this->session->flashdata('successMsg'); } ?></h1>
							</div>
							<div class="width40">
								Current Password:*
							</div>
							<div class="width60">
								<input type="password" value="<?php echo set_value('current_password'); ?>" name="current_password"  class="form-input" />
							</div>
							<div class="width100">
              				<?php echo form_error('current_password', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width40">
							New Password:*
							</div>
							<div class="width60">
								<input type="password"  value="<?php echo set_value('new_password'); ?>" name="new_password" class="form-input" />
							</div>
							<div class="width100">
							<?php echo form_error('new_password', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width40">
								Confirm New Password:*
							</div>
							<div class="width60">
								<input type="password"  value="<?php echo set_value('confirm_password'); ?>" name="confirm_password" class="form-input" />
							</div>
							<div class="width100">
							<?php echo form_error('confirm_password', '<span class="error">', '</span>'); ?>
							</div>
						</div>
						<div class="form-row">
							<div class="width25">
								<a href="<?php echo base_url();?>users/profile" class="button button-right button-aqua">Back</a>
								<input type="submit" class="button button-aqua" value="submit"/>
							</div>
						</div>
					</form>
				</div>
		</section>   