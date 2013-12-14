<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="js/tinymce/tinymce.min.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
</head>
<body>

	<h1>Инстахрам</h1>

	<div class="post">
		<textarea></textarea>
		<button>Поставить свечку и помолиться</button>
	</div>
	
	<div class="prays">
	</div>
	<div class="background"></div>
	<script>
			
			$(document).ready(function() {
				tinymce.init({selector:'textarea', menubar : false});
			
				function post(pray) {
					$.post("database.php", {'add_prey': encodeURIComponent(pray)});
					draw(pray, 0);
				}
				function draw(pray, amenCount) {
					$('.prays').prepend('<div class="pray"><p><div class="verba">'+pray+'</div></p>'
										+'<a href="javascript:void(0)">Аминь ('+amenCount+')</a></div>');
				}
				
				$.post("database.php", { 'oratio_offset': 0}, function(prays) {
					prays = $.parseJSON(prays);
					for(var i = prays.length-1; i >= 0; --i) draw(prays[i].text, prays[i].amen);
					
					$('.post button').click(function() {
						var pray = tinyMCE.activeEditor.getContent();
						if(pray.length > 3) post(pray);
					});
					
					$('.pray a').click(function() {
						var pray = $(this).parent().find(".verba").html();
						
						
						$.ajax({
							url: 'database.php',
							type: 'POST',
							data: { 'to_amen_oratio_verba': pray },
							dataType: 'html',
							success: function(result) {
								//alert('the request was successfully sent to the server and result: '+ result);
							}
						});
						var amen = $(this).text();						
						var N = (/[0-9]+/g).exec(amen)[0]; ++N;
						$(this).text('Аминь('+N+')');
					});
				});
			});
	</script>
</body>
</html>