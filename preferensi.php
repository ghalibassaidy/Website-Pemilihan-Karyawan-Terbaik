<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";
require "W.php";
require "R.php";
?>

<body>
  <div id="app">
    <?php require "layout/sidebar.php";?>
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <div class="page-heading">
        <h3>Nilai Preferensi (P)</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Tabel Nilai Preferensi (P)</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p class="card-text">Nilai preferensi (P) merupakan penjumlahan dari perkalian matriks ternormalisasi R dengan vektor bobot W.</p>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mb-0" id="preference-table">
                    <caption>Nilai Preferensi (P)</caption>
                    <tr>
                      <th>No</th>
                      <th>Alternatif</th>
                      <th>Hasil</th>
                    </tr>
                    <?php
                    $P = array();
                    $m = count($W);
                    $no = 0;

                    // Hitung nilai preferensi
                    foreach ($R as $i => $r) {
                        for ($j = 0; $j < $m; $j++) {
                            $P[$i] = (isset($P[$i]) ? $P[$i] : 0) + $r[$j] * $W[$j];
                        }
                    }

                    // Urutkan nilai preferensi dari yang tertinggi hingga terendah
                    arsort($P);

                    // Tampilkan hasil
                    foreach ($P as $i => $value) {
                        echo "<tr class='center'>
                                <td>" . (++$no) . "</td>
                                <td>A{$i}</td>
                                <td>{$value}</td>
                              </tr>";
                    }
                    ?>
                  </table>
                </div>
                <a href="cetak_preferensi.php" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php require "layout/footer.php";?>
    </div>
  </div>
</body>
</html>
