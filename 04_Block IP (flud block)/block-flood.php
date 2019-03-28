<?php
/**
 * @param integer $ipTimeLimit
 * @param integer $maxArray
 * @return boolean
 * @return string
 */
function stopFlood($ipTimeLimit = 3000, $maxArray = 50, $userIP = '')
{
    if (!defined('LIMIT_WRITE_FILE')) { define('LIMIT_WRITE_FILE', 2000); }// limit to only 2000 maximum write table in the file
    if (!defined('PATHFILE')) { define('PATHFILE', __DIR__ . '/'); } // path to directory
    if (!defined('LIMIT_MIN_DOUBLE_CLICK')) { define('LIMIT_MIN_DOUBLE_CLICK', 1 ); } // limit minimum time double click
    if (!defined('LIMIT_MAX_DOUBLE_CLICK')) { define('LIMIT_MAX_DOUBLE_CLICK', 550); } // limit maximum time double click

    if(empty($userIP)) {
        $userIP = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }
    $timeMilli = millisecond(); // time in millisecond

    // $userIP = "2001:DB8:0:10::260"; //TODO:: delete this line in the production

    if (filter_var($userIP, FILTER_VALIDATE_IP) || filter_var($userIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
        && !empty($timeMilli)) {
        $blackList = PATHFILE . 'blackList.json';
        $fileJson = PATHFILE . 'blockFlood.json';
        $arrayJSON = [];
        $arrayJSONBlackList = [];
        $firstFiftyElements = [];
        $arrayTime = [];
        $arrayIp = [];
        $intervalTime = [];
        $i = 0;

        // check in the black list userIP
        if (file_exists($blackList)) {
            $jsonGetDataBlackList = file_get_contents($blackList);
            $arrayJSONBlackList = json_decode($jsonGetDataBlackList, true);
            if (json_last_error() != JSON_ERROR_SYNTAX) { // check if blacklist isn't empty
                // return user if this found in the black list
                foreach ($arrayJSONBlackList as $key => $value) {
                    if (isset($value[$userIP]) == $userIP) {
                        return $userIP;
                    }
                }
            }
        }

        // check if file exist
        if (file_exists($fileJson)) {

            $jsonGetData = file_get_contents($fileJson); // get json file
            $arrayJSON = json_decode($jsonGetData, true); // decode in a array format
            if (json_last_error() == JSON_ERROR_SYNTAX) { // check if blockFlood.json is empty
                $arrayJSON[] = ['ip' => $userIP, 'date' => $timeMilli];
                $json_data = json_encode($arrayJSON, JSON_PRETTY_PRINT);
                $json_data = myxor($json_data);
                file_put_contents($fileJson, $json_data);
                return true;
            } else {

                array_unshift($arrayJSON, array('ip' => $userIP, 'date' => $timeMilli)); // push in the array last element

                // get only value $maxArray elements for treatments
                $getArrayJSON = $arrayJSON;
                $firstFiftyElements = array_slice($getArrayJSON, 0, $maxArray, true);

                array_splice($arrayJSON, LIMIT_WRITE_FILE); // get only value LIMIT_WRITE_FILE elements before save
                $json_data = json_encode($arrayJSON, JSON_PRETTY_PRINT); // encode in the json format
                $json_data = myxor($json_data); // get new data from function myxor()
                file_put_contents($fileJson, $json_data); // save file

            }

        } else { // if file not exist
            $arrayJSON[] = ['ip' => $userIP, 'date' => $timeMilli];
            $json_data = json_encode($arrayJSON, JSON_PRETTY_PRINT);
            $json_data = myxor($json_data);
            file_put_contents($fileJson, $json_data);
            return true;
        }

        // check if it's first time in the first 50 elements
        $checkIp = array_count_values(array_column($firstFiftyElements, 'ip'))[$userIP];
        if ($checkIp == 1) {
            return true;
        }
        foreach ($firstFiftyElements as $key => $value) {
            if ($value['ip'] === $userIP) {
                if (!empty($arrayTime)) {
                    $intervalTime[] = $arrayTime[$i] - $value['date']; // get interval time
                    $i++;
                }
                $arrayTime[] = $value['date']; // get time
            }
        }

        // anonyme function for blacklist
        $black = function ($blackList, $userIP, $timeMilli) {
            if (file_exists($blackList)) {
                $jsonGetDataBlackList = file_get_contents($blackList);
                $arrayJSONBlackList = json_decode($jsonGetDataBlackList, true);
            }
            $arrayJSONBlackList[] = [$userIP => $timeMilli];
            $json_data_blackList = json_encode($arrayJSONBlackList, JSON_PRETTY_PRINT);
            file_put_contents($blackList, $json_data_blackList, true);
        };

        if ($intervalTime[0] >= LIMIT_MIN_DOUBLE_CLICK && $intervalTime[0] <= LIMIT_MAX_DOUBLE_CLICK) {
            if ($checkIp == 2) {
                return 'dc';
            } elseif ($intervalTime[1] >= $ipTimeLimit) {
                return 'dc';
            } else {
                $black($blackList, $userIP, $timeMilli);
                return $userIP;
            }
        } elseif ($intervalTime[0] < LIMIT_MIN_DOUBLE_CLICK) {
            $black($blackList, $userIP, $timeMilli);
            return $userIP;
        } elseif ($intervalTime[0] > LIMIT_MAX_DOUBLE_CLICK && $intervalTime[0] < $ipTimeLimit) {
            $black($blackList, $userIP, $timeMilli);
            return $userIP;
        }
        // get average time
        if (!empty($intervalTime)) {
            $averageTime = array_sum($intervalTime) / count($intervalTime);
        }
        // check limit
        if (!empty($averageTime)) {
            if ($averageTime < $ipTiimeLimit) {
                // add ip in the black list
                $black($blackList, $userIP, $timeMilli);
                return $userIP;
            }
        }
        return true;
    } else {
        $errorsFile = PATHFILE . 'errors.log';
        $errorsLog[] = '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++' . PHP_EOL;
        $errorsLog[] = PHP_EOL;
        $errorTime = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''))->setTimezone(new DateTimeZone("Europe/Kiev"))->format("Y-m-d H:i:s.u");
        $errorsMessage = $errorTime . ' No valid ip address : " ' . $userIP . ' "';
        $errorsLog[] = $errorsMessage;
        $errorsLog[] = PHP_EOL;
        $errorsLog[] = '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++' . PHP_EOL;
        if (file_exists($errorsFile)) {
            $errorsLog[] = file_get_contents($errorsFile);
            file_put_contents($errorsFile, $errorsLog); // write in the file errors.log
        } else {
            file_put_contents($errorsFile, $errorsLog); // create and write in the file errors.log
        }

        return $errorsMessage;
    }
}

/**
 * @param string $json_data
 * @return string
 */
function myxor($json_data)
{
    return $json_data;
}

/**
 *
 * @return integer
 */
function millisecond()
{
    $microtime = microtime();
    $comps = explode(' ', $microtime);

    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}
