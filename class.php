<?php
	define("SERVER_NAME", "localhost");
	define("DB_NAME", "core5429_ihram");
	define("LOGIN", "core5429_ihram");
	define("PASSWORD", "совсем1");
	
	class site_session {
		public $db;
		function __construct() {
			$this->db = mysql_connect(SERVER_NAME, LOGIN, PASSWORD) or die("Не могу создать соединение");
			mysql_query('SET NAMES utf8');
			mysql_select_db(DB_NAME, $this->db) or die(mysql_error());
		}
	}

	class site_query {
		public $sql;
		public $row=null;
		private $res;
		public function run($ses) {
			$this->res = mysql_query($this->sql, $ses) or die(mysql_error());
			$this->row = mysql_fetch_array($res);			
		}
		public function next() {
			if(!$this->row = mysql_fetch_array($this->res)) {
				$this->row=null;
			}
		}
		public function update($ses, $sql) {
			$this->sql=$sql;
			$this->res=mysql_query($sql,$ses) or die(mysql_error());
			$this->row=mysql_fetch_array($this->res);
		}
		function __construct($ses, $sql) {
			$this->sql=$sql;
			$this->res=mysql_query($sql,$ses) or die(mysql_error());
			$this->row=mysql_fetch_array($this->res);
		}	
	}


	abstract class site_module {
		public $sqlstring=null;
		protected $sql;
		protected $ses;
		protected $cur_cat;//Имя текущей категории находится в cur_cat[0], остальное - элементы пути.
		protected $cur_cat_id;
		protected $cur_path;
		
		abstract function output();
		
		function sql_row($name)
		{
			return $this->sql->row[$name];
		}
		
		function get_category_id($name)
		{
			$category=explode('/', $name);
			$cat_sql=new site_query($this->ses->db, 'SELECT * FROM vodoley__menu WHERE link="'.$category[1].'" LIMIT 1');
			$this->cur_cat_id=$cat_sql->row['ID'];
		}
		
		function get_category()
		{
			$this->cur_cat=explode('/', $_GET['path']);
			if($this->cur_cat[0]==null)
			{
				$cat_sql=new site_query($this->ses->db, 'SELECT * FROM vodoley__menu ORDER BY menu_order LIMIT 1');
				$this->cur_cat[0]=$cat_sql->row['link'];
			}
			else
			{
				$this->cur_path=null;
				foreach ($this->cur_cat as $cat)
				{
					$this->cur_path.='/'.$cat;
				}
			}
		}
		
		function update()
		{
			$this->sql = new site_query($this->ses->db, $this->sqlstring);
		}
		
		function __construct()
		{
			$this->ses = new site_session();
			if($this->sqlstring != null) {$this->sql = new site_query($this->ses->db, $this->sqlstring);}
		}
	}


	/*class site_module_output extends site_module//Вывод блоков отдельных публикаций
	{
		function output()
		{
			if($_GET['link']=='index.htm' || $_GET['link']=='index.html' || $_GET['link']=='index' || $_GET['link']=='INDEX.HTM' || $_GET['link']=='INDEX.HTML')
			{
				$_GET['link']='';
			}
			IF($_POST['mode']==null)
			{
			$this->sqlstring ='SELECT * FROM masquerade__page WHERE link="'.$_GET['link'].'"';
			$this->update();
			$row=$this->sql->row;
			switch($row['funct'])
			{
				case 'catalog':
					$this->sqlstring ='SELECT * FROM masquerade__category';
					$this->update();
					echo'
<div class="text">
<H1>Прокат театральных и карнавальных костюмов в Хабаровске</H1>
<UL style="MARGIN-BOTTOM: 15px">
	<LI><P><STRONG><FONT size=2>Maskarade - первый в Хабаровске салон проката карнавальных костюмов и аксессуаров для детей и взрослых. Maskarade - не интернет-магазин, вы всегда можете примерить понравившийся вам костюм у нас в ТРЦ "магазины Радости", 3 этаж, бутик 330.</FONT></STRONG></P></LI>
</UL>
<P><STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; НАШ ГРАФИК РАБОТЫ:</STRONG></P>
<UL style="MARGIN-BOTTOM: 15px">
	<LI><STRONG>ежедневно с 10:00 до 21:00</STRONG></LI>
</UL>

<DIV id=catalog-main>
<DIV class=catalog-inner style="text-align: center;">';
					$i=0;
					while($this->sql->row!=null)
					{
						echo'<a href="'.$this->sql->row['link'].'"><img alt="'.$this->sql->row['name'].'" src="/res/'.$this->sql->row['pic'].'" style="margin-left: 2px; margin-top: 2px;"></a>';
						$i++;
						if($i>=4)
						{
							echo'<br>';
							$i=0;
						}
						$this->sql->next();
					}
echo'</DIV>
</DIV>
</div>';
				break;
				case 'subcatalog':
					$this->sqlstring ='SELECT * FROM masquerade__category WHERE ID="'.$row['param'].'"';
					$this->update();
echo'<h1>'.$this->sql->row['name'].'</h1>';
					$this->sqlstring ='SELECT * FROM masquerade__item WHERE catID="'.$row['param'].'"';
					$this->update();
echo'<div id="catalog" style="min-width: 266px; visibility: visible;">
	<img src="/res/catalog-left.gif" alt="" class="bg-img">
	<div class="catItemRow">';
					while($this->sql->row!=null)
					{
echo'		<span class="catItem" style="width: 110px;">
			<div class="catImage" style="height: 150px;">
				<a href="'.$this->sql->row['link'].'"><img src="/img/small_'.$this->sql->row['photo'].'" alt="'.$this->sql->row['name'].'" height="150" border="0"></a>
			</div>
			<div class="catInfo" style="height: 20px;">
				<a href="?id=607" class="catTitle">'.$this->sql->row['name'].'</a>
			</div>
		</span>';
						$this->sql->next();
					}
echo'	</div>
</div>';
				break;
			}
			if($row==null)
			{
					$this->sqlstring ='SELECT * FROM masquerade__item WHERE link="'.$_GET['link'].'"';
					$this->update();
					$row=$this->sql->row;
echo'	<h1>'.$row['name'].'</h1>
	<div id="catalog-inner">
		<table>
			<tr>
				<th>
					<img src="/img/'.$row['photo'].'" alt="'.$row['name'].'">
				</th>
				<td>
					<p>Размеры: <b>'.$row['size'].'</b></p>
					<p>Стоимость проката в сутки: <b>'.$row['prise'].'</b></p>';
					$rw=explode('
',$row['content']);
					foreach($rw as $rows)
					{
						echo '<p>'.$rows;
					}
echo'				</td>
			</tr>
		</table>
	</div>';
			}
			else
			{
				echo'<div class="text">';
				echo $row['text'];
				echo'</div>';
			}
			}
			ELSE
			{
				require_once('stemmer.php');
				$stemmer = new Lingua_Stem_Ru();
				$words = explode(" ", $_POST['sample']); // разбиваем исходную строку на массив слов
				$sql_text = "SELECT * FROM masquerade__item WHERE "; //Начало запроса
				foreach ($words as $value)
					{
					// для каждого слова получаем его бессуфиксно-безокончательную часть =)
					$svalue = $stemmer->stem_string($value);
					// добавляем в $sql-запрос
					$sql_text.= 'name LIKE \'%'.$svalue.'%\' or content LIKE \'%'.$svalue.'%\' or ';
					}
				// удаляем лишний "or" в конце строки
				$sql_text = ereg_replace(' or $', '', $sql_text);
				$sql_text1 = "SELECT * FROM masquerade__page WHERE "; //Начало запроса
				foreach ($words as $value)
					{
					// для каждого слова получаем его бессуфиксно-безокончательную часть =)
					$svalue = $stemmer->stem_string($value);
					// добавляем в $sql-запрос
					$sql_text1.= 'text LIKE \'%'.$svalue.'%\' or ';
					}
				// удаляем лишний "or" в конце строки
				$sql_text1 = ereg_replace(' or $', '', $sql_text1);
				echo'<h1>Результаты поиска</h1>
				<p><b>КОСТЮМЫ И АКСЕССУАРЫ:</b></p>
				<p><ul>';
				$this->sqlstring = $sql_text;
				$this->update();
				while($this->sql->row!=null)
				{
					echo'<li><a href="/'.$this->sql->row['link'].'">'.$this->sql->row['name'].'</a>';
					$this->sql->next();
				}
				echo'</ul></p>
				<p><b>СТРАНИЦЫ САЙТА:</b></p>
				<p><ul>';
				$this->sqlstring = $sql_text1;
				$this->update();
				while($this->sql->row!=null)
				{
					echo'<li><a href="/'.$this->sql->row['link'].'">'.$_SERVER['HTTP_HOST'].'/'.$this->sql->row['link'].'</a>';
					$this->sql->next();
				}
			}
		}
		
		function menu_out()
		{
			$this->sqlstring ='SELECT * FROM masquerade__category';
			$this->update();
			while($this->sql->row!=null)
			{
				echo'<li><a href="/'.$this->sql->row['link'].'">'.$this->sql->row['name'].'</a></li>';
				$this->sql->next();
			}
		}
	}*/
?>