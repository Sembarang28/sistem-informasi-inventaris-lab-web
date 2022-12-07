<?php
    session_start();
    
    if(!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
?>

<html>

<head>
    <style>
    h2 {
        padding: 0px;
        margin: 0px;
        font-size: 14pt;
    }

    h4 {
        font-size: 12pt;
    }

    text {
        padding: 0px;
    }

    table {
        border-collapse: collapse;
        border: 1px solid #000;
        font-size: 11pt;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 5px;
    }

    table.tab {
        table-layout: auto;
        width: 100%;
    }
    </style>
    <title>Cetak Laporan Barang Masuk</title>
</head>

<body>
    <?php
    require 'function.php';
    $tgl_awal = $_POST['tglawal'];
    $tgl_akhir = $_POST['tglakhir'];
    $masuk = select("SELECT a.id_barangMasuk, a.id_barang, b.nama_barang, 
                        c.nama_merek, d.nama_kategori, a.keterangan, a.tanggal, a.jumlah 
                        FROM barang_masuk a 
                        JOIN barang b ON a.id_barang = b.id_barang
                        JOIN merek c ON b.id_merek = c.id_merek
                        JOIN kategori d ON b.id_kategori = d.id_kategori 
                        WHERE a.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
                        ORDER BY a.id_barangMasuk");
    ?>
    <div style="page-break-after:always;text-align:center;margin-top:5%;">
        <div style="line-height:5px;">
            <h2>LAPORAN BARANG MASUK</h2>
            <h4>TANGGAL "<?= date('d-m-Y',strtotime($tgl_awal)); ?>" SAMPAI
                "<?= date('d-m-Y',strtotime($tgl_akhir)); ?>"</h4>
        </div>
        <hr style="border-color:black;">
        <table class="tab">
            <tr>
                <th width="20">NO</th>
                <th>TGL</th>
                <th>NAMA BARANG</th>
                <th>MEREK</th>
                <th>KATEGORI</th>
                <th>KETERANGAN</th>
                <th>JUMLAH</th>
            </tr>
            <?php $n=1; foreach($masuk as $row){ ?>
            <tr>
                <td align="center"><?= $n++.'.'; ?></td>
                <td><?= date('d-m-Y',strtotime($row['tanggal'])); ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['nama_merek']; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td><?= $row['keterangan']; ?></td>
                <td><?= $row['jumlah']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>

<script>
window.print();
</script>