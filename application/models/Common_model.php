<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {
	/**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   Manage common user functionality
     * @params          :
     * @return          :   
     */
	public function __construct(){
		parent::__construct();   
	}	
    
    /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   get countries data
     * @params          :	
     * @return          :   data as []
     */
	public function getCountries(){	
        $this->db->select('*');
        $this->db->from('nrf_country');
        $countries = $this->db->get()->result_array(); 
        if(!empty($countries)){
            return $countries;
        }else{
            return array();
        }
	}

    /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all orders status
     * @params          :   
     * @return          :   data as []
     */
    public function getAllOrdersStatus(){ 
        $this->db->select('*');
        $this->db->from('nrf_order_status_text');
        $oStatus = $this->db->get()->result_array(); 
        if(!empty($oStatus)){
            return $oStatus;
        }else{
            return array();
        }
    }
	
	    /**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   get all get snep Shot 
     * @params          :   
     * @return          :   data as []
     */
    public function getsnepShot(){ 
		$data=array();
				 
		$nowTime  =  $this->getNowGmtTime();
		 
		$c_day = (integer)date('j',$nowTime);

		$c_week = (integer)date('j',$nowTime);

		$c_month = (integer)date('n',$nowTime);

		$c_year = (integer)date('Y',$nowTime);

		$OneDay = 1*24*3600; //sec ----

		$cDayEnd =$this->localToGMT($nowTime);
		$cDayStart = $this->localToGMT(strtotime('00:00:00') );
		
		$pDayEnd = $this->localToGMT($cDayStart-1 );
		//echo $cDayEnd ;die;
		$pDayStart = $this->localToGMT( $cDayStart-$OneDay);
		
		$pYrYr = $c_year-1;

		$cYrEnd = $nowTime;

		$cYrStart = mktime(0,0,0,1,1,$c_year);

		$pYrEnd = $cYrStart-1;

		$pYrStart = mktime(0,0,0,1,1,$pYrYr);
		//-----------------------------------------------------  day calucalation start
		$cDayOdrTotal = $this->getSnapCount($cDayStart,$cDayEnd); 
		$cDayOdrVal = 0; // ***		
		list($cDayOdrVal,$cDayOdrPage,$cDayOdrCsrVal,$discount,$rush_charge) = $this->getOrderValueFast($cDayStart,$cDayEnd);
		$grsRevTotal = $cDayOdrPage*(20) + $rush_charge - $discount;
		$cDayOdrVal = $grsRevTotal - (($cDayOdrVal) + ($cDayOdrCsrVal) );
		$data['cDayOdrTotal']=$cDayOdrTotal;
		$data['cDayOdrVal']=$cDayOdrVal;
		// ------- prev day
		$pDayOdrTotal = $this->getSnapCount($pDayStart,$pDayEnd); // ***

		$pDayOdrVal = 0; // ***
		$discount = 0;
		$rush_charge = 0;

		list($pDayOdrVal,$pDayOdrPage,$pDayOdrCsrVal,$discount,$rush_charge) = $this->getOrderValueFast($pDayStart,$pDayEnd);

		$grsRevTotal = $pDayOdrPage*20 + $rush_charge- $discount;
		//*******************************************************************************************
		// Net Revenue = Total pages * 20 - ((Total pages * Talent rate) + (Total pages * CSR rate))
		$pDayOdrVal = $grsRevTotal - (($pDayOdrVal) + ($pDayOdrCsrVal) );
		$data['pDayOdrTotal']=$pDayOdrTotal;
		$data['pDayOdrVal']=$pDayOdrVal;
		$dlDayTotal = $this->percent($pDayOdrTotal,$cDayOdrTotal);
		$dlDayVal = $this->percent($pDayOdrVal,$cDayOdrVal,true);
		$data['dlDayTotal']=$dlDayTotal;
		$data['dlDayVal']=$dlDayVal;
		//-----------------------------------------------------  day calucalation end
		
		
		//------------------------------------------------------ year

		$cYrOdrTotal = $this->getSnapCount($cYrStart,$cYrEnd); // ***
		
		list($cYrOdrVal,$cYrOdrPage,$cYrOdrCsrVal,$discount,$rush_charge) = $this->getOrderValueFast($cYrStart,$cYrEnd);

		$grsRevTotal = $cYrOdrPage*20 + $rush_charge - $discount;
		
		//*******************************************************************************************
		// Net Revenue = Total pages * 20 - ((Total pages * Talent rate) + (Total pages * CSR rate))
		$cYrOdrVal = $grsRevTotal - (($cYrOdrVal) + ($cYrOdrCsrVal) );
		$data['cYrOdrTotal']=$cYrOdrTotal;
		$data['cYrOdrVal']=$cYrOdrVal;

		// ------- prev year
		$pYrOdrTotal = $this->getSnapCount($pYrStart,$pYrEnd); // ***

		list($pYrOdrVal,$pYrOdrPage,$pYrOdrCsrVal,$discount,$rush_charge) = $this->getOrderValueFast($pYrStart,$pYrEnd);


		$grsRevTotal = $pYrOdrPage*20 + $rush_charge - $discount;
		//*******************************************************************************************
		// Net Revenue = Total pages * 20 - ((Total pages * Talent rate) + (Total pages * CSR rate))
		$pYrOdrVal = $grsRevTotal - (($pYrOdrVal) + ($pYrOdrCsrVal) );
		$data['pYrOdrTotal']=$pYrOdrTotal;
		$data['pYrOdrVal']=$pYrOdrVal;
		$dlYrTotal = $this->percent($pYrOdrTotal,$cYrOdrTotal);
		
		$dlYrVal = $this->percent($pYrOdrVal,$cYrOdrVal,true);
		$data['dlYrTotal']=$dlYrTotal;
		$data['dlYrVal']=$dlYrVal;
		
		 return $data;
		
    }
	
	public function localToGMT($localTime, $localTZoffSet=false)
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
	
	function getSnapCount($startTime,$endTime)
	{
        $allRow = array();
        $sql ="SELECT
                    COUNT(order_id) AS order_count
                FROM
                    nrf_orders
                WHERE
                    order_date >= $startTime AND order_date <= $endTime";

        $query = $this->db->query($sql);
        $orders = $query->result_array();				
        if(!empty($orders)){
            return $count = $orders[0]['order_count'];
        }else{
        return array();
        }			   

	}
	
	function getOrderValueFast($startTime,$endTime)
    {
		$orderDisc=0;
		$discount = 0;
		$rush_charge = 0;
        $orderval = 0;
		$orderCSRval = 0;
        $pages = 0;
        $sql ="SELECT
                        SUM(SC.script_page) talent_page, 
                        SUM(SC.script_page)*(
                                                                TNLT.tlnt_rate + 
                                                                IF(ORDR.rush_charge>0.00 , 2.0, 0.00)
                                                                )AS talent_total,
                        SUM(SC.script_page)*CSRM.csrm_rate AS csr_total,
                        SUM(SC.script_page * ORDR.order_discount) AS discount,
                        SUM(SC.script_page * ORDR.rush_charge) AS rush_charge
                FROM
                        nrf_orders AS ORDR
                JOIN
                        nrf_order_talent_rel AS OTR
                ON
                        (ORDR.order_id = OTR.order_id)
                LEFT JOIN
                        nrf_talent AS TNLT
                ON
                        (OTR.tlnt_id = TNLT.tlnt_id)
                JOIN
                        nrf_scripts AS SC
                ON
                        (OTR.otr_id=SC.otr_id)
                LEFT JOIN 
                        nrf_csrm AS CSRM
                ON
                        (ORDR.order_csr = CSRM.user_id)

                WHERE 
                    order_date >= $startTime AND order_date <= $endTime
                ";
        $sql .= " GROUP BY OTR.otr_id ";

		$query = $this->db->query($sql);
        $orderdata = $query->result_array();
		if($orderdata)
        {
           foreach($orderdata as $record)
            {
                $orderval += $record['talent_total'];
                $pages += $record['talent_page'];
                $orderCSRval += $record['csr_total'];
                $orderDisc += $record['discount'];
                $rush_charge += $record['rush_charge'];
                //$allRow[] = $row;
				
            }            

        }		


		//echo "classSnap--$orderval,$pages,$orderCSRval,$rush_charge<br />";
        return array($orderval,$pages,$orderCSRval,$orderDisc,$rush_charge);
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

		//return number_format(($nxt - $prev)/($nxt == 0 ? 1 : $nxt) * 100.00,2);

		return $percentText;

	}
}

?>