<?php
  #######################################################
  # Server Side BackUp © Alessandro Marinuzzi [Alecos]  #
  # Server Side BackUp - Version 1.9 - 01/01/2019 - GPL #
  # Web: https://www.alecos.it - Mail: alecos@alecos.it #
  #######################################################
  session_start();
  @ini_set('default_charset', 'UTF-8');
  @set_time_limit(0);
  @ini_set('max_execution_time', 0);
  include("access.php");
  if (isset($_SERVER['REMOTE_USER'])) {
    $auth = $_SERVER['REMOTE_USER'];
  } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
    $auth = $_SERVER['PHP_AUTH_USER'];
  } elseif (isset($_SERVER['REDIRECT_REMOTE_USER'])) {
    $auth = $_SERVER['REDIRECT_REMOTE_USER'];
  }
  function check_protocol() {
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
      $isSecure = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == 'on') {
      $isSecure = true;
    }
    return $isSecure;
  }
  if (!isset($auth)) {
    $protocol = check_protocol() ? 'https://' : 'http://';
    $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: $absolute/error.php");
    exit();
  }
  ob_start();
  if (file_exists(basename("config.php"))) {
    include(basename("config.php"));
  }
  $exclude = ob_get_clean();
  if (empty($exclude)) {
    $exclude = '';
  }
  $ini_time = microtime(true);
  setcookie('ini_time', $ini_time);
  $root = realpath($_SERVER['DOCUMENT_ROOT']);
  $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']));
  if (file_exists(basename("zone-format.php"))) {
    include(basename("zone-format.php"));
  }
  if (file_exists(basename("date-format.php"))) {
    include(basename("date-format.php"));
    $name = "BackUp_" . date("$format") . ".tar";
  } else {
    $name = "BackUp_" . date("[m-d-Y][H-i-s]") . ".tar";
  }
  $skip = "BackUp*.tar";
  @exec("tar -cf $sdir/$name $root/* $exclude --exclude='$sdir/$skip' ");
  $protocol = check_protocol() ? 'https://' : 'http://';
  $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  header("Location: $absolute/index.php");
?>