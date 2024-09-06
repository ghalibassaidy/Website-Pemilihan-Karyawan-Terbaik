<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cetak Alternatif</title>
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

        <div class="container">
        <div style="width:100%;margin:0 auto;text-align:center;">
        <h3>Tabel Alternatif</h3>
            <table class="table">
                
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                require "include/conn.php";
                $sql = 'SELECT id_alternative, name FROM saw_alternatives';
                $result = $db->query($sql);
                $i = 0;
                while ($row = $result->fetch_object()) {
                    echo "<tr>
                        <td>" . (++$i) . "</td>
                        <td>{$row->name}</td>
                      </tr>\n";
                }
                $result->free();
                ?>
                </tbody>
            </table>
        </div>
        <div class="tanda-tangan">
        <p>Jakarta Utara, <?php echo date('d F Y'); ?></p>
        <p>____________________________</p>
        <p>Pemimpin</p>
    </body>
</html>
