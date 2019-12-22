<?php
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Math\Distance\Minkowski;
use Phpml\Classification\KNearestNeighbors;

// $samples = [[7,6,3], [6,6,4], [6,5,1], [1,3,2], [2,4,2], [2,2,3]];
// $labels  = ['bad', 'bad', 'bad', 'good', 'good', 'good'];

$samples = [[8,4], [4,5], [4,6], [7,7], [5,6], [6,5]];
$labels  = ['baik', 'jelek', 'jelek', 'Baik', 'jelek', 'baik'];

// $classifier = new KNearestNeighbors();
$classifier = new KNearestNeighbors($k=15);
// $classifier = new KNearestNeighbors($k=5, new Minkowski($lambda=4));
$classifier->train($samples, $labels);

print("<pre>".print_r($classifier, true)."</pre>");
print_r($classifier->predict([7,4]));

 ?>
