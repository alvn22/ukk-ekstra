<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
        
        session_start();
        require('../config.php');
        require('../essentials.php');

        if(!isset($_SESSION['id_user'])){
            redirect('../index.php');
        } else if ($_SESSION['role'] !== 'Siswa'){
            redirect('../index.php');
        }

    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Siswa - Isi Absensi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #024040;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center my-1" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/stmjpng.png" width="60px">
                </div>
                <!-- <div class="sidebar-brand-text mx-3">SMKN 1 Jenangan</div> -->
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="daftar.php">
                    <i class="fas fa-user-edit"></i>
                    <span>Daftar Ekstrakurikuler</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="ekstra.php">
                    <i class="fas fa-puzzle-piece mx-1"></i>
                    <span>Ekstrakurikuler</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="nav-item dropdown no-arrow">
                        <a href="absen.php" class="nav-link text-dark">
                            <i class="fas fa-arrow-left fa-sm fa-fw mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                Logout
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item no-arrow">
                            <span class="nav-link" href="#" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nama'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </span>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Isi Absensi</h1>
                    </div>

                    <form class="offset-md-1" method="POST" enctype="multipart/form-data">
                        <div class="col-md-10 mb-3">
                            <label>Nama:</label>
                            <?php
                                $id = $_SESSION['id_user'];
                                $q = "SELECT * FROM user WHERE id_user = '$id'";
                                $r = mysqli_query($con,$q);
                                $dt = mysqli_fetch_assoc($r);
                            ?>
                            <input type="text" name="nama" readonly value="<?php echo $dt['nama'] ?>" class="form-control">
                        </div>
                        <div class="col-md-10 mb-3">
                            <label>Kelas:</label>
                            <?php
                                $q = "SELECT * FROM ekstra_diikuti d JOIN jurusan k ON d.id_jurusan = k.id_jurusan WHERE id_user = '$id'";
                                $r = mysqli_query($con,$q);
                                $dt = mysqli_fetch_assoc($r);
                            ?>
                            <input type="text" name="nama" readonly value="<?php echo $dt['jurusan'] ?>" class="form-control">
                        </div>
                        <div class="col-md-10 mb-3">
                            <label>Ekstrakurikuler:</label>
                            <?php
                                $id_absen = $_GET['id'];
                                $q = "SELECT * FROM absensi a JOIN ekstra e ON a.id_ekstra = e.id_ekstra WHERE a.id_buat_absensi = '$id_absen'";
                                $r = mysqli_query($con,$q);
                                $dt = mysqli_fetch_assoc($r);
                            ?>
                            <input type="text" name="nama" readonly value="<?php echo $dt['nama_ekstra'] ?>" class="form-control">
                        </div>
                        <div class="col-md-10 mb-3">
                            <label>Tanggal:</label>
                            <?php
                                $id_absen = $_GET['id'];
                                $q = "SELECT * FROM absensi WHERE id_buat_absensi = '$id_absen'";
                                $r = mysqli_query($con,$q);
                                $dt = mysqli_fetch_assoc($r);
                                $tanggal = date("d F Y",strtotime($dt['tanggal']));
                            ?>
                            <input type="text" name="nama" readonly value="<?php echo $tanggal ?>" class="form-control">
                        </div>
                        <div class="col-md-10 mb-3">
                            <label>Keterangan:</label>
                            <div class="form-check">
                                <input class="form-check-input" value="Hadir" type="radio" name="status" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Hadir
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="Sakit" type="radio" name="status" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Sakit
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="Izin" type="radio" name="status" id="flexRadioDefault3">
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Izin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="Alpha" type="radio" name="status" id="flexRadioDefault4" checked>
                                <label class="form-check-label" for="flexRadioDefault4">
                                    Alpha
                                </label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <a href="absen.php" class="btn btn-dark">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SMKN 1 Jenangan 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingin Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Klik tombol "Logout" jika ingin melakukan logout</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>