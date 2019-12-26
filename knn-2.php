<?php
require_once 'koneksi.php';
$koneksi = koneksi();
require_once __DIR__ . '/vendor/autoload.php';
// use Phpml\Math\Distance\Minkowski;
use Phpml\Classification\KNearestNeighbors;

$id_mhs = $_POST['id_mhs'];
$nilaik = $_POST['nilaik'];

$sql_sampel  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs";
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

$sql_label  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs";
$hasil_label = mysqli_query($koneksi, $sql_label);
$labels = array();
$is = 0;
while ($row = mysqli_fetch_array($hasil_label)) {
  if ($row['status_tamat'] == 1) {
    $status = 'Tepat Waktu';
  }else{
    $status = 'Terlambat Lulus';
  }
  $labels[$is] = $status;
  $is++;
}

// print("<pre>".print_r($samples, true)."</pre>");
// print("<pre>".print_r($labels, true)."</pre>");
// $classifier = new KNearestNeighbors();
$classifier = new KNearestNeighbors($k = $nilaik);
$classifier->train($samples, $labels);
// print_r($classifier->predict([2.4, 4.4]));

$sql_test  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs AND mhs.id_mhs = '$id_mhs'";
$hasil_test = mysqli_query($koneksi, $sql_test);
$data_test = array();
$j = 0;
while ($row = mysqli_fetch_array($hasil_test)) {
  $data_test[$j][0] = $row['IPS1'];
  $data_test[$j][1] = $row['IPS2'];
  $data_test[$j][2] = $row['IPS3'];
  $data_test[$j][3] = $row['IPS4'];
  $data_test[$j][4] = $row['IPS5'];
  $data_test[$j][5] = $row['IPS6'];
  $data_test[$j][6] = $row['IPS7'];
  $data_test[$j][7] = $row['IPS8'];
  $data_test[$j][8] = $row['IPS9'];
  $data_test[$j][9] = $row['IPS10'];
  $data_test[$j][10] = $row['sks_lulus'];
  $j++;
}

$sql_test_detail  = "SELECT * FROM mhs, prodi, detail_mhs WHERE mhs.prodi_id = prodi.id_prodi AND detail_mhs.id_mhs_detail = mhs.id_mhs AND mhs.id_mhs = '$id_mhs'";
$hasil_test_detail = mysqli_query($koneksi, $sql_test_detail);
$data_test_detail = array();
$n = 0;
while ($row = mysqli_fetch_array($hasil_test_detail)) {
  $data_test_detail[$n]['nama'] = $row['nama_mhs'];
  $data_test_detail[$n]['jk'] = $row['jenis_kelamin'];
  $data_test_detail[$n]['prodi'] = $row['nama_prodi'];
  $n++;
}
// print("<pre>".print_r($data_test, true)."</pre>");
$prediksi = $classifier->predict($data_test);

?>

<table class="table table-bordered table-striped" width="100%">
  <thead class='thead-light'>
    <tr>
      <th style="width: 150px">Nama Mahasiswa</th>
      <th>Prodi</th>
      <th>IPS1</th>
      <th>IPS2</th>
      <th>IPS3</th>
      <th>IPS4</th>
      <th>IPS5</th>
      <th>IPS6</th>
      <th>IPS7</th>
      <th>IPS8</th>
      <th>IPS9</th>
      <th>IPS10</th>
      <th>SKS Lulus</th>
      <th>Jenis Kelamin</th>
      <th>Jarak Terdekat</th>
      <th>Kesimpulan</th>
    </tr>
  </thead>
  <tbody>
    <td><b><?php echo $data_test_detail[0]['nama']; ?></b></td>
    <td><?php echo $data_test_detail[0]['prodi']; ?></td>
    <td><?php echo $data_test[0][0]; ?></td>
    <td><?php echo $data_test[0][1]; ?></td>
    <td><?php echo $data_test[0][2]; ?></td>
    <td><?php echo $data_test[0][3]; ?></td>
    <td><?php echo $data_test[0][4]; ?></td>
    <td><?php echo $data_test[0][5]; ?></td>
    <td><?php echo $data_test[0][6]; ?></td>
    <td><?php echo $data_test[0][7]; ?></td>
    <td><?php echo $data_test[0][8]; ?></td>
    <td><?php echo $data_test[0][9]; ?></td>
    <td><?php echo $data_test[0][10]; ?></td>
    <td><?php echo $data_test_detail[0]['jk']; ?></td>
    <td><?php echo $nilaik ?></td>
    <td>
      <?php if ($prediksi[0] == 'Tepat Waktu') {
        $label = 'success';
      }else{
        $label = 'danger';
      }
      ?>
      <label class="label label-<?php echo $label; ?>"><?php echo $prediksi[0]; ?></label>
    </td>
  </tbody>
