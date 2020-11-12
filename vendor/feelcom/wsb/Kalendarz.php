<?php
namespace feelcom\wsb;

// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');

// min requirements

include_once 'minequirements.php';

// including function file
include_once 'Functions.php';
include_once 'Auth.php';

use DateTime;
use Exception;


const WEEKDAYS = array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela');
const WEEKDAYS_SHORT = array('PN','WT','ŚR','CZ','PT','SO','N');

class Kalendarz {


	private $_data;
	private $_month;
	private $_year;
	private $_days;
	private $_day;
	private $_startDay;
	private $_lastDay;
	private $_todayY;
	private $_todayM;
	private $_todayD;

	function __construct($month=NULL,$year=NULL) {

		if (isset($month)){
			$month = (int)$month;
		}
		else
		{
			$month = date('m');
		}

		if (isset($year)){
			$year = (int)$year;
		}
		else
		{
			$year = date('Y');
		}

		$day = 01;//date('d');

		$this->_data = date($year.'-'.$month.'-'.$day);

		$dt = strtotime($this->_data);
		$this->_month = (int)date('m',$dt);
		$this->_year = (int)date('Y',$dt);
		$this->_day = (int)date('d',$dt);

		$this->_days = cal_days_in_month(CAL_GREGORIAN, $this->_month,$this->_year);

		$dt = mktime(0,0,0, $this->_month,0,$this->_year);
		$this->_startDay = (int)date('w',$dt);
		$this->_lastDay = (int)date('w',mktime(0, 0, 0, $this->_month, $this->_days, $this->_year));

		$this->_todayY = date('Y');
		$this->_todayM = date('m');
		$this->_todayD = date('d');


	}

