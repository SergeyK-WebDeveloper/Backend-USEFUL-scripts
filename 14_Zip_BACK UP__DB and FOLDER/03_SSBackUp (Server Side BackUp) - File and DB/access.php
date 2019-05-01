<?php
  #######################################################
  # Server Side BackUp © Alessandro Marinuzzi [Alecos]  #
  # Server Side BackUp - Version 1.9 - 01/01/2019 - GPL #
  # Web: https://www.alecos.it - Mail: alecos@alecos.it #
  #######################################################
  @ini_set('default_charset', 'UTF-8');
  $accessdb = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF'])) . "/log/access_" . date("Y") . ".sqlite";
  $referer = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'HTTP_REFERER_UNKNOWN';
  $date = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
  $ip = $_SERVER['REMOTE_ADDR'];
  $page = basename($_SERVER['REQUEST_URI']);
  if (!isset($page) || empty($page)) {
    $page = basename($_SERVER['SCRIPT_FILENAME']);
  }
  $agent = isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_NOQUOTES, 'UTF-8') : 'USER_AGENT_UNKNOWN';
  try {
    if (!file_exists($accessdb)) {
      $access_log = new PDO("sqlite:" . $accessdb);
      $access_log->exec('CREATE TABLE access(id INTEGER PRIMARY KEY, date DATETIME, ip TEXT, page TEXT, referer TEXT, agent TEXT)');
      
    } else {
      $access_log = new PDO("sqlite:" . $accessdb);
    }
  }
  catch (PDOException $e) {
    die($e->getMessage());
  }
  $insert_accessdb = $access_log->prepare('INSERT INTO access(date, ip, page, referer, agent) VALUES (:date, :ip, :page, :referer, :agent)');
  $insert_accessdb->execute(['date' => $date, 'ip' => $ip, 'page' => $page, 'referer' => $referer, 'agent' => $agent]);
  $access_log = null;
?>