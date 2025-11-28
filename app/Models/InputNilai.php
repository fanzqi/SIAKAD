<?php
//koneksi database
//require_once __DIR__ . '../database/koneksiDB.php';
session_start();
$host = "localhost";
$port = "5432";
$dbname = "penjualan";
$user = "postgres";
$password = "maulan10";
try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    // echo("Koneksi Berhasil");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <!-- awal container -->
  <div class="container">
    <h3 class="text-center">Input Nilai Mahasiswa</h3>

    <!-- awal row -->
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card">
          <div class="card-header bg-info text-light">
            Form Input Nilai
          </div>
          <!-- awal card -->
          <div class="card-body">
            <!-- awal form -->
            <form method="POST">
              <form>
                <div class="mb-3">
                  <label class="form-label">Pilih Mata Kuliah</label>
                  <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">technopreneurship</option>
                    <option value="2">web development</option>
                    <option value="3">game development</option>
                  </select>
                </div>
              </form>
            </form>

            <form method="POST">
              <form>
                <div class="mb-3">
                  <label class="form-label">Pilih Kelas</label>
                  <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">2</option>
                    <option value="2">3</option>
                    <option value="3">4</option>
                  </select>
                </div>
              </form>
            </form>

            <form method="POST">
              <form>
                <div class="mb-3">
                  <label class="form-label">Pilih Angkatan</label>
                  <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">2023/2024</option>
                    <option value="2">2024/2025</option>
                    <option value="3">2025/2026</option>
                  </select>
                </div>
              </form>
            </form>
            <div class="text-center">
              <hr>
              <button class="btn btn-primary" name="csimpan" type="submit">lihat</button>
              <button class="btn btn-danger" name="ckosongkan" type="submit">kosongkan</button>
            </div>
            <!-- akhir form -->
          </div>
          <div class="card-footer bg-info">
            <!-- akhir card -->
          </div>
        </div>
      </div>
    </div>
    <!-- akhir row -->

    <div class="card mt-5">
      <div class="card-header bg-info text-light">
        Form Input Nilai
      </div>
      <div class="card-body">
<div class="col-md-6 mx-auto">
  <form method="POST">
    <div class="input-group mb-3">
      <input type="text" name="tcari" class="form-control" placeholder="masukkan kata kunci">
      <button class="btn btn-primary" name="cari" type="submit">cari</button>
      <button class="btn btn-danger" name="reset" type="submit">reset</button>
    </div>
  </form>
</div>
        <table class="table table-stripped table-hover table-bordered">
          <tr>
            <th>No</th>
            <th>Nim</th>
            <th>Mahasiswa</th>
            <th>Kehadiran</th>
            <th>Tugas</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Mean</th>
            <th>Status</th>
          </tr>

          <tr>
            <td>1</td>
            <td>230100</td>
            <td>Sinta Dewi</td>
            <td>90%</td>
            <td>80</td>
            <td>76</td>
            <td>88</td>
            <td>82.0</td>
            <td>
              <button class="btn btn-warning" name="cedit" type="submit">edit</button>
              <button class="btn btn-danger" name="chapus" type="submit">hapus</button>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>230101</td>
            <td>Wira Kusuma</td>
            <td>100%</td>
            <td>90</td>
            <td>78</td>
            <td>80</td>
            <td>82.4</td>
            <td>
              <button class="btn btn-warning" name="cedit" type="submit">edit</button>
              <button class="btn btn-danger" name="chapus" type="submit">hapus</button>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>230102</td>
            <td>Wisnu Bakhti</td>
            <td>70%</td>
            <td></td>
            <td>85</td>
            <td>68</td>
            <td>?</td>
            <td>
              <button class="btn btn-warning" name="cedit" type="submit">edit</button>
              <button class="btn btn-danger" name="chapus" type="submit">hapus</button>
            </td>
          </tr>

        </table>
      </div>
      <div class="card-footer bg-info">

      </div>
    </div>

  </div>
  <!-- akhir container -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>