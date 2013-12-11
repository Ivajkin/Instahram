<?php
	//require "JsonDB.class.php";
	//$db = new JsonDB("./data/");
	//$rrr = JsonDB -> selectAll ( "table" );
	//JsonDB -> selectAll ( "table" )
	// $result = $db->select("test","Age",43);
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="js/tinymce/tinymce.min.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
	<script>
			tinymce.init({selector:'textarea'});
			
			$(document).ready(function() {
				function post(pray) {
					draw(pray, 0);
				}
				function draw(pray, amenCount) {
					$('.prays').prepend('<div class="pray"><p>'+pray+'</p>'
										+'<a href="#">Аминь ('+amenCount+')</a></div>');
				}
				
				var prays = /*$ajax('prays.json');*/[
					{text:'<span class="Unicode">Отче нашъ, сущій на небесахъ!<br>да святится имя Твое;<br>да пріидетъ Царствіе Твое;<br>да будетъ воля Твоя и на землѣ, какъ на небѣ;<br>хлѣбъ нашъ насущный дай намъ на сей день;<br>			и прости намъ долги наши, какъ и мы прощаемъ должникамъ нашимъ;<br>и не введи насъ в искушеніе, но избавь насъ от лукаваго</span>', amen: 12},
					{text:'<p><strong>Живый в помощи  Вышняго, в крове Бога Небеснаго водворится.<br>          Речет Господеви:  Заступник мой еси &nbsp;и прибежище мое, Бог  мой, и уповаю на Него.<br>          Яко Той избавит  тя от сети ловчи, и от словесе мятежна,<br>          плещма Своима осенит  тя, и под криле Его надеешися: оружием обыдет тя истина Его.<br>          Не убоишися от  страха нощнаго, от стрелы летящия во дни,<br>          от вещи во тме  переходящия, от сряща, и беса полуденнаго.<br>          Падет от страны  твоея тысяща, и тма одесную тебе, к тебе же не приближится: <br>          обаче очима  твоима смотриши, и воздаяние грешников узриши.<br>          Яко Ты, Господи,  упование мое, Вышняго положил еси прибежище твое.<br>          Не приидет к тебе  зло, и рана не приближится телеси твоему:<br>          яко Ангелом Своим  заповесть о тебе, сохранити тя во всех путех твоих.<br>          На руках возмут  тя, да некогда преткнеши о камень ногу твою:<br>          на аспида и  василиска наступиши, и попереши льва и змия. <br>          Яко на Мя упова,  и избавлю и: <br>          покрыю и, яко  позна имя Мое. Воззовет ко Мне, и услышу его: с ним есмь в скорби, <br>          изму его, и  прославлю его, долготою дней исполню его, <br>          и явлю ему  спасение Мое.</strong></p>', amen: 1},
					{text:'<p><strong>Огради мя,  Господи, силою Честнаго и Животворящаго Твоего креста,<br>          и сохрани мя от всякаго  зла.</strong></p>', amen:5},
					{text:'Круто! Теперь можно ставить свечи онлайн и фотаться со свечками!', amen:0}];
				for(i in prays) draw(prays[i].text, prays[i].amen);
				
				$('.post button').click(function() {
					var pray = tinyMCE.activeEditor.getContent();
					if(pray.length > 3) post(pray);
				});
				
				$('.pray a').click(function() {
					var amen = $(this).text();
					var N = (/[0-9]+/g).exec(amen)[0]; ++N;
					$(this).text('Аминь('+N+')');
				});
			});
	</script>
</head>
<body>

	<h1>Инстахрам</h1>

	<div class="post">
		<textarea></textarea>
		<button>Поставить свечку и помолиться</button>
	</div>
	
	<div class="prays">
	<?php
		$pray = array();
		foreach ($pray as &$value) {
			echo '<div class="pray"><p>'.$value.'</p>'
					.'<a href="#">Аминь ('.rand(1,100).')</a></div>';
		}
	?>
	</div>
	<div class="background"></div>
</body>
</html>