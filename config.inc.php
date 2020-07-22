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
		'name' => $data[$headers['Interactable Name']], // ?: $data[$headers['Object Name']],
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
		0 => [17, 67],
		1 => [23, 53],
		2 => [39, 42],
		3 => [58, 68],
		4 => [81, 50],
		5 => [62, 29],
		6 => [14, 52],
		7 => [48, 80],
		8 => [30, 74],
		9 => [16, 42],
		10 => [32, 22],
		11 => [22, 25],
		12 => [45, 10],
		13 => [42, 53],
		14 => [59, 97],
		15 => [6, 59],
	),
	5 => array(
		0 => [42, 54],
		1 => [29, 68],
		2 => [44, 90],
		3 => [34, 73],
		4 => [56, 9],
		5 => [45, 32],
		6 => [79, 11],
		7 => [49, 42],
		8 => [47, 16],
		9 => [41, 22],
		10 => [31, 62],
		11 => [50, 52],
		12 => [55, 83.5],
		13 => [78, 48],
		14 => [59, 33],
		15 => [56, 71],
	),
	6 => array(
		0 => [44, 45],
		1 => [49, 94],
		2 => [32, 50],
		3 => [60, 40],
		4 => [34, 38],
		5 => [49, 69],
		6 => [46, 83],
		7 => [43, 52],
		8 => [47, 75.5],
		9 => [62, 9],
		10 => [48, 33],
		11 => [31, 57],
		12 => [52, 19],
		13 => [31, 63],
		14 => [29, 44],
		15 => [48, 62],
	),
	7 => array(
		0 => [65, 6],
		1 => [36, 85],
		2 => [52, 13],
		3 => [42, 22],
		4 => [58, 51],
		5 => [37, 62],
		6 => [28, 25],
		7 => [70, 19],
		8 => [69, 39],
		9 => [37, 68.5],
		10 => [39, 16],
		11 => [40, 79],
		12 => [39, 31],
		13 => [39, 39],
		14 => [28, 56],
		15 => [59, 25],
	),
	8 => array(
		0 => [28, 16],
		1 => [28, 85],
		2 => [64, 90],
		3 => [76, 56],
		4 => [33, 10],
		5 => [9, 67],
		6 => [35, 51],
		7 => [18, 81],
		8 => [64, 67],
		9 => [15, 72.5],
		10 => [5, 59],
		11 => [26, 24],
		12 => [64, 37],
		13 => [16, 43],
		14 => [33, 95],
		15 => [14, 30],
	),
	9 => array(
		0 => [22, 46],
		1 => [29, 63],
		2 => [22, 56],
		3 => [78, 57],
		4 => [40, 51],
		5 => [67, 60],
		6 => [21, 51],
		7 => [30, 39],
		8 => [42, 29],
		9 => [78, 46],
		10 => [52, 93],
		11 => [42, 73],
		12 => [50, 51],
		13 => [31, 45],
		14 => [45, 20],
		15 => [70, 41],
	),
	10 => array(
		0 => [71, 90],
		1 => [29, 52],
		2 => [53, 76],
		3 => [30, 26],
		4 => [27, 59],
		5 => [38, 54],
		6 => [36, 40],
		7 => [55, 60],
		8 => [27, 56],
		9 => [54, 69],
		10 => [58, 14],
		11 => [37, 49],
		12 => [29, 63],
		13 => [38, 57],
		14 => [39, 62],
		15 => [43, 33],
	),
	11 => array(
		0 => [33, 73],
		1 => [35, 81],
		2 => [26, 31],
		3 => [22, 44],
		4 => [55, 47],
		5 => [82, 61],
		6 => [25, 53],
		7 => [22, 25],
		8 => [14, 51],
		9 => [50, 11],
		10 => [36, 32],
		11 => [48, 98],
		12 => [9, 65],
		13 => [34, 60],
		14 => [31, 47],
		15 => [41, 74],
	),
	12 => array(),
	13 => array(),
	14 => array(),
	15 => array(),
);
