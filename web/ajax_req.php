<?php
include_once '../vendor/feelcom/wsb/minequirements.php';
include_once '../vendor/feelcom/wsb/Kalendarz.php';

// including function file
include_once '../vendor/feelcom/wsb/Functions.php';

use feelcom\wsb as wsb;
use feelcom\wsb\Functions;

// display names of months in PL language
setlocale(LC_TIME,'pl_PL.UTF8');

// check is $_POST['action'] exist
if (isset($_POST['action'])){

	// assign $_POST['action'] to variable
	$function = htmlspecialchars($_POST['action']);

	// check is function exist
	if(function_exists( $function)){

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

function getMarkAjax(){

	$fk = new Functions();

	$out = $fk->getMake();

	echo json_encode($out);
}

function getModelAjax(){

	$mark = (int)$_POST['get_model'] ? (int)$_POST['get_model'] : 0;

	$fk = new Functions();

	$out = $fk->getModel($mark);

	echo json_encode($out);
}

function getGenerationAjax(){

	$model = (int)$_POST['get_generation'] ? (int)$_POST['get_generation'] : 0;

	$fk = new Functions();

	$out = $fk->getGeneration($model);

	echo json_encode($out);
}

function getSerieAjax(){

	$generation = (int)$_POST['get_serie'] ? (int)$_POST['get_serie'] : 0;

	$fk = new Functions();

	$out = $fk->getSerie($generation);

	echo json_encode($out);
}

function getModificationAjax(){

	$serie = (int)$_POST['get_modification'] ? (int)$_POST['get_modification'] : 0;

	$fk = new Functions();

	$out = $fk->getModification($serie);

	echo json_encode($out);
}

function getServicesAjax(){

	$fk = new Functions();

	$out = $fk->getServices();

	///var_dump($out);

	echo json_encode($out);
}

function sendReservationFormAjax(){

	foreach ($_POST as $key => $value)
	{
		//remove space bfore and after
		$value = trim($value);
		//remove slashes
		$value = stripslashes($value);
		$value=(filter_var($value, FILTER_SANITIZE_STRING));

		//if values are empty assign 0
		if(empty($value)){
			$value=0;
		}
		//make var form array
		$form[$key]=$value;
	}

	$fk = new Functions();

	$out = $fk->saveReservation($form);

	echo json_encode($out);
}


function getUserSMSCodeAjax(){

    foreach ($_POST as $key => $value)
    {
        //remove space bfore and after
        $value = trim($value);
        //remove slashes
        $value = stripslashes($value);
        $value=(filter_var($value, FILTER_SANITIZE_STRING));

        //if values are empty assign 0
        if(empty($value)){
            $value=0;
        }
        //make var form array
        $form[$key]=$value;
    }

    $fk = new Functions();

    $out = $fk->getSMSCode($form);

    $res['code'] = $out;
    $res['phone'] = $form['custPhone'];

    echo json_encode($res);
}


function checkReservationUserAjax(){

	foreach ($_POST as $key => $value)
	{
		//remove space bfore and after
		$value = trim($value);
		//remove slashes
		$value = stripslashes($value);
		$value=(filter_var($value, FILTER_SANITIZE_STRING));

		//if values are empty assign 0
		if(empty($value)){
			$value=0;
		}
		//make var form array
		$form[$key]=$value;
	}

	$fk = new Functions();

	$out = $fk->checkCode($form);

	echo json_encode($out);
}


