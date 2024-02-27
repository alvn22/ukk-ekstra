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

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ekstra1 = $_POST['ekstra1'];
        $ekstra2 = $_POST['ekstra2'];
        $id_user = $_SESSION["id_user"];
        $jurusan = $_POST['jurusan'];

        if($ekstra1 == $ekstra2){
            alert('error', "Ekstra tidak dapat sama!");
        } else {
            $q = "INSERT INTO ekstra_diikuti (id_ekstra1, id_ekstra2, id_user, id_jurusan) VALUES ('$ekstra1', '$ekstra2', '$id_user', '$jurusan')";
            $r = mysqli_query($con,$q);
            alert('success','Berhasil daftar ekstra');
        }
    }

    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Siswa - Daftar Ekstrakurikuler</title>

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
                <a class="nav-link" href="daftar.php">
                    <i class="fas fa-user-edit"></i>
                    <span>Daftar Ekstrakurikuler</span>
                </a>
            </li>
            <li class="nav-item">
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
                        <h1 class="h3 mb-0 text-gray-800">Daftar Ekstrakurikuler</h1>
                    </div>
                    

                    <?php 
                        $id = $_SESSION["id_user"];
                        $q = "SELECT COUNT(*) as total FROM ekstra_diikuti WHERE id_user='$id'";
                        $r = mysqli_query($con,$q);
                        $dt = mysqli_fetch_assoc($r);

                        if($dt['total'] >= 2){
                            echo"<div class='d-flex justify-content-center text-center'><center>Anda sudah mendaftar 2 ekstra</center></div>";
                        } else { ?>
                        <div class="row">
                        <?php 

                        $q = "SELECT * FROM ekstra JOIN pelatih_ekstra ON ekstra.id_ekstra = pelatih_ekstra.id_ekstra 
                            JOIN user ON pelatih_ekstra.id_user = user.id_user";
                        $r = mysqli_query($con,$q);

                        while($row = mysqli_fetch_assoc($r)){
                            $waktu = date("H:i", strtotime($row['waktu']));
                            echo<<<data
                                <div class="col-lg-4 col-md-6 mt-3">
                                    <div class="card shadow">
                                        <div class="card-header d-flex align-items-center justify-content-center mt-2">
                                            <h4 name="nama_ekstra"><strong>$row[nama_ekstra]</strong></h4>
                                        </div>
                                        <div class="card-body">
                                            <h6>Pelatih: <strong>$row[nama]</strong></h6>
                                            <h6>Hari: <strong>$row[hari]</strong></h6>
                                            <h6>Waktu: <strong>$waktu</strong></h6>
                                        </div>
                                        <div class="card-footer">
                                            <a href="daftar_ekstra.php?id=$row[id_ekstra]" type="submit" name="submit" class="btn btn-primary my-2 col-12">Daftar</a>
                                        </div>
                                    </div>
                                </div>
                            data;
                        }
                        
                        ?>
                        </div>

                        <div class="modal fade" id="daftarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="dialog">
                                <div class="modal-content">
                                    <form action="" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Daftar Ekstra</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label fw-bold">Nama:</label>
                                                    <?php
                                                        $id = $_SESSION["id_user"];
                                                        $r = $con->query("SELECT * FROM user WHERE id_user=$id");
                                                        $dt = $r->fetch_assoc();
                                                    ?>
                                                    <input type="text" name="ekstra" class="form-control" value="<?php echo $dt['nama'] ?>" readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-bold">Kelas:</label>
                                                    <select name="jurusan" class="custom-select">
                                                    <?php
                                                        $id = $_SESSION["id_user"];
                                                        $r = $con->query("SELECT * FROM jurusan");

                                                        if($r){
                                                            while($dt = mysqli_fetch_assoc($r)){
                                                                echo "<option value='$dt[id_jurusan]'>$dt[jurusan]</option>";
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <label class="form-label fw-bold">Nama Ekstrakurikuler:</label>
                                                    <select name="ekstra1" class="custom-select">
                                                        <?php
                                                            $sq = "SELECT * FROM ekstra";
                                                            $re = mysqli_query($con,$sq);

                                                            if($re){
                                                                while($dt = mysqli_fetch_assoc($re)){
                                                                    echo "<option value='$dt[id_ekstra]'>$dt[nama_ekstra]</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <label class="form-label fw-bold">Nama Ekstrakurikuler:</label>
                                                    <select name="ekstra2" class="custom-select">
                                                        <?php
                                                            $sq = "SELECT * FROM ekstra";
                                                            $re = mysqli_query($con,$sq);

                                                            if($re){
                                                                while($dt = mysqli_fetch_assoc($re)){
                                                                    echo "<option value='$dt[id_ekstra]'>$dt[nama_ekstra]</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="action" value="add">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php
                        }
                    ?>

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