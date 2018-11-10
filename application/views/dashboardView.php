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
	<section class="col-sm-12">
		<div class="row">
		
			<div class="col-sm-12 mb-2 mt-3"><h4>Administrative Dashboard</h4></div>
		</div>
		<?php  if($userData['group_id']==ADMIN_GR || $userData['group_id']==CSM_GR ){ ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="col-sm-12 box1">
				<div class="row">
						<div class="col-sm-9">
							<div class="left-box-1">
								<h6 class="what-next">What's Next</h5>
							</div>
							<div class="left-box-1">
								<a href="<?php echo base_url();?>orders/10/1?type=all" class="btn btn-info"> 
								<i class="fas fa-edit"></i> Manage Orders</a>	
								<a href="<?php echo base_url();?>orders/create_order" class="btn btn-info">
								<i class="fas fa-plus-circle"></i> Add an Order</a>							
							</div>
							<div class="left-box-1">
								<h6 class="what-next">Your Store at a Glance....</h6>
								<div class="label">
									<button type="button" class="btn btn-outline-info btn-sm">
										Orders <span class="badge badge-info">
											<?php 
												if(isset($totallOrdersCount) && !empty($totallOrdersCount)){
													echo $totallOrdersCount[0]['order_count'];
												}else{
													echo '0';
												}
											?>
										</span>
									</button>
									<button type="button" class="btn btn-outline-info btn-sm">
										Customers <span class="badge badge-info">
											<?php 
												if(isset($cOrderCount) && !empty($cOrderCount)){
													echo $cOrderCount[0]['cust_count'];
												}else{
													echo '0';
												}
											?>
										</span>
									</button>
									<button type="button" class="btn btn-outline-info btn-sm">
										Voice Talents <span class="badge badge-info">
											<?php 
												if(isset($voiceCount) && !empty($voiceCount)){
													echo $voiceCount;
												}else{
													echo '0';
												}
											?>
										</span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-3 mt-3">
							<div class="btn-group-vertical">		
								<a href="<?php echo base_url();?>customers" class="btn btn-outline-info">Customers</a>			
								<a href="<?php echo base_url();?>talents" class="btn btn-outline-info">Talent	</a>		
								<a href="<?php echo base_url();?>representative" class="btn btn-outline-info">Personnel	</a>	
								<a href="<?php echo base_url();?>invoices/10/1?type=active" class="btn btn-outline-info">Invoicing	</a>	
								<a href="<?php echo base_url();?>payments" class="btn btn-outline-info">Payments	</a>	
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
						<div class="btn-group nav nav-tabs">
						  <a href="#" class="btn btn-outline-info btn-sm">View:</a>
						  <a data-toggle="tab" href="#day" class="btn btn-outline-info btn-sm">Day</a>
						  <a data-toggle="tab" href="#week"class="btn btn-outline-info btn-sm active">Week</a>
						  <a data-toggle="tab" href="#month"class="btn btn-outline-info btn-sm">Month</a>
						  <a data-toggle="tab" href="#year" class="btn btn-outline-info btn-sm">Year</a>
						</div>
					</div>
				</div>
				<div class="row tab-content">
						<table id="day" class="table tab-pane">
							<tr><td class="text-right"><a href="#" class="btn btn-outline-info btn-sm">Reports <i class="fas fa-arrow-right"></i></a>	</td><td>Last Day</td><td>	This Day</td><td>	Change</td></tr>
							<tr><td class="text-right">Net Revenue:</td><td>$<?php  echo $sales_snapshot['pDayOdrVal']; ?>	</td><td>$<?php echo $sales_snapshot['cDayOdrVal']; ?></td><td>	$<?php echo $sales_snapshot['dlDayVal']; ?></td></tr>
							<tr><td class="text-right">Orders:</td><td><?php echo $sales_snapshot['pDayOdrTotal']; ?>	</td><td><?php echo $sales_snapshot['cDayOdrTotal']; ?></td><td><?php echo $sales_snapshot['dlDayTotal']; ?></td></tr>
						</table>
						<table id="week" class="table tab-pane active">
							<tr><td class="text-right"><a href="#" class="btn btn-outline-info btn-sm">Reports <i class="fas fa-arrow-right"></i></a>	</td><td>Last Week</td><td>	This Week</td><td>	Change</td></tr>
							<tr><td class="text-right">Net Revenue:</td><td>$<?php echo $sales_snapshot['pWeekOdrVal']; ?>	</td><td>$<?php echo $sales_snapshot['cWeekOdrVal']; ?></td><td>	$<?php echo $sales_snapshot['dlWeekVal']; ?></td></tr>
							<tr><td class="text-right">Orders:</td><td><?php echo $sales_snapshot['pWeekOdrTotal']; ?></td><td><?php echo $sales_snapshot['cWeekOdrTotal']; ?> </td><td><?php echo $sales_snapshot['dlWeekTotal']; ?></td></tr>
						</table>
						<table id="month" class="table tab-pane">
							<tr><td class="text-right"><a href="#" class="btn btn-outline-info btn-sm">Reports <i class="fas fa-arrow-right"></i></a>	</td><td>Last Month</td><td>	This Month</td><td>	Change</td></tr>
							<tr><td class="text-right">Net Revenue:</td><td>$<?php echo $sales_snapshot['pMonthOdrVal']; ?>	</td><td>$<?php echo $sales_snapshot['cMonthOdrVal']; ?></td><td>	$<?php echo $sales_snapshot['dlMonthVal']; ?></td></tr>
							<tr><td class="text-right">Orders:</td><td><?php echo  $sales_snapshot['pMonthOdrTotal']; ?></td><td><?php echo $sales_snapshot['cMonthOdrTotal']; ?> </td><td><?php  echo $sales_snapshot['dlMonthTotal']; ?></td></tr>
						</table>
						<table id="year" class="table tab-pane">
							<tr><td class="text-right"><a href="#" class="btn btn-outline-info btn-sm">Reports <i class="fas fa-arrow-right"></i></a>	</td><td>Last Year</td><td>	This Year</td><td>	Change</td></tr>
							<tr><td class="text-right">Net Revenue:</td><td>$<?php echo $sales_snapshot['pYrOdrVal']; ?></td><td>$<?php echo $sales_snapshot['cYrOdrVal']; ?></td><td>	$<?php echo $sales_snapshot['dlYrVal']; ?></td></tr>
							<tr><td class="text-right">Orders:</td><td><?php echo $sales_snapshot['pYrOdrTotal']; ?></td><td><?php echo $sales_snapshot['cYrOdrTotal']; ?> </td><td><?php echo $sales_snapshot['dlYrTotal']; ?></td></tr>
						</table>
				</div>
				
			</div>
			</div>
		</div>
		<?php } ?>
		<div class="row mt-4">
			<div class="col-sm-12 mb-3">
				<h5>Recent Orders On The Narrator Files	
				<a href="<?php echo base_url();?>orders?type=all" class="btn btn-info float-right">View All Orders 
				<i class="fas fa-eye"></i></a>	</h5> 
			</div>
			<div class="col-sm-12">
			
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th colspan="3">Show: 
								<a href="<?php echo base_url();?>users/dashboard/recent" class="btn <?php  echo $class = ($orderType == '' || $orderType == 'recent') ? 'btn-secondary' : 'btn-info'; ?> btn-sm">Recent Orders</a>	
								<a href="<?php echo base_url();?>users/dashboard/complete" class="btn <?php  echo $class = ($orderType == 'complete') ? 'btn-secondary' : 'btn-info'; ?> btn-sm">Completed Orders</a>
								<a href="<?php echo base_url();?>users/dashboard/new" class="btn <?php  echo $class = ($orderType == 'new') ? 'btn-secondary' : 'btn-info'; ?> btn-sm">	New Orders</a>
							</th>
							<th>Invoice Status</th>
							<th>Set Order Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($recentOrder))
						{
							foreach ($recentOrder as $order) 
							{ 
						?>
						<tr>
							<td><span class="badge <?php  echo $class = ($order['ostat_text'] == 'Completed') ? 'badge-danger' : 'badge-primary'; ?> text-uppercase"><?php echo $order['ostat_text'];?></span>	</td>
							<td><span class="text-primary">Order #<?php echo $order['order_id'];?> - <?php echo $order['cust_name'];?></span> <br><?php 
							echo date("F dS, Y", local_time($order["order_date"]) );
							if(!$order["is_date_mod"])
							{
								echo ' at '.date("g:i A " , local_time($order["order_date"]) ); 
							}
							?> , 
							<?php 
								if(!empty($order['pages'])){
									echo $order['pages'][0]['pages'];
								}

							?> pages</td>
							<td class="text-primary">Assigned To:<br><?php echo $order['user_fname'];?> <?php echo $order['user_lname'];?></td>
							<td>
								<?php 
								if($order["invoice_stat"]==3)
									{ ?>
						            <img src="<?php echo base_url();?>assets/images/paid.gif" width="30" height="31" onclick="openPaidwin(<?php echo $order["order_id"]; ?>);" style="cursor:pointer;"/>
									<?php 
									} else if($order['isAutoInvoice'] == 'Y' && $order["invoice_stat"]==2) {
									?>
									<a href=""><img src="<?php echo base_url();?>assets/images/resend.png" width="28" height="22" style="cursor:pointer;"/></a>
									<?php echo $order["in_status_text"]; ?>
									<?php 
									}else{
										echo $order["in_status_text"];
									} 
									?>

							</td>
							<td>
								<select name="ostat_1" id="ostat_1"  class="statusList form-control form-control-sm">
								<?php
									$selected = $order["status"];
								    foreach($oStatus as $ostatrow)
								    {
								        $showSelected = '';
										$disableOldStat = '';
								        if($selected == $ostatrow['ostat_id'])    
								        {
								            $showSelected = 'selected="selected"';
								        }
										if($selected >= $ostatrow['ostat_id'])
										{
											$disableOldStat = 'disabled="disabled"';
										}
										if($ostatrow['ostat_id']==6)
											$statColor = '#94c500';
										else	
											$statColor = '#DFECFD';
								?>
								    <option value="<?=$ostatrow['ostat_id']?>" <?=$showSelected?> style="background-color:<?=$statColor?>;" ><?=$ostatrow['ostat_text']?></option>
								<?php
								    }
								?>    
								</select>
								<img style="display:none;" class="saveStatus"   data-orderid="<?php echo  $order['order_id'] ;  ?>" src="<?php echo base_url();?>/assets/images/save_but1.gif"  name="save" alt="Save">
							</td>
							<td><a href="<?php echo base_url();?>orders?type=all&searchField=order_id&searchWord=<?php echo $order['order_id'] ; ?>" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
						</tr>
						<?php 
							}
						}
						?>
					  
					</tbody>
				  </table>
			</div>
		</div>
	</section>
	<script>
	$(document).ready(function() {
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
	});
	</script>