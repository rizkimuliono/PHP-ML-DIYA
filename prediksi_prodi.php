<?php require_once 'koneksi.php'; ?>

<?php require_once 'menu.php'; ?>

<!-- Full Width Column -->
<div class="container" style="margin-top: 5px">
  <!-- Main content -->
  <div id="simpan"></div>

  <div class="row">
    <form id="form" class="form-horizontal" method="POST">
      <hr>
      <h3>Prediksi Ketepatan Kelulusan Mahasiswa Dengan Metode k-NN</h3>
      <hr>
      <div class="form-group">
        <label class="col-sm-2 control-label">Pilih Prodi :</label>
        <div class="col-sm-8">
          <select class="form-control select2" name="prodi" id="prodi" required>
            <option value="" readonly >Pilih Prodi</option>
            <?php
            $conn = koneksi();
            $sql  = "SELECT * FROM prodi";
            $hasil = mysqli_query($conn, $sql);
            while ($r = mysqli_fetch_array($hasil)) { ?>
              <option value="<?=$r['id_prodi']?>">
                <?php echo $r['nama_prodi']?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Tetangga Terdekat :</label>
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
        <button type="submit" id="hitung" name="hitung" class="btn btn-primary">HITUNG</button>
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
      url  : 'knn-1.php',
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
