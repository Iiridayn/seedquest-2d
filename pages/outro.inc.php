<?php
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
	'assoc' => "Associatates Degree",
	'bs' => "Bachelors Degree",
	'adv' => "Graduate Degree",
	'other' => "Other",
);
// derived from https://www.bls.gov/soc/2018/soc_structure_2018.pdf
$occupation = array(
	'engineer' => "Architect, Engineer, Surveyer",
	'media' => "Art/Design/Entertainer/Journalist/Sports",
	'business' => "Business: Executive, Management, Advertising, Marketing, PR, or HR",
	'clerk' => "Clerk, Teller, Operator, Courier, Secretary, Data Entry, etc",
	'computer' => "Computer/IT professional/engineer",
	'making' => "Construction/Mining/Drilling",
	'education' => "Education: Teacher or Curator/Librarian",
	'outdoors' => "Fishing/Farming/Forestry",
	'food' => "Food preparation and service",
	'health' => "Heathcare assistent, Massage Therapist",
	'homemaker' => "Homemaker",
	'repair' => "Installation/Repair/Maintenance",
	'legal' => "Legal: Lawyer, Judge, etc",
	'maintenance' => "Maintenance/Pest control/Cleaning/Landscaping",
	'medical' => "Medical professional, Dentist",
	'mturk' => "Mechanical Turk Worker",
	'military' => "Military",
	'proudction' => "Production: Assembly, Baker, Butcher, Machinist, Caster, Printer, Laundry, Tailor, Woodworker, Plant operator",
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
<p>Thank you for your participation in this study.</p>
<form method="post">
	<?= makeCSRF() ?>

	<dl>
		<dt><label for="recovered">Recovered passphrase</label> <span id="required"<?= !empty($_POST) && empty($_POST['recovered']) ? ' style="color: red"' : ''?>>(required)</span></dt>
		<dd><input id="recovered" name="recovered" type="text" value="<?= !empty($_POST['recovered']) ? htmlspecialchars($_POST['recovered']) : '' ?>"></dd>
	</dl>

	<h2>Demographics</h2>
	<dl>
		<?= select('gender', 'Gender', $genders); ?>
		<?= select('age', 'Age', $ages); ?>
		<?= select('education', 'Highest Completed Formal Education', $education); ?>
		<?= select('occupation', 'Current occupation - primary source of income', $occupation); ?>
	</dl>

	<input type="submit">
</form>
