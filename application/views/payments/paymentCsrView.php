	<div id="content" class="row">            
		<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<h2>Payment Management</h2> 
				</div>
                <div class="col-sm-12">
					<div class="form-row">
						<div class="col-sm-4">
						 <select id='dynamic_select' class="form-control">
							<option <?php  if(isset($_GET['for']) && $_GET['for']=='TLNT'){ ?>  selected <?php } ?> value="<?php echo base_url();?>payments/view?for=TLNT&filter_tlnt_pay=all">for Talents</option>
							<option  <?php if(isset($_GET['for']) && $_GET['for']=='CSR'){ ?>  selected <?php } ?> value="<?php echo base_url();?>payments/view?for=CSR&filter_tlnt_pay=all">for CSR</option>
						  </select>
						</div>
						<div class="col-sm-4">
						  <select  id='dynamic_select2'  class="form-control">
							<option  <?php  if(isset($_GET['filter_tlnt_pay']) && $_GET['filter_tlnt_pay']==0){ ?> selected <?php } ?>  value="<?php echo base_url();?>payments/view?for=CSR&filter_tlnt_pay=0">All payments</option>
							<option <?php  if(isset($_GET['filter_tlnt_pay']) && $_GET['filter_tlnt_pay']==1){ ?> selected <?php } ?>  value="<?php echo base_url();?>payments/view?for=CSR&filter_tlnt_pay=1">Received</option>
							<option <?php  if(isset($_GET['filter_tlnt_pay']) && $_GET['filter_tlnt_pay']==2){ ?> selected <?php } ?>   value="<?php echo base_url();?>payments/view?for=CSR&filter_tlnt_pay=2">Requested</option>
							<option  <?php  if(isset($_GET['filter_tlnt_pay']) && $_GET['filter_tlnt_pay']==3){ ?> selected <?php } ?>  value="<?php echo base_url();?>payments/view?for=CSR&filter_tlnt_pay=3">CSR Paid</option>
						  </select>
						</div>
						<div class="col-sm-1">
						  <button  class="btn btn-info btn-sm search">Go</button>
						</div>
					</div>   <br>
					<div class="form-row">
						<div class="col-sm-4">
						 <select class="form-control" id="paymentaction">
							<option value="">Select any one</option>
							<option value="2">Request payment</option>
							<option value="3">Mark as paid</option>
						  </select>
						</div>
						<?php $nowTime  = time(); ?>
						<div class="input-group date col-sm-1 date-input hide">
							<input class="form-control" value="<?php echo date('m',$nowTime)?>" id="month" name="month" type="text" />
						</div>
						<div class="input-group date col-sm-1 date-input hide">
							<input class="form-control" value="<?php echo date('d',$nowTime)?>" id="date" name="date" type="text" />
						</div>
						<div class="input-group date col-sm-2 date-input hide">
							<input class="form-control" value="<?php echo date('Y',$nowTime)?>" id="year" name="year" type="text" />
						</div>
						
						
							<!--<div class="col-sm-1 date-input hide">
							 <select class="form-control" name="month">
							    <?php for($i=1; $i<= 12;$i++){?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php }?>
							</select>
							</div>
							<div class="col-sm-1 date-input hide">
							 <select class="form-control" name="year">
							    <?php for($i=1; $i<= 31;$i++){?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php }?>
							</select>
							</div>
							<div class="col-sm-1 date-input hide">
							  <select class="form-control" name="year">
							    <?php for($i=1970; $i<= 2018;$i++){?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php }?>
							</select>
							</div>-->

						<div class="col-sm-4">
						  <button id="mark_action" class="btn btn-info btn-sm">Go</button>
						</div>
					</div>   					
                </div>
			</div>
			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4" id="export_buttons"></div>
				</div>
			</div>
			<div class="col-sm-12 mt-4">
                     <div class="row">
						<div class="col-sm-12 col-md-5">
							<div class="dataTables_info" id="customerTable_info" role="status" aria-live="polite">
								Showing <?php  if(isset($_GET['page'])){ $page_num=$_GET['page'];}else{$page_num=1;} $start= 1+PER_PAGE_NUMBER*$page_num-PER_PAGE_NUMBER; echo  $start?> to <?php echo PER_PAGE_NUMBER*$page_num; ?> of <?php echo $total_rows;?> entries
							</div>
						</div>
						<div class="col-sm-12 col-md-7">
							<div class="dataTables_paginate paging_full_numbers" id="customerTable_paginate">
								<?php echo $links; ?>
							</div>
						</div>
					</div>
                <table id="paymentTable" class="table display table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th colspan="2">
								<a  href="javascript:void(0)" class="checkall_btn checkall btn btn-info btn-sm">
									<i class="fas fa-edit"></i>
									 Check All
								</a>
								<a  href="javascript:void(0)" class="checkall_btn hide uncheckall btn btn-info btn-sm">
									<i class="fas fa-edit"></i>
									 Uncheck All
								</a>
							</th>
							<th>ID</th>
							<?php if(isset($_GET['for']) && $_GET['for']=='TLNT'){ ?><th>Talent</th><?php } ?>
							<?php if(isset($_GET['for']) && $_GET['for']=='CSR'){ ?><th>CSR</th><?php } ?>
							<th>Total</th>
							<th>Project</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>   
						 <?php
                            if(!empty($results)){ 
                                foreach ($results as $data) {
                        ?>
						<tr>
						
							<td class="details-control" id="<?php echo $data['cp_id'];  ?>">
								
							</td>
							<td class="" >
								<input type="checkbox" name="otr_ids[]" class="check_boxes" value="<?php echo $data["cp_id"];?>">
							</td>
							 <td><?php echo $data["order_id"];?></td>
							
							<td><?php echo $data["user_fname"].' '.$data["user_lname"];?></td>
							  
							
							 <td>Total pages <?php echo $data["pages"];?>&nbsp;--&nbsp;$<?php echo $data["amount"] ;?> @ $<?php echo $data["csrm_rate"];?>/page</td>
							 
							  
							 <td>
								<?php echo $data["order_name"];?>
							 <td> 
								 <strong><?php echo str_replace('Talent', 'CSR', $data["paystat_text"]);?></strong>
								 &nbsp;&nbsp;-&nbsp;&nbsp;<?php echo date("dS M Y",$data["pay_stat_dt"]);?>  
							 </td>
						</tr>
						<tr class="created-new-row"  style="display: none;" id="detailRow-<?php echo $data['cp_id'];?>">
							<td colspan="7">
                               <div class="container">
                                    <div class="row">
                                        <div class="col-sm mycontent-left">
                                            <span class="orderdetails"><strong>Order Details</strong></span><br/>
											
											Project Name: <?php echo $data["order_name"];?><br />
											 Customern name: <?php echo $data["cust_name"];?><br />
											  Account manager: <?php 
												$csrDetail = $data["csrDetail"][0];
											    echo $csrDetail['user_fname'].' '.$csrDetail['user_lname'];
											  ?>
										</div>
                                        <div class="col-sm mycontent-left">
                                             <div style="line-height:16px;">
                                                 <span class="orderdetails"><strong>Order History</strong></span><br/>
												 <?php
                                            
                                            foreach($data["history"] as $histRow)
                                            {
                                        ?>
                                            <?php echo date('m/d/Y',$histRow['hist_date'])?> &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;<?php echo $histRow['hist_text'];?> <br/>
                                        <?php
                                            }
                                        ?>
											</div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </td>
						</tr>
						<?php
						   }
					    }else{ ?>
						<tr>
							<td colspan="6">
								 <div style="text-align: center;" class="alert alert-danger alert-dismissible">
									<strong>Sorry!</strong> No records found.
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
					<div class="row">
						<div class="col-sm-12 col-md-5">
							<div class="dataTables_info" id="customerTable_info" role="status" aria-live="polite">
							Showing <?php  if(isset($_GET['page'])){ $page_num=$_GET['page'];}else{$page_num=1;} $start= 1+PER_PAGE_NUMBER*$page_num-PER_PAGE_NUMBER; echo  $start?> to <?php echo PER_PAGE_NUMBER*$page_num; ?> of <?php echo $total_rows;?> entries
								
							</div>
						</div>
						<div class="col-sm-12 col-md-7">
							<div class="dataTables_paginate paging_full_numbers" id="customerTable_paginate">
								<?php echo $links; ?>
							</div>
						</div>
					</div>
			</div>

<script>
$(document).ready(function() {
	
$('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
		  //console.log(url);
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
     });
	 $('.search').on('click', function () {
          var url = $('#dynamic_select2').val(); // get selected value
		  //console.log(url);
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
     });
	 
	$('.details-control').on('click', function () {
          var id = $(this).attr('id'); // get selected value
		 if( $(this).parent().hasClass('shown')){
			$("#detailRow-"+id).hide();
			$(this).parent().removeClass('shown');			
		 }else{
			 $("#detailRow-"+id).show();
			 $(this).parent().addClass('shown');
		 }
		  
    });

     //===show hide date picker=======================
     $('body').on('change', '#paymentaction', function() {
        if($(this).val() == '3'){
		   $('.date-input').removeClass('hide');
	    }else{
			$('.date-input').addClass('hide');
		}
     });
	 
	 //=========mark action process=================
	 $('body').on('click', '#mark_action', function() {
		var pay_stat = $('#paymentaction').val();
		var date = $('#date').val();
		var month = $('#month').val();
		var year = $('#year').val();
		var otr_ids =  $(".check_boxes:checked").map(function () {
						return $(this).val();
					}).get().join(',');
		console.log('otr_ids',otr_ids);
        if( pay_stat == ''){
		    swal("Sorry", "Please select any one value from dropdown.", "error");
	    }else{
			var checkedNum = $('input[name="otr_ids[]"]:checked').length;
			if(checkedNum > 0){
				console.log('good work',otr_ids);				
				 $.ajax({
					url: "<?php echo base_url();?>payments/savePaySatus", 
					 type: "POST",
					 data : { pay_stat : pay_stat, date : date, month:month,year:year,otr_ids : otr_ids },
					success: function(result){
						console.log(result);
						
					}
				}); 
			}else{
				swal("Sorry", "Please check at least one check box from table.", "error");
			}
		}
     });
	 
	  //=========check and uncheck all checkboxes=================
	 $('body').on('click', '.checkall_btn', function() { 
		  if($(this).hasClass("checkall")){
			$('input[name="otr_ids[]"]:checkbox').attr('checked','checked');
			$('.checkall').addClass('hide');
			$('.uncheckall').removeClass('hide');
		  } else {
			  $('input[name="otr_ids[]"]:checkbox').removeAttr('checked');
			  $('.uncheckall').addClass('hide');
			  $('.checkall').removeClass('hide');
			  
		  }       
     });
	 

});
</script>  