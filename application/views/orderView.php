			<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<label class="label mr-3"><strong>View:</strong> </label> 
					<select id ='dynamic_select' class="form-control">
						<option  value="<?php echo base_url();?>orders?type=all" <?php if($_GET['type']=='all') echo "selected"; ?>>All Orders</option>
						<option  value="<?php echo base_url();?>orders?type=active" <?php if($_GET['type']=='active') echo "selected"; ?>>All Active</option>
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
				<?php echo $links; ?>					
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
					
					
					
<script>

$(document).ready(function() {
	function format ( d ) {
		//console.log(d)
    // `d` is the original data object for the row
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
					console.log(data.talents)
					return data.talents.split(",").removeDuplicates().join(",");
					
				},
                "defaultContent": ""
				
			},
            { 
				"orderable":      false,
                "data":           null,
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
	  

} );
</script>