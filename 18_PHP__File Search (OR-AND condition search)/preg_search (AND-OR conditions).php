<?php
/**
* @author Dmitriy Mikhaylik <sblazze@gmail.com>
*/

$file = '';     // if empty else use cur folder and all tree folders
$words = ["file_put_contents", "functions.php"];
$action = "AND";    // AND or OR
$hard = false;

$search_result = [];
$re = '';

function allCombination($array, $new_arr = [], $l = 0, $r = 0) {

    $tmp_arr = $array;
    $tmp_arr[$l] = $array[$r];
    $tmp_arr[$r] = $array[$l];
    $new_arr[] = $tmp_arr;

    var_dump($new_arr);

    $n = count($array) - 1;
    if($r >= $n){
        $l++;
        if($l >= $n)
            return $new_arr;
    }
    else{
        $r++;
        return allCombination($array, $new_arr, $l, $r);
    }
}


function getData($dir)
{
    global $search_result;
    echo"cur folder: $dir \n";

    $list = scandir($dir);

var_dump($list);

    foreach ($list as $one)
    {
        if(in_array($one, ['.', '..', basename(__FILE__)]))
            continue;

        if(is_dir($one)){
            $path = $dir."\\".$one;
            echo "dir: $path \n";
            getData($path);
        }
        elseif(is_file($dir."\\".$one)){
            echo "get content: $dir\\$one \n";
            $text = file_get_contents($dir."\\".$one);
            if(!empty($text)){
                // var_dump(strlen($text));
                $result = testReg($text);
                if(!empty($result)){
                    $search_result[] = $dir."\\".$one;
                }
            }
        }
    }
}

function testReg($text)
{
    global $re;
    $result = preg_match_all($re, $text, $matches);

    var_dump($re);

    return $result;
}


function formatRe($words, $action)
{
    switch($action)
    {
        case 'AND':
            $re = "/^";
            for ($i = 0; $i < count($words); $i++) {
                //$words[$i] = str_replace('/', '\/', $words[$i]);
                $words[$i] = preg_quote($words[$i]);
                $re .= ".*".$words[$i];
            }
            $re .= ".*$/m";
            break;

        case 'OR':
            $re = "/^.*(";
            for ($i = 0; $i < count($words); $i++) {
                //$words[$i] = str_replace('/', '\/', $words[$i]);
                $words[$i] = preg_quote($words[$i]);
                $re .= $words[$i]."|";
            }
            $re = substr($re, 0, -1).").*$/m";
            break;
        default:
    }

    return $re;
}



// ################## MAIN ##########################

if($hard){
    $words = allCombination($words);
}

$re = formatRe($words, $action);

if(empty($file)){
    getData(__DIR__);
}
else{
    testReg(__DIR__."\\".$file);
}

echo "\n################## RESULT ##################\n";
if(!empty($search_result)){
    foreach ($search_result as $path) {
        echo "$path \n";
    }
}
else{
    echo "not found... \n";
}