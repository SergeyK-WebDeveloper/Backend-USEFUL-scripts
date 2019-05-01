<?php
  ############################################
  # Created By Alessandro Marinuzzi [Alecos] #
  # apache-ht.php - Version 1.9 - 01/01/2019 #
  # https://www.alecos.it - alecos@alecos.it #
  ############################################
  @ini_set('default_charset', 'UTF-8');
  include("access.php");
  if ((isset($_POST['username']) && (!empty($_POST['username']))) && ((isset($_POST['password'])) && (!empty($_POST['password'])))) {
    $username = htmlspecialchars($_POST['username'], NULL, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], NULL, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Alessandro Marinuzzi [Alecos]">
<meta name="generator" content="Notepad2">
<meta name="pragma" content="no-cache">
<meta name="robots" content="noindex, nofollow">
<title>Apache - Username :: Password Generator</title>
<style>
@import url('https://fonts.googleapis.com/css?family=Oswald');
@import url('https://fonts.googleapis.com/css?family=Roboto+Condensed');
html * {
  max-height: 1000000px;
}
html {
  display: table;
  min-width: 640px;
}
html, body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}
body {
  background-color: lightgray;
  display: table-cell;
  vertical-align: middle;
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
}
.mainbox {
  border-radius: 7px;
  border: 1px solid gray;
  background-color: darkgray;
  width: 420px;
  height: auto;
  margin-top: 50px;
  margin-bottom: 50px;
  vertical-align: middle;
  text-align: center;
  margin: 0 auto;
  padding: 20px;
}
.title {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 26px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
  white-space: nowrap;
}
.here {
  font-family: 'Roboto Condensed', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 17px;
  font-style: normal;
  line-height: 40px;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
}
.save {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 22px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  border-radius: 3px;
  background-color: #006699;
  border: 3px solid #CCCCCC;
  color: #E6E6FA;
  cursor: pointer;
  box-shadow: inset -5px 5px 5px rgba(255, 255, 255, 0.15), inset 5px -5px 5px rgba(0, 0, 0, 0.15);
  vertical-align: middle;
  text-align: center;
  padding: 3px;
}
.save:hover {
  background-color: #006600;
}
.data {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 19px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
}
.doit {
  vertical-align: middle;
  text-align: center;
}
.user {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  background-color: #006699;
  border: #CCCCCC 2px solid;
  vertical-align: middle;
  text-align: center;
  border-radius: 3px;
  color: white;
  width: 80px;
  margin: 5px;
}
.pass {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  background-color: #006699;
  border: #CCCCCC 2px solid;
  vertical-align: middle;
  text-align: center;
  border-radius: 3px;
  color: white;
  width: 80px;
  margin: 5px;
}
.link:link {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #006699;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
.link:visited {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #006699;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
.link:hover {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #003399;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
</style>
</head>
<body>
<?php
    function crypt_apr1_md5($plainpasswd) {
      $tmp = "";
      $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
      $len = strlen($plainpasswd);
      $text = $plainpasswd . '$apr1$' . $salt;
      $bin = pack("H32", md5($plainpasswd . $salt . $plainpasswd));
      for ($i = $len; $i > 0; $i -= 16) {
        $text .= substr($bin, 0, min(16, $i));
      }
      for ($i = $len; $i > 0; $i >>= 1) {
        $text .= ($i & 1) ? chr(0) : $plainpasswd{0};
      }
      $bin = pack("H32", md5($text));
      for ($i = 0; $i < 1000; $i++) {
        $new = ($i & 1) ? $plainpasswd : $bin;
        if ($i % 3) {
          $new .= $salt;
        }
        if ($i % 7) {
          $new .= $plainpasswd;
        }
        $new .= ($i & 1) ? $bin : $plainpasswd;
        $bin = pack("H32", md5($new));
      }
      for ($i = 0; $i < 5; $i++) {
        $k = $i + 6;
        $j = $i + 12;
        if ($j == 16) {
          $j = 5;
        }
        $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
      }
      $tmp = chr(0) . chr(0) . $bin[11] . $tmp;
      $tmp = strtr(strrev(substr(base64_encode($tmp), 2)), "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
      return "$" . "apr1" . "$" . $salt . "$" . $tmp;
    }
    if ((substr($_SERVER['DOCUMENT_ROOT'],-1,1) == "/") && (substr($_SERVER['PHP_SELF'],0,1) == "/")) {
      $path = $_SERVER['DOCUMENT_ROOT'] . substr(dirname($_SERVER['PHP_SELF']),1) . "/.htpasswd";
    } else {
      $path = $_SERVER['DOCUMENT_ROOT'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/.htpasswd";
    }
    $tmp1 = fopen(".htaccess", "w");
    $tmp2 = "AuthType Basic\n";
    $tmp2 .= "AuthName \"Restricted Area\"\n";
    $tmp2 .= "AuthUserFile \"$path\"\n";
    $tmp2 .= "Require valid-user\n";
    fwrite($tmp1, $tmp2);
    fclose($tmp1);
    unset($tmp1);
    unset($tmp2);
    if (strtoupper(substr(PHP_OS,0,3) == 'WIN')) {
      $tmp1 = fopen(".htpasswd", "w");
      $tmp2 = "$username:" . crypt_apr1_md5($password) . "\n";
      fwrite($tmp1, $tmp2);
      fclose($tmp1);
      unset($tmp1);
      unset($tmp2);
    } else {
      $tmp1 = fopen(".htpasswd", "w");
      $salt = substr(str_replace('+','.',base64_encode(md5(mt_rand(), true))),0,16);
      $tmp2 = "$username:" . crypt($password,'$6$rounds=5000$' . $salt . '$') . "\n";
      fwrite($tmp1, $tmp2);
      fclose($tmp1);
      unset($tmp1);
      unset($tmp2);
    }
    exit("<div class=\"mainbox\">\n<span class=\"title\">Apache - Username :: Password Generated!</span><br>\n<span class=\"here\">Click <a class=\"link\" href=\"index.php\">here</a> to continue!</span>\n</div>\n</body>\n</html>");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Alessandro Marinuzzi [Alecos]">
<meta name="generator" content="Notepad2">
<meta name="pragma" content="no-cache">
<meta name="robots" content="noindex, nofollow">
<title>Apache - Username :: Password Generator</title>
<style>
@import url('https://fonts.googleapis.com/css?family=Oswald');
@import url('https://fonts.googleapis.com/css?family=Roboto+Condensed');
html * {
  max-height: 1000000px;
}
html {
  display: table;
  min-width: 640px;
}
html, body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}
body {
  background-color: lightgray;
  display: table-cell;
  vertical-align: middle;
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
}
.mainbox {
  border-radius: 7px;
  border: 1px solid gray;
  background-color: darkgray;
  width: 420px;
  height: auto;
  margin-top: 50px;
  margin-bottom: 50px;
  vertical-align: middle;
  text-align: center;
  margin: 0 auto;
  padding: 20px;
}
.title {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 26px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
  white-space: nowrap;
}
.here {
  font-family: 'Roboto Condensed', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 17px;
  font-style: normal;
  line-height: 40px;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
}
.save {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 22px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  border-radius: 3px;
  background-color: #006699;
  border: 3px solid #CCCCCC;
  color: #E6E6FA;
  cursor: pointer;
  box-shadow: inset -5px 5px 5px rgba(255, 255, 255, 0.15), inset 5px -5px 5px rgba(0, 0, 0, 0.15);
  vertical-align: middle;
  text-align: center;
  padding: 3px;
}
.save:hover {
  background-color: #006600;
}
.data {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 19px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  vertical-align: middle;
  text-align: center;
}
.doit {
  vertical-align: middle;
  text-align: center;
}
.user {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  background-color: #006699;
  border: #CCCCCC 2px solid;
  vertical-align: middle;
  text-align: center;
  border-radius: 3px;
  color: white;
  width: 80px;
  margin: 5px;
}
.pass {
  font-family: Oswald, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-style: normal;
  line-height: normal;
  font-weight: normal;
  font-variant: normal;
  background-color: #006699;
  border: #CCCCCC 2px solid;
  vertical-align: middle;
  text-align: center;
  border-radius: 3px;
  color: white;
  width: 80px;
  margin: 5px;
}
.link:link {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #006699;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
.link:visited {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #006699;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
.link:hover {
  color: #E6E6FA;
  text-decoration: none;
  background-color: #003399;
  border: black 1px solid;
  border-radius: 5px;
  padding-left: 3px;
  padding-right: 3px;
}
</style>
</head>
<body>
<div class="mainbox">
<span class="title">Apache - Username :: Password Generator</span><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<span class="data"><label for="username">Username:</label> <input type="text" class="user" id="username" name="username"></span><br>
<span class="data"><label for="password">Password:</label> <input type="password" class="pass" id="password" name="password"></span><br>
<span class="doit"><input type="submit" class="save" value="Create Username &amp; Password"></span><br>
</form>
</div>
</body>
</html>