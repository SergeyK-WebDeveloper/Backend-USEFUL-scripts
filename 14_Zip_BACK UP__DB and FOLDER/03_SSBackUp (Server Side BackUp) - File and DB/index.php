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
    $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF'])) . "/";
    $backups = glob($sdir . "BackUp*.tar");
    foreach ($backups as $backup) {
      $archive = basename($backup);
      if (file_exists($archive)) {
        rename($archive, "." . $archive);
      }
    }
    $protocol = check_protocol() ? 'https://' : 'http://';
    $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: $absolute/error.php");
    exit();
  } else {
    $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF'])) . "/";
    $backups = glob($sdir . ".BackUp*.tar");
    foreach ($backups as $backup) {
      $archive = basename($backup);
      if (file_exists($archive)) {
        rename($archive, substr($archive, 1));
      }
    }
  }
  $ssbk = 1900;
  if (!function_exists('parse_ini_string')) {
    function parse_ini_string($str, $processsections = false) {
      $lines = explode("\n", $str);
      $return = array();
      $insect = false;
      foreach ($lines as $line) {
        $line = trim($line);
        if (!$line || $line[0] == "#" || $line[0] == ";") {
          continue;
        }
        if ($line[0] == "[" && $endidx = strpos($line, "]")) {
          $insect = substr($line, 1, $endidx-1);
          continue;
        }
        if (!strpos($line, '=')) {
          continue;
        }
        $tmp = explode("=", $line, 2);
        if ($processsections && $insect) {
          $return[$insect][trim($tmp[0])] = ltrim($tmp[1]);
        } else {
          $return[trim($tmp[0])] = ltrim($tmp[1]);
        }
      }
      return $return;
    }
  }
  $updates = @parse_ini_string(@file_get_contents("https://www.alecos.it/updates.ini"));
  $ssbv = $updates['ssbv'];
  if ($ssbk < $ssbv) {
    $notify = TRUE;
  } else {
    $notify = FALSE;
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
  <title>SSBackUp &bull; Server Side BackUp</title>
  <link rel="stylesheet" type="text/css" href="css/backup.css">
  <script>
  function SubmitForm() {
    StartProgress();
    var backup = document.getElementById("backup");
    backup.submit();
  }
  function StartProgress() {
    ProgressImage = document.getElementById('progress_image');
    document.getElementById("progress").style.display = "block";
    setTimeout("ProgressImage.src = ProgressImage.src", 100);
    return true;
  }
  </script>
</head>

<body>

<div class="mainbox">
  <div class="box1">
    <a class="link tooltip" href="exclude.php"><span class="tip">Go here to exclude folders</span>Admin Section</a> :: <a class="link tooltip" href="test.php"><span class="tip">Go here to perform some tests</span>Test Section</a> :: <a class="link tooltip" href="format.php"><span class="tip">Go here to set the date format</span>Config Section</a> :: <a class="link tooltip" href="#popup1"><span class="tip">Go here to check for updates</span>Check Updates</a><div id="popup1" class="overlay"><div class="popup"><h2>Check Updates</h2><a class="close" href="#">&times;</a><div class="content"><?php if ($notify == TRUE) { echo "Version $ssbv is found. Click to download: <a class=\"vlink\" href=\"http://www.alecos.it/dat/SSBackUp.zip\">SSBackUp.zip</a>"; } else { echo "Congratulations! Your version is already updated!"; } ?></div></div></div>
  </div>
  <div class="cleardiv"></div>
  <div class="box1">
    <span class="title">Server Side BackUp - BackUps Become Easy</span>
  </div>
  <div class="cleardiv"></div>
  <div class="box2">
    <form id="backup" action="backup.php" method="post">
    <input class="backup" type="submit" name="backup" onclick="SubmitForm()" value="BackUp">
    </form>
  </div>
  <div class="cleardiv"></div>
  <div style="display: none" id="progress"><img id="progress_image" src="css/busy.gif" alt="BackUp in progress..."></div>
  <div class="cleardiv"></div>
  <div class="box3">
<?php
  $url = $_SERVER['QUERY_STRING'];
  $out = array();
  parse_str($url, $out);
  if (isset($out['delete']) || (!empty($out['delete']))) {
    $delete = $out['delete'];
  }
  if (!defined('PHP_EOL')) {
    if (strtoupper(substr(PHP_OS,0,3) == 'WIN')) {
      define('PHP_EOL',"\r\n");
    } elseif (strtoupper(substr(PHP_OS,0,3) == 'MAC')) {
      define('PHP_EOL',"\r");
    } elseif (strtoupper(substr(PHP_OS,0,3) == 'DAR')) {
      define('PHP_EOL',"\n");
    } else {
      define('PHP_EOL',"\n");
    }
  }
  function GetRealSize($file) {
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
      if (class_exists("COM")) {
        $fsobj = new COM('Scripting.FileSystemObject');
        $f = $fsobj->GetFile(realpath($file));
        $size = $f->Size;
      } else {
        $size = trim(@exec("for %F in (\"" . $file . "\") do @echo %~zF"));
      }
    } elseif (PHP_OS == 'Darwin') {
      $size = trim(@exec("stat -f %z " . $file));
    } else {
      $size = trim(@exec("stat -c %s " . $file));
    }
    if ((!is_numeric($size)) || ($size < 0)) {
      $size = filesize($file);
    }
    if ($size < 1024) {
      return $size . ' Byte';
    } elseif ($size < 1048576) {
      return number_format(round($size / 1024, 2), 2) . ' KB';
    } elseif ($size < 1073741824) {
      return number_format(round($size / 1048576, 2), 2) . ' MB';
    } elseif ($size < 1099511627776) {
      return number_format(round($size / 1073741824, 2), 2) . ' GB';
    } elseif ($size < 1125899906842624) {
      return number_format(round($size / 1099511627776, 2), 2) . ' TB';
    } elseif ($size < 1152921504606846976) {
      return number_format(round($size / 1125899906842624, 2), 2) . ' PB';
    } elseif ($size < 1180591620717411303424) {
      return number_format(round($size / 1152921504606846976, 2), 2) . ' EB';
    } elseif ($size < 1208925819614629174706176) {
      return number_format(round($size / 1180591620717411303424, 2), 2) . ' ZB';
    } else {
      return number_format(round($size / 1208925819614629174706176, 2), 2) . ' YB';
    }
  }
  function TakeBackupTime($seconds) {
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    echo "    <span class=\"time\"><span class=\"time-me\">BackUp Performed In: " . sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes) . ':' . sprintf('%02d', $seconds) . "</span></span><br><br>" . PHP_EOL;
  }
  if ((isset($_COOKIE['ini_time'])) && (!empty($_COOKIE['ini_time']))) {
    $ini_time = htmlspecialchars($_COOKIE['ini_time'], ENT_QUOTES, 'UTF-8');
    $end_time = microtime(true);
    $dif_time = $end_time - $ini_time;
  }
  if ((isset($ini_time)) && (!empty($ini_time))) {
    TakeBackupTime($dif_time);
    setcookie('ini_time');
    unset($_COOKIE['ini_time']);
    session_destroy();
  }
  if ((isset($delete)) && (!empty($delete))) {
    $delete = htmlspecialchars($delete, ENT_QUOTES, 'UTF-8');
    $delete = str_replace("\0", "", $delete);
    $delete = basename($delete);
    $cktype = array("tar");
    $ckexts = strtolower(substr(strrchr($delete, "."), 1));
    if ((in_array($ckexts, $cktype)) && (file_exists($delete))) {
      @unlink($delete);
      $protocol = check_protocol() ? 'https://' : 'http://';
      $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      header("Location: $absolute/index.php");
    }
  }
  $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF'])) . "/";
  $backups = glob($sdir . "BackUp*.tar");
  array_multisort(array_map('filemtime', $backups), SORT_NUMERIC, SORT_DESC, $backups);
  $count_backups = 0;
  foreach ($backups as $backup) {
    $archive = basename($backup);
    ++$count_backups;
    echo "    <span class=\"download\"><a href=\"$archive\" class=\"download-me tooltip\" onclick=\"return confirm('Download $archive?');\"><span class=\"tip\">Download $archive</span>$archive</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"delete\"><a class=\"delete-me tooltip\" href=\"index.php?delete=$archive\" onclick=\"return confirm('Delete $archive?');\"><span class=\"tip\">Delete $archive</span>Delete</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"filesize\"><span class=\"filesize-me\">" . GetRealSize($archive) . "</span></span><br>" . PHP_EOL;
  }
  if ($count_backups == 0) {
    echo "    <span class=\"warn\">Please, click on BackUp button to perform a backup!</span><br>" . PHP_EOL;
  }
  ?>
  </div>
  <div class="cleardiv"></div>
</div>

</body>

</html>