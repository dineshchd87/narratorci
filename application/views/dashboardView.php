	<section class="col-sm-12">
		<div class="row">
			<div class="col-sm-12 mb-2 mt-3"><h4>Administrative Dashboard</h4></div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="col-sm-12 box1">
				<div class="row">
						<div class="col-sm-9">
							<div class="left-box-1">
								<h6 class="what-next">What's Next</h5>
							</div>
							<div class="left-box-1">
								<a href="<?php echo base_url();?>orders?type=all" class="btn btn-info"> 
								<i class="fas fa-edit"></i> Manage Orders</a>	
								<a href="#" class="btn btn-info">
								<i class="fas fa-plus-circle"></i> Add an Order</a>	
							
							</div>
							<div class="left-box-1">
								<h6 class="what-next">Your Store at a Glance....</h6>
								<div class="label">
									<button type="button" class="btn btn-outline-info btn-sm">
										Orders <span class="badge badge-info">8952</span>
									</button>
									<button type="button" class="btn btn-outline-info btn-sm">
										Customers <span class="badge badge-info">756</span>
									</button>
									<button type="button" class="btn btn-outline-info btn-sm">
										Voice Talents <span class="badge badge-info">15</span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-3 mt-3">
							<div class="btn-group-vertical">		
								<a href="#" class="btn btn-outline-info">Customers</a>			
								<a href="#" class="btn btn-outline-info">Talent	</a>		
								<a href="#" class="btn btn-outline-info">Personnel	</a>	
								<a href="#" class="btn btn-outline-info">Invoicing	</a>	
								<a href="#" class="btn btn-outline-info">Payments	</a>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="col-sm-12 box2">
			
				<div class="row">
					<div class="col-sm-4">
						<h6 class="what-next">Sales Snapshot	</h6>
					</div>
					<div class="col-sm-8 mt-2">
						<div class="btn-group">
						  <a href="#" class="btn btn-outline-info btn-sm">View:</a>
						  <a href="#" class="btn btn-outline-info btn-sm">Day</a>
						  <a href="#" class="btn btn-outline-info btn-sm">Week</a>
						  <a href="#" class="btn btn-outline-info btn-sm">Month</a>
						  <a href="#" class="btn btn-outline-info btn-sm">Year</a>
						</div>
					</div>
				</div>
				<div class="row">
						<table class="table">
							<tr><td class="text-right"><a href="#" class="btn btn-outline-info btn-sm">Reports <i class="fas fa-arrow-right"></i></a>	</td><td>Last Week</td><td>	This Week</td><td>	Change</td></tr>
							<tr><td class="text-right">Net Revenue:</td><td>$1902	</td><td>$1380</td><td>	- $522</td></tr>
							<tr><td class="text-right">Orders:</td><td>19	</td><td>22	+ </td><td>3</td></tr>
						</table>
				</div>
			</div>
			</div>
		</div>
	
		<div class="row mt-4">
			<div class="col-sm-12 mb-3">
				<h5>Recent Orders On The Narrator Files	
				<a href="#" class="btn btn-info float-right">View All Orders 
				<i class="fas fa-eye"></i></a>	</h5> 
			</div>
			<div class="col-sm-12">
			
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th colspan="3">Show: 
								<a href="#" class="btn btn-info btn-sm">Recent Orders</a>	
								<a href="#" class="btn btn-info btn-sm">Completed Orders</a>
								<a href="#" class="btn btn-info btn-sm">	New Orders</a>
							</th>
							<th>Invoice Status</th>
							<th>Set Order Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span class="badge badge-info text-uppercase">Out to Talent</span>	</td>
							<td>Order #9709 - Morgan Walkup <br>August 21st, 2018 at 1:03 PM , 7 pages</td>
							<td>Assigned To:<br>Anne Brown</td>
							<td><span class="badge badge-success text-uppercase">Paid</span></td>
							<td>
								<select name="ostat_1" id="ostat_1" onchange="checkSatus(1,9709)" class=" form-control form-control-sm">
								<option value="1" style="background-color:#DFECFD;">Received</option>
								<option value="2" selected="selected" style="background-color:#DFECFD;">Out to Talent</option>
								<option value="3" style="background-color:#DFECFD;">Audio Received</option>
								<option value="4" style="background-color:#DFECFD;">Pickups</option>
								<option value="5" style="background-color:#DFECFD;">Sent to Client</option>
								<option value="6" style="background-color:#94c500;">Completed</option>
								</select>
							</td>
							<td><a href="#" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
						</tr>
						<tr>
							<td><span class="badge badge-info text-uppercase">Out to Talent</span>	</td>
							<td>Order #9709 - Morgan Walkup <br>August 21st, 2018 at 1:03 PM , 7 pages</td>
							<td>Assigned To:<br>Anne Brown</td>
							<td><span class="badge badge-success text-uppercase">Paid</span></td>
							<td>
								<select name="ostat_1" id="ostat_1" onchange="checkSatus(1,9709)" class=" form-control form-control-sm">
								<option value="1" style="background-color:#DFECFD;">Received</option>
								<option value="2" selected="selected" style="background-color:#DFECFD;">Out to Talent</option>
								<option value="3" style="background-color:#DFECFD;">Audio Received</option>
								<option value="4" style="background-color:#DFECFD;">Pickups</option>
								<option value="5" style="background-color:#DFECFD;">Sent to Client</option>
								<option value="6" style="background-color:#94c500;">Completed</option>
								</select>
							</td>
							<td><a href="#" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
						</tr>
						<tr>
							<td><span class="badge badge-info text-uppercase">Out to Talent</span>	</td>
							<td>Order #9709 - Morgan Walkup <br>August 21st, 2018 at 1:03 PM , 7 pages</td>
							<td>Assigned To:<br>Anne Brown</td>
							<td><span class="badge badge-info text-uppercase">Received</span></td>
							<td>
								<select name="ostat_1" id="ostat_1" onchange="checkSatus(1,9709)" class=" form-control form-control-sm">
								<option value="1" style="background-color:#DFECFD;">Received</option>
								<option value="2" selected="selected" style="background-color:#DFECFD;">Out to Talent</option>
								<option value="3" style="background-color:#DFECFD;">Audio Received</option>
								<option value="4" style="background-color:#DFECFD;">Pickups</option>
								<option value="5" style="background-color:#DFECFD;">Sent to Client</option>
								<option value="6" style="background-color:#94c500;">Completed</option>
								</select>
							</td>
							<td><a href="#" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
						</tr>
						<tr>
							<td><span class="badge badge-info text-uppercase">Out to Talent</span>	</td>
							<td>Order #9709 - Morgan Walkup <br>August 21st, 2018 at 1:03 PM , 7 pages</td>
							<td>Assigned To:<br>Anne Brown</td>
							<td><span class="badge badge-success text-uppercase">Paid</span></td>
							<td>
								<select name="ostat_1" id="ostat_1" onchange="checkSatus(1,9709)" class=" form-control form-control-sm">
								<option value="1" style="background-color:#DFECFD;">Received</option>
								<option value="2" selected="selected" style="background-color:#DFECFD;">Out to Talent</option>
								<option value="3" style="background-color:#DFECFD;">Audio Received</option>
								<option value="4" style="background-color:#DFECFD;">Pickups</option>
								<option value="5" style="background-color:#DFECFD;">Sent to Client</option>
								<option value="6" style="background-color:#94c500;">Completed</option>
								</select>
							</td>
							<td><a href="#" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
						</tr>
					  
					</tbody>
				  </table>
			</div>
		</div>
	</section>
		