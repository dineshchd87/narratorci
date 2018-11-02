			
	<?php 
function local_time($GMTtime, $localTZoffSet=false)
{
    if(!$localTZoffSet)
    {
        $localTZoffSet = LOCAL_TIME_OFFSET; 
    }
    return $GMTtime+$localTZoffSet;
}
	?>
			<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<label class="label mr-3"><strong>Invoice:</strong> </label> 
					<select id ='dynamic_select' class="form-control">
						
						<option id="active" value="<?php echo base_url();?>invoices/10/1?type=active" <?php if($_GET['type']=='active') echo "selected"; ?>>Active Orders</option>
						<option id="received" value="<?php echo base_url();?>invoices/10/1?type=received" <?php if($_GET['type']=='received') echo "selected"; ?> >Received Orders</option>
						<option id="invoiced"  value="<?php echo base_url();?>invoices/10/1?type=invoiced" <?php if($_GET['type']=='invoiced') echo "selected"; ?>>Invoiced Orders</option>
						<option id="paid" value="<?php echo base_url();?>invoices/10/1?type=paid" <?php if($_GET['type']=='paid') echo "selected"; ?>>Paid Orders</option>
					</select>
					<?php echo $totalRecored; ?>
				</div>
				
			</div>
			
			
			 <div id="csrChange_success_msg" class="col-sm-12 mt-4" style="text-align: center; display:none;">
    			<div class="alert alert-success fade in alert-dismissible show">
                         <button style="margin-top: -5px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <!--<span aria-hidden="true" style="font-size:20px">×</span>-->
                          </button>    <strong>Success!</strong> CSR changed successfully.
                </div>
            </div>
			<div id="statusChange_success_msg" class="col-sm-12 mt-4" style="text-align: center; display:none;">
    			<div class="alert alert-success fade in alert-dismissible show">
                         <button style="margin-top: -5px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <!--<span aria-hidden="true" style="font-size:20px">×</span>-->
                          </button>    <strong>Success!</strong> Status changed successfully.
                </div>
            </div>
			<div class="col-sm-12 mt-4">
			<div class="dataTables_length" id="example_length">
			<label> 
			<select id="actionDropdown">
				<option value='0'>Set invoice status for all selected</option>
				<option value='1'>Received</option>
				<option value='2'>Invoiced</option>
				<option value='3'>Paid</option>
			</select> 
			<input id="go" type="button" value="Go">
			</label>
			
			<label style="float:right;">Show 
			<select id ='pagination' name="example_length" aria-controls="example" class="">
			<option  <?php if($this->uri->segment(2)=='10') echo "selected"; ?> value="<?php echo base_url();?>invoices/10/1">10</option>
			<option  <?php if($this->uri->segment(2)=='25') echo "selected"; ?> value="<?php echo base_url();?>invoices/25/1">25</option>
			<option  <?php if($this->uri->segment(2)=='50') echo "selected"; ?>  value="<?php echo base_url();?>invoices/50/1">50</option>
			<option  <?php if($this->uri->segment(2)=='100') echo "selected"; ?> value="<?php echo base_url();?>invoices/100/1">100</option>
			</select> 
			entries</label>
			</div>
				<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
				
					<tr>
					<th></th>
						<th><input type="checkbox"  name="chkLoop[]" id="checkAll"></th>					
						<th>Customer</th>
						<th>Bill to Email</th>
						<th>Account Manager (CSR)</th>
						<th>Invoice Total</th>
						<th>Invoice Status</th>						
						
						
					</tr>
				</thead>
			<tbody>
			<?php if(isset($invoiceList)){ foreach($invoiceList as $order){ ?>
			<tr  id="brifRow-<?php echo $order['order_id'];  ?>">
				<td class="details-control" id="<?php echo $order['order_id'];  ?>"></td>
				<td><input type="checkbox" name="chkLoop" value ="<?php echo $order['order_id']; ?>" id="chkLoop"></td>
                
                <td><?php echo $order['cust_comp']."</br>"; ?><?php echo $order['cust_name']; ?></td>
                <td><?php echo $order['cust_email'];?>
				</td>
                <td>    <?php   foreach($allCsr as $csr){  
									if($csr['user_id'] == $order['order_csr']){ 
										echo $csr['user_fname'].' '.$csr['user_lname'];
										break;
									}
								}
				  ?>  </td>
                <td><?php $totalPage=0; foreach($order["pages"] as $pages){  $totalPage=$totalPage+$pages['script_page']; } echo number_format(($totalPage* (20 + $order['rush_charge'] - $order["order_discount"]) ),2) ?><?php
							if($order["order_discount"] > 0.00 )
							{
						?>
                        <br />
                        <sapn><sub>( - $ <?php echo number_format(($totalPage* ( $order["order_discount"]) ),2)?>)</sub></sapn>
                        <?php
							}
						?> 
						<?php
							if($order["rush_charge"] > 0.00 )
							{
						?>
                       <sapn><sub>( + $ <?php echo number_format(($totalPage* ( $order["rush_charge"]) ),2)?>)</sub></sapn>
                        <?php
							}
						?></td>
                <td> 
					<?php if ($order["invoice_stat"] == 3){ ?>
                        <img src="<?php echo base_url();?>/assets/images/paid.gif" width="30" height="31" />
					<?php }else
						{
						echo $order["in_status_text"];
						} ?> 
						
						&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("dS M Y", $order["invoice_date"]);?>
				</td>				
            </tr>
			<tr class="order-detail" id="detailRow-<?php echo $order['order_id'];  ?>"><td colspan="9">
			<div class="row">
			  <div class="col-sm-1">
				<?php echo $order["order_id"]; ?>
			  </div>
			  <div class="col-sm-2">
				<label style="font-weight: bold;">Invoice Details:</label>
			  </div>
			  <div class="col-sm-5">
				<?php foreach($order['pages'] as $script){
					echo $script['script_name']."</br>";
				}  ?>
			  </div>
			  <div class="col-sm-2">
				<?php foreach($order['pages'] as $script){
					echo $script['talent'][0]->tlnt_fname."</br>";
				}  ?>
			  </div>
			  <div class="col-sm-1"><?php foreach($order['pages'] as $script){
					echo $script['script_page']."Pages</br>";
				}  ?>
			  </div>
			  <div class="col-sm-1">
			  <?php 
						if($order['isAutoInvoice'] == 'Y' && $order["invoice_stat"]==2)
                        {
				?>
				<img src="<?php echo base_url();?>/assets/images/resend.png" width="28" height="22" style="cursor:pointer;"/>
					<?php	}
			  ?>
			  </div>
			</div>
			</td></tr>
			<?php } 
			}else{ 
			?>
			<tr><td colspan="9" style="text-align:center;">No results found<td></tr>
			<?php } ?>
			</tbody>
			</table>
			<?php if(isset($invoiceList)){?> <div class="col-sm-12 col-md-7"><?php echo $links; ?></div> <?php } ?>
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
	 
	 	$('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
		  //console.log(url);
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
     });
	 
	 	 $('#pagination').on('change', function () {
		 var id = $('#dynamic_select').children(":selected").attr("id");
		 
          var url = $(this).val()+"?type="+id ; // get selected value		 
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
     });
	 
	 	$('#go').on('click', function () {
		 var actionType=$("#actionDropdown").val();
			if(actionType=='0'){
				swal("Please select an app. action.")
				return false;
			}
			if(tmp.length>0){			  
			  
			swal({
			  title: "Are you sure?",
			  text: "Do you want to change status for selected records?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes",
			  cancelButtonText: "No",
			  closeOnConfirm: false
			},
			function(){
			  $.ajax({
						type: 'POST',
						data: { 'invoiceArr' :tmp,'status':actionType},				
						url: "<?php echo base_url();?>invoices/invoice_status/",
						success: function(result){
							
							swal("Status changed!", "Status changed successfully.", "success");
						}
					});
						 
			});
					  
		  }else{
			  swal("Please select at least one Checkbox.!")
		  }
     });
	 
	 var tmp=[]
	$('#checkAll').click(function () {    
		 $('input:checkbox').prop('checked', this.checked);    
	 });
	
	$("input[name='chkLoop']").change(function() {
		var checked = $(this).val();
		if ($(this).is(':checked')) {
		  tmp.push(checked);
		}else{
		tmp.splice($.inArray(checked, tmp),1);
		}
	
  });
});	 
</script>

					
					
					
