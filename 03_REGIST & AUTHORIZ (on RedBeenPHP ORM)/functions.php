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

function check_user() {
	
	if(isset($_SESSION['sess'])) {
		$sess = $_SESSION['sess'];
		
		$sql = "SELECT user_id
				FROM users
				WHERE sess='$sess'";
		$result = mysql_query($sql);
		
		if(!$result || mysql_num_rows($result) < 1) {
			return FALSE;
		}
		
		return TRUE;		
	}
	elseif(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
		$login = $_COOKIE['login'];
		$password = $_COOKIE['password'];
		
		$sql = "SELECT user_id
				FROM users
				WHERE login='$login'
				AND password='$password'
				AND confirm = '1'";
		$result2 = mysql_query($sql);
		
		if(!$result || mysql_num_rows($resul) < 1) {
			return FALSE;
		}
		
		$sess = md5(microtime());
		
		$sql_update = "UPDATE users SET sess='$sess' WHERE login='%s'";
		$sql_update = sprintf($sql_update,mysql_real_escape_string($login));
	
		if(!mysql_query($sql_update)) {
			return "Ошибка авторизации пользователя";
		}
		
		$_SESSION['sess'] = $sess;	
		
		return TRUE;	
	}
	else {
		return FALSE;
	}
	
}

function login($post) {
	
	
	if(empty($post['login']) || empty($post['password'])) {
		return "Заполните поля";
	}
	
	$login = clean_data($post['login']);
	$password = md5(trim($post['password']));
	
	$sql = "SELECT user_id,confirm
			FROM users
			WHERE login = '%s'
			AND password = '%s'";
	$sql = sprintf($sql,mysql_real_escape_string($login),$password);
	
	$result = mysql_query($sql);
	
	if(!$result || mysql_num_rows($result) < 1) {
		return "Не правильный логи или пароль";
	}
	if(mysql_result($result,0,'confirm') == 0) {
		return "Пользователь с таким логином еще не продтвержден";
	}		
	
	$sess = md5(microtime());
	
	$sql_update = "UPDATE users SET sess='$sess' WHERE login='%s'";
	$sql_update = sprintf($sql_update,mysql_real_escape_string($login));
	
	if(!mysql_query($sql_update)) {
		return "Ошибка авторизации пользователя";
	}
	
	$_SESSION['sess'] = $sess;
	
	if($post['member'] == 1) {
		$time = time() + 10*24*3600;
		
		setcookie('login',$login,$time);
		setcookie('password',$password,$time);
		
	}
	
	return TRUE;
}
function logout() {
	unset($_SESSION['sess']);
	
	setcookie('login','',time()-3600);
	setcookie('password','',time()-3600);
	
	return TRUE;
}
function get_password($email) {
	$email = clean_data($email);
	
	$sql = "SELECT user_id
			FROM users
			WHERE email = '%s'";
	$sql = sprintf($sql,mysql_real_escape_string($email));	
	
	$result = mysql_query($sql);
	
	if(!$result) {
		return "не возможно сгенерировать новый пароль";
	}
	
	if(mysql_num_rows($result) == 1) {
		$str = "234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		
		$pass = '';
		
		for($i = 0; $i < 6; $i++) {
			$x = mt_rand(0,(strlen($str)-1));
			
			if($i != 0) {
				if($pass[strlen($str)-1] == $str[$x]) {
					$i--;
					continue;
				}
			}
			$pass .= $str[$x];
		}
		
		$md5pass = md5($pass);
		
		$query = "UPDATE users
					SET password='$md5pass'
					WHERE user_id = '".mysql_result($result,0,'user_id')."'";
		$result2 = mysql_query($query);
		
		if(!$result2) {
			return "Не возможно сгенерировать новый пароль";
		}
		
		$headers = '';
		$headers .= "From: Admin <admin@mail.ru> \r\n";
		$headers .= "Content-Type: text/plain; charset=utf8";
		
		$subject = 'new password';
		$mail_body = "Ваш новый пароль: ".$pass;
		
		mail($email,$subject,$mail_body,$headers);
		
		return TRUE;	
	}
	else {
		return "Пользователя с таким потчтовым ящиком нет";
	}	
}





