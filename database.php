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
	
	
	if(isset($_POST['oratio_offset'])) {
		echo "[";
		$oratio_offset = $_POST['oratio_offset'];
		$query = "select * from oratio ORDER BY amen desc limit 50 offset ".($oratio_offset*50);
		$sql = new query($query);
		while($sql->row) {
			$verba = $sql->row['verba'];
			$amen  = $sql->row['amen'];
			
			
			echo json_encode(array('text' => $verba, 'amen' => $amen));
			$sql->next();
			if($sql->row) { echo ","; }
		}
		echo "]";
	} else if(isset($_POST['add_prey'])) {
		$prey = $_POST['add_prey'];
		$query = "insert into oratio values (0, \"".$prey."\")";
		new query($query);
		echo "ok, sql query: ".$query;
	} else if(isset($_POST['to_amen_oratio_verba'])) {
		$oratio_verba = $_POST['to_amen_oratio_verba'];
		//$oratio_verba = preg_replace_callback('/(?<!\\\)".*?(?<!\\\)"/s', function($m) { return str_replace(';', ',', $m[0]); }, $oratio_verba);
		$oratio_verba = addslashes($oratio_verba);
		
		$query = "update oratio set amen = amen+1 where verba=\"".$oratio_verba."\"";
		new query($query);
		echo "ok, sql query: ".$query;
	}
	
	// print('<pre>');
	// print_r($_POST);
	// print('</pre>');
?>