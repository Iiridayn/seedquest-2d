<?php

define('WORLDS', 6);
define('ITEMS', 3);
define('ORDERED', true);

$map = array();
$f = fopen('Saved_data.csv', 'r');
$headers;
while (($data = fgetcsv($f)) !== false) {
	if (!isset($headers)) {
		$headers = array_flip($data);
		continue;
	}

	$scene = $data[$headers['Scene ID']];
	if (!isset($map[$scene])) {
		$map[$scene] = array(
			'name' => $data[$headers['Scene Name']],
			'items' => array(),
		);
	}
	$map[$scene]['items'][$data[$headers['Interactable ID']]] = array(
		'name' => $data[$headers['Interactable Name']] ?: $data[$headers['Object Name']],
		'options' => array(
			$data[$headers['Action One']],
			$data[$headers['Action Two']],
			$data[$headers['Action Three']],
			$data[$headers['Action Four']],
		),
	);
}

$world_thumbs = array(
	['Cabin', -76], ['Cafe'], ['CastleBeach'], ['Desert'],
	['DinoPark', -65], ['Farm', -297], ['GhostHouse'], ['Gym', -115],
	['Apartment'], ['Lab', -218], ['MagicTower', -224], ['PirateShip', -107],
	['Restaurant', -110], ['Saloon'], ['Snowlands', - 203], ['Space', -150],
);

// World -> items array
$positions = array(
	0 => array(
		0 => [32, 31],
		1 => [31, 43],
		2 => [33, 52],
		3 => [87, 30],
		4 => [36, 81],
		5 => [72, 55],
		6 => [24, 58],
		7 => [59, 90],
		8 => [10, 33],
		9 => [32, 62],
		10 => [68, 17],
		11 => [21, 27],
		12 => [45, 14],
		13 => [35, 69],
		14 => [13, 26],
		15 => [11, 38],
	),
	1 => array(
		0 => [72, 36],
		1 => [15, 33],
		2 => [19, 73],
		3 => [22, 38],
		4 => [18, 8],
		5 => [69, 5],
		6 => [56, 92],
		7 => [17, 20],
		8 => [9, 28],
		9 => [7, 65],
		10 => [30, 0],
		11 => [38, 91],
		12 => [33, 26],
		13 => [62, 54],
		14 => [28, 81],
		15 => [34, 44],
	),
	2 => array(),
	3 => array(),
	4 => array(),
	5 => array(),
	6 => array(),
	7 => array(),
	8 => array(),
	9 => array(),
	10 => array(),
	11 => array(),
	12 => array(),
	13 => array(),
	14 => array(),
	15 => array(),
);
