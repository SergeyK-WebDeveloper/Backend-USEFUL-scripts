<?php

	function get_statti() {
		$sql = "SELECT * FROM statti";
		$result = mysql_query($sql);
		
		if(!$result) {
			exit(mysql_error());
		}
		
		for($i = 0; $i<mysql_num_rows($result);$i++) {
			$row[] = mysql_fetch_array($result);
		}
		return $row;
	}
	
	function registration($post) {
		
		$login = clean_data($post['reg_login']);
		$password = trim($post['reg_password']);
		$conf_pass= trim($post['reg_password_confirm']);
		$email = clean_data($post['reg_email']);
		$name = clean_data($post['reg_name']);
		
		$msg = '';
		
		if(empty($login)) {
			$msg .= "Введите логин <br />";
		}
		if(empty($password)) {
			$msg .= "Введите пароль <br />";
		}
		if(empty($email)) {
			$msg .= "Введите адресс почтового ящика <br />";
		}
		if(empty($name)) {
			$msg .= "Введите имя <br />";
		}
		
		if($msg) {
			$_SESSION['reg']['login'] = $login;
			$_SESSION['reg']['email'] = $email;
			$_SESSION['reg']['name'] = $name;
			return $msg;
		}
		
		if($conf_pass == $password) {
			$sql = "SELECT user_id
					FROM users
					WHERE login='%s'";
			$sql = sprintf($sql,mysql_real_escape_string($login));
			
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0) {
				$_SESSION['reg']['email'] = $email;
				$_SESSION['reg']['name'] = $name;
				
				return "Пользователь с таким логином уже существует";
			}
					
			$password = md5($password);
			$hash = md5(microtime());
			
			$query = "INSERT INTO users (
						name,
						email,
						password,
						login,
						hash
						) 
					VALUES (
						'%s',
						'%s',
						'%s',
						'%s',
						'$hash'
					)";
			$query = sprintf($query,
								mysql_real_escape_string($name),
								mysql_real_escape_string($email),
								$password,
								mysql_real_escape_string($login)
							);
			$result2 = mysql_query($query);
			
			if(!$result2) {
				$_SESSION['reg']['login'] = $login;
				$_SESSION['reg']['email'] = $email;
				$_SESSION['reg']['name'] = $name;
				return "Ошибка при добавлении пользователя в базу данных".mysql_error();
			}
			else {
				$headers = '';
				$headers .= "From: Admin <admin@mail.ru> \r\n";
				$headers .= "Content-Type: text/plain; charset=utf8";
				
				$tema = "registration";
				
				$mail_body = "Спасибо за регистрацию на сайте. Ваша ссылка для подтверждения  учетной записи: http://localhost/regauth/confirm.php?hash=".$hash;
				
				mail($email,$tema,$mail_body,$headers);
				
				return TRUE;
				
			}								
		}
		else {
			$_SESSION['reg']['login'] = $login;
			$_SESSION['reg']['email'] = $email;
			$_SESSION['reg']['name'] = $name;
			return "Вы не правильно подтвердили пароль";
		}
		
	}
	
	function clean_data($str) {
		return strip_tags(trim($str));
	}

function confirm() {
	
	$new_hash = clean_data($_GET['hash']);
	
	$query = "UPDATE users
				SET confirm='1'
				WHERE hash = '%s'
				";
	$query = sprintf($query,mysql_real_escape_string($new_hash));	
	
	$resutl = mysql_query($query);
	
	if(mysql_affected_rows() == 1) {
		return TRUE;
	}
	else {
		return "Не верный код подтверждения регистрации";
	}
	
			
}







