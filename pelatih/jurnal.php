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

        $id = $_SESSION["id_user"];
        
        $r = $con->query("SELECT * FROM ekstra JOIN pelatih_ekstra ON ekstra.id_ekstra = pelatih_ekstra.id_ekstra WHERE id_user= '$id'");
        $pe = $r->fetch_assoc();

        $idekstra = $pe['id_ekstra'];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST['tambah'])){
                $ekstra = $_POST["ekstra"];
                $judul = $_POST["judul"];
                $desk = $_POST["deskripsi"];

                $q = "INSERT INTO `jurnal`(`id_user`, `id_ekstra`, `ekstrakulikuler`, `judul`, `deskripsi`) VALUES ('$id','$idekstra','$ekstra','$judul','$desk')";
                $r = mysqli_query($con,$q);
                alert('success','Berhasil menambahkan jurnal');
            }
        }

        if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $query = "DELETE FROM jurnal WHERE id_jurnal=$id";
            $result = mysqli_query($con, $query);
            alert('success','Berhasil menghapus jurnal');
        }

    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pelatih - Jurnal</title>

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
            <li class="nav-item active">
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
                        <h1 class="h3 mb-0 text-gray-800">Pengisian Jurnal</h1>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <div class=""></div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#jurnalModal">
                            <i class="fas fa-plus-square"></i> Tambah
                        </button>
                    </div>

                    <div class="modal fade" id="jurnalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Buat Jurnal</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-3">
                                                <label>Ekstrakurikuler</label>
                                                <?php
                                                    $id = $_SESSION["id_user"];
                                                    $r = $con->query("SELECT nama_ekstra FROM ekstra JOIN pelatih_ekstra 
                                                        ON ekstra.id_ekstra = pelatih_ekstra.id_ekstra WHERE id_user=$id");
                                                    $nm = $r->fetch_assoc();
                                                ?>
                                                <input type="text" name="ekstra" class="form-control" value="<?php echo $nm['nama_ekstra'] ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label>Judul</label>
                                                <input type="text" name="judul" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12 mb-3">
                                                <label>Deskripsi</label>
                                                <textarea name="deskripsi" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-white" style="background-color: #024040;">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ekstrakurikuler</th>
                                <th scope="col" style="width: 200px;">Tanggal</th>
                                <th scope="col">Judul</th>
                                <th scope="col" style="width: 500px;">Deskripsi</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT j.*, e.nama_ekstra
                                    FROM jurnal j
                                    JOIN pelatih_ekstra pe ON j.id_user = pe.id_user
                                    JOIN ekstra e ON pe.id_ekstra = e.id_ekstra
                                    WHERE pe.id_user = $id";
                                    $res = mysqli_query($con,$sql);

                                    $i=1;
                                    if($res){
                                        while($data = mysqli_fetch_assoc($res)){
                                            $tanggal = date("d F Y",strtotime($data['tanggal']));
                                            echo<<<res
                                                <tr>
                                                <td>$i</td>
                                                <td>$data[ekstrakulikuler]</td>
                                                <td>$tanggal</td>
                                                <td>$data[judul]</td>
                                                <td>$data[deskripsi]</td>
                                                <td><a href="edit_jurnal.php?id=$data[id_jurnal]" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="jurnal.php?action=delete&id=$data[id_jurnal]" class="btn btn-sm btn-danger">Hapus</a></td>
                                                </tr>
                                            res;
                                            $i++;
                                            // <a href="edit_jurnal.php?id=$data[id_jurnal]" class="btn btn-sm btn-warning">Edit</a>
                                            
                                        }
                                    } else {
                                        echo "Tidak ada data.";
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