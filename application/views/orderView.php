			<div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<label class="label mr-3"><strong>View:</strong> </label> 
					<select class="form-control">
						<option>All Orders</option>
						<option>All Active</option>
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
						<th><input type="checkbox" name="chkLoop[]" id="chkLoop"></th>
						<th></th>
						<th>ID</th>
						<th>Customer</th>
						<th>Date</th>
						<th>Total</th>
						<th>Talent</th>
						<th>Account Manager (CSR)</th>
						<th></th>
						<th>Status</th>
						
					</tr>
				</thead>
			<tbody>
				<?php foreach($orders as $order){  $i=1;?>
					<tr>
						<td>
							<input type="checkbox" name="chkLoop[]" id="chkLoop">
						</td>
						<td>
							<img class="collapse" id="collapse_1" src="images/plus.gif" width="9" height="9" onclick="showDesc('1');">
						</td>
						<td>
						<?php echo $order['order_id']; ?>
						</td>
						<td>
							
							<?php echo $order['cust_name']; ?>
						</td>
						<td>
						<?php echo date("Y/m/d",$order['order_date']); ?>
						</td>
						<td>
							<span class="badge badge-info text-uppercase">Paid</span> 1 Pages
						</td>
						<td>
						Derek
						</td>
						<td>
							<select name="csrep_1" id="csrep_1" class="form-control form-control-sm">
								<option value="0">Select a CSR</option>
								<option value="10">Anne Brown</option>
								<option value="16">Diego Pinto</option>
								<option value="8">Jack Braglia</option>
								<option value="3" selected="selected">Jack Courtney</option>
								<option value="15">Jake McEvoy</option>
								<option value="14">Khalil Abu-jamous</option>
								<option value="12">test ee</option>
							</select>	
						</td>
						<td class="bg-green">
						
						</td>
						<td>
							<select name="ostat_1" id="ostat_1" class="form-control form-control-sm">
								<option value="1">Received</option>
								<option value="2">Out to Talent</option>
								<option value="3">Audio Received</option>
								<option value="4">Pickups</option>
								<option value="5">Sent to Client</option>
								<option value="6" selected="selected">Completed</option>
							</select>
						</td>
						</tr>
					<?php $i+1; } ?>
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
    $('#example').DataTable();
} );
</script>