	public function userReservation(){

		$cnt =1;

		$monthName = strftime("%B", mktime(0, 0, 0, $this->_month, 1));

		//create object functions
		$fk = new Functions();

		//create object auth
		$auth = new Auth();
		$isAdmin = $auth->cookie_login();
		$adminClass = "";
		$checkTitle = "Sprawdź rezerwację";
		if($isAdmin){
			$adminClass = "adm_check";
			$tmp = array();
			//get reservations for admin month from DB
			$reservations = $fk->getReservationsAdm($this->_month,$this->_year);

			//change array key value to data_id - for get reservation details
			foreach ($reservations as $key => $value )
			{
				$tmp[$value['date_id']] = $value;
			}
			$reservations = $tmp;
		}
		else
		{
			//get reservations for users month from DB
			$reservations = $fk->getReservations($this->_month,$this->_year);
		}






		$html = "
			<!-- data choice row -->
			<div class='top-tr'>
			
					<!-- data choice previous arrow -->
					<div class='flex-tr'>
						<i class='fas fa-angle-double-left fa-3x' id='previous_month' data-year='$this->_year' data-month='$this->_month'></i>
					</div>
					
					
					<!-- data choice month & year select -->
					<div class='flex-tr ' id='choice_date' data-year='$this->_year' data-month='$this->_month'>
					
						<div class='flex-tr select-flex' id='select-date'>
						    
						    <!-- data choice month select -->
						    <div class='month'>
						
								<div class='select'>
								
									<div class='select-styled' id='month'>
										$monthName
									</div>
									
									<ul class='select-options month-list'>
										<li class='month-options' data-year='$this->_year' data-month='1'>styczeń</li>
										<li class='month-options' data-year='$this->_year' data-month='2'>luty</li>
										<li class='month-options' data-year='$this->_year' data-month='3'>marzec</li>
										<li class='month-options' data-year='$this->_year' data-month='4'>kwiecień</li>
										<li class='month-options' data-year='$this->_year' data-month='5'>maj</li>
										<li class='month-options' data-year='$this->_year' data-month='6'>czerwiec</li>
										<li class='month-options' data-year='$this->_year' data-month='7'>lipec</li>
										<li class='month-options' data-year='$this->_year' data-month='8'>sierpień</li>
										<li class='month-options' data-year='$this->_year' data-month='9'>wrzesień</li>
										<li class='month-options' data-year='$this->_year' data-month='10'>październik</li>
										<li class='month-options' data-year='$this->_year' data-month='11'>listopad</li>
										<li class='month-options' data-year='$this->_year' data-month='12'>grudzień</li>
									</ul>
								</div>
								
						    </div>
						
						
							<!-- data choice year select -->
						    <div class='year'>
						
								<div class='select'>
								
									<div class='select-styled' id='year'>
										$this->_year
									</div>
									
									<ul class='select-options year-list'>
										<li class='year-options' data-year='2019' data-month='$this->_month'>2019</li>
										<li class='year-options' data-year='2020' data-month='$this->_month'>2020</li>
									</ul>
								</div>
								
						    </div>
						</div>									
					</div>
					
					<!-- data choice next arrow -->
					<div class='flex-tr'>
						<i class='fas fa-angle-double-right fa-3x' id='next_month' data-year='$this->_year' data-month='$this->_month'></i>
					</div>	
				
			</div>
			
			<!-- weekdays full res row -->
			<ul class='weekdays'>";

		for($i=0; $i<7; $i++){

			$html .= "<li>".WEEKDAYS[$i]."</li>";
		}

		$html .= "		</ul>
						<!--end of weekdays full res row -->
		
						<!-- weekdays mobile res row -->
						<ul class='weekdays-short'>";

		for($i=0; $i<7; $i++){

			$html .= "<li>".WEEKDAYS_SHORT[$i]."</li>";
		}

		$html .= "		</ul>
						<!-- end of weekdays mobile res row -->
					
						<!-- days of month row -->
						<ul class='days'>
					";
		// days of previous month
		if ($cnt == 1 && $this->_startDay != 0) {
			for ($i = 0; $i < $this->_startDay; $i++) {
				$html .= "<li class='last-month'></li>";
			}
		}

		// days days of first week of month
		for ($i = $this->_startDay; $i < 7; $i++) {

			// Concat parts of date to string
			$reqDate= $this->_year.'-'.$this->_month.'-'.$cnt;

			// format requested date
			$reqDate = date("d-m-Y", strtotime($reqDate));


			// generate div for today  or other day
			if($this->_year==$this->_todayY && $this->_month == $this->_todayM && $cnt == $this->_todayD) {

				// different style for today day.
				if(!$isAdmin)
				{
					$html .= "<li class='kartka-today'>
								<div class='reservation-date'>$cnt</div>
								<div class='houre_row'>
									<div class='reservation-desc'>
										<div class='reservation-time'>Rezerwacja </div>
										<div class='reservation-title'>telefoniczna</div>
									</div>
								</div>									
							</li>";
				}
				else // generate day reservation for admin
				{
					// style for other days.
					$html .= "<li class='kartka-today' ><div class='reservation-date $adminClass' data-date='$reqDate'>$cnt</div>";

					// fill up day by reservation row
					$html .= $this->getHoures($i,$this->_year,$this->_month,$cnt,$reservations);

					$html .= "</li>";
				}

			}
			else
			{
				// style for other days.
				$html .= "<li class='kartka-otherday'><div class='reservation-date $adminClass' data-date='$reqDate'>$cnt</div>";

				// fill up day by reservation row
				$html .= $this->getHoures($i,$this->_year,$this->_month,$cnt,$reservations);

				$html .= "</li>";
			}

			$cnt++;
		}

		$html .= "</ul>";

		// the rest of days in rest of weeks of month (second,third,fourth and fifth week)
		while ($cnt <= $this->_days) {




			$html .= "<ul class='days'>";

			// the rest of days of month
			for ($i = 0; $i <7; $i++) {

				// Concat parts of date to string
				$reqDate= $this->_year.'-'.$this->_month.'-'.$cnt;

				// format requested date
				$reqDate = date("d-m-Y", strtotime($reqDate));

				if($this->_year==$this->_todayY && $this->_month == $this->_todayM && $cnt == $this->_todayD) {

					// different style for today day.
					if(!$isAdmin)
					{
						$html .= "<li class='kartka-today'>
								<div class='reservation-date'>$cnt</div>
								<div class='houre_row'>
									<div class='reservation-desc'>
										<div class='reservation-time'>Rezerwacja </div>
										<div class='reservation-title'>telefoniczna</div>
									</div>
								</div>									
							</li>";
					}
					else // generate day reservation for admin
					{
						// style for other days.
						$html .= "<li class='kartka-today'><div class='reservation-date $adminClass' data-date='$reqDate'>$cnt</div>";

						// fill up day by reservation row
						$html .= $this->getHoures($i,$this->_year,$this->_month,$cnt,$reservations);

						$html .= "</li>";
					}
				}
				else
				{
					// style for other days.
					$html .= "<li class='kartka-otherday'><div class='reservation-date $adminClass' data-date='$reqDate'>$cnt</div>";

					// fill up day by reservation row
					$html .= $this->getHoures($i,$this->_year,$this->_month,$cnt,$reservations);

					$html .= "</li>";
				}

				$cnt++;

				// days of next month
				if ($cnt == $this->_days+1 && $this->_lastDay != 0) {
					for ($j = 0; $j < (7 - $this->_lastDay); $j++) {
						$html .= "<li class='next-month'></li>";
					}
					break;
				}
			}
			$html .= "</ul>";
		}

		$html .= "
				<div class='bottom-tr'>
					<div id='check_reservations'>$checkTitle</div>				
				</div>";

		return $html;

	}

