<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form autocomplete="off" action="<?php echo base_url();?>talents/edit/<?php echo $talent_details[0]['tlnt_id'];?>" method="post" class="add_customer_form">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3> Add Talent</h3>
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
									NickName:
								</div>
								<div class="col-sm-4">
									<input type="text" value="<?php echo set_value('tlnt_nickname', $talent_details[0]['tlnt_nickname']); ?>" name="tlnt_nickname"  class="form-control" />
								</div>
							</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								First Name : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value="<?php  echo set_value('tlnt_fname',$talent_details[0]['tlnt_fname']); ?>" name="tlnt_fname" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('tlnt_fname', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Last name: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_lname" value="<?php echo set_value('tlnt_lname',$talent_details[0]['tlnt_lname']); ?>" class="form-control"/>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('tlnt_lname', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Email address : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input id="tlnt_email" type="text" name="tlnt_email" value="<?php echo set_value('tlnt_email',$talent_details[0]['tlnt_email']); ?>" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('tlnt_email', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
							Rate per page: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_rate" value="<?php echo set_value('tlnt_rate',$talent_details[0]['tlnt_rate']); ?>" class="form-control"/>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('tlnt_rate', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
							Phone: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_phone" value="<?php echo set_value('tlnt_phone',$talent_details[0]['tlnt_phone']); ?>" class="form-control"/>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('tlnt_phone', '<span class="text-danger">', '</span>'); ?>
								</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
							Address line 1: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_address1" value="<?php echo set_value('tlnt_address1',$talent_details[0]['tlnt_address1']); ?>" class="form-control"/>
							</div>
							
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
							Address line 2: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_address2" value="<?php echo set_value('tlnt_address2',$talent_details[0]['tlnt_address2']); ?>" class="form-control"/>
							</div>
							
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									City:
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_city" value="<?php echo set_value('tlnt_city',$talent_details[0]['tlnt_city']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								State:
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_state" value="<?php echo set_value('tlnt_state',$talent_details[0]['tlnt_state']); ?>" class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								ZIP/PIN:
							</div>
							<div class="col-sm-4">
								<input type="text" name="tlnt_zip" value="<?php echo set_value('tlnt_zip',$talent_details[0]['tlnt_zip']); ?>" class="form-control" />
							</div>
							
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Country: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="tlnt_country"  id="country" class="form-control">
									<option value="" selected>Select country</option>
									<?php foreach ($countries as $opt) { ?>
									<option value="<?php echo $opt['iso']; ?>" <?php if($talent_details[0]['tlnt_country'] == $opt['iso']){ echo 'selected'; }?> ><?php echo $opt['printable_name'] ; ?> </option> 
									<?php } ?>
								</select>
							</div>
							
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Accepts rush : 
							</div>
							<div class="col-sm-1">
							<?php if($talent_details[0]['is_rush'] == 'Y'){ ?>
							
								<input type="checkbox" name="is_rush"  value="Y" <?php echo set_checkbox('is_rush', 'Y', true); ?> class="form-control"  />
							
							<?php }else{ ?>							
								<input type="checkbox" name="is_rush"  value="N" <?php echo set_checkbox('is_rush', 'N', false); ?> class="form-control"  />
							<?php } ?>
								
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Not Available :
							</div>
							<div class="col-sm-2">
								<label>from </label>
								<input type="text" id="out_start" name="out_start" value="<?php echo set_value('out_start',date('m/d/Y',$talent_details[0]['out_start'])); ?>" class="form-control" />
							</div>
							
							<div class="col-sm-2">
							<label>to</label>
								<input type="text"  id="out_end" name="out_end" value="<?php echo set_value('out_start',date('m/d/Y',$talent_details[0]['out_start'])); ?>" class="form-control" />
							</div>
							<div class="col-sm-2">
							<span style="text-decoration: underline; cursor: pointer;" id="clearOutDt">Clear</span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								
							</div>
							<div class="col-sm-2">
								<label>from </label>
								<input type="text" id="out_start_b" name="out_start_b" value="<?php echo set_value('out_start_b',date('m/d/Y',$talent_details[0]['out_end_b'])); ?>" class="form-control" />
							</div>
							
							<div class="col-sm-2">
							<label>to</label>
								<input type="text"  id="out_end_b" name="out_end_b" value="<?php echo set_value('out_end_b',date('m/d/Y',$talent_details[0]['out_end_b'])); ?>" class="form-control" />
							</div>
							<div class="col-sm-2">
							<span style="text-decoration: underline; cursor: pointer;" id="clearOutDt_b">Clear</span>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Visible on external system: : 
							</div>
							<div class="col-sm-1">
							<?php if($talent_details[0]['is_external'] == 'Y'){ ?>
							
								<input type="checkbox" name="is_external"  value="Y" <?php echo set_checkbox('is_external', 'Y', true); ?> class="form-control"  />
							
							<?php }else{ ?>							
								<input type="checkbox" name="is_external"  value="N" <?php echo set_checkbox('is_external', 'N', false); ?> class="form-control"  />
							<?php } ?>
								
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
				$( "#out_start , #out_end, #out_start_b , #out_end_b" ).datepicker({
					showOtherMonths: true,
					selectOtherMonths: true,
					showAnim: 'fadeIn',
					beforeShow: function(input, inst){
					posTo = setTimeout(function () {
					inst.dpDiv.css({
                    top: $(document).height() - 350
                });
//                clearTimeout(posTo);
            }, 0);
        }
      });
	  
	     $('#clearOutDt').click(function(){
			if( confirm('Are you sure?') ){
				$( "#out_start , #out_end" ).val(0);
			}
		});
		$('#clearOutDt_b').click(function(){
			if( confirm('Are you sure?') ){
				$( "#out_start_b , #out_end_b" ).val(0);
			}
		});

			});
		</script>