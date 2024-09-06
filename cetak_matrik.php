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
<div class="kop-surat">
        <img src="assets/images/logo.PNG" alt="Logo Sekolah"> <!-- Sesuaikan path logo -->
        <h2>PT SiBalec</h2>
        <h3>Jl. Bidara Raya No.1, RT.9/RW.5, Pejagalan, Kec. Penjaringan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14450</h3>
        <p>Telp: (021) 843367483 | Email: Sibalec12@yahoo.com</p>
        <hr>
    </div>

    <table>
    <div style="width:100%;margin:0 auto;text-align:center;">
        <h3>Penilaian Alternatif</h3>
    </div>
        <tr>
            <th rowspan="2">Alternatif</th>
            <th colspan="6">Kriteria</th>
        </tr>
        <tr>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th>
            <th>C4</th>
            <th colspan="2">C5</th>
        </tr>
        <?php
        require "include/conn.php";

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
        while ($row = $result->fetch_object()) {
            echo "<tr>
                    <td>A<sub>{$row->id_alternative}</sub> {$row->name}</td>
                    <td>" . round($row->C1, 2) . "</td>
                    <td>" . round($row->C2, 2) . "</td>
                    <td>" . round($row->C3, 2) . "</td>
                    <td>" . round($row->C4, 2) . "</td>
                    <td>" . round($row->C5, 2) . "</td>
                  
                  </tr>\n";
        }
        $result->free();
        ?>
    </table>

    

    <div class="tanda-tangan">
        <p>Jakarta Utara, <?php echo date('d F Y'); ?></p>
        <p>____________________________</p>
        <p>Pemimpin</p>
    </div>
</body>
</html>
