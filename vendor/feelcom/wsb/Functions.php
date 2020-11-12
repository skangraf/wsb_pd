<?php


namespace feelcom\wsb;

//var_dump($_SERVER);
require BASE.'/vendor/autoload.php';
use \Firebase\JWT\JWT;
use \SerwerSMS\SerwerSMS;

use \PDO;
use \PDOException;

// min requirements
include_once 'minequirements.php';
// DB connection
include_once 'DB.php';



class Functions extends DB {

	public function __construct($dbo=NULL) {

		parent::__construct($dbo);

	}

	public function getHoures() {

		$pdo= $this->db;

		$sql = "SELECT * FROM `houres`";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$houres = $query->fetchAll();
			return $houres;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getReservations($month=0,$year=0) {

		$pdo= $this->db;

		$sql = "SELECT * FROM `reservations` WHERE `f_month` = '$month' AND `f_year` = '$year' AND `status`=1";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$reservations = $query->fetchAll();
			return $reservations;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getReservationsAdm($month=0,$year=0) {

		$pdo= $this->db;

		$sql = "SELECT `reservation_id`,`date_id`,`f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,s.`name` as `service`, h.`op_houres` as `houre`, 
       			m.`name` as `make`,t.`name` as `model` FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `services` s ON r.carService = s.id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model 
				WHERE r.f_month = '$month' AND r.f_year='$year' AND r.`status`=1";


		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$reservations = $query->fetchAll();
			return $reservations;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getReservationsList() {

		$pdo= $this->db;

		$year = date('Y');
		$month = date('m');
		$day = date('d');



		$sql = "SELECT `reservation_id`,`date_id`,`f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,s.`name` as `service`, h.`op_houres` as `houre`, 
       			m.`name` as `make`,t.`name` as `model` FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `services` s ON r.carService = s.id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model 
				WHERE r.f_month >= '$month' AND r.f_year >= '$year' AND r.f_day >= '$day' AND r.`status`=1";


		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$reservations = $query->fetchAll();
			return $reservations;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getMake() {
		$pdo= $this->db;

		$out = array();
		$sql = "SELECT * FROM `car_make` WHERE `id_car_type` = 1";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id_car_make'],
					'name' => $row['name'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getModel($id=0) {

		$val = (int)$id;

		$pdo= $this->db;

		$out = array();

		$sql = "SELECT * FROM `car_model` WHERE `id_car_make` = '$val'";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id_car_model'],
					'name' => $row['name'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getGeneration($id=0) {

		$val = (int)$id;

		$pdo= $this->db;

		$out = array();

		$sql = "SELECT * FROM `car_generation` WHERE `id_car_model` = '$val'";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id_car_generation'],
					'name' => $row['name'],
					'year_begin' => $row['year_begin'],
					'year_end' => $row['year_end'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}


	public function getSerie($id=0) {

		$val = (int)$id;

		$pdo= $this->db;

		$out = array();

		$sql = "SELECT * FROM `car_serie` WHERE `id_car_generation` = '$val'";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id_car_serie'],
					'name' => $row['name'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getModification($id=0) {

		$val = (int)$id;

		$pdo= $this->db;

		$out = array();

		$sql = "SELECT * FROM `car_trim` WHERE `id_car_serie` = '$val'";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id_car_trim'],
					'name' => $row['name'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getServices() {

		$pdo= $this->db;

		$out = array();

		$sql = "SELECT * FROM `services`";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$out[] = array(
					'id' => $row['id'],
					'name' => $row['name'],
					'date_create' => $row['date_create'],
					'date_update' => $row['date_update'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function saveReservation($form=array()) {

		//create car details array from form array
		$carDetail = $form;

		// uppercase for car registration No
		$carDetail['carRegNo'] = strtoupper($carDetail['carRegNo']);

		//unset unnecessary array keys
		unset($carDetail['action']);
		unset($carDetail['cusName']);
		unset($carDetail['cusPhone']);
		unset($carDetail['carService']);
		unset($carDetail['f_hid']);
		unset($carDetail['f_year']);
		unset($carDetail['f_month']);
		unset($carDetail['f_day']);


		//create customer details array from form array
		$customerDetail = $form;

		//unset unnecessary array keys
		unset($customerDetail['action']);
		unset($customerDetail['carMark']);
		unset($customerDetail['carModel']);
		unset($customerDetail['carGeneration']);
		unset($customerDetail['carSerie']);
		unset($customerDetail['carModification']);
		unset($customerDetail['carService']);
		unset($customerDetail['carRegNo']);
		unset($customerDetail['f_hid']);
		unset($customerDetail['f_year']);
		unset($customerDetail['f_month']);
		unset($customerDetail['f_day']);


		//create reservation details array from form array
		$reservationDetail = $form;

		//unset unnecessary array keys
		unset($reservationDetail['action']);
		unset($reservationDetail['carMark']);
		unset($reservationDetail['carModel']);
		unset($reservationDetail['carGeneration']);
		unset($reservationDetail['carSerie']);
		unset($reservationDetail['carModification']);
		unset($reservationDetail['cusName']);
		unset($reservationDetail['carRegNo']);
		unset($reservationDetail['cusPhone']);

		//create date_id for unique
		$reservationDetail['date_id'] = $reservationDetail['f_hid'].$reservationDetail['f_day'].$reservationDetail['f_month'].$reservationDetail['f_year'];


		$pdo= $this->db;
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		try
		{
			//begin SQL transaction
			$pdo->beginTransaction();

			//insert customer details array to DB - update on duplicate phone
			$sql = "INSERT INTO `customers` (cusName, cusPhone) 
					VALUES (:cusName, :cusPhone) 
					ON DUPLICATE KEY UPDATE cusPhone= :cusPhone,customer_id = LAST_INSERT_ID(customer_id)";
			$query = $pdo->prepare($sql);
			$query->execute($customerDetail);
			$reservationDetail['cusId'] = $pdo->lastInsertId();

			//insert cars details array to DB - update on duplicate carRegNo
			$sql = "INSERT INTO `cars` (`carMark`,`carModel`,`carGeneration`,`carSerie`,`carModification`,`carRegNo`) 
					VALUES (:carMark,:carModel,:carGeneration,:carSerie,:carModification,:carRegNo)
					ON DUPLICATE KEY UPDATE carRegNo= :carRegNo, cars_id = LAST_INSERT_ID(cars_id)";
			$query = $pdo->prepare($sql);
			$query->execute($carDetail);
			$reservationDetail['carId'] = $pdo->lastInsertId();

			//insert reservations details array to DB - on duplicate date_id return error
			$sql = "INSERT INTO `reservations` (`cusId`,`carId`,`carService`,`f_hid`,`f_year`,`f_month`,`f_day`,`date_id`) 
					VALUES (:cusId,:carId,:carService,:f_hid,:f_year,:f_month,:f_day,:date_id)";
			$query = $pdo->prepare($sql);
			$query->execute($reservationDetail);

			//commit SQL transaction
			$pdo->commit();

			//return info
			$res['code'] = 0;
			$res['date_id'] = $reservationDetail['date_id'];
		}
		catch (PDOException $e)
		{
			//rollBack SQL statments if transaction fail
			$pdo->rollBack();

			//return info
			$res['code'] = 1;
			$res['error'] = $e->getMessage();
		}

		return $res;

	}


    public function getSMSCode($form=array()) {

        $phone = $form['custPhone'];
        $res=0;


        $pdo= $this->db;

        $sql = "SELECT * FROM `customers` WHERE cusPhone='".$phone."'";

        try
        {
            $query = $pdo->prepare($sql);
            $query->execute();
            $res = $query->fetchAll();

        }
        catch (PDOException $e)
        {
            die ($e->getMessage());
        }



        if (!empty($res)){

            $customerID =$res[0]['customer_id'];
            $res = $this->sendSMSCode($phone,$customerID);

        }
        else{
            $res = 0;
        }

        return $res;

    }

    public function sendSMSCode($phone='',$customerID=0){

	    $res = 0;

	    $phone = (filter_var($phone, FILTER_SANITIZE_STRING));
	    $phone = '+48'.str_replace("-","",$phone);
        $code = mt_rand(100000, 999999);

        $smsCode = $this->sendSMSNotification($code,$phone);


        if($smsCode=='success'){

            $data = [
                'cusID' => intval($customerID),
                'status' => 0,

            ];

            $data1 = [
                'cusID' => intval($customerID),
                'code' => $code,
                'status' => 1,

            ];

            $pdo= $this->db;
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            try
            {
                //begin SQL transaction
                $pdo->beginTransaction();

                $sql = "UPDATE customers_code SET status=:status WHERE customer_id=:cusID";
                $query = $pdo->prepare($sql);
                $query->execute($data);

                //insert customer details array to DB - update on duplicate phone
                $sql = "INSERT INTO `customers_code` (customer_id, sms_code,status) 
					VALUES (:cusID, :code,:status) 
                    ";
                $query = $pdo->prepare($sql);
                $query->execute($data1);


                //commit SQL transaction
                $pdo->commit();
                $res =1;

            }
            catch (PDOException $e)
            {
                //rollBack SQL statments if transaction fail
                $pdo->rollBack();

                //return info
                $res = $e->getMessage();
            }

        }

        return $res;


    }


    public function sendSMSNotification($data=array(),$sPhone=0){

        $res = false;

        if(!empty($data) && $sPhone>0)
        {

            $sMesage ="carobd.pl kod potwierdzający: ".$data;



            try{
                $serwersms = new SerwerSMS('USERNAME','PASSWORD');

                // SMS FULL
                $res = $serwersms->messages->sendSms(
                    $sPhone,
                    $sMesage,
                    'FEELCOM',
                    array(
                        'test' => false,
                        'details' => true
                    )
                );

                // SMS ECO
                /*   $res  = $serwersms->messages->sendSms(
                       $sPhone,
                       $sMesage,
                       null,
                       array(
                           'test' => true,
                           'details' => true
                       )
                   );*/


                if ($res->success){
                    $res='success';
                }
                else{
                    $res='Błąd wysyłki SMS';
                }

            } catch(Exception $e){
                $res = $e->getMessage();
            }
        }

        return $res;

    }

    public function checkCode($form=array()){

       // var_dump($form);

        $out ='';

        $phone = $form['phoneToCheck'];
        $code = $form['custPhoneCode'];

        if ($phone!='' && $code!=''){

            $pdo= $this->db;

            $sql = "SELECT * FROM `customers_code` WHERE sms_code ='".$code."' AND status ='1' AND  customer_id =(SELECT customer_id FROM customers WHERE cusPhone = '".$phone."')";

            try
            {
                $query = $pdo->prepare($sql);
                $query->execute();
                $res = $query->fetchAll();

            }
            catch (PDOException $e)
            {
                die ($e->getMessage());
            }



            if (!empty($res)){

                $out = $this->checkReservation($phone);

            }

        }

        return $out;

    }

	public function checkReservation($phone='') {


		$pdo= $this->db;

		$out = array();

		$sql = "SELECT `f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,s.`name` as `service`, h.`op_houres` as `houre`, m.`name` as `make`,t.`name` as `model` FROM `reservations` r
				JOIN `customers` c ON r.cusId = c.customer_id
				JOIN `cars` a ON r.carId = a.cars_id
				JOIN `services` s ON r.carService = s.id
				JOIN `houres` h ON r.f_hid = h.id
				JOIN `car_make` m ON a.carMark = m.id_car_make
				JOIN `car_model` t ON a.carModel = t.id_car_model
				WHERE c.cusPhone = '$phone' AND r.`status`=1";

		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$res = $query->fetchAll();

			foreach ($res as $row){

				$reqDate= $row['f_year'].'-'.$row['f_month'].'-'.$row['f_day'];
				// format requested date
				$reqDate = date("d-m-Y", strtotime($reqDate));

				$houre = substr($row['houre'],0,5);
				$out[] = array(
					'date' => $reqDate,
					'houre' => $houre,
					'carRegNo' => $row['carRegNo'],
					'service' => $row['service'],
					'make' => $row['make'],
					'model' => $row['model'],
				);
			}

			return $out;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

	}

	public function getDayReservations($day){

		$dt = strtotime($day);
		$month = (int)date('m',$dt);
		$year = (int)date('Y',$dt);
		$day = (int)date('d',$dt);

		$pdo= $this->db;

		$sql = "SELECT `reservation_id`,`date_id`,`f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,s.`name` as `service`, h.`op_houres` as `houre`, 
       			m.`name` as `make`,t.`name` as `model` FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `services` s ON r.carService = s.id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model 
				WHERE r.f_month = '$month' AND r.f_year='$year' AND r.`f_day`='$day' AND r.`status`=1";


		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$reservations = $query->fetchAll();
			return $reservations;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}
	}


	public function getReservationDetails($id){

		$id = (int)$id;

		$pdo= $this->db;

		$sql = "SELECT `reservation_id`,`date_id`,`f_year`,`f_month`,`f_day`,`cusPhone`,`carRegNo`,s.`name` as `service`, h.`op_houres` as `houre`, 
       			m.`name` as `make`,t.`name` as `model` FROM `reservations` r 
                JOIN `customers` c ON r.cusId = c.customer_id 
                JOIN `cars` a ON r.carId = a.cars_id 
                JOIN `services` s ON r.carService = s.id 
                JOIN `houres` h ON r.f_hid = h.id 
                JOIN `car_make` m ON a.carMark = m.id_car_make 
                JOIN `car_model` t ON a.carModel = t.id_car_model 
				WHERE r.reservation_id = '$id' AND r.`status`=1";


		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$reservations = $query->fetchAll();
			return $reservations;
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}
	}

}