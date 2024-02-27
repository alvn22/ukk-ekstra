<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
        
        session_start();
        require('../config.php');
        require('../essentials.php');

        if(!isset($_SESSION['id_user'])){
            redirect('../index.php');
        } else if ($_SESSION['role'] !== 'Kesiswaan'){
            redirect('../index.php');
        }

        // tambah ekstra
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
            if($_POST["action"] == "add"){
                $nama_ekstra = $_POST["nama_ekstra"];
                $hari = $_POST["hari"];
                $waktu = $_POST["waktu"];

                $sql = "SELECT * FROM ekstra WHERE nama_ekstra = '$nama_ekstra'";
                $res = mysqli_query($con,$sql);
                $ray = mysqli_fetch_assoc($res);

                if(!empty($ray['nama_ekstra'])){
                    alert('error', 'Ekstra sudah terdaftar!');
                } else {
                    $q = "INSERT INTO ekstra (nama_ekstra, hari, waktu) VALUES ('$nama_ekstra','$hari','$waktu')";
                    $r = mysqli_query($con,$q);
                    alert('success','Ekstrakurikuler berhasil ditambahkan');
                }
            }
        }

        if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql_pelatih = "SELECT * FROM pelatih_ekstra p JOIN ekstra e ON p.id_ekstra = e.id_ekstra WHERE p.id_ekstra = '$id'";
            $res_pelatih = mysqli_query($con,$sql_pelatih);
            $ray1 = mysqli_fetch_assoc($res_pelatih);

            $sql_jurnal = "SELECT * FROM jurnal j JOIN ekstra e ON j.id_ekstra = e.id_ekstra WHERE j.id_ekstra = '$id'";
            $res_jurnal = mysqli_query($con,$sql_jurnal);
            $ray2 = mysqli_fetch_assoc($res_jurnal);

            $sql_diikuti = "SELECT * FROM ekstra_diikuti d JOIN ekstra e ON d.id_ekstra = e.id_ekstra WHERE d.id_ekstra = '$id'";
            $res_diikuti = mysqli_query($con,$sql_diikuti);
            $ray3 = mysqli_fetch_assoc($res_diikuti);

            if(!empty($ray2['id_ekstra'])){
                alert('error', 'Ekstra masih ada jurnal!');
            } elseif(!empty($ray3['id_ekstra'])){
                alert('error', 'Ada murid yang mendaftar ekstra!');
            } elseif(!empty($ray1['id_ekstra'])){
                alert('error', 'Ekstra masih ada pelatih!');
            } else {
                $q = "DELETE FROM ekstra WHERE id_ekstra=$id";
                $r = mysqli_query($con, $q);
                alert('success','Ekstrakurikuler berhasil dihapus!');
            }

        }

        // read data
        $q = "SELECT * FROM ekstra";
        $r = mysqli_query($con,$q);

        if(!$r){
            echo "Error: " . mysqli_error($con);
        }

    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kesiswaan - Ekstrakurikuler</title>

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
                <a class="nav-link" href="user.php">
                <i class="fas fa-users-cog"></i>
                <span>User</span></a>
            </li>
            <li class="nav-item active">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-puzzle-piece mx-1"></i>
                    <span>Ekstrakurikuler</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Ekstra:</h6>
                        <a class="collapse-item" href="ekstra.php">Kelola Ekstra</a>
                        <a class="collapse-item" href="pelatih.php">Pelatih</a>
                        </div>
                </div>
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Ekstrakurikuler</h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h5>
                            <!-- <span class="badge bg-danger text-light">
                            Pastikan tidak ada murid yang terdaftar serta menghapus pelatih<br> ekstrakulikuler dan jurnal sebelum menghapus ekstrakulikuler!
                            </span> -->
                        </h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#ekstraModal">
                            <i class="fas fa-plus-square"></i> Tambah
                        </button>
                    </div>

                    <div class="modal fade" id="ekstraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Ekstrakurikuler</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <label class="form-label fw-bold">Nama Ekstrakurikuler:</label>
                                                <input type="text" name="nama_ekstra" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label fw-bold">Waktu:</label>
                                                <input type="time" name="waktu" class="form-control shadow-none" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label class="form-label fw-bold">Hari:</label>
                                                <select class="custom-select" name="hari">
                                                <option value="Senin">Senin</option>
                                                <option value="Selasa">Selasa</option>
                                                <option value="Rabu">Rabu</option>
                                                <option value="Kamis">Kamis</option>
                                                <option value="Jumat">Jumat</option>
                                                <option value="Sabtu">Sabtu</option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-8 mt-2">
                                                <label class="form-label fw-bold">Pelatih:</label>
                                                <select class="custom-select" name="pelatih"> -->
                                                <?php
                                                    // $sql = "SELECT * FROM user WHERE `role`='Pelatih'";
                                                    // $res = mysqli_query($con,$sql);

                                                    // if($res){
                                                    //     while($data = mysqli_fetch_assoc($res)){
                                                    //         echo "<option value='$data[nama]'>$data[nama]</option>";
                                                    //     }
                                                    // } else {
                                                    //     echo "Data tidak ada.";
                                                    // }
                                                ?>
                                                <!-- </select>
                                            </div> -->
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-white" style="background-color: #024040;">
                                <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Nama Ekstrakurikuler</th>
                                <!-- <th scope="col">Nama Pelatih</th> -->
                                <th scope="col">Hari</th>
                                <th scope="col" style="width: 250px;">Jam Ekstrakurikuler</th>
                                <th scope="col" style="width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=1;
                                    if($r){
                                        while($row = mysqli_fetch_assoc($r)){
                                            echo "<tr>";
                                            echo "<td>$i</td>";
                                            echo "<td>$row[nama_ekstra]</td>";
                                            // echo "<td>$row[nama_pelatih]</td>";
                                            echo "<td>$row[hari]</td>";
                                            echo "<td>$row[waktu]</td>";
                                            echo "<td><a href='edit_ekstra.php?id=$row[id_ekstra]' class='btn btn-sm btn-warning'>Edit</a>
                                            <a href='ekstra.php?action=delete&id={$row['id_ekstra']}' class='btn btn-sm btn-danger'>Hapus</a></td>";
                                            echo "</tr>";
                                            $i++;
                                            // <a href='edit_ekstra.php?id=$row[id_ekstra]' class='btn btn-sm btn-warning'>Edit</a>
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php $row = mysqli_fetch_assoc($r) ?>
                    

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