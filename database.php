<?php
	define("SERVER_NAME", "localhost");
	define("DB_NAME", "core5429_ihram");
	define("LOGIN", "core5429_ihram");
	define("PASSWORD", "совсем1");
	
	/* DB CONNECTION */
	$db = mysql_connect(SERVER_NAME, LOGIN, PASSWORD) or die("Не могу создать соединение");
	mysql_query('SET NAMES utf8');
	mysql_select_db(DB_NAME, $db) or die(mysql_error());

	/* SQL QUIERY */
	class query {
		public $row=null;
		private $res;
		public function next() {
			if(!$this->row = mysql_fetch_array($this->res)) {
				$this->row=null;
			}
		}
		function __construct($sql) {
			$this->res=mysql_query($sql) or die(mysql_error());
			$this->row=mysql_fetch_array($this->res);
		}	
	}
	
	echo "[";
	$oratio_offset = $_GET['oratio_offset'];
	$query = "select * from oratio ORDER BY amen desc limit 5 offset ".($oratio_offset*5);
	$sql = new query($query);
	while($sql->row) {
		$verba = $sql->row['verba'];
		$amen  = $sql->row['amen'];
		
		
		echo json_encode(array('text' => $verba, 'amen' => $amen));
		$sql->next();
		if($sql->row) { echo ","; }
	}
	echo "]";
?>