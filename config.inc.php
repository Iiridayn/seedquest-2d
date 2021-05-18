<?php

if (file_exists('testing'))
	define('TESTING', true);

define('WORLDS', 2);
define('ITEMS', 4);
define('WORDS', 5);
define('BITS', 55);

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
			'label' => $data[$headers['Scene Label']],
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
$positions = array( // states, details - which matches default state if 4
	0 => array( // low res/poly; ?
		0 => [32, 36], // 4, model - 0
		1 => [31, 48], // 4, model - 3
		2 => [33, 57], // 4, model - 0
		3 => [87, 35], // 4, model - 3
		4 => [36, 86], // 4, model, 1 animated (fire), really only 3 atm - 0
		5 => [72, 60], // 4, model - 2
		6 => [24, 63], // 5, picture swap
		7 => [59, 95], // 5, model
		8 => [10, 38], // 1, audio only
		9 => [32, 67], // 4, model - 0
		10 => [68, 22], // 4, model - 2
		11 => [21, 32], // 4, model - 3
		12 => [45, 19], // 4, model - 0
		13 => [35, 74], // 4, minor model on 2, color swap 2 - 0
		14 => [13, 31], // 5, picture swap
		15 => [11, 43], // 4, model, 1 animated (fire) - 0
	),
	1 => array( // low res/poly; ?
		0 => [72, 41], // 4, model - 2
		1 => [15, 38], // 5, model, minor animation
		2 => [19, 78], // 5, model
		3 => [22, 43], // 4, model - 3
		4 => [18, 13], // 4, model - 1
		5 => [69, 10], // 4, model - 1
		6 => [56, 97], // 4, model - 2
		7 => [14, 26], // 5, model, animations
		8 => [9, 33], // 1, audio only
		9 => [7, 70], // 4, model - 1
		10 => [30, 5], // 5, model
		11 => [38, 96], // 4, model - 1
		12 => [33, 31], // 4, model - 3
		13 => [62, 59], // 5, model
		14 => [28, 86], // 4, color swap, not changing animation - 0
		15 => [34, 49], // 5, picture swap
	),
	2 => array( // low res/poly; ?
		0 => [41, 94], // 5, 1 model swap (from default), 4 palate swaps
		1 => [13, 12], // 5, 1 model swap (from default), 4 palate swaps, minor static animation
		2 => [70, 55], // 4, model - 1
		3 => [10, 45], // 4, picture swap - 0
		4 => [10, 21], // 4, model - 0
		5 => [19, 65], // 4, model, 1 animated (fire), really only 3 atm - 0
		6 => [11, 32], // 5, model, minor/subtractive
		7 => [24, 22], // 4, minor model on 2, color swap 2 - 0
		8 => [20, 55], // 4, model, but two are palate swaps of each other - 1
		9 => [7, 25], // 4, model - 0
		10 => [6, 31], // 5, picture swap
		11 => [13, 49], // 4, model - 0
		12 => [11, 38], // 5, 2 models - default and active; active just palate swap, _barely_ visible
		13 => [33, 79], // 5, palate swap
		14 => [44, 29], // 4, model, though palate swap between default and one case; thus possibly 5, minor constant animation (fire, smoke)
		15 => [34, 70], // 4, model, though palate swap between default and one case; thus possibly 5, minor constant animation (fire)
	),
	3 => array( // low res/poly; ?
		0 => [74, 83], // 4, 2 models, 4 total, 2 palate swaps. - 0
		1 => [43, 54], // 4, model - 0
		2 => [28, 64], // 5, model, though one is _just_ an animation
		3 => [27, 36], // 4, model - 2
		4 => [57, 42], // 4, model - 1
		5 => [47, 100], // 4, palate, animation speed/rotation direction changes - 0
		6 => [30, 78], // 5, minor model - additive
		7 => [44, 62], // 5, model - though one vs default is subtle
		8 => [29, 51], // 5, model
		9 => [69, 10], // 4, model - 3
		10 => [48, 83], // 5, model
		11 => [27, 69], // 4, model; one subtractive, one animates only (no model change), one additive, one no change - 3
		12 => [28, 59], // 4, palate swap - 1
		13 => [27, 73], // 5, model
		14 => [37, 26], // 5, palate, minor rotation from default
		15 => [28, 43], // 5, model - 3 models (2 of the states), the other two are animations
	),
	4 => array( // low res/poly; ?
		0 => [17, 67], // 4, 1 animation only, one subtractive, one additive
		1 => [23, 53], // 4, model - 2
		2 => [39, 42], // 4, model - 2
		3 => [58, 68], // 4, model, only default pair is animated - 3
		4 => [81, 50], // 5, model, one just a rotations of default
		5 => [62, 29], // 4, model - 2
		6 => [14, 52], // 4, picture swap - 0
		7 => [48, 80], // 4, model - 2
		8 => [30, 74], // 1, audio only
		9 => [16, 42], // 4, model - 3
		10 => [32, 22], // 5, model
		11 => [22, 25], // 5, model
		12 => [45, 10], // 4, texture swap - 1
		13 => [42, 53], // 5, model
		14 => [59, 97], // 4, palate swap - 3
		15 => [6, 59], // 2, model, otherwise sound only - 0, 1, 2
	),
	5 => array( // low res/poly; broken defaults
		0 => [42, 54], // 5, model, one differs only in animation
		1 => [29, 68], // 1, sound only
		2 => [44, 90], // 4, model, one is animated - 3
		3 => [34, 73], // 5, model, though one is palate only
		4 => [56, 9], // 5, model, one is animated
		5 => [45, 32], // 5, model
		6 => [79, 11], // 4, model - 0
		7 => [49, 42], // 4, picture - 3
		8 => [47, 16], // 5, model, all additive
		9 => [41, 22], // 4, palate - 3
		10 => [31, 62], // 5, model, one animated
		11 => [50, 52], // 5, model
		12 => [55, 83.5], // 4, minor model on 2, color swap 2 - 0
		13 => [78, 48], // 4, model, but the model jumps sideways in the game from default - 3
		14 => [59, 33], // 5, model, additive
		15 => [56, 71], // 5, model
	),
	6 => array( // mix of high/low res/poly; some broken defaults
		0 => [44, 45], // 5, textures
		1 => [49, 94], // 5, model
		2 => [32, 50], // 5, model - broken default
		3 => [60, 40], // 5, model, though really 2 models, color and effects changes
		4 => [34, 38], // 5, color and effects, minor model changes - broken default
		5 => [49, 69], // 5, effects
		6 => [46, 83], // 5, model
		7 => [43, 52], // 5, color mostly, though default has no flame animation
		8 => [47, 75.5], // 5, model, high poly/res
		9 => [62, 9], // 5, model - broken default
		10 => [48, 33], // 5, model
		11 => [31, 57], // 5, model, animations
		12 => [52, 19], // 5, model, animated transitions
		13 => [31, 63], // 5, model; broken default (disappears, as knight)
		14 => [29, 44], // 5, model, one adds animation of fire, add/sub/same otherwise - same has slight color change
		15 => [48, 62], // 5, 2 models though, color changes (some luminosity for the gold though)
	),
	7 => array( // low res/poly; broken defaults
		0 => [65, 6], // 4, model - 1
		1 => [36, 85], // 5, animation
		2 => [52, 13], // 4, model - 0
		3 => [42, 22], // 5, model, though one is small from default
		4 => [58, 51], // 5, model, though one is small from default
		5 => [37, 62], // 4, color - 0
		6 => [28, 25], // 4, picture - 0
		7 => [70, 19], // 4, model - 0
		8 => [69, 39], // 5, model, but _very slight_ luminescence change from default to 1 and no model change
		9 => [37, 68.5], // 5, model, animation
		10 => [39, 16], // 4, model barely, picture at least - 1
		11 => [40, 79], // 5, model
		12 => [39, 31], // 4, model - 3
		13 => [39, 39], // 4, model, animated - 3
		14 => [28, 56], // 4, image - 0
		15 => [59, 25], // 5, model, the one is _almost_ the same as default, but they juke sideways a tiny bit
	),
	// Haven't flagged scene before here
	8 => array( // mostly low res/poly; working defaults
		0 => [28, 16], // 5, model
		1 => [28, 85], // 5, model
		2 => [64, 90], // 5, model
		3 => [76, 56], // 5, model
		4 => [33, 10], // 5, model, 3 are animated, one is an animated transition
		5 => [9, 67], // 5, texture
		6 => [35, 51], // 5, model, scene
		7 => [18, 81], // 5, model, animated
		8 => [64, 67], // 5, model, animated
		9 => [15, 72.5], // 5, model, subtractive all 4 to just 1
		10 => [5, 59], // 5, texture
		11 => [26, 24], // 5, model
		12 => [64, 37], // 5, model, 1 animated transition, 1 animated effects, fairly high res
		13 => [16, 43], // 5, model, 3 are animated, one minor with flames on candles only
		14 => [33, 95], // 5, texture - broken atm
		15 => [14, 30], // 5, texture, scene (somewhat broad at least)
	),
	9 => array( // mostly low res/poly; working defaults
		0 => [22, 46], // 5, texture
		1 => [29, 63], // 5, model/effect/animated transition for 1
		2 => [22, 56], // 5, texture
		3 => [78, 57], // 5, model, animated
		4 => [40, 51], // 5, model, one is animated, one is just a lighting change
		5 => [67, 60], // 5, 3 models, 4 textures for the selected states, animated
		6 => [21, 51], // 5, model, animated
		7 => [30, 39], // 5, model, animated
		8 => [42, 29], // 5, model
		9 => [78, 46], // 5, model, 1 animated
		10 => [52, 93], // 5, color
		11 => [42, 73], // 5, model, high poly/res, animated
		12 => [50, 51], // 5, 3 models, 2 texture only changes, the two model changes are animated
		13 => [31, 45], // 5, model
		14 => [45, 20], // 5, model, animated
		15 => [70, 41], // 5, color, 1/4 light up
	),
	10 => array( // mostly high res/poly; broken defaults
		0 => [71, 90], // 5, model, animated transitions, animated
		1 => [29, 52], // 4, model, low poly/res - 2
		2 => [53, 76], // 5, hard to say - whiteout. Needs to be fixed. Maybe just 2 models and effects
		3 => [30, 26], // 4, model - 0
		4 => [27, 59], // 5, model, animated once selection made
		5 => [38, 54], // 5, model, scene
		6 => [36, 40], // 5, animated primarily, no model changes
		7 => [55, 60], // 5, model, 3/4 are animated
		8 => [27, 56], // 5, model, save one is a heart animation
		9 => [54, 69], // 5, model, selection from 4, animated idle state
		10 => [58, 14], // 4, model, low poly/res - 2
		11 => [37, 49], // 4, model, animated, scene - 3
		12 => [29, 63], // 5, model mostly - one is luminescence, 2 are animated
		13 => [38, 57], // 5, color, constant animation/effects
		14 => [39, 62], // 5, model, though 2 just change animation, 2 are model changes
		15 => [43, 33], // 4, color - 0
	),
	11 => array( // low res/poly; broken defaults
		0 => [33, 73], // 4, model - 3
		1 => [35, 81], // 4, texture - 2
		2 => [26, 31], // 4/5, model - 0 is a tiny rotation
		3 => [22, 44], // 4, model - 3
		4 => [55, 47], // 5, model
		5 => [82, 61], // 4, model - 1
		6 => [25, 53], // 5, model
		7 => [22, 25], // 4, model - 1
		8 => [14, 51], // 4, picture - 1
		9 => [50, 11], // 5, model
		10 => [36, 32], // 5, model
		11 => [48, 98], // 4, model - 2
		12 => [9, 65], // 5, image
		13 => [34, 60], // 5, model, animation
		14 => [31, 47], // 4, model - 1
		15 => [41, 74], // 5, model, 1 animated
	),
	12 => array( // low res/poly; broken defaults
		0 => [80, 69], // 5, model
		1 => [50, 79], // 4, model - 3
		2 => [9, 41], // 4, model - 0
		3 => [8, 63], // 5, model
		4 => [15, 71], // 4, model, 2 animated - 1
		5 => [42, 26], // 4, model - 2
		6 => [70, 44], // 4, model - 2
		7 => [25, 17], // 4, model - 3
		8 => [19, 46], // 4, texture, scene - 0
		9 => [26, 89], // 5, model, working default
		10 => [1, 51], // 4, model - 2
		11 => [39, 47], // 5, model, minor scene
		12 => [48, 56], // 4, color - 3
		13 => [16, 28], // 4, model - 0
		14 => [16, 57], // 5, model, animated, 1 transition animation
		15 => [33, 63], // 4, model - 0
	),
	13 => array( // low res/poly; broken defaults
		0 => [40, 71], // 4, model, color for 2 - 1
		1 => [37, 51], // 5, model
		2 => [38, 42], // 4, model - 1
		3 => [11, 61], // 4, model - 0
		4 => [40, 89], // 4, model, fire animation on one - 0
		5 => [29, 63], // 4, model - 3
		6 => [24, 47], // 4, model - 0
		7 => [28, 41], // 5, model
		8 => [24, 53], // 4, model - 0
		9 => [12, 55], // 4, model - 0
		10 => [30, 55], // 4, model - 0
		11 => [29, 27], // 5, model
		12 => [70, 80], // 4, model, 2
		13 => [22, 61], // 5, model
		14 => [25, 72], // 4/5, model - 2, but card color _does_ change
		15 => [29, 16], // 5, image
	),
	14 => array( // low res/poly; broken defaults
		0 => [32, 63], // 4, model - 2; not broken default
		1 => [13, 52], // 4/5, model - 0, but minor change, so, leave alone
		2 => [13, 45], // 5, animation only
		3 => [39, 43], // 4, model, scene, one (fire, default) animated - 3
		4 => [18, 64], // 4, model - 0
		5 => [31, 77], // 4, minor model on 2, color swap 2 - 0
		6 => [17, 75], // 5, animation only diff from default for one, colors and animation for the rest
		7 => [39, 58], // 4/5, model, scene - 0, minor tweak in part of scene for 0
		8 => [53, 16], // 1, audio only
		9 => [26, 21], // 4, model - 0
		10 => [28, 51], // 4, model - 0
		11 => [25, 34], // 1, audio only
		12 => [18, 69], // 4, model - 0
		13 => [13, 37], // 5, model, additive
		14 => [51, 81], // 5, model though one differs from default only by color
		15 => [76, 38], // 4, model - 0
	),
	15 => array( // low res/poly; broken defaults
		0 => [26, 18], // 5, animation, minor color change and no animation for one from defautl
		1 => [29, 44], // 5, model
		2 => [25, 54], // 4, color - 0
		3 => [43, 6], // 5, model, animations, 2 have intro animations
		4 => [20, 30], // 4, color - 0
		5 => [17, 76], // 4, model - 0
		6 => [38, 98], // 1, no changes in anything, just the choices
		7 => [51, 23], // 4, model - 0
		8 => [13, 65], // 5, model
		9 => [29, 87], // 4, color, animated all same - 1
		10 => [20, 68], // 5, texture
		11 => [75, 9], // 4, model, all animated burning - 2
		12 => [19, 59], // 5, model, animated
		13 => [60, 32], // 5, animated and color on 2 (though one is similar to the default)
		14 => [36, 58], // 5, model
		15 => [37, 69], // 4, model - 0
	),
);
