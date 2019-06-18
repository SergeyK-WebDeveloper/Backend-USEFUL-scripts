<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
	<form enctype="multipart/form-data" method="post" id="form">
		<p>Имя</p>
		<input placeholder="В. В. Путин" name="name" type="text" >
		<p>Телефон</p>
		<input placeholder="+7 777 77 77 777" name="number" type="text" >
		<p>Email</p>
		<input placeholder="example@mail.com" name="email" type="text" >
		<p>Прикрепить файлы</p>
		<input type="file" name="userfile[]" multiple id="userfile" class="w100" accept="image/*" >
		<p><input value="Отправить" type="submit"></p>
	</form>

	<script>
		$(function(){
			'use strict';
			$('#form').on('submit', function(e){
				e.preventDefault();
				var fd = new FormData( this );
				$.ajax({
					url: 'sendform.php',
					type: 'POST',
					contentType: false, 
					processData: false, 
					data: fd,
					success: function(msg){
						if(msg == 'ok') {
							$(".button").val("Отправлено"); 
						} else {
							$(".button").val("Ошибка");
							setTimeout(function() {$(".button").val("Отправить");}, 3000);
						}
					}
				})
				  .done(function( e ) {
				    console.log( "success" );
				    console.log( e );
				  })
				  .fail(function(e) {
				    console.log( "error" );
				    console.log( e );
				  })
				  .always(function() {
				    console.log( "complete" );
				  });
			});
		});
	</script>
</body>
</html>