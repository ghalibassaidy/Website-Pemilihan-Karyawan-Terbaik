<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Matriks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 180px;
            height: auto;
            float: left;
        }

        .kop-surat h2, .kop-surat h3 {
            margin: 0;
            text-align: center;
        }

        .kop-surat p {
            margin: 5px 0;
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .tanda-tangan {
            margin-top: 50px;
            text-align: right;
            margin-right: 50px;
        }

        .tanda-tangan p {
            margin-bottom: 100px; /* Ruang untuk tanda tangan */
        }
    </style>
</head>
<body onload="window.print()">
    <?php include 'include/conn.php'; ?>

    <div class="kop-surat">
        <img src="assets/images/logo.PNG" alt="Logo Sekolah"> <!-- Sesuaikan path logo -->
        <h2>PT SiBalec</h2>
        <h3>Jl. Bidara Raya No.1, RT.9/RW.5, Pejagalan, Kec. Penjaringan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14450</h3>
        <p>Telp: (021) 843367483 | Email: Sibalec12@yahoo.com</p>
        <hr>
    </div>

    <div style="width:100%;margin:0 auto;text-align:center;">
        <h3>Matriks Ternormalisasi</h3>
    </div>
    
    <table>
        <tr>
            <th rowspan="2">Alternatif</th>
            <th colspan="5">Kriteria</th>
        </tr>
        <tr>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th>
            <th>C4</th>
            <th>C5</th>
        </tr>
        <?php
        // Pastikan variabel $X diisi sebelumnya
        $X = array(
            1 => array('max' => 10, 'min' => 2),
            2 => array('max' => 8, 'min' => 1),
            3 => array('max' => 9, 'min' => 3),
            4 => array('max' => 7, 'min' => 2),
            5 => array('max' => 6, 'min' => 1)
        );

        $sql = "SELECT
                  a.id_alternative,
                  SUM(
                    IF(
                      a.id_criteria=1,
                      IF(
                        b.attribute='benefit',
                        a.value/" . $X[1]['max'] . ",
                        " . $X[1]['min'] . "/a.value)
                      ,0)
                      ) AS C1,
                  SUM(
                    IF(
                      a.id_criteria=2,
                      IF(
                        b.attribute='benefit',
                        a.value/" . $X[2]['max'] . ",
                        " . $X[2]['min'] . "/a.value)
                       ,0)
                     ) AS C2,
                  SUM(
                    IF(
                      a.id_criteria=3,
                      IF(
                        b.attribute='benefit',
                        a.value/" . $X[3]['max'] . ",
                        " . $X[3]['min'] . "/a.value)
                       ,0)
                     ) AS C3,
                  SUM(
                    IF(
                      a.id_criteria=4,
                      IF(
                        b.attribute='benefit',
                        a.value/" . $X[4]['max'] . ",
                        " . $X[4]['min'] . "/a.value)
                       ,0)
                     ) AS C4,
                  SUM(
                    IF(
                      a.id_criteria=5,
                      IF(
                        b.attribute='benefit',
                        a.value/" . $X[5]['max'] . ",
                        " . $X[5]['min'] . "/a.value)
                       ,0)
                     ) AS C5
                FROM
                  saw_evaluations a
                  JOIN saw_criterias b USING(id_criteria)
                GROUP BY a.id_alternative
                ORDER BY a.id_alternative
               ";
        $result = $db->query($sql);
        while ($row = $result->fetch_object()) {
            echo "<tr>
                    <td>A{$row->id_alternative}</td>
                    <td>" . round($row->C1, 2) . "</td>
                    <td>" . round($row->C2, 2) . "</td>
                    <td>" . round($row->C3, 2) . "</td>
                    <td>" . round($row->C4, 2) . "</td>
                    <td>" . round($row->C5, 2) . "</td>
                  </tr>\n";
        }
        ?>
    </table>

    <div class="tanda-tangan">
        <p>Jakarta Utara, <?php echo date('d F Y'); ?></p>
        <p>____________________________</p>
        <p>Pemimpin</p>
    </div>
</body>
</html>
