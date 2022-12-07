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
    $barang = select("SELECT a.id_barang, a.id_merek, a.id_kategori, 
                    a.nama_barang, b.nama_merek, c.nama_kategori, a.keterangan, a.stok 
                    FROM barang a JOIN merek b ON a.id_merek = b.id_merek JOIN kategori c 
                    ON a.id_kategori = c.id_kategori");
    ?>
    <div style="page-break-after:always;text-align:center;margin-top:5%;">
        <div style="line-height:5px;">
            <h2>LAPORAN STOK BARANG</h2>
        </div>
        <hr style="border-color:black;">
        <table class="tab">
            <tr>
                <th width="20">NO</th>
                <th>NAMA BARANG</th>
                <th>MEREK</th>
                <th>KATEGORI</th>
                <th>KETERANGAN</th>
                <th>STOK</th>
            </tr>
            <?php $n=1; foreach($barang as $row){ ?>
            <tr>
                <td align="center"><?= $n++.'.'; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['nama_merek']; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td><?= $row['keterangan']; ?></td>
                <td><?= $row['stok']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>

<script>
window.print();
</script>