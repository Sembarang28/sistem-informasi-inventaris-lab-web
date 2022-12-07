<?php
  session_start();
  require 'function.php';
  
  if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  }
  
  $masuk = select("SELECT a.id_barangMasuk, a.id_barang, b.nama_barang, 
                    c.nama_merek, d.nama_kategori, a.keterangan, a.tanggal, a.jumlah 
                    FROM barang_masuk a 
                    JOIN barang b ON a.id_barang = b.id_barang
                    JOIN merek c ON b.id_merek = c.id_merek
                    JOIN kategori d ON b.id_kategori = d.id_kategori");

  if(isset($_POST['tambah'])){
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $barang = $_POST['barang'];
    $keterangan = $_POST['keterangan'];

    $query = select("SELECT * FROM barang WHERE id_barang = '$barang'");
    
    $stokAwal = intval($query[0]['stok']);
    $stok = $stokAwal + $jumlah;

    $insert = mysqli_query($conn, "INSERT INTO barang_masuk VALUES ('','$barang','$jumlah','$keterangan','$tanggal')");
    $update = mysqli_query($conn, "UPDATE barang SET stok = '$stok' WHERE id_barang = '$barang'");
    header("Location: barangMasuk.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Barang Masuk</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logoJTIK.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="index.php" class="logo d-flex align-items-center">
    <img src="assets/img/logoJTIK.png" alt="">
    <span class="d-none d-lg-block">Inventaris Lab JTIK</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="assets/img/photo.png" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['nama'];?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?= $_SESSION['nama'];?></h6>
          <span><?= $_SESSION['nama'];?></span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item d-flex align-items-center" href="profile.php">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <?php 
    if($_SESSION['role'] == 'admin'){
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="merek.php">
          <i class="bi bi-circle"></i><span>Merek</span>
        </a>
      </li>
      <li>
        <a href="kategori.php">
          <i class="bi bi-circle"></i><span>Kategori</span>
        </a>
      </li>
      <li>
        <a href="barang.php">
          <i class="bi bi-circle"></i><span>Barang</span>
        </a>
      </li>
      <li>
        <a href="pengguna.php">
          <i class="bi bi-circle"></i><span>Pengguna</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tabless-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tabless-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="barangMasuk.php">
          <i class="bi bi-circle"></i><span>Barang Masuk</span>
        </a>
      </li>
      <li>
        <a href="barangKeluar.php">
          <i class="bi bi-circle"></i><span>Barang Keluar</span>
        </a>
      </li>
      <li>
        <a href="pinjam.php">
          <i class="bi bi-circle"></i><span>Peminjaman</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="LaporanBarangMasuk.php">
          <i class="bi bi-circle"></i><span>Laporan Barang Masuk</span>
        </a>
      </li>
      <li>
        <a href="laporanbarangkeluar.php">
          <i class="bi bi-circle"></i><span>Laporan Barang Keluar</span>
        </a>
      </li>
      <li>
        <a href="laporanstokbarang.php" target="_blank">
          <i class="bi bi-circle"></i><span>Laporan Stok Barang</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->
  <?php
    } else {
  ?>
  <li class="nav-item">
    <a class="nav-link " href="barang.php">
      <i class="bi bi-menu-button-wide"></i>
      <span>Barang</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="pinjam.php">
      <i class="bi bi-layout-text-window-reverse"></i>
      <span>Pinjam</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <?php } ?>
</ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

<div class="pagetitle">
  <h1>Barang Masuk</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Transaksi</li>
          <li class="breadcrumb-item active">Barang Masuk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>

            <!-- Default Table -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Merek</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col">Jumlah</th>
                </tr>
              </thead>
              <?php
                $i = 1;
                foreach($masuk as $row){
              ?>
              <tbody>
                <tr>
                  <th scope="row"><?= $i; ?></th>
                  <td><?= $row['tanggal']; ?></td>
                  <td><?= $row['nama_barang']; ?></td>
                  <td><?= $row['nama_merek']; ?></td>
                  <td><?= $row['nama_kategori']; ?></td>
                  <td><?= $row['keterangan']; ?></td>
                  <td><?= $row['jumlah']; ?></td>
                </tr>                 
              </tbody>
              <?php
                  $i++;
                }
              ?>
            </table>
            <!-- End Default Table Example -->
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

<div class="modal fade" id="tambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Barang Masuk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="inputText" class="col-form-label">Tanggal</label>
              <input type="date" name="tanggal" class="form-control">
            </div>
            <div class="form-group">
              <label class="col-form-label">Barang</label>
              <select class="form-select" aria-label="Default select example" name="barang">
                  <option selected>Open this select menu</option>
                  <?php
                    $barang = select("SELECT * FROM barang");
                    foreach($barang as $row){
                  ?>
                  <option value="<?= $row['id_barang'] ?>"><?= $row['nama_barang'] ?></option>
                  <?php
                    }
                  ?>
              </select>
            </div>
            <div class="form-group">
                <label for="inputText" class="col-form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah">
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-form-label">Keterangan</label>
              <textarea class="form-control" name="keterangan" style="height: 100px"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
          </div>
        </form>
    </div>
  </div>
</div><!-- End Vertically centered Modal-->