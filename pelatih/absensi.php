<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
        
        session_start();
        require('../config.php');
        require('../essentials.php');

        if(!isset($_SESSION['id_user'])){
            redirect('../index.php');
        } else if ($_SESSION['role'] !== 'Pelatih'){
            redirect('../index.php');
        }

    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pelatih - Absensi</title>

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
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-users-cog"></i>
                    <span>Absensi</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Absen:</h6>
                        <a class="collapse-item" href="buat_absensi.php">Buat absensi</a>
                        <a class="collapse-item" href="absensi.php">Absensi</a>
                        </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jurnal.php">
                    <i class="fas fa-book mx-1"></i>
                    <span>Jurnal</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTw"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-server mx-1"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseTw" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Laporan:</h6>
                        <a class="collapse-item" href="laporan_absensi.php">Laporan Absensi</a>
                        <a class="collapse-item" href="laporan_jurnal.php">Laporan Jurnal</a>
                        </div>
                </div>
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
                        <h1 class="h3 mb-0 text-gray-800">Absensi Murid</h1>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-white" style="background-color: #024040;">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Ekstrakurikuler</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $id = $_SESSION['id_user'];
                                    $q = "SELECT * FROM absensi_siswa a JOIN user u ON a.id_user = u.id_user JOIN jurusan k ON a.id_kelas = k.id_jurusan
                                        JOIN ekstra e ON a.id_ekstra = e.id_ekstra JOIN pelatih_ekstra pe ON a.id_ekstra = pe.id_ekstra WHERE pe.id_user = '$id'";
                                    $r = mysqli_query($con,$q);

                                    $i = 1;
                                    while($data = mysqli_fetch_assoc($r)){
                                        echo<<<res
                                        <tr>
                                        <td>$i</td>
                                        <td>$data[nama]</td>
                                        <td>$data[jurusan]</td>
                                        <td>$data[nama_ekstra]</td>
                                        <td>$data[keterangan]</td>
                                        <td><script>
                                        function konvertHari(tanggal){
                                            var Hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                            var date = new Date(tanggal);
                                            var indek = date.getDay();
                                            var NamaHari = Hari[indek];
                                            return NamaHari;
                                        }
                                        var tanggal = '$data[waktu_absen]';
                                        var hariIndo = konvertHari(tanggal);
                                        document.write(hariIndo);
                                        </script></td>
                                        <td>$data[waktu_absen]</td>
                                        <td><a href="edit_absensi.php?id=$data[id_absensi]" type="button" name="edit" class="btn btn-sm btn-primary">Absensi</a></td>
                                        </tr>
                                        res;
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>


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