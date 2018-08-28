			
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
			<div class="col-sm-12 mt-4">
			<div class="dataTables_length" id="example_length">
			<label>Show 
			<select id ='pagination' name="example_length" aria-controls="example" class="">
			<option  <?php if($this->uri->segment(2)=='10') echo "selected"; ?> value="<?php echo base_url();?>orders/10/1">10</option>
			<option  <?php if($this->uri->segment(2)=='25') echo "selected"; ?> value="<?php echo base_url();?>orders/25/1">25</option>
			<option  <?php if($this->uri->segment(2)=='50') echo "selected"; ?>  value="<?php echo base_url();?>orders/50/1">50</option>
			<option  <?php if($this->uri->segment(2)=='100') echo "selected"; ?> value="<?php echo base_url();?>orders/100/1">100</option>
			</select> 
			entries</label></div>
				<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
				
					<tr>
					<th></th>
						<th><input type="checkbox" name="chkLoop[]" id="chkLoop"></th>
						
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
			<?php foreach($orders as $order){ ?>
			<tr>
				<td class="details-control" id="<?php echo $order['order_id'];  ?>"></td>
				<td><input type="checkbox" name="chkLoop[]" id="chkLoop"></td>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['cust_name']; ?></td>
                <td><?php echo date("F dS, Y", local_time($order["order_date"]) );
							if(!$order["is_date_mod"])
							{
								echo ' at '.date("g:i A " , local_time($order["order_date"]) ); 
							} ?>
				</td>
                <td> <?php if($order["invoice_stat"]==3){ ?><img src="<?php echo base_url();?>/assets/images/paid.gif" width="30" height="31" onclick="openPaidwin(9709);" style="cursor:pointer;"><?php }elseif($order["invoice_stat"]==2 && $order["isAutoInvoice"]=='Y'){?><a href=""><img src="<?php echo base_url();?>/assets/images/resend.png" width="28" height="22" style="cursor:pointer;"></a> <?php }else{ ?><?php } ?> <?php $totalPage=0; foreach($order["pages"] as $pages){  $totalPage=$totalPage+$pages['script_page']; } echo $totalPage; ?> Pages </td>
                <td><?php echo $order['talents']; ?></td>
                <td><select name='csrep_1' id='csrep_1' class='form-control form-control-sm'><option value='0'>Select a CSR</option><option value='10'>Anne Brown</option><option value='16'>Diego Pinto</option><option value='8'>Jack Braglia</option><option value='3' selected='selected'>Jack Courtney</option><option value='15'>Jake McEvoy</option><option value='14'>Khalil Abu-jamous</option><option value='12'>test ee</option></select></td>
				<td><select name='ostat_1' id='ostat_1' class='form-control form-control-sm'><option value='1'>Received</option><option value='2'>Out to Talent</option><option value='3'>Audio Received</option><option value='4'>Pickups</option><option value='5'>Sent to Client</option><option value='6' selected='selected'>Completed</option></select></td>
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
			  <div class="col-sm-4">
				<div class="card">
				 <div class="card-header">Order Details</div>
				  <div class="card-body">
					<div class="form-group form-inline">
					  <label for="discount" class="col-lg-6" >Project Name:</label>
					  <div class="col-lg-6">
						<label ><?php echo $order["order_name"]; ?></label>
					  </div>					  
					</div>
					<?php foreach( $order["pages"] as $details) ?>
					<div class="form-group form-inline">
					<a class="col-lg-6"> <?php echo $details['talent'][0]->tlnt_fname; ?>:</a>
					 
					  <div class="col-lg-6">
						<label > <?php echo $details["script_page"]; ?>- Pages-<?php echo $details["script_name"]; ?></label>
					  </div>					  
					</div>
				  </div>
				</div>
			  </div>
			  <div class="col-sm-4">
				<div class="card">
				 <div class="card-header">Order History</div>
				  <div class="card-body">
					<?php foreach($order["history"] as $history){ ?>
					<p class="card-text"><?php echo date("m/d/Y", local_time($history['hist_date']) ) .'--'.$history['hist_text'] ?></p>
					<?php } ?>
				  </div>
				</div>
			  </div>
			</div>
			</td></tr>
			<?php } ?>
			</tbody>
			</table>
			<div class="col-sm-12 col-md-7"><?php echo $links; ?></div>
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
	/*
	function format ( d ) {
		//console.log(d)
    // `d` is the original data object for the row
	return '<div class="row">'+
			'<div class="col-sm-4">'+
				'<div class="card bg-light mb-3">'+
				'<div class="card-header">Customer Details</div>'+
		  '<div class="card-body">'+
			'<h6 class="card-title">	Kathy Haratonik- Genentech</h6>'+
				'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>'+
				'<div class="form-group">'+
      '<label for="comment">Comment:</label>'+
      '<textarea class="form-control" rows="5" id="comment" name="text"></textarea>'+
    '</div>'+
			  '</div>'+
			'</div>'+
		  '</div>'+
		  '<div class="col-sm-4">'+
				'<div class="card bg-light mb-3">'+
				'<div class="card-header">Order Details</div>'+
		  '<div class="card-body">'+
			'<h5 class="card-title">Special title treatment</h5>'+
				'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>'+
				
			  '</div>'+
			'</div>'+
		  '</div>'+
	'<div class="col-sm-4">'+
				'<div class="card bg-light mb-3">'+
				'<div class="card-header">Order History</div>'+
		  '<div class="card-body">'+
			'<h5 class="card-title">Special title treatment</h5>'+
				'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>'+
				'</div>'+
			'</div>'+
		  '</div>'+
		'</div>';
		
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.cust_name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.order_id+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}
	 var table =$('#example').DataTable({
        "processing": true,
        "serverSide": true,
		"sDom": "ltipr",
        "ajax": "<?php echo base_url();?>orders/ajax?type=<?php echo $_GET['type'] ?>",
		"columns": [
			{
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
			{
                "class":          "",
                "orderable":      false,
                "data":           null,
                "defaultContent": "<input type='checkbox' name='chkLoop[]' id='chkLoop'>"
            },
            { "data": "order_id" },
            { "data": "cust_name" },
            { "data": "order_date"},
            { 
				"orderable":      false,
                "data":           null,
				"render": function ( data ) { 
					if(data.invoice_stat=='3'){
						var status ='<span class="badge badge-success text-uppercase">Paid</span> ';
					}else if(data.invoice_stat=='3' && data.isAutoInvoice=='Y'){
						var status='<span class="badge badge-primary text-uppercase">Invoiced</span> ';
					}else{
						var status='<span class="badge badge-info text-uppercase">Received</span> ';
						
					}
                     return  status+data.script_count+ 'Pages';
                 }
                
				
			},
            { 
				"orderable":      false,
                "data":           function(data){
					//console.log(data.talents)
					return data.talents.split(",").removeDuplicates().join(",");
					
				},
                "defaultContent": ""
				
			},
            { 
				"orderable":      false,
                "data":           null,
				"csr":function(csr){
					console.log(csr)
				},
                "defaultContent": "<select name='csrep_1' id='csrep_1' class='form-control form-control-sm'><option value='0'>Select a CSR</option><option value='10'>Anne Brown</option><option value='16'>Diego Pinto</option><option value='8'>Jack Braglia</option><option value='3' selected='selected'>Jack Courtney</option><option value='15'>Jake McEvoy</option><option value='14'>Khalil Abu-jamous</option><option value='12'>test ee</option></select>"
				
			},			
			{ 	
				"orderable":      false,
                "data":           null,
                "defaultContent": "<select name='ostat_1' id='ostat_1' class='form-control form-control-sm'><option value='1'>Received</option><option value='2'>Out to Talent</option><option value='3'>Audio Received</option><option value='4'>Pickups</option><option value='5'>Sent to Client</option><option value='6' selected='selected'>Completed</option></select>"
				
			},
        ]
    } );
 
  $('#example tbody').on('click', 'td.details-control', function () {
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
	
	$('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
		  //console.log(url);
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
     });
	 
	   $(document).on('submit', '#searchForm', function () {
		   //console.log($(this).serialize());
		   table.search( $(this).serialize()).draw();
        return false;
    } );
	 Array.prototype.removeDuplicates = function () {        
		  return this.filter(function (item, index, self) {
                    return self.indexOf(item) == index;
                });
      };
	  */

} );
</script>