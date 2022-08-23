<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>sfasfafafaf</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 25cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: bolder;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        h2 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 1.8em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        h3 {
            /* border-top: 1px solid #5D6975; */
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 1.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: left;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div {
            white-space: nowrap;
            font-size: 1.2em;
            margin-left: 10px;
        }

        #company div {
            white-space: nowrap;
            font-size: 1.3em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
            white-space: nowrap;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
            background-color: #9eadb6;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width:100px;background-color:transparent" src="data:image/svg+xml;charset=utf-8;base64,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" alt="">
        </div>
        <h1>Perhitungan RAB Setelah Revisi</h1>
        <div id="company" class="clearfix">
            <div>PT ADIKA JAYA ENGINEERING</div>
            <div>Office : Jl. Gemah Kumala No 16 Pedurungan Semarang 50191</div>
            <div>Workshop : Jl. Kyai Selan RT 06 RW 03 Ds. Penyangkringan <br> Karangmulyo Kec. Pegandon Kab. Kendal 51357</div>
            <div>+62 821-1458-7645</div>
            <div><a>adikajayaengineering@gmail.com</a></div>
        </div>
        <div id="project">
            <div><span>PROJECT</span><?= $user[0]['namaproyek']; ?></div>
            <div><span>ID AJUAN</span> <?= $user[0]['idajuan']; ?></div>
            <div><span>CLIENT</span><?= $user[0]['nama']; ?></div>
            <div><span>ALAMAT</span><?= $user[0]['alamat']; ?></div>
            <div><span>EMAIL</span> <a><?= $user[0]['email']; ?></a></div>
            <div><span>No TELP</span><?= $user[0]['notelp']; ?></div>
            <div><span>TANGGAL</span><?= $tanggal; ?></div>
        </div>
    </header>
    <main>
        <h2 style="margin-top:20px">Biaya Material</h2>
        <table>
            <thead>
                <tr>
                    <th class="service">Nama Material</th>
                    <th class="service">Satuan Material</th>
                    <th class="service">Qty</th>
                    <th class="service">Harga Material</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bb as $row) : ?>
                    <tr>
                        <td class="service"><?= $row['namamp']; ?></td>
                        <td class="service"><?= $row['satuanmp']; ?></td>
                        <td class="service"><?= $row['jumlahmp']; ?></td>
                        <td class="service">Rp <?= number_format($row['hargamp'], 0), '', '.'; ?>,-</td>
                        <td class="total">Rp <?= number_format($row['totalmp'], 0, '', '.'); ?>,-</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total">Rp <?= number_format($sumbb, 0, '', '.'); ?>,-</td>
                </tr>
            </tbody>
        </table>
        <h2 style="margin-top:40px">Biaya Tenaga Kerja</h2>
        <table>
            <thead>
                <tr>
                    <th class="service">JobDesk</th>
                    <th class="service">Status Pekerjaan</th>
                    <th class="service">Gaji</th>
                    <th class="service">Total Pekerja</th>
                    <th class="total">Total Gaji</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($tk as $row) : ?>
                    <tr>
                        <td class="service"><?= $row['jobdesk']; ?></td>
                        <td class="service"><?= $row['statuspekerjaan']; ?></td>
                        <td class="service"><?= $row['gaji']; ?></td>
                        <td class="service"><?= $row['total_pekerja']; ?></td>
                        <td class="total"><?= $row['total_gaji']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total">Rp <?= number_format($sumtk, 0, '', '.'); ?>,-</td>
                </tr>
            </tbody>
        </table>

        <h2 style="margin-top:20px">Biaya Operasional</h2>
        <table>
            <thead>
                <?php foreach ($bop as $row) ?>
                <tr>
                    <th class="desc">Nama Biaya</th>
                    <th class="desc">Qty</th>
                    <th class="desc">Satuan</th>
                    <th class="desc">Harga</th>
                    <th class="total">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="desc"><?= $row['namatrans']; ?></td>
                    <td class="desc"><?= $row['quantity']; ?></td>
                    <td class="desc"><?= $row['satuan']; ?></td>
                    <td class="desc"><?= $row['harga']; ?></td>
                    <td class="total">Rp <?= number_format($row['tot_biaya'], 0, '', '.'); ?>,-</td>
                </tr>
                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total">Rp <?= number_format($sumbop, 0, '', '.'); ?>,-</td>
                </tr>
                <tr>
                    <td colspan="4" class="grand total">TOTAL BIAYA KESELURUHAN</td>
                    <td class="grand total">Rp <?= number_format($sumall, 0, '', '.'); ?>,-</td>
                </tr>
            </tbody>
        </table>

        <h3>Item Item Yang Direvisi</h3>
        <h2>Biaya Operasional</h2>
        <table>
            <thead>

                <tr>
                    <th class="desc">Nama Biaya</th>
                    <th class="desc">Qty</th>
                    <th class="desc">Satuan</th>
                    <th class="desc">Harga</th>
                    <th class="total">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boprevisi as $row) : ?>
                    <tr>
                        <td class="desc"><?= $row['namatrans']; ?></td>
                        <td class="desc"><?= $row['quantity']; ?></td>
                        <td class="desc"><?= $row['satuan']; ?></td>
                        <td class="desc">Rp <?= number_format($row['harga'], 0, '', '.'); ?>,-</td>
                        <td class="total">Rp <?= number_format($row['tot_biaya'], 0, '', '.'); ?>,-</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top:40px">Biaya Tenaga Kerja</h2>
        <table>
            <thead>
                <tr>
                    <th class="service">JobDesk</th>
                    <th class="service">Status Pekerjaan</th>
                    <th class="service">Gaji</th>
                    <th class="service">Total Pekerja</th>
                    <th class="total">Total Gaji</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($tkrevisi as $row) : ?>
                    <tr>
                        <td class="service"><?= $row['jobdesk']; ?></td>
                        <td class="service"><?= $row['statuspekerjaan']; ?></td>
                        <td class="service"><?= $row['gaji']; ?></td>
                        <td class="service"><?= $row['total_pekerja']; ?></td>
                        <td class="total"><?= $row['total_gaji']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top:20px">Biaya Material</h2>
        <table>
            <thead>
                <tr>
                    <th class="service">Nama Material</th>
                    <th class="service">Satuan Material</th>
                    <th class="service">Qty</th>
                    <th class="service">Harga Material</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bbrevisi as $row) : ?>
                    <tr>
                        <td class="service"><?= $row['namamp']; ?></td>
                        <td class="service"><?= $row['satuanmp']; ?></td>
                        <td class="service"><?= $row['jumlahmp']; ?></td>
                        <td class="service">Rp <?= number_format($row['hargamp'], 0), '', '.'; ?>,-</td>
                        <td class="total">Rp <?= number_format($row['totalmp'], 0, '', '.'); ?>,-</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>



    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>