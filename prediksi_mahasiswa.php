<?php require_once 'koneksi.php'; ?>

<?php require_once 'menu.php'; ?>

<!-- Full Width Column -->
<div class="container" style="margin-top: 5px">
  <!-- Main content -->
  <div id="simpan"></div>

  <div class="row">
    <hr>
    <h3>Prediksi Ketepatan Kelulusan Per Mahasiswa Dengan Metode k-NN</h3>
    <hr>
    <form id="form" class="form-horizontal" method="POST">
      <div class="form-group">
        <label class="col-sm-2 control-label">Pilih Mahasiswa :</label>
        <div class="col-sm-8">
          <select class="form-control select2" name="id_mhs" id="id_mhs" required>
            <option value="" readonly >Pilih Mahasiswa</option>
            <?php
            $conn = koneksi();
            $sql  = "SELECT * FROM mhs inner join detail_mhs on mhs.id_mhs = detail_mhs.id_mhs_detail GROUP BY mhs.id_mhs";
            $hasil = mysqli_query($conn, $sql);
            while ($r = mysqli_fetch_array($hasil)) {
              $gender = "Perempuan";
              if($r["jenis_kelamin"] == "L"){
                $gender = "Laki-laki";
              }
              ?>
              <option value="<?=$r['id_mhs']?>">
                <?php echo $r['nama_mhs']?> |
                <?php echo $r['IPS1']?> |
                <?php echo $r['IPS2']?> |
                <?php echo $r['IPS3']?> |
                <?php echo $r['IPS4']?> |
                <?php echo $r['IPS5']?> |
                <?php echo $r['IPS6']?> |
                <?php echo $r['IPS7']?> |
                <?php echo $r['IPS8']?> |
                <?php echo $r['IPS9']?> |
                <?php echo $r['IPS10']?> |
                <?php echo $r['sks_lulus']?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Tetangga Terdekat (K):</label>
        <div class="col-sm-8">
          <select class="form-control select2" name="nilaik" required>
            <option value="" readonly >Pilih</option>
            <option>5</option>
            <option>9</option>
            <option>13</option>
            <option>15</option>
          </select>
        </div>
      </div>
      <div class="col-sm-2" style="margin-top: 20px;margin-bottom: 30px">
        <button type="submit" id="hitung" name="hitung" class="btn btn-lg btn-success">HITUNG</button>
      </div>
    </form>

    <!-- Munculkan hasil -->
    <div id="loader"><img src="bootstrap3/loader.gif" /></div>
    <div class="data_load"></div>

  </div>
</div> <!-- /.container -->
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="bootstrap3/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
$(function () {
  $('#loader').hide();
  $('.select2').select2();

  $("#form").submit(function(event){
    event.preventDefault();
    var $form = $(this);
    var serializedData = $form.serialize();
    $.ajax({
      type : 'POST',
      url  : 'knn-2.php',
      data : serializedData,
      beforeSend: function() {
        $('#loader').show();
      },
      success: function(data) {
        $('.data_load').html(data);
      },
      error: function(xhr) {
        alert("Error occured.please try again");
        $(placeholder).append(xhr.statusText + xhr.responseText);
        $(placeholder).removeClass('loading');
      },
      complete: function() {
        $('#loader').hide();
      }
    });
  });//end-Ajax


});
</script>
