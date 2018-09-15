	<div id="content" class="row">            
		<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<h2>Payment Management</h2> 
				</div>
                <div class="col-sm-12">
					<div class="form-row">
						<div class="col-sm-4">
						 <select class="form-control">
							<option value="0">for Talents</option>
							<option value="1">for CSR</option>
						  </select>
						</div>
						<div class="col-sm-4">
						  <select class="form-control">
							<option value="0">All payments</option>
							<option value="1">Received</option>
							<option value="1">Requested</option>
							<option value="1">Talent Paid</option>
						  </select>
						</div>
						<div class="col-sm-1">
						  <button class="btn btn-info btn-sm">Go</button>
						</div>
					</div>   <br>
					<div class="form-row">
						<div class="col-sm-4">
						 <select class="form-control">
							<option value="0">Select action for all selected:</option>
							<option value="1">Request payment</option>
							<option value="1">Mark as paid</option>
						  </select>
						</div>
							<div class="col-sm-1">
							  <input type="text" class="form-control" placeholder="MM">
							</div>
							<div class="col-sm-1">
							  <input type="text" class="form-control" placeholder="DD">
							</div>
							<div class="col-sm-1">
							  <input type="text" class="form-control" placeholder="YYYY">
							</div>

						<div class="col-sm-4">
						  <button class="btn btn-info btn-sm">Go</button>
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
								Showing <?php echo $page;?> to <?php echo $per_page;?> of <?php echo $total_rows;?> entries
							</div>
						</div>
						<div class="col-sm-12 col-md-7">
							<div class="dataTables_paginate paging_full_numbers" id="customerTable_paginate">
								<?php echo $links; ?>
							</div>
						</div>
					</div>
                <table id="customerTableppppppppppp" class="table display table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th colspan="2"><a href="javascript:void(0)" class="btn btn-info btn-sm">
									<i class="fas fa-edit"></i>
									 Check All
								</a></th>
							<th>ID</th>
							<th>Talent</th>
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
						<tr class="<?php if($data["rush_charge"] > 0.0) echo "alert-danger";?>">
						
							<td class="details-control" id="<?php echo $data['otr_id'];  ?>">
								
							</td>
							<td class="" >
								<input type="checkbox" value="<?php echo $data["otr_id"];?>">
							</td>
							 <td><?php echo $data["ORDER_SERIAL"];?></td>
							 <td><?php echo $data["tlnt_fname"].' '.$data["tlnt_lname"];?></td>
							 <td>Total pages <?php echo $data["pages"];?>&nbsp;--&nbsp;$<?php echo $data["amount"];?> @ $<?php echo $data['tlnt_rate'] + $data['talent_rush'];?>/page</td>
							 <td>
								<?php echo $data["order_name"];?>
							 <td> 
								 <strong><?php echo $data["paystat_text"];?></strong>
								 &nbsp;&nbsp;-&nbsp;&nbsp;<?php echo date("dS M Y",$data["pay_stat_dt"]);?>  
							 </td>
						</tr>
						<tr class="created-new-row"  style="display: none;" id="detailRow-<?php echo $data['otr_id'];?>">
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
								Showing <?php echo $page;?> to <?php echo $per_page;?> of <?php echo $total_rows;?> entries
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

     //===delete customer=======================
     $('body').on('click', '.delete_btn', function() {
        var selectedCustomer = $(this).attr('data');
        swal({
          title: "Are you sure?",
          text: "Really want to delete this record.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
        },
        function(){
            $.ajax({url: "http://localhost/narratorci/customers/deleteCustomer/"+selectedCustomer, 
                success: function(result){
                    $('#customerRow_'+selectedCustomer).remove();
                    $('#created_new_row_'+selectedCustomer).remove();
                    swal("Deleted!", "Customer deleted successfully.", "success");
                }
            });
        });
     });


    $('body').on('change', '.change_status_btn', function() {
        var selectedCustomer = $(this).attr('data');
        var status_type = $(this).val();
        $.ajax({url: "http://localhost/narratorci/customers/updateStatus/"+selectedCustomer, 
            type: "POST",
             data : { type : status_type },
            success: function(result){
                    swal({
                      title: "Sweet!",
                      text: "Customer status updated successfully.",
                      imageUrl: 'http://localhost/narratorci/assets/images/thumbs-up.jpg'
                    });
            }
        });
     });
});
</script>  </div>