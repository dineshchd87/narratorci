<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form autocomplete="off" action="<?php echo base_url();?>customers/add" method="post" class="add_customer_form">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3>Add New Order</h3>
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
								Date:
							</div>
							<div class="col-sm-1">
							<?php $nowTime  = time(); ?>
								<input type="text" value="<?php echo date('m',$nowTime)?>" name="month"  class="form-control" />
							</div>
							<div class="col-sm-1">
								<input type="text" value="<?php echo date('d',$nowTime)?>" name="date"  class="form-control" />
							</div>
							<div class="col-sm-2">
								<input type="text" value="<?php echo date('Y',$nowTime)?>" name="year"  class="form-control" />
							</div>
							
							<div class="col-sm-3 text-right">
								Total Page Count:
							</div>
							<div class="col-sm-2">
								<input readonly="readonly" type="text" value="" name="cust_title"  class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Project Name:
							</div>
							<div class="col-sm-4">
								<input type="text" value="" name="cust_title"  class="form-control" />
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									Discount($ / page) : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value="" name="cust_name" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_name', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Customer: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="cust_country"  id="country" class="form-control">
									<option value="" selected>Select a customer</option>
									<?php foreach ($allCust as $cust) { ?>
									<option value="<?php echo $cust['cust_id']; ?>"  ><?php echo stripslashes( "{$cust['cust_name']} - {$cust['cust_comp']}" ); ?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-5">
								<a type="button" class="btn btn-primary" href="<?php echo base_url();?>customers/add" id="addredd_link">Add Customer</a>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_country', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								CSR: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="cust_country"  id="country" class="form-control">
									<option value="" selected>Select a CSR</option>
									<?php foreach ($allCSR as $csr) { ?>
									<option value="<? echo $csr['user_id'] ?>" ><?php echo $csr["user_fname"].' '.$csr["user_lname"]?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_country', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Use manual billing  : 
							</div>
							<div class="col-sm-1">
								<input type="checkbox" name="check_name"  value="Y"  class="form-control"  />
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Rush Project? : 
							</div>
							<div class="col-sm-1">
								<input type="checkbox" name="rush_val"  value="Y" class="form-control"  />
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
				
			});
		</script>