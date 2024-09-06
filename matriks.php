<!DOCTYPE html>
<html lang="en">
  <?php
require "layout/head.php";
require "include/conn.php";
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
          <h3>Matrik</h3>
        </div>
        <div class="page-content">
          <section class="row">
            <div class="col-12">
              <div class="card">

                <div class="card-header">
                  <h4 class="card-title">Matriks Keputusan (X) &amp; Ternormalisasi (R)</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <p class="card-text">Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai ternormalisasi (R), dengan ketentuan :
Untuk normalisai nilai, jika faktor/attribute kriteria bertipe cost maka digunakan rumusan:
Rij = ( min{Xij} / Xij)
sedangkan jika faktor/attribute kriteria bertipe benefit maka digunakan rumusan:
Rij = ( Xij/max{Xij} )</p>
                  </div>
                  <button type="button" class="btn btn-outline-success btn-sm m-2" data-bs-toggle="modal"
                                        data-bs-target="#inlineForm">
                                        Isi Nilai Alternatif
                                    </button>
                                    <a href="cetak_matrik.php" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
                                    <a href="cetak_ternormalisasi.php" target="_blank" class="btn btn-primary btn-sm">Cetak Ternormalisasi</a>
                  <div class="table-responsive" id="decision-matrix">
                  <table class="table table-striped mb-0">
                  <caption>
        Matrik Keputusan(X)
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='6'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
        <th colspan="2">C5</th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4,
          SUM(IF(a.id_criteria=5,a.value,0)) AS C5
        FROM
          saw_evaluations a
          JOIN saw_alternatives b USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
while ($row = $result->fetch_object()) {
    array_push($X[1], round($row->C1, 2));
    array_push($X[2], round($row->C2, 2));
    array_push($X[3], round($row->C3, 2));
    array_push($X[4], round($row->C4, 2));
    array_push($X[5], round($row->C5, 2));
    echo "<tr class='center'>
            <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
            <td>" . round($row->C1, 2) . "</td>
            <td>" . round($row->C2, 2) . "</td>
            <td>" . round($row->C3, 2) . "</td>
            <td>" . round($row->C4, 2) . "</td>
            <td>" . round($row->C5, 2) . "</td>
            <td>
            <a href='keputusan-hapus.php?id={$row->id_alternative}' class='btn btn-danger btn-sm'>Hapus</a>
            </td>
          </tr>\n";
}
$result->free();

?>
</table>

<tr>
            <th rowspan='2'>Alternatif</th>
            <th colspan='5'>Kriteria</th>
        </tr>
        <tr>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th>
            <th>C4</th>
            <th>C5</th>
        </tr>
        <?php
        // Asumsikan $db adalah koneksi database
        $sql = "SELECT
                  a.id_alternative,
                  SUM(
                    IF(
                      a.id_criteria=1,
                      IF(
                        b.attribute='benefit',
                        a.value/" . max($X[1]) . ",
                        " . min($X[1]) . "/a.value)
                      ,0)
                      ) AS C1,
                  SUM(
                    IF(
                      a.id_criteria=2,
                      IF(
                        b.attribute='benefit',
                        a.value/" . max($X[2]) . ",
                        " . min($X[2]) . "/a.value)
                       ,0)
                     ) AS C2,
                  SUM(
                    IF(
                      a.id_criteria=3,
                      IF(
                        b.attribute='benefit',
                        a.value/" . max($X[3]) . ",
                        " . min($X[3]) . "/a.value)
                       ,0)
                     ) AS C3,
                  SUM(
                    IF(
                      a.id_criteria=4,
                      IF(
                        b.attribute='benefit',
                        a.value/" . max($X[4]) . ",
                        " . min($X[4]) . "/a.value)
                       ,0)
                     ) AS C4,
                  SUM(
                    IF(
                      a.id_criteria=5,
                      IF(
                        b.attribute='benefit',
                        a.value/" . max($X[5]) . ",
                        " . min($X[5]) . "/a.value)
                       ,0)
                     ) AS C5
                FROM
                  saw_evaluations a
                  JOIN saw_criterias b USING(id_criteria)
                GROUP BY a.id_alternative
                ORDER BY a.id_alternative
               ";
        $result = $db->query($sql);
        $R = array();
        while ($row = $result->fetch_object()) {
            $R[$row->id_alternative] = array($row->C1, $row->C2, $row->C3, $row->C4, $row->C5);
            echo "<tr class='center'>
                    <th>A{$row->id_alternative}</th>
                    <td>" . round($row->C1, 2) . "</td>
                    <td>" . round($row->C2, 2) . "</td>
                    <td>" . round($row->C3, 2) . "</td>
                    <td>" . round($row->C4, 2) . "</td>
                    <td>" . round($row->C5, 2) . "</td>
                  </tr>\n";
        }
        ?>
    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <?php require "layout/footer.php";?>
      </div>
    </div>

    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Isi Nilai Kandidat </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="matrik-simpan.php" method="POST">
                        <div class="modal-body">
                            <label>Name: </label>
                            <div class="form-group">
                            <select class="form-control form-select" name="id_alternative">
                            <?php
$sql = 'SELECT id_alternative,name FROM saw_alternatives';
$result = $db->query($sql);
$i = 0;
while ($row = $result->fetch_object()) {
    echo '<option value="' . $row->id_alternative . '">' . $row->name . '</option>';
}
$result->free();
?>
                                          </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <label>Criteria: </label>
                            <div class="form-group">
                            <select class="form-control form-select" name="id_criteria">
                            <?php
$sql = 'SELECT * FROM saw_criterias';
$result = $db->query($sql);
$i = 0;
while ($row = $result->fetch_object()) {
    echo '<option value="' . $row->id_criteria . '">' . $row->criteria . '</option>';
}
$result->free();
?>
                                          </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <label>Value: </label>
                            <div class="form-group">
                                <input type="text" name="value" placeholder="value..." class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" name="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <!-- Tambahkan elemen untuk header dan footer cetakan -->
        <div id="print-header" style="display:none; text-align:center;">
            <table style="width:100%;">
                <tr>
                    <td style="text-align: left;">
                        <img src="assets/images/logo.png" alt="Logo" style="height: 50px;">
                    </td>
                    <td style="text-align: center;">
                        <h4>Jl. Bidara Raya No.1, RT.9/RW.5, Pejagalan, Kec. Penjaringan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14450</h4>
                    </td>
                </tr>
            </table>
        </div>

        <div id="print-footer" style="display:none; text-align:right;">
            <p>Jakarta, <?php echo date('l, d F Y'); ?></p>
            <br><br><br>
            <p>Pimpinan</p>
        </div>

        <?php require "layout/js.php";?>
      </div>
    </div>

    <script>
        function printTable(tableId) {
            var header = document.getElementById('print-header').innerHTML;
            var footer = document.getElementById('print-footer').innerHTML;
            var content = document.getElementById(tableId).outerHTML;
            var newWin = window.open("");
            newWin.document.write(`
                <html>
                    <head>
                        <style>
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;
                            }
                            table, th, td {
                                border: 1px solid black;
                            }
                            th, td {
                                padding: 8px;
                                text-align: center;
                            }
                            caption {
                                font-weight: bold;
                                margin-top: 10px;
                            }
                        </style>
                    </head>
                    <body>
                        ${header}
                        ${content}
                        ${footer}
                    </body>
                </html>
            `);
            newWin.document.close();
            newWin.print();
        }
    </script>
  </body>
</html>