	private function getHoures($id=NULL,$year=NULL,$month=NULL,$cnt=NULL,$reservations=array()) {

		// variable definitions
		$div = "";
		$workday  = "";
		$saturday = "";

		//create object auth
		$auth = new Auth();

		// Concat parts of date to string
		$reqDate= $year.'-'.$month.'-'.$cnt;

		// format requested date
		$reqDate = date("d-m-Y", strtotime($reqDate));


		// Create object current date
		$dDay  = new DateTime();

		// try to create object current date
		try
		{
			$reqDateformated  = new DateTime($reqDate);
		}
		catch (Exception $e)
		{
			die ($e->getMessage());
		}

		// make & format diff between dates
		$dDiff = $reqDateformated->diff($dDay);
		$diffInDays = (int)$dDiff->format("%r%a");

		// Generate div for offdays
		$dayoff = "<div class='houre_row'>
						<div class='reservation-desc finished'>
							<div class='reservation-time'>&nbsp;</div>
							<div class='reservation-title'>nieczynne</div>
						</div>
					</div>";


		// if diff in days is grather than 0 then don't generate reservations
		if ($diffInDays > 0 && !$auth->cookie_login())
		{
			$div ="<div class='houre_row'>
						<div class='reservation-desc finished'>
							<div class='reservation-time'>Rezerwacje </div>
							<div class='reservation-title'>zakończone</div>
						</div>
				 </div>";
		}
		else
		{

			$day = $id;



			//create object functions
			$fk = new Functions();

			//get operating houres from DB
			$houres = $fk->getHoures();

			if (!empty($houres)) {

				$i=0;
				foreach ($houres as $res) {

					$class = "res_avail";
					$class_desc = "";
					$title = "Zarezerwuj";
					$admin_class = "";
					$admin_tooltip = "";
					$resID = 0;

					$divId = $res['id'].$cnt.$month.$year;

					if($reservations){
						if(array_search($divId, array_column($reservations, 'date_id'))) {
							$class = "";
							$class_desc = "finished";
							if($auth->cookie_login()){
								$title = $reservations[$divId]['make'];
								$resID = $reservations[$divId]['reservation_id'];
								$admin_tooltip = "data-toggle='tooltip' title='".$reservations[$divId]['service']."'";
							}
							else
							{
								$title = "Niedostępne";
							}

						}
					}



					if($auth->cookie_login()){
						$admin_class = "get_details";

					}

					// generate div for saturday
					if ($i < 3) {

						$saturday .= "<div id='$divId' class='houre_row $class $admin_class' $admin_tooltip data-resid='$resID' data-date='$reqDate' data-year='$year' data-month='$month' data-day='$cnt' data-hid='$res[id]' data-hval='$res[op_houres]'>
									<div class='reservation-desc $class_desc'>
										<div class='reservation-time'><i class='far fa-clock'></i> $res[op_houres]</div>
										<div class='reservation-title'>$title</div>
									</div>
								</div>";
					}

					// generate div for work weekdays
					$workday = $saturday;

					$workday .= "<div id='$divId' class='houre_row $class $admin_class'  $admin_tooltip data-resid='$resID' data-date='$reqDate' data-year='$year' data-month='$month' data-day='$cnt' data-hid='$res[id]' data-hval='$res[op_houres]'>
									<div class='reservation-desc $class_desc'>
										<div class='reservation-time'><i class='far fa-clock'></i> $res[op_houres]</div>
										<div class='reservation-title'>$title</div>
									</div>
								</div>";
					$i++;
				}
			}

			if ($day<5) {
				$div .= $workday;
			}
			elseif ($day==5) {
				$div .= $saturday;
			}
			else {
				$div .= $dayoff;
			}


		}

		return $div;

	}



}