			<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<label class="label mr-3"><strong>Customers</strong> </label> 
					
				</div>
			</div>
			<div class="col-sm-12 mt-2">
				<p>Your orders are shown below. Click the plus icon next to an order to see its complete details.</p>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">
						<a href="#" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add an Order</a>
					</div>
					<div class="col-sm-8">
						<form class="form-inline float-right" id="searchForm" action="#" method="get">
						<div class="form-group mr-3">
							<label class="mr-3"><strong>Search : </strong> </label> 	 	
							<select name="searchField" id="searchField" class="form-control form-control-sm">
								<option value="cust">Customer/ Client</option>
								<option value="comp">Company</option>
								<option value="tlnt">Talent</option>
								<option value="csr">CSR</option>
							</select>
						</div>
						<div class="form-group mr-3">
						
							<input type="text" name="searchWord" class="form-control form-control-sm"/>
						</div>
							<div class="form-group">
						
							<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
						</div>
						</form>
					</div>
				</div>
			</div>
            <div id="delete_success_msg" class="col-sm-12 mt-4" style="text-align: center; display:none;">
    			<div class="alert alert-success fade in alert-dismissible show">
                         <button style="margin-top: -5px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <!--<span aria-hidden="true" style="font-size:20px">×</span>-->
                          </button>    <strong>Success!</strong> Customer deleted successfully.
                </div>
            </div>
             <div id="status_success_msg" class="col-sm-12 mt-4" style="text-align: center; display:none;">
                <div class="alert alert-success fade in alert-dismissible show">
                         <button style="margin-top: -5px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <!--<span aria-hidden="true" style="font-size:20px">×</span>-->
                          </button>    <strong>Success!</strong> Status updated successfully.
                </div>
            </div>
			<div class="col-sm-12 mt-4">
				<table id="customerTable" class="table display table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if(!empty($allCustomers)){ //echo "<pre>"; print_r($allCustomers); die;
                                foreach ($allCustomers as $customer) {
                        ?>
                    <tr id="customerRow_<?php echo $customer['cust_id'];?>">
                         <td><?php echo stripslashes($customer['cust_name']);?></td>
                         <td><a href="mailto:<?php echo $customer["cust_email"]; ?>" title="<?php echo $customer["cust_email"]; ?>"><?php echo $customer["cust_email"]; ?></a></td>
                         <td><?php echo $customer['cust_phone'];?></td>
                         <td>
                             <select data="<?php echo $customer['cust_id'];?>" class="form-control change_status_btn" id="customerStatus_<?php echo $customer['cust_id'];?>">
                             <option value="Y" <?php if($customer['is_active'] == "Y"){ ?> selected="selected" <?php } ?>>Active</option>
                            <option value="N" <?php if($customer['is_active'] == "N"){?> selected="selected" <?php } ?>>Inactive</option>
                            </select>
                         <td> 
                            <a data-toggle="modal" data-target="#deleteCustomerModal" data="<?php echo $customer['cust_id'];?>" href="javascript:void(0)" class="btn btn-danger btn-sm delete_btn">
                               <i class="fas fa-times"></i> Remove
                            </a>
                            <a href="javascript:void(0)" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                                 Edit
                            </a>
                        </td>
                    </tr>
                     <?php
                       }
                   }
                    ?>
                </tbody>
            </table>
				
			
			</div>	
				
				
					<div class="row-details rd_1" style="display:none;">
							<div class="cl-d1">
								<div class="width40">
									<label>Customer Details:</label>
									<textarea name="textarea" class="text" id="comment_1"></textarea>
									<label>Order Discount</label>
									<div class="width100">
									$0.00/page
									<img src="images/page_white_edit.png" id="discedit_1" class="editimg"></div>
								</div>
								<div class="width60">
								Dominique Valdez<br>
								Director of Operations - eSystem Training Solutions<br><br>

								<img src="images/flags/US.gif" class="countryFlagImg">United States<br><br>
								dv@esystemtraining.com<br>
								832-632-2805<br>
								</div>
							</div>
							<div class="cl-d2">
								
<label>Order Details</label>
Project Name: Intermediate Rigging	<br>
<a href="mailto:rachael@rachaelwesttalent.com" title="rachael@rachaelwesttalent.com">Rachael West</a><br>
 	- 43 pages - <a href="#">1271829884-T_6-Intermediate Rigging Script.pdf</a><br>
 
							</div>
							<div class="cl-d3">
								
<label>Order History</label>
04/21/2010    --   Received<br>
04/20/2010    --   Out to Talent<br>
04/20/2010    --   Invoiced<br>
04/21/2010    --   Paid<br>
04/22/2010    --   Audio Received<br>
04/23/2010    --   Sent to Client<br>
04/23/2010    --   Completed<br>
							</div>
						</div>
					
<!-- The delete customer modal -->
<div class="modal" id="deleteCustomerModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Note!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <b>Are you sure you want to delete this imagnary data ?</b>
        <input id="selectedCustomer" type="hidden" value=""  />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >N0</button>
        <button id="proceed_delete_btn" type="button" class="btn btn-primary btn-sm" >Yes</button>
      </div>

    </div>
  </div>
</div>					

<script>
    function format ( d ) {
        return '<span>test</span>'
    }

$(document).ready(function() {	
	$('#customerTable').DataTable( {
        "order": [[ 3, "desc" ]],
        "pagingType": "full_numbers"
    });

     $('#customerTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

     //===delete customer=======================
     $('.delete_btn').click(function(){
        $('#selectedCustomer').val($(this).attr('data'));
     });

      $('#proceed_delete_btn').click(function(){
         var selectedCustomer = $('#selectedCustomer').val();
         $.ajax({url: "<?php echo base_url();?>customers/deleteCustomer/"+selectedCustomer, 
            success: function(result){
                $('#delete_success_msg').css('display','block');
                $('#customerRow_'+selectedCustomer).remove();
                setTimeout(function(){ 
                    $('#delete_success_msg').css('display','none');
                 }, 2000);
            }
        });
         $('#deleteCustomerModal').modal('toggle');
     });


      $('.change_status_btn').change(function(){
        var selectedCustomer = $(this).attr('data');
        var status_type = $(this).val();
        $.ajax({url: "<?php echo base_url();?>customers/updateStatus/"+selectedCustomer, 
            type: "POST",
             data : { type : status_type },
            success: function(result){
                console.log(result);
                $('#status_success_msg').css('display','block');
                setTimeout(function(){ 
                    $('#status_success_msg').css('display','none');
                 }, 2000);
            }
        });
     });
});
</script>