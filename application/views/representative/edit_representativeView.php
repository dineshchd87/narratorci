<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form autocomplete="off" action="<?php echo base_url();?>customers/edit/<?php echo $customer_details[0]['cust_id'];?>" method="post" class="add_customer_form">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3>Edit Customer</h3>
							</div>
						</div>
							<div class="row form-group">
								<div class="col-sm-3 text-right">
									Title:
								</div>
								<div class="col-sm-4">
									<input type="text"  value="<?php echo set_value('cust_title', $customer_details[0]['cust_title']); ?>"  name="cust_title"  class="form-control" />
								</div>
							</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									Name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value="<?php  echo set_value('cust_name', $customer_details[0]['cust_name']); ?>" name="cust_name" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_name', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Company name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_comp" value="<?php echo set_value('cust_comp', $customer_details[0]['cust_comp']); ?>" class="form-control"/>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_comp', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Email address : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input id="customer_id" type="hidden" name="customer_id" value="<?php echo $customer_details[0]['cust_id']; ?>" class="form-control" />

								<input id="cust_email" type="text" name="cust_email" value="<?php echo set_value('cust_email', $customer_details[0]['cust_email']); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_email', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Bill to Email : 
							</div>
							<div class="col-sm-4">
								<input id="cust_bill_to" type="text" name="cust_bill_to" value="<?php echo set_value('cust_bill_to', $customer_details[0]['cust_bill_to']); ?>" class="form-control" />
							</div>
							<div class="col-sm-5">
								<a type="button" class="btn btn-primary" href="javascript:void(0)" id="addredd_link">Same as above</a>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Copy Invoice To : 
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_copy_invoice_to" value="<?php echo set_value('cust_copy_invoice_to', $customer_details[0]['cust_copy_invoice_to']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Address line 1:
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_address1"  value="<?php echo set_value('cust_address1', $customer_details[0]['cust_address1']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									Address line 2:
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_address2" value="<?php echo set_value('cust_address2', $customer_details[0]['cust_address2']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									City:
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_city" value="<?php echo set_value('cust_city', $customer_details[0]['cust_city']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								State:
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_state" value="<?php echo set_value('cust_state',$customer_details[0]['cust_state']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								ZIP/PIN:
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_zip" value="<?php echo set_value('cust_zip',$customer_details[0]['cust_zip']); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_zip', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Country: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="cust_country"  id="country" class="form-control">
									<option value="" selected>Select country</option>
									<?php foreach ($countries as $opt) { ?>
									<option <?php if($customer_details[0]['cust_country'] == $opt['iso']){ echo 'selected'; }?> value="<?php echo $opt['iso'] ; ?>" <?php echo set_select('cust_country', $opt['iso'], False); ?> ><?php echo $opt['printable_name'] ; ?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_country', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Phone number: 
							</div>
							<div class="col-sm-4">
								<input type="text" name="cust_phone"  value="<?php echo set_value('cust_phone',$customer_details[0]['cust_phone']); ?>" class="form-control"  />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_phone', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Is Active : 
							</div>
							<?php if($customer_details[0]['is_active'] == 'Y'){ ?>
							<div class="col-sm-1">
								<input type="checkbox" name="is_active"  value="Y" <?php echo set_checkbox('is_active', 'Y', true); ?> class="form-control"  />
							</div>
							<?php }else{ ?>
							<div class="col-sm-1">
								<input type="checkbox" name="is_active"  value="N" <?php echo set_checkbox('is_active', 'N', false); ?> class="form-control"  />
							</div>
							<?php } ?>
						</div>
						<div class="row form-group">
							<div class="col-sm-12">
									To prove your authenticity please enter the current password
							</div>

						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Password : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="password" value="<?php echo set_value('current_password'); ?>" autocomplete="new-password" name="current_password" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('current_password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-9 offset-sm-2">
								<button type="submit" class="btn btn-info" value="Save" ><i class="fas fa-save"></i> Save</button>
								<a href="<?php echo base_url();?>customers" class="btn btn-outline-info"><i class="fas fa-arrow-left"></i> Back</a>
							</div>
						</div>
					</form>
				</div>
		</section>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#addredd_link').click(function(){
					$('#cust_bill_to').val($('#cust_email').val());
				});
			});
		</script>