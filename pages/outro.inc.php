<?php

if (empty($_SESSION['payment']))
	redirect('instructions');

function option($value, $label, $field) {
	return '<option value="' . $value . '"' . (
		isset($_POST[$field]) && $_POST[$field] == $value ? ' selected=selected' : ''
	) . '>' . $label . '</option>';
}

function select($name, $label, $options) {
	$select = '<dt><label for="' . $name . '">' . $label . '</label></dt>' ."\n";
	$select .= '<dd><select id="' . $name . '" name="' . $name . '">' . "\n";
	$select .= option('', '', $name) . "\n";
	$select .= option('-', 'Prefer not to say', $name) . "\n";
	foreach ($options as $value => $label)
		$select .= option($value, $label, $name) . "\n";
	$select .= '</select></dd>' . "\n";

	return $select;
}

$system = 'SeedQuest';
$sus = array(
	1 => 'I think that I would like to use this system frequently.',
	'I found the system unnecessarily complex.',
	'I thought the system was easy to use.',
	'I think that I would need the support of a technical person to be able to use this system.',
	'I found the various functions in this system were well integrated.',
	'I thought there was too much inconsistency in this system.',
	'I would imagine that most people would learn to use this system very quickly.',
	'I found the system very cumbersome to use.',
	'I felt very confident using the system.',
	'I needed to learn a lot of things before I could get going with this system.',
);
function radio($name, $value) {
	return '<input type="radio" name="' . $name . '" value="' . $value . '"'
		. (isset($_POST[$name]) && $_POST[$name] == $value ? ' checked=checked' : '')
		. ' />';
}
function sus($num) {
	global $system, $sus;
	$line = '<tr>'. "\n" . '<td>' . preg_replace('/(?:this|the) system/', $system, $sus[$num]) . '</td>' . "\n";
	for ($i = 1; $i <= 5; $i++)
		$line .= '<td>' . radio('sus' . $num, $i) . '</td>' . "\n";
	$line .= '</tr>' . "\n";
	return $line;
}

// TODO: add attention question; sth like "please select all services you have recently used a password on" - seedquest, youtube, facebook, twitter, google, youtwitter
$genders = array(
	'm' => "Male",
	'f' => "Female",
	'o' => "Non-binary",
);
$ages = array(
	'18' => "18 - 24",
	'25' => "25 - 34",
	'35' => "35 - 44",
	'45' => "45 - 54",
	'56' => "55 - 64",
	'65' => "65 or older",
);
$education = array(
	'pre-hs' => "Some High School",
	'hs' => "High School / GED",
	'some-uni' => "Some University",
	'assoc' => "Associates Degree",
	'bs' => "Bachelors Degree",
	'adv' => "Graduate Degree",
	'other' => "Other",
);
// derived from https://www.bls.gov/soc/2018/soc_structure_2018.pdf
$occupation = array(
	'engineer' => "Architect, Engineer, Surveyor",
	'media' => "Art/Design/Entertainer/Journalist/Sports",
	'business' => "Business: Executive, Management, Advertising, Marketing, PR, or HR",
	'clerk' => "Clerk, Teller, Operator, Courier, Secretary, Data Entry, etc",
	'computer' => "Computer/IT professional/engineer",
	'making' => "Construction/Mining/Drilling",
	'education' => "Education: Teacher or Curator/Librarian",
	'outdoors' => "Fishing/Farming/Forestry",
	'food' => "Food preparation and service",
	'health' => "Healthcare assistant, Massage Therapist",
	'homemaker' => "Homemaker",
	'repair' => "Installation/Repair/Maintenance",
	'legal' => "Legal: Lawyer, Judge, etc",
	'maintenance' => "Maintenance/Pest control/Cleaning/Landscaping",
	'medical' => "Medical professional, Dentist",
	'mturk' => "Mechanical Turk Worker",
	'military' => "Military",
	'production' => "Production: Assembly, Baker, Butcher, Machinist, Caster, Printer, Laundry, Tailor, Woodworker, Plant operator",
	'protect' => "Protection: Law enforcement, Firefighters, Security, etc",
	'retired' => "Retired",
	'sales' => "Sales, including Retail",
	'science' => "Scientist or Technician",
	'service' => "Service - Usher, Embalmer, Barber, Tour Guide, Childcare, etc",
	'social' => "Social Worker or Religious Professional",
	'student' => "Student",
	'transportation' => "Transportation: Pilot, Trucker, Driver, Sailor, Traffic engineer, etc",
	'unemployed' => "Unemployed",
	'other' => "Other",
);
?>
<main class="document">
<p>Thank you for your participation in this study.</p>
<form method="post">
	<?= makeCSRF() ?>

	<dl>
		<dt><label for="recovered">Recovered passphrase</label> <span id="required"<?= !empty($_POST) && empty($_POST['recovered']) ? ' style="color: red"' : ''?>>(required)</span></dt>
		<dd><input id="recovered" name="recovered" type="text" value="<?= htmlspecialchars(!empty($_POST['recovered']) ? $_POST['recovered'] : (!empty($_SESSION['words-input']) ? $_SESSION['words-input'] : '')) ?>"></dd>
	</dl>

	<h2>Demographics</h2>
	<dl>
		<?= select('gender', 'Gender', $genders); ?>
		<?= select('age', 'Age', $ages); ?>
		<?= select('education', 'Highest Completed Formal Education', $education); ?>
		<?= select('occupation', 'Current occupation - primary source of income', $occupation); ?>
	</dl>

	<h2>System Usability Scale</h2>
	<table id="sus">
		<thead>
			<tr>
				<th></th>
				<th>Strongly Disagree</th>
				<th></th>
				<th></th>
				<th></th>
				<th>Strongly Agree</th>
			</tr>
		</thead>
		<tbody>
		<?php for ($i = 1; $i <= count($sus); $i++): ?>
			<?= sus($i) ?>
		<?php endfor; ?>
		</tbody>
	</table>

	<input type="submit">
</form>
</main>
