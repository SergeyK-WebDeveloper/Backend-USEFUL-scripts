<?php

require_once 'config.php';
include_once 'classes.php';
include_once 'functions.php';

$db = new Database($dbase['dbhost'], $dbase['dbuser'], $dbase['dbpass'], $dbase['dbname']);
$db->query('SET NAMES UTF8');

if (!defined('DATE_W3C')) {
	define('DATE_W3C', 'Y-m-d\TH:i:sO');
}

if ($_SERVER['REQUEST_URI'] == '/sitemap.xml') {
	$data = $db->query_once('SELECT added FROM ' . $table['pages'] . ' WHERE display=1 ORDER BY updated DESC LIMIT 1');
	$data2 = $db->query_once('SELECT COUNT(*) FROM ' . $table['pages'] . ' WHERE in_map=1 AND model <> 11 AND display=1');
	$total = ceil($data2[0] / 1000);
	//for ($j = 1; $j <= 3; $j++) {
	for ($j = 1; $j <= 2; $j++) {
		for ($i = 1; $i <= $total; $i++) {
			$modified[$j . '-' . $i] = ($i == $total ? date(DATE_W3C, $data[0]) : null);
		}
	}

	header('Content-Type: application/xml; charset=utf-8');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	foreach ($modified as $key => $val) {
		echo "<sitemap>";
		echo "<loc>http://" . $_SERVER['HTTP_HOST'] . "/sitemap" . $key . ".xml.gz</loc>";
		if ($val) {
			echo "<lastmod>" . $val . "</lastmod>";
		}
		echo "</sitemap>";
	}
	echo "</sitemapindex>";
} else {
	$num = preg_replace('/.+?(\d+)\-?(\d*).+/', '$1-$2', $_SERVER['REQUEST_URI']);
	list($cat, $sub) = explode('-', $num);
	//$lang = $cat == 1 ? 'ru' : ($cat == 2 ? 'ua' : 'en');
	$lang = $cat == 1 ? 'ru' : 'ua';
	if (empty($sub)) {
		$sub = 1;
	}
	$offset = $sub * 1000 - 1000;

	ob_start('ob_gzhandler');
	header('Content-Type: application/xml; charset=utf-8');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	$result = $db->query('SELECT id, path_' . $lang . ', added, model FROM ' . $table['pages'] . ' WHERE (parent_id NOT IN (1,11) OR ISNULL(parent_id)) AND display=1 AND in_map=1 AND model <> 11 ORDER BY updated LIMIT ' . $offset . ', 50000');
	while ($data = $db->fetch_row($result)) {
		echo "<url>";
		echo "<loc>http://" . $_SERVER['HTTP_HOST'] . get_path_by_id($data[0], $lang) . "</loc>";
		echo "<lastmod>" . date(DATE_W3C, $data[2]) . "</lastmod>";
		if (in_array($data[0], array(1))) {
			echo "<changefreq>weekly</changefreq>";
			echo "<priority>1</priority>";
		} elseif (in_array($data[3], array(0))) {
			echo "<changefreq>weekly</changefreq>";
			echo "<priority>0.8</priority>";
		} else {
			echo "<changefreq>weekly</changefreq>";
			echo "<priority>0.5</priority>";
		}
		echo "</url>";
	}
	echo "</urlset>";
}

?>