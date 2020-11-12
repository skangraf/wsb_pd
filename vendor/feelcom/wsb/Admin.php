<?php
namespace feelcom\wsb;

// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');

// min requirements
include_once 'minequirements.php';

// including necessary files
include_once 'Functions.php';
include_once 'Auth.php';
include_once 'Kalendarz.php';


use DateTime;
use Exception;

class Admin extends Kalendarz {

	function __construct($month=NULL,$year=NULL) {

		parent::__construct();

	}

	public function getReservations(){
		//default $html brak rezerwacji
		$html = "brak rezerwacji";

		// Create new function object
		$fk = new Functions();

		//get reservstion lists array
		$res = $fk->getReservationsList();

		// check is reservation array is not empty
		if(!empty($res)){

			//create table & table header & open table body
			$html = "
				<table id='resTable' class='table table-striped table-bordered dt-responsive nowrap' style='width:100%'>
					<thead>
						<tr>
							<th>lp.</th>
							<th>data</th>
							<th>godzina</th>
							<th>telefon</th>
							<th>nr rej.</th>
							<th>marka</th>
							<th>model</th>
							<th>usługa</th>
							<th>akcje</th>
						</tr>
					</thead>
					<tbody>
			";
			$i=0;
			//generate table row
			foreach ($res as $row){

				// increase $i for lp. column
				$i++;

				// Concat parts of date to string
				$reqDate= $row['f_year'].'-'.$row['f_month'].'-'.$row['f_day'];

				// format requested date
				$data = date("d-m-Y", strtotime($reqDate));

				$houre = substr($row['houre'],0,5);

				$html .= "
					<tr>
						<td>$i</td>
						<td>$data</td>
						<td>$houre</td>
						<td>".$row['cusPhone']."</td>
						<td>".$row['carRegNo']."</td>
						<td>".$row['make']."</td>
						<td>".$row['model']."</td>
						<td>".$row['service']."</td>
						<td class='td-actions'><i class='fas fa-trash-alt remove_res' data-resid='".$row['reservation_id']."'></i></td>
					</tr>
				";

			}


			// close table body & table
			$html .= "
					</tbody>
				</table>
			";

		}

		return $html;
	}


}