<?php
require_once 'koneksi.php';
$koneksi = koneksi();
require_once __DIR__ . '/vendor/autoload.php';
// use Phpml\Math\Distance\Minkowski;
use Phpml\Classification\KNearestNeighbors;
$prodi = $_POST['prodi'];
$sql_sampel  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs AND prodi.id_prodi = '$prodi'";
$hasil = mysqli_query($koneksi, $sql_sampel);
$samples = array();
$i = 0;
while ($row = mysqli_fetch_array($hasil)) {
  $samples[$i][0] = $row['IPS1'];
  $samples[$i][1] = $row['IPS2'];
  $samples[$i][2] = $row['IPS3'];
  $samples[$i][3] = $row['IPS4'];
  $samples[$i][4] = $row['IPS5'];
  $samples[$i][5] = $row['IPS6'];
  $samples[$i][6] = $row['IPS7'];
  $samples[$i][7] = $row['IPS8'];
  $samples[$i][8] = $row['IPS9'];
  $samples[$i][9] = $row['IPS10'];
  $samples[$i][10] = $row['sks_lulus'];
  $i++;
}

$sql_label  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs  AND prodi.id_prodi = 1";
$hasil_label = mysqli_query($koneksi, $sql_label);
$labels = array();
$is = 0;
while ($row = mysqli_fetch_array($hasil_label)) {
  if ($row['status_tamat'] == 1) {
    $status = 'Tepat';
  }else{
    $status = 'Gagal';
  }
  $labels[$is] = $status;
  $is++;
}

// print("<pre>".print_r($samples, true)."</pre>");
// print("<pre>".print_r($labels, true)."</pre>");
// $classifier = new KNearestNeighbors();
$classifier = new KNearestNeighbors($k=5);
$classifier->train($samples, $labels);
// print_r($classifier->predict([2.4, 4.4]));
print_r($classifier->predict([3.45, 3.13, 3.50, 3.30, 2.85, 2.75, 3.75, 3.20, 0.00, 0.00, 148]));

?>
