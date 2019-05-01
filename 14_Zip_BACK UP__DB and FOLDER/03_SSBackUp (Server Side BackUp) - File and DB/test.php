<?php
  #######################################################
  # Server Side BackUp © Alessandro Marinuzzi [Alecos]  #
  # Server Side BackUp - Version 1.9 - 01/01/2019 - GPL #
  # Web: https://www.alecos.it - Mail: alecos@alecos.it #
  #######################################################
  @ini_set('default_charset', 'UTF-8');
  include("access.php");
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
</head>

<body>

<div class="mainbox">
  <div class="box1">
    <a class="link tooltip" href="index.php"><span class="tip">Go here to perform backups</span>BackUp Section</a> :: <a class="link tooltip" href="exclude.php"><span class="tip">Go here to exclude folders</span>Admin Section</a> :: <a class="link tooltip" href="format.php"><span class="tip">Go here to set the date format</span>Config Section</a>
  </div>
  <div class="cleardiv"></div>
  <div class="box1">
    <span class="title">Server Side BackUp - Test!</span>
  </div>
  <div class="cleardiv"></div>
  <div class="box5">
    <span class="verify">Exec:</span>
    <?php
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
      if (@exec('echo EXEC') == 'EXEC') {
        echo "<span class=\"passed\">passed!</span><br>" . PHP_EOL;
      } else {
        echo "<span class=\"failed\">failed!</span><br>" . PHP_EOL;
      }
    ?>
    <span class="verify">Tar:</span>
    <?php
      $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']));
      @exec("tar -cvf $sdir/test.tar $sdir/test.php ");
      if (file_exists("$sdir/test.tar")) {
        echo "<span class=\"passed\">passed!</span><br>" . PHP_EOL;
      } else {
        echo "<span class=\"failed\">failed!</span><br>" . PHP_EOL;
      }
      if (file_exists("$sdir/test.tar")) {
        unlink("$sdir/test.tar");
      }
    ?>
    <span class="verify">Stat:</span>
    <?php
      $sdir = realpath($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']));
      $file = "$sdir/test.php";
      if (PHP_OS == 'Darwin') {
        $size = trim(@exec("stat -f %z " . $file));
      } else {
        $size = trim(@exec("stat -c %s " . $file));
      }
      if (is_numeric($size)) {
        echo "<span class=\"passed\">passed!</span><br>" . PHP_EOL;
      } else {
        echo "<span class=\"failed\">failed!</span><br>" . PHP_EOL;
      }
    ?>
  </div>
  <div class="cleardiv"></div>
</div>

</body>

</html>