		<section id="content">
			<div class="section1">
				<div class="view-order">
					<label>View:</label> 
					<select class="form-select">
						<option>All Orders</option>
						<option>All Active</option>
					</select>
				</div>
			</div>
			<div class="section2">
				<p>Your orders are shown below. Click the plus icon next to an order to see its complete details.</p>
			</div>
			<div class="section3">
				<div class="sec3-1">
					<a href="#" class="button button-aqua">Add an Order</a>
				</div>
				<div class="sec3-2">
					<form id="searchForm" action="#" method="get">
						<label>Search</label> 	 	
						<select name="searchField" id="searchField">
							<option value="cust">Customer/ Client</option>
							<option value="comp">Company</option>
							<option value="tlnt">Talent</option>
							<option value="csr">CSR</option>
						</select>
					
						<input type="text" name="searchWord" class="text-input"/>
						<input type="submit" value="Search" class="search-btn">
					</form>
				</div>
				
			</div>
			<div class="section4">
				<div class="rightalign">
				<?php echo $links; ?>
					<div class="pagination">
						<a href="#" class="next" title="first page">[1]</a>
						<a href="#" class="next" title="Prev">Prev</a>
						<a href="#" class="next" title="Go to page 4">4</a>|
						<a href="#" class="next" title="Go to page 5">5</a>|
						<a href="#"><b><span class="report">6</span></b></a>|
						<a href="#" class="next" title="Go to page 7">7</a>|
						<a href="#" class="next" title="Go to page 8">8</a>
						<a href="#" class="next" title="Next">Next</a>
						<a href="#" class="next" title="last page">[895]</a>
					</div>
					<div class="dropdown">
						<label>Per Page : </label>
						<select name="setPerPage">
							<option value="10" selected="selected">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="250">250</option>
							<option value="500">500</option>
						</select>
					</div>
				</div>
			</div>
			<div class="section5">
				<div class="tbl">
					<div class="tbl-row headings">
						<div class="cl cl-1">
							<input type="checkbox" name="chkLoop[]" id="chkLoop">
						</div>
						<div class="cl cl-2">
						</div>
						<div class="cl cl-3">
						ID
						</div>
						<div class="cl cl-4">
						Customer
						</div>
						<div class="cl cl-5">
						Date
						</div>
						<div class="cl cl-6">
						Total
						</div>
						<div class="cl cl-7">
						Talent
						</div>
						<div class="cl cl-8">
						Account Manager (CSR)	
						</div>
						<div class="cl cl-9">
						
						</div>
						<div class="cl cl-10">
						Status
						</div>
					</div>
					<?php foreach($orders as $order){ ?>
					<div class="tbl-row rowdata">
						<div class="cl-1">
							<input type="checkbox" name="chkLoop[]" id="chkLoop">
						</div>
						<div class="cl-2">
							<img class="collapse" id="collapse_1" src="images/plus.gif" width="9" height="9" onclick="showDesc('1');">
						</div>
						<div class="cl-3">
						1
						</div>
						<div class="cl-4">
							Steve Jones
						</div>
						<div class="cl-5">
						20th Apr 2010
						</div>
						<div class="cl-6">
							<img src="images/paid.gif" width="30" height="31"> 1 Pages
						</div>
						<div class="cl-7">
						Derek
						</div>
						<div class="cl-8">
							<select name="csrep_1" id="csrep_1">
								<option value="0">Select a CSR</option>
								<option value="10">Anne Brown</option>
								<option value="16">Diego Pinto</option>
								<option value="8">Jack Braglia</option>
								<option value="3" selected="selected">Jack Courtney</option>
								<option value="15">Jake McEvoy</option>
								<option value="14">Khalil Abu-jamous</option>
								<option value="12">test ee</option>
							</select>	
						</div>
						<div class="cl-9 bg-green">
						
						</div>
						<div class="cl-10">
							<select name="ostat_1" id="ostat_1">
								<option value="1">Received</option>
								<option value="2">Out to Talent</option>
								<option value="3">Audio Received</option>
								<option value="4">Pickups</option>
								<option value="5">Sent to Client</option>
								<option value="6" selected="selected">Completed</option>
							</select>
						</div>
						<div class="row-details rd_1">
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
					</div>
					<?php  } ?>
				</div>
			</div>
		</section>
