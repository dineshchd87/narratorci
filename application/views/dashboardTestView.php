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
	<?php
$nowTime  =  local_time(time());
//$nowTime  =  getNowGmtTime();
$c_day = (integer)date('j',$nowTime);
$c_week = (integer)date('j',$nowTime);
$c_month = (integer)date('n',$nowTime);
$c_year = (integer)date('Y',$nowTime);
$OneDay = 1*24*3600; //sec ----
function localToGMT($localTime, $localTZoffSet=false)
{
    if(!$localTZoffSet)
    {
        $localTZoffSet = LOCAL_TIME_OFFSET; 
    }
    return $localTime-$localTZoffSet;
}
function getNowGmtTime($nowTime = false)
{
    if(!$nowTime)
    {
        $nowTime = time();
    }
    $serverTZoffSet = date("Z");
    $GMTtime =  $nowTime-$serverTZoffSet;
    return $GMTtime;
}
function calPrevMonth($MnYr=array())
{
    $pMonthNum = $MnYr[0]-1;
    $pMonthYr = $MnYr[1];
    if($pMonthNum == 0 )
    {
        $pMonthNum = 12 ;
        $pMonthYr--;
    }
    return array($pMonthNum,$pMonthYr);
}
function calPrevDay($dMnYr=array())
{
    $pDayNum = $dMnYr[0] -1;
    $pDayMn = $dMnYr[1];
    $pDayYr = $dMnYr[2];
    if($pDayNum == 0 )
    {
        list($pDayMn,$pDayYr) = calPrevMonth( array($pDayMn,$pDayYr) );
        $pDayNum = (integer)date('t', mktime(0,0,0,$pDayMn,1,$pDayYr) );
    }
    return array($pDayNum,$pDayMn,$pDayYr);
}
function percent($prev,$nxt,$isUsd=false)
{
	$percent = (float)($nxt - $prev);
	$percentText = $percent; //( $isUsd? number_format($percent,2) : $percent);
	if($percent<0)
	{
		$prefix = '-';
		$percentText = '<span>'.$prefix.($isUsd? ' $':' ').($percentText*-1)."</span>";
	}
	elseif($percent>=0)
	{
		$prefix = '+';
		$percentText = '<span>'.$prefix.($isUsd? ' $':' ').$percentText."</span>";
	}
	return $percentText;
}
list($pDayNum,$pDayMn,$pDayYr) = calPrevDay( array($c_day,$c_month,$c_year) );
$cDayEnd = localToGMT($nowTime);
$cDayStart = localToGMT(strtotime('00:00:00') );
$pDayEnd = localToGMT($cDayStart-1 );
$pDayStart = localToGMT( $cDayStart-$OneDay);
$tdSt = strtotime('00:00:00');
$ysSt = strtotime('-1 day',$tdSt);
$nowLocalStart = strtotime(date("l",local_time(getNowGmtTime()) ));
$nowLocalEnd = $nowLocalStart+$OneDay-1;
$gmtStart = localToGMT($nowLocalStart);
$gmtEnd = localToGMT($nowLocalEnd);
$startDay = 'Monday';
$cWeekEnd = $nowTime;
$weekTime = (date("l",$cWeekEnd) == $startDay) ? ($cWeekEnd+$OneDay) : $cWeekEnd ;
$cWeekStart = strtotime("last $startDay",$weekTime);
$pWeekEnd = $cWeekStart-1;
$pWeekStart = strtotime("last $startDay",$pWeekEnd);
list($pMonthNum,$pMonthYr) = calPrevMonth(array($c_month,$c_year));
$cMonthEnd = $nowTime;
$cMonthStart = mktime(0,0,0,$c_month,1,$c_year);
$pMonthEnd = $cMonthStart-1;
$pMonthStart = mktime(0,0,0,$pMonthNum,1,$pMonthYr);
$pYrYr = $c_year-1;
$cYrEnd = $nowTime;
$cYrStart = mktime(0,0,0,1,1,$c_year);
$pYrEnd = $cYrStart-1;
$pYrStart = mktime(0,0,0,1,1,$pYrYr);

?>
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
								<a href="<?php echo base_url();?>orders/10/1?type=all" class="btn btn-info"> 
								<i class="fas fa-edit"></i> Manage Orders</a>	
								<a href="#" class="btn btn-info">
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
								<select name="ostat_1" id="ostat_1" onchange="checkSatus(1,9709)" class=" form-control form-control-sm">
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
							</td>
							<td><a href="#" class="btn btn-info btn-sm"> View <i class="fas fa-eye"></i></a></td>
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
		