<?php

define('WORLDS', 6);
define('ITEMS', 3);

$map = array();
$f = fopen('Saved_data.csv', 'r');
$headers;
while (($data = fgetcsv($f)) !== false) {
	if (!isset($headers)) {
		$headers = array_flip($data);
		continue;
	}
	if (!isset($map[$data[$headers['Scene ID']]])) {
		$map[$data[$headers['Scene ID']]] = array(
			'name' => $data[$headers['Scene Name']],
			'items' => array(),
		);
	}
	$map[$data[$headers['Scene ID']]]['items'][$data[$headers['Interactable ID']]] = array(
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
