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
		0 => [32, 36],
		1 => [31, 48],
		2 => [33, 57],
		3 => [87, 35],
		4 => [36, 86],
		5 => [72, 60],
		6 => [24, 63],
		7 => [59, 95],
		8 => [10, 38],
		9 => [32, 67],
		10 => [68, 22],
		11 => [21, 32],
		12 => [45, 19],
		13 => [35, 74],
		14 => [13, 31],
		15 => [11, 43],
	),
	1 => array(
		0 => [72, 41],
		1 => [15, 38],
		2 => [19, 78],
		3 => [22, 43],
		4 => [18, 13],
		5 => [69, 10],
		6 => [56, 97],
		7 => [14, 26],
		8 => [9, 33],
		9 => [7, 70],
		10 => [30, 5],
		11 => [38, 96],
		12 => [33, 31],
		13 => [62, 59],
		14 => [28, 86],
		15 => [34, 49],
	),
	2 => array(
		0 => [41, 94],
		1 => [13, 12],
		2 => [70, 55],
		3 => [10, 45],
		4 => [10, 21],
		5 => [19, 65],
		6 => [11, 32],
		7 => [24, 22],
		8 => [20, 55],
		9 => [7, 25],
		10 => [6, 31],
		11 => [13, 49],
		12 => [11, 38],
		13 => [33, 79],
		14 => [44, 29],
		15 => [34, 70],
	),
	3 => array(
		0 => [74, 83],
		1 => [43, 54],
		2 => [37, 26],
		3 => [27, 36],
		4 => [57, 42],
		5 => [47, 100],
		6 => [30, 78],
		7 => [44, 62],
		8 => [29, 51],
		9 => [69, 10],
		10 => [48, 83],
		11 => [27, 69],
		12 => [28, 59],
		13 => [27, 73],
		14 => [28, 64],
		15 => [28, 43],
	),
	4 => array(
		0 => [15, 72],
		1 => [21, 56],
		2 => [34, 44],
		3 => [56, 74],
		4 => [81, 51],
		5 => [55, 26],
		6 => [11, 56],
		7 => [45, 90],
		8 => [29, 82],
		9 => [12, 45],
		10 => [25, 22],
		11 => [16, 27],
		12 => [35, 7],
		13 => [37, 56],
		// TODO: picture needs to move left more... and redo all the positioning
		15 => [2, 63],
	),
	5 => array(
		0 => [38, 53],
		1 => [28, 71],
		2 => [43, 96],
		3 => [32, 76],
		4 => [47, 5],
		5 => [39, 28],
		6 => [65, 5], // TODO: not full in picture, nor is horse (4); fix and move everything
		7 => [44, 38],
		8 => [41, 13],
		9 => [35, 20],
		10 => [28, 64],
		11 => [45, 49],
		12 => [54, 88],
		13 => [73, 38],
		14 => [52, 26],
		15 => [52, 73],
	),
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
