<h3><a href="readme.pdf" target="_blank">Sample PDF Here</a></h3>

<?php 

require_once('vendor/autoload.php');

$saw = new Algorithm\SAW;

$saw->addCriteria('benefit', 1.9, 'Penguasaan Aspek teknis');
$saw->addCriteria('benefit', 2.1, 'Pengalaman Kerja');
$saw->addCriteria('benefit', 3, 'Interpersonal Skill');
$saw->addCriteria('cost', 2, 'Usia');
$saw->addCriteria('cost', 2.5, 'Status Perkawinan');


$saw->addAlternative(array('nama' => 'Lina P.'), array(9, 1, 8.5, 38, 8));
$saw->addAlternative(array('nama' => 'A. Alfian'), array(8, 1, 8, 43, 10));
$saw->addAlternative(array('nama' => 'Yuna D.'), array(7.5, 8.5, 7.5, 41, 10));
$saw->addAlternative(array('nama' => 'M. Tantri '), array(6.5, 7, 6.5, 32, 8));
$saw->addAlternative(array('nama' => 'M. Zaki'), array(6, 6, 8.5, 40, 5));
$saw->addAlternative(array('nama' => 'Bella M.'), array(8, 6.5, 8.5, 31, 8));
$saw->addAlternative(array('nama' => 'James'), array(8.5, 4.5, 7.5, 38, 5));
$saw->addAlternative(array('nama' => 'Nina P.'), array(7, 7.5, 7, 35, 5));

$matrix_x = array(
	'assigned' => array(),
	'unassigned' => array()
);

$normalized_r = array(
	'matrix' => array(),
	'preference' => array(),
	'criteria' => array()
);


foreach ($saw->getCriteria()->get() as $criteria_key => $criteria)
{
	$matrix_x['assigned'][$criteria_key] = array();
	$matrix_x['unassigned'] = array();

	$normalized_r['matrix'][$criteria_key] = array();

	foreach ($saw->getAlternative()->get() as $alternative_key => $alternative)
	{
		// unassigned alternative to criteria
		array_push($matrix_x['unassigned'], $alternative['criteria']);

		// assign alternative to criteria
		array_push($matrix_x['assigned'][$criteria_key], $saw->getAlternative()->get($alternative_key)['criteria'][$criteria_key]);
	}

	foreach ($matrix_x['assigned'][$criteria_key] as $row_x)
	{
		// benefit = max size
		if ($criteria['attribute'] == 'benefit')
		{
			array_push($normalized_r['matrix'][$criteria_key], round($row_x/max($matrix_x['assigned'][$criteria_key]), 2));
		}
		// cost = min size
		else
		{
			array_push($normalized_r['matrix'][$criteria_key], round(min($matrix_x['assigned'][$criteria_key])/$row_x, 2));
		}
	}
}

foreach ($saw->getAlternative()->get() as $alternative_key => $alternative)
{
	foreach ($normalized_r['matrix'] as $normalized_key => $normalize)
	{
		array_push($normalized_r['preference'], $normalized_r['matrix'][$normalized_key][$alternative_key]);
	}
}

$normalized_r['preference'] = array_chunk($normalized_r['preference'], count($saw->getCriteria()->get()));


foreach ($saw->getCriteria()->get() as $criteria_key => $criteria)
{
	array_push($normalized_r['criteria'], $criteria['weight']);
}

$sum_prefrence = array();

foreach ($normalized_r['preference'] as $pkey => $preference)
{
	$sum_prefrence[$pkey] = array();
	foreach ($normalized_r['criteria'] as $ckey => $criteria)
	{
		array_push($sum_prefrence[$pkey], $preference[$ckey]*$criteria);
	}
}

for ($pkey = 0; $pkey < count($normalized_r['preference']); $pkey++)
{
	$sum_prefrence[$pkey] = array();

	for ($ckey = 0; $ckey < count($normalized_r['criteria']); $ckey++)
	{
		array_push($sum_prefrence[$pkey], $normalized_r['preference'][$pkey][$ckey]*$normalized_r['criteria'][$ckey]);
	}
}

for ($i = 0; $i < count($sum_prefrence); $i++)
{
	$sum_prefrence[$i] = array_sum($sum_prefrence[$i]);
}

?>

<!-- CREATE VIEW -->

<h3>Kecocokan Alternatif dan Kriteria</h3>
<table border="1">
	<thead>
		<th>Alternatif</th>
		<?php foreach ($saw->getCriteria()->get() as $criteria_key => $criteria) : ?>
		<th>C<?php echo ($criteria_key+1) ?></th>
		<?php endforeach; ?>
	</thead>
	<tbody>
		<?php foreach ($saw->getAlternative()->get() as $alternative) : ?>
		<tr>
			<td><?php echo $alternative['data']['nama'] ?></td>
			<?php foreach ($saw->getCriteria()->get() as $criteria_key => $criteria) : ?>
			<td><?php echo $alternative['criteria'][$criteria_key] ?></td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h3>Bobot Kriteria</h3>
<table border="1">
	<thead>
		<th>Kriteria</th>
		<th>Deskripsi</th>
		<th>Bobot</th>
		<th>Atribut</th>
	</thead>
	<tbody>
		<?php foreach ($saw->getCriteria()->get() as $criteria_key => $criteria) : ?>
		<tr>
			<td>C<?php echo ($criteria_key+1) ?></td>
			<td><?php echo $criteria['name'] ?></td>
			<td><?php echo $criteria['weight'] ?></td>
			<td><?php echo $criteria['attribute'] ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h3>Perhitungan Nilai Preferensi (P)</h3>
<?php
foreach ($sum_prefrence as $key => $value)
{
	echo 'A <small>'.($key+1).'</small> = '.$value.'<br>';
}
// echo "<pre>";
// print_r ($sum_prefrence);
// echo "</pre>";

// echo "<pre>";
// print_r ($saw);
// echo "</pre>";

// echo "<pre>";
// print_r ($matrix_x);
// echo "</pre>";