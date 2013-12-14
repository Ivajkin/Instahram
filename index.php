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
				
				$.post("database.php?oratio_offset=0", function(prays) {
					prays = $.parseJSON(prays);
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