<?php
setlocale(LC_TIME,'pl_PL.UTF8');

// min requirements
include_once '../../vendor/feelcom/wsb/minequirements.php';

// including files
include_once '../../vendor/feelcom/wsb/Kalendarz.php';
include_once '../../vendor/feelcom/wsb/Functions.php';
include_once '../../vendor/feelcom/wsb/Auth.php';

use feelcom\wsb as wsb;
use feelcom\wsb\Auth;
use feelcom\wsb\Functions;




// check is $_POST['action'] exist
if (isset($_POST['action'])){

	$auth = new Auth();
	$isAdmin = $auth->cookie_login();

	// assign $_POST['action'] to variable
	$function = htmlspecialchars($_POST['action']);

	// check is function exist & user isAdmin
	if(function_exists( $function)&&$isAdmin){

		// call requested function
		call_user_func($function);
	}
	else
	{
		// $aRet['code'] - 1 mean there are some errors
		$aRet['code'] = 1;
		$aRet['html'] = "brak podanej funkcji";

		// return JSON answear.
		echo json_encode($aRet);
	}

}
else
{
	// $aRet['code'] - 1 mean there are some errors
	$aRet['code'] = 1;
	$aRet['html'] = "brak podanej akcji";

	// return JSON answear.
	echo json_encode($aRet);
}

/* function generating reservation calendar for index.php */
function getReservationUserAjax(){

	// check is $_POST['month'] exist if not then get current month
	if (isset($_POST['month'])){
		$month = (int)$_POST['month'];
	}
	else
	{
		$month = date('m');
	}

	// check is $_POST['year'] exist if not then get current year
	if (isset($_POST['year'])){
		$year = (int)$_POST['year'];
	}
	else
	{
		$year = date('Y');
	}

	// create new calendar object
	$cal = new wsb\kalendarz($month,$year);

	// check is object $cal exist
	if (is_object($cal)){

		// $aRet['code'] - 0 mean no error
		$aRet['code'] = 0;
		$aRet['html'] = $cal->userReservation();
	}
	else
	{
		// $aRet['code'] - 1 mean there are some errors
		$aRet['code'] = 1;
		$aRet['html'] = "Błąd generowania kalendarza";
	}

	// return JSON answear.
	echo json_encode($aRet);
}

function checkDayReservationAjax(){

	$day = $_POST['date'];


	$fk = new Functions();

	$out = $fk->getDayReservations($day);

	echo json_encode($out);
}

function getReservationDetailsAjax(){

	$id = (int)$_POST['id'];


	$fk = new Functions();

	$out = $fk->getReservationDetails($id);

	echo json_encode($out);
}

function cancelReservationAjax(){

	$id = (int)$_POST['id'];


	$fk = new Functions();

	$out = $fk->cancelReservation($id);

	echo json_encode($out);
}


