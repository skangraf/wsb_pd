<?php
namespace feelcom\wsb;

use PDO;
use PDOException;

// min requirements
include_once 'minequirements.php';

class DB {

	protected $_db;

	protected function __construct($_db=NULL) {

		// check is DB object exist, if not create it.
		if (is_object($_db))
		{
			$this->db = $_db;
		}
		else
		{
			// try to create DB connection if fail return exception message
			try {

				$this->db = new PDO('mysql:host=ADDRESS:PORT;dbname=DBNAME','USERNAME','PASSWORD',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"]);

			} catch (PDOException $e) {
				die ($e->getMessage());
			}

		}

	}
}
