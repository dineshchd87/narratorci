			
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
					<label class="label mr-3"><strong>View:</strong> </label> 
					<select id ='dynamic_select' class="form-control">
						<option id='all' value="<?php echo base_url();?>orders/10/1?type=all" <?php if($_GET['type']=='all') echo "selected"; ?>>All Orders</option>
						<option id='active' value="<?php echo base_url();?>orders/10/1?type=active" <?php if($_GET['type']=='active') echo "selected"; ?>>All Active</option>
					</select>
				</div>
				
			</div>
			<div class="col-sm-12 mt-2">
				<p>Your orders are shown below. Click the plus icon next to an order to see its complete details.</p>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">
						<a href="<?php echo base_url();?>orders/create_order" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add an Order</a>
					</div>
					<div class="col-sm-8">
						<form class="form-inline float-right" id="searchForm" action="<?php echo  base_url().$this->uri->uri_string(); ?>" method="get">
						<div class="form-group mr-3">
						<input type='hidden' name='type' value='<?php echo $_GET['type']; ?>'>
							<label class="mr-3"><strong>Search : </strong> </label> 	 	
							<select name="searchField" id="searchField" class="form-control form-control-sm">
								<option <?php if(isset($_GET['searchField']) && $_GET['searchField']=="cust"){ echo 'selected'; } ?>  value="cust">Customer/ Client</option>
								<option <?php if(isset($_GET['searchField']) && $_GET['searchField']=="comp"){ echo 'selected'; } ?>  value="comp">Company</option>
								<option <?php if(isset($_GET['searchField']) && $_GET['searchField']=="tlnt"){ echo 'selected'; } ?> value="tlnt">Talent</option>
								<option <?php if(isset($_GET['searchField']) && $_GET['searchField']=="csr"){ echo 'selected'; } ?>  value="csr">CSR</option>
							</select>
						</div>
						<div class="form-group mr-3">
						
							<input type="text" name="searchWord" value="<?php if(isset($_GET['searchWord'])){ echo $_GET['searchWord']; } ?>" class="form-control form-control-sm"/>
						</div>
							<div class="form-group">
						
							<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			<!--div class="col-sm-12">
				<div class="float-right">
				<?php //echo $links; ?>					
					<div class="form-inline">
						<label>Per Page : </label>
						<select name="setPerPage" class="form-control form-control-sm">
							<option value="10" selected="selected">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="250">250</option>
							<option value="500">500</option>
						</select>
					</div>
				</div>
			</div-->
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
				<option value='0'>Choose an action</option>
				<option value='1'>Hide Selected</option>
				<option value='2'>Delete Selected</option>
			</select> 
			<input id="go" type="button" value="Go">
			</label>
			
			<label style="float:right;">Show 
			<select id ='pagination' name="example_length" aria-controls="example" class="">
			<option  <?php if($this->uri->segment(2)=='10') echo "selected"; ?> value="<?php echo base_url();?>orders/10/1">10</option>
			<option  <?php if($this->uri->segment(2)=='25') echo "selected"; ?> value="<?php echo base_url();?>orders/25/1">25</option>
			<option  <?php if($this->uri->segment(2)=='50') echo "selected"; ?>  value="<?php echo base_url();?>orders/50/1">50</option>
			<option  <?php if($this->uri->segment(2)=='100') echo "selected"; ?> value="<?php echo base_url();?>orders/100/1">100</option>
			</select> 
			entries</label>
			</div>
				<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
				
					<tr>
					<th></th>
						<th><input type="checkbox"  name="chkLoop[]" id="checkAll"></th>
						
						<th>ID</th>						
						<th>Customer</th>
						<th>Date</th>
						<th>Total</th>
						<th>Talent</th>
						<th>Account Manager (CSR)</th>						
						<th>Status</th>
						
					</tr>
				</thead>
			<tbody>
			<?php if(isset($orders)){ foreach($orders as $order){ ?>
			<tr  id="brifRow-<?php echo $order['order_id'];  ?>">
				<td class="details-control" id="<?php echo $order['order_id'];  ?>"></td>
				<td><input type="checkbox" name="chkLoop" value ="<?php echo $order['order_id']; ?>" id="chkLoop"></td>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['cust_name']; ?></td>
                <td><?php echo date("F dS, Y", local_time($order["order_date"]) );
							if(!$order["is_date_mod"])
							{
								echo ' at '.date("g:i A " , local_time($order["order_date"]) ); 
							} ?>
				</td>
                <td> <?php if($order["invoice_stat"]==3){ ?><img src="<?php echo base_url();?>/assets/images/paid.gif" width="30" height="31" onclick="openPaidwin(9709);" style="cursor:pointer;"><?php }elseif($order["invoice_stat"]==2 && $order["isAutoInvoice"]=='Y'){?><a href=""><img src="<?php echo base_url();?>/assets/images/resend.png" width="28" height="22" style="cursor:pointer;"></a> <?php }else{ ?><?php } ?> <?php $totalPage=0; if(isset($order["pages"])){ foreach($order["pages"] as $pages){  $totalPage=$totalPage+$pages['script_page']; } } echo $totalPage; ?> Pages </td>
                <td><?php  if(isset($order["talents"])){ echo $order['talents']; } ?></td>
                <td> 
				<?php  if(3 != $this->session->userdata('group_id')){ ?>
					<select  name='csrep_1'  class='form-control form-control-sm selectCsr'>
					<option value="0">Select a CSR</option>
					<?php foreach($allCsr as $csr){  
						if($csr['user_id'] == $order['order_csr']) $selected = 'selected="selected"'; 
                                    else $selected ='';
					?>
						<option  <?php echo $selected; ?> value='<?php echo $csr['user_id']; ?>'><?php echo $csr["user_fname"].' '.$csr["user_lname"]; ?></option>
					<?php } ?>
					
					</select>
				<?php
				}
				else
				{
					echo $this->session->userdata('user_fname').' ' .$this->session->userdata('user_lname');
				}
				?>
				<img style="display:none;" class="saveCSR"  data-oldcsr="<?php echo $order['order_csr'] ?>" data-orderid="<?php echo $order['order_id'] ;  ?>" src="<?php echo base_url();?>/assets/images/save_but1.gif"  name="save" alt="Save">
				</td>
				<td>
					<select name='ostat_1' class='statusList' class='form-control form-control-sm'>
					<?php foreach($allstatus as $status){ 
					
					if($status['ostat_id'] == $order['status']) $selectedStatus = 'selected="selected"'; 
                                    else $selectedStatus ='';
					?>
					<option <?php echo $selectedStatus; ?> value='<?php echo $status['ostat_id']; ?>'><?php echo $status['ostat_text']; ?></option>
					<?php } ?>
					</select>
					<img style="display:none;" class="saveStatus"   data-orderid="<?php echo $order['order_id'] ;  ?>" src="<?php echo base_url();?>/assets/images/save_but1.gif"  name="save" alt="Save">
				</td>
            </tr>
			<tr class="order-detail" id="detailRow-<?php echo $order['order_id'];  ?>"><td colspan="9">
			<div class="row">
			  <div class="col-sm-4">
				<div class="card">
				 <div class="card-header">Customer Details:</div>
				  <div class="card-body">
					<h6 class="card-title"><?php echo $order['cust_name'].'-'.$order['cust_comp']; ?></h6>
					<p class="card-text"><?php if($order["cust_address1"]) { echo $order["cust_address1"].'<br/>'; }
      if($order["cust_address2"]) { echo $order["cust_address2"].'<br/>'; } ?></p>
	  
	  <p><?php if($order["cust_city"]) { echo $order["cust_city"].', '; } ?> </p>
     <p> <?php if($order["cust_state"]){ echo $order["cust_state"].' '; }  ?> </p>
     <p> <?php if($order["cust_zip"]) {echo $order["cust_zip"].'<br/>'; }?></p>
					<p class="card-text"><span class="flag-image"><img src="<?php echo base_url();?>assets/images/flags/<?php echo $order["cust_country"]?>.gif" class="countryFlagImg" /></span><span class="country-name"><?php  if($order["cust_country"]=="US"){ echo "United States";}else{ echo $order["cust_country"]; }?></span></p>
					<a href="#"><?php if($order["cust_email"]) {echo $order["cust_email"].'<br/>'; }?></a>
					
					<div class="form-group">					
					<textarea class="form-control commentBox" id="exampleFormControlTextarea1" rows="3" data-id="<?php echo $order['order_id'];  ?>"> <?php if($order["order_cmnt"]) { echo $order["order_cmnt"]; } ?></textarea>					 
					</div>
					<div class="form-group form-inline">
					  <label for="discount" class="col-lg-6" >Order Discount:</label>
					  <div class="col-lg-6">
						<label id="lableDiscount-<?php echo $order['order_id'];  ?>"  ><?php echo $order["order_discount"]; ?><img  class='editDiscount' data-order="<?php echo $order['order_id'];  ?>"  src="<?php echo base_url();?>assets/images/page_white_edit.png" style="width:16px; height:16px; cursor:pointer;" > </label>
					  <input  style="display:none;" class="discountRate"  type="text" class="form-control" id="discount-<?php echo $order['order_id'];  ?>"  name="discount">
						</div>
					  
					</div>
				  </div>
				</div>
			  </div>
			  <div class="col-sm-5">
				<div class="card">
				 <div class="card-header">Order Details</div>
				  <div class="card-body">
					<div class="form-group form-inline">
					  <label class="col-lg-6 projectName" >Project Name:</label>
					  <div class="col-lg-6">
						<label ><?php echo $order["order_name"]; ?></label>
					  </div>					  
					</div>
					<ul class="list-group">
					<?php if(count($order["pages"])>0){ foreach( $order["pages"] as $details){ ?>
					<li style="height: 60px;" class="list-group-item">
					 <strong><?php echo $details['talent'][0]->tlnt_fname; ?>:</strong>				 
						 -<?php echo $details["script_page"]; ?>- Pages-<?php echo $details["script_name"]; ?>
					</li>
					<?php  } } ?>
					
					</ul>
				  </div>
				</div>
			  </div>
			  <div class="col-sm-3">
				<div class="card">
				 <div class="card-header">Order History</div>
				  <div class="card-body">
				   <ul class="list-group list-group-flush">
					<?php if(count($order["history"])){ foreach($order["history"] as $history){ ?>
					<li class="list-group-item"><p class="card-text"><?php echo date("m/d/Y", local_time($history['hist_date']) ) .'--'.$history['hist_text'] ?></p></li>
					
					<?php }}else{ ?>
					<p class="card-text">No Activity Yet</p>
					<?php } ?>
					</ul>
				  </div>
				</div>
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
			<div class="row">
						<div class="col-sm-12 col-md-5">
							<div class="dataTables_info" id="customerTable_info" role="status" aria-live="polite">
								<?php   $start=1+$this->uri->segment(3)*$this->uri->segment(2)-$this->uri->segment(2); ?>Showing  <?php echo $start;?> to <?php echo $this->uri->segment(3)*$this->uri->segment(2);?> of <?php echo $totalOrder; ?> entries
							</div>
						</div>
						<?php if(isset($orders)){?> <div class="col-sm-12 col-md-7"><?php echo $links; ?></div> <?php } ?>
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
	 
	 $('#pagination').on('change', function () {
		 var id = $('#dynamic_select').children(":selected").attr("id");
		 
          var url = $(this).val()+"?type="+id ; // get selected value		 
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
	 
	 $('.editDiscount').on('click', function () {
          var id = $(this).attr('data-order'); // get selected value
		 $('#discount-'+id).show();
		 $('#lableDiscount-'+id).hide();
		  
     });
	 
	 $('.commentBox').on('focusout', function () {
          var orderId = $(this).attr('data-id');
		  var comments = $(this).val();	
			var myKeyVals = { 'order_id' : orderId, 'comments' : comments}		  
			$.ajax({
			  type: 'POST',
			  url: "<?php echo base_url();?>orders/saveComments",
			  data: myKeyVals,
			  dataType: "text",
			  success: function(resultData) {
				  
			  }
			});
		  
     });
	 
	 $('.selectCsr').on('change', function() {
		$(this).next().show();
	});
	
	$('.statusList').on('change', function() {
		var orderId=$(this).next().attr('data-orderid');
		var ostId=$(this).val();
		
		if($(this).val()==5){
			swal({
			  title: "Enter here the script file name only.",
			  text: "N.B. file name only, not full path.",
			  type: "input",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Submit",
			  cancelButtonText: "Cancel",
			  closeOnConfirm: false
			},
			function(inputValue){
				if(inputValue){				
				var resource_path=inputValue;
				var dataArr = { 'order_id' : orderId, 'ostId' : ostId,'resource_path':resource_path}
				$.ajax({
					type: "POST",
					data: dataArr,
					url: "<?php echo base_url();?>orders/saveStatus", 
					success: function(result){
						
						swal("Saved!", "Status changed successfully.", "success");
					}
				});
				}else{
					swal.close();
					return false;
				}
			});
		}else if($(this).val()==4){
						swal({
			  title: "Please enter your pickups below:",
			  text: "<textarea  style='width: 100%;height:100px;' id='text'></textarea>",
			  html: true,
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Ok",
			  cancelButtonText: "Cancel",
			  closeOnConfirm: false
			},
			function(input){
				if(input){
					var  resource_path=$("#text").val();
					
					var dataArr = { 'order_id' : orderId, 'ostId' : ostId,'resource_path':resource_path}
					$.ajax({
						type: "POST",
						data: dataArr,				  
						url: "<?php echo base_url();?>orders/saveStatus",  
						success: function(result){						
							swal("Saved!", "Status changed successfully.", "success");
						}
					});
				}else{
					swal.close();
					return false;
				}
			});
		}else{
			$(this).next().show();
			
		}
	});
	
	
	
	$('.saveCSR').on('click', function() {
		var csrId=$(this).prev().val();
		var orderId=$(this).attr('data-orderid');
		var oldcsrId=$(this).attr('data-oldcsr');
		var obj=$(this);
		var data = { 'order_id' : orderId, 'csrId' : csrId,'oldcsrId':oldcsrId}		  
			$.ajax({
			  type: 'POST',
			  url: "<?php echo base_url();?>orders/changeCsr",
			  data: data,
			  dataType: "text",
			  success: function(resultData) {
				  obj.attr('data-oldcsr',csrId);
				  $('#csrChange_success_msg').css('display','block');
				  obj.hide();
                setTimeout(function(){ 
                    $('#csrChange_success_msg').css('display','none');
                 }, 2000);
			  }
			});
		
	});
	
	$('.saveStatus').on('click', function() {
		var ostId=$(this).prev().val();
		var orderId=$(this).attr('data-orderid');
		
		var obj=$(this);
		var data = { 'order_id' : orderId, 'ostId' : ostId}		  
			$.ajax({
			  type: 'POST',
			  url: "<?php echo base_url();?>orders/saveStatus",
			  data: data,
			  dataType: "text",
			  success: function(resultData) {
				  
				  $('#statusChange_success_msg').css('display','block');
				  obj.hide();
                setTimeout(function(){ 
                    $('#statusChange_success_msg').css('display','none');
                 }, 2000);
			  }
			});
		
	});
	
	
	 
	 $('.discountRate').on('focusout', function () {
		 var that=$(this);
          var orderId = $(this).attr('id');
		  var order= orderId.split("-");
		  var discount = $(this).val();	
			var myKeyVals = { 'order_id' : order[1], 'discount' : discount}		  
			$.ajax({
			  type: 'POST',
			  url: "<?php echo base_url();?>orders/updateDiscount",
			  data: myKeyVals,
			  dataType: "text",
			  success: function(resultData) {
				  that.hide();
				  $("#lableDiscount-"+order[1]).show();
			  }
			});
		  
     });
	 
	 $('#go').on('click', function () {
		 var actionType=$("#actionDropdown").val();
			if(actionType=='0'){
				swal("Please select an app. action.")
				return false;
			}
			if(tmp.length>0){			  
			  if(actionType=='1'){
				swal({
				  title: "Are you sure?",
				  text: "Do you want to hide selected records?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes",
				  cancelButtonText: "No",
				  closeOnConfirm: false
				},
				function(){
				  for ( var i = 0, l = tmp.length; i < l; i++ ) {
							$("#detailRow-"+tmp[i]).hide();
							$("#brifRow-"+tmp[i]).hide();						
						}
							 swal.close();
				});
			}else if(actionType=='2'){
				swal({
				  title: "Are you sure?",
				  text: "Do you want to delete selected records?\nThis is permanent!",
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
						data: { 'orderArr' :tmp},				
						url: "<?php echo base_url();?>orders/deleteOrder/",
						success: function(result){
							for ( var i = 0, l = tmp.length; i < l; i++ ) {
								$("#detailRow-"+tmp[i]).remove();
								$("#brifRow-"+tmp[i]).remove();						
							}	
							swal("Deleted!", "Orders deleted successfully.", "success");
						}
					});
				});
			}		  
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

} );
</script>