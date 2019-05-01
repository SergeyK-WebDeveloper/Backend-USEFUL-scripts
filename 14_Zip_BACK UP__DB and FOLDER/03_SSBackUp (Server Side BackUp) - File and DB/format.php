<?php
  #######################################################
  # Server Side BackUp © Alessandro Marinuzzi [Alecos]  #
  # Server Side BackUp - Version 1.9 - 01/01/2019 - GPL #
  # Web: https://www.alecos.it - Mail: alecos@alecos.it #
  #######################################################
  @ini_set('default_charset', 'UTF-8');
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
  } else {
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
    <a class="link tooltip" href="index.php"><span class="tip">Go here to perform backups</span>BackUp Section</a> :: <a class="link tooltip" href="test.php"><span class="tip">Go here to perform some tests</span>Test Section</a> :: <a class="link tooltip" href="exclude.php"><span class="tip">Go here to exclude folders</span>Admin Section</a> :: <a class="link tooltip" href="format.php"><span class="tip">Reload this page to see the changes</span>Reload Page</a>
  </div>
  <div class="cleardiv"></div>
  <div class="box1">
    <span class="title">Server Side BackUp - Date Configuration!</span>
  </div>
  <div class="cleardiv"></div>
  <div class="box5">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <select class="datezone" name="datezone">
<?php  $pref_date = array("american", "european");
        if (file_exists("dat/datezone.dat")) {
          $temp_date = file_get_contents("dat/datezone.dat");
        } else {
          $temp_date = "Not Set";
        }
        foreach ($pref_date as $tdate) {
          if ($tdate == $temp_date) {
            echo "        <option value=\"$tdate\" selected>" . ucfirst($tdate) . " Date</option>" . PHP_EOL;
          } else {
            echo "        <option value=\"$tdate\">" . ucfirst($tdate) . " Date</option>" . PHP_EOL;
          }
        } ?>
      </select><br>
      <input class="savedate" type="submit" name="savedate" value="Save Preferences">
    </form>
<?php
    $success_date = FALSE;
    if (!is_dir("dat")) {
      mkdir("dat");
      chmod("dat", 0755);
    }
    if ((isset($_POST['savedate'])) && (isset($_POST['datezone']))) {
      $date_format = 'date-format.php';
      $save_date = 'dat/datezone.dat';
      $datezone = $_POST['datezone'];
      switch ($datezone) {
        case 'american':
          file_put_contents($date_format, '<?php $format = \'[m-d-Y][H-i-s]\'; ?>');
          file_put_contents($save_date, $datezone);
          break;
        case 'european':
          file_put_contents($date_format, '<?php $format = \'[d-m-Y][H-i-s]\'; ?>');
          file_put_contents($save_date, $datezone);
          break;
        default:
      }
      chmod($date_format, 0755);
      chmod($save_date, 0755);
      $success_date = TRUE;
    } elseif (file_exists(basename("date-format.php"))) {
      echo "    <br><span class=\"check_done\">Exists a configuration file saved! You can overwrite it!</span><br><br>" . PHP_EOL;
    } else {
      echo "    <br><span class=\"check_wait\">Nothing selected! New preferences not saved yet!</span><br><br>" . PHP_EOL;
    }
    if ($success_date == TRUE) {
      echo "    <br><span class=\"check_done\">Saved preferences to file! You saved date in " . ucfirst($datezone) . " format!</span><br><br>" . PHP_EOL;
    }
  ?>
  </div>
  <div class="cleardiv"></div>
  <div class="box5">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <select class="timezone" name="timezone">
<?php  if (file_exists("dat/timezone.dat")) {
          $temp_zone = file_get_contents("dat/timezone.dat");
        } else {
          $temp_zone = "Not Set";
        }
        foreach (timezone_identifiers_list() as $tzone) {
          if ($tzone == $temp_zone) {
            echo "        <option value=\"$tzone\" selected>$tzone</option>" . PHP_EOL;
          } else {
            echo "        <option value=\"$tzone\">$tzone</option>" . PHP_EOL;
          }
        } ?>
      </select><br>
      <input class="savezone" type="submit" name="savezone" value="Save Preferences">
    </form>
<?php
    $success_zone = FALSE;
    if (!is_dir("dat")) {
      mkdir("dat");
      chmod("dat", 0755);
    }
    if ((isset($_POST['savezone'])) && (isset($_POST['timezone']))) {
      $zone_format = 'zone-format.php';
      $save_zone = 'dat/timezone.dat';
      $timezone = $_POST['timezone'];
      file_put_contents($zone_format, "<?php date_default_timezone_set('$timezone'); ?>");
      file_put_contents($save_zone, $timezone);
      chmod($zone_format, 0755);
      chmod($save_zone, 0755);
      $success_zone = TRUE;
    } elseif (file_exists(basename("zone-format.php"))) {
      echo "    <br><span class=\"check_done\">Exists a configuration file saved! You can overwrite it!</span><br><br>" . PHP_EOL;
    } else {
      echo "    <br><span class=\"check_wait\">Nothing selected! New preferences not saved yet!</span><br><br>" . PHP_EOL;
    }
    if ($success_zone == TRUE) {
      echo "    <br><span class=\"check_done\">Saved preferences to file! You saved zone as " . $timezone . " country!</span><br><br>" . PHP_EOL;
    }
  }
  ?>
  </div>
</div>

</body>

</html>