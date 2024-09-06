<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nilai Preferensi (P)</title>
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
        <h3>Tabel Nilai Preferensi</h3>
    </div>
        <tr>
            <th>No</th>
            <th>Alternatif</th>
            <th>Hasil</th>
        </tr>
        <?php
        require "include/conn.php";
        require "W.php";
        require "R.php";

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
            echo "<tr>
                    <td>" . (++$no) . "</td>
                    <td>A{$i}</td>
                    <td>" . round($value, 4) . "</td>
                  </tr>";
        }
        ?>
    </table>
    <div class="tanda-tangan">
        <p>Jakarta Utara, <?php echo date('d F Y'); ?></p>
        <p>____________________________</p>
        <p>Pemimpin</p>
</body>
</html>
