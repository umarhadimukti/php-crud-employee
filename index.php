<?php
session_start();
require "functions.php";
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

//pagination
$jumlahDataPerHalaman = 5;
$jumlahData = count(showData("SELECT * FROM tb_staff"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : "1";
//jika $jumlahDataPerHalaman = 2 maka:
//halaman1 = 0,1 => awal datanya 0
//halaman2 = 2,3 => awal datanya 2
//halaman3 = 4,5 => awal datanya 4
//halaman4 = 6 => awal datanya 6
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$staff = showData("SELECT * FROM tb_staff LIMIT $awalData, $jumlahDataPerHalaman");
$numRows = count($staff);

if (isset($_POST["search"])) {
    $staff = cariData($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500&family=Yanone+Kaffeesatz:wght@500&display=swap"
        rel="stylesheet">
    <!-- source jquery & js -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>

    <title>Create of CRUD | PHP</title>

    <style>
    .tbody {
        cursor: pointer;
    }

    .jdl {
        font-family: 'Yanone Kaffeesatz', sans-serif;
    }

    .btn-dark:hover {
        background-color: #330066;
    }

    .container {
        padding: 20px;
    }

    .logout {
        margin-left: 130px;
    }

    .pagination {
        margin-left: 110px;
    }

    /* .contain {
        width: 270px;
        margin: 10px 110px;
    } */

    .loader {
        width: 100px;
        position: absolute;
        top: -2px;
        left: 240px;
        z-index: -1;
        display: none;
    }

    .print {
        margin-left: 5px;
    }

    @media print {

        .logout,
        .tambah,
        .aksi,
        .aksi-col,
        .pagination,
        .input-group {
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="jdl">Tabel Staff</h3>
            </div>

            <div class="col-md-2">
                <a href="logout.php" class="logout btn btn-danger badge btn-sm justify-content-end mt-3"
                    onclick="return confirm('Anda yakin ingin logout?');">Logout</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="tambah.php" class="tambah btn btn-success btn-sm mb-3 shadow-sm">Data Baru (+)</a>
                <a href="cetak.php" class="btn btn-primary badge print" target="_blank">Cetak</a>
                <div class="col-md-3">
                    <form action="" method="POST">
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" class="form-control" id="keyword" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" placeholder="Cari data staff" name="keyword"
                                autofocus autocomplete="off">
                            <img src="img/loader.gif" class="loader" alt="loader">
                            <button type="submit" class="btn btn-dark input-group-btn shadow-sm" name="search"
                                id="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- awal contain -->
        <div class="contain">
        </div>
        <!-- akhir contain -->

        <!-- navigasi -->
        <?php if (!isset($_POST["search"])) : ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm">
                <?php if ($halamanAktif > 1) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                <li class="page-item active dark"><a class="page-link success" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                </li>
                <?php else : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                <?php endif; ?>
                <?php endfor; ?>

                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
        <!-- akhir navigasi -->

        <!-- awal table -->
        <div class="row justify-content-center mt-4 tbl">
            <div class="col-md-10">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Id Staff</th>
                            <th scope="col" class="d-flex justify-content-center">Foto</th>
                            <th scope="col">Nama Staff</th>
                            <th scope="col" class="d-flex justify-content-center">Gaji</th>
                            <th scope="col">Jenkel</th>
                            <th scope="col">Tempat Lahir</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Divisi</th>
                            <th scope="col" class="aksi-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php $i = 1; ?>
                        <?php foreach ($staff as $stf) : ?>
                        <tr onclick="return window.location.href = 'ubah.php?id='+<?= $stf['idstaff'] ?>">
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $stf["idstaff"]; ?></td>
                            <td>
                                <img src="img/<?= $stf["foto"] ?>" alt="<?= $stf["foto"] ?>" width="50" height="50">
                            </td>
                            <td><?= $stf["snama"]; ?></td>
                            <td><?= $stf["sgaji"]; ?></td>
                            <td><?= $stf["jenkel"]; ?></td>
                            <td><?= $stf["tmplhr"]; ?></td>
                            <td><?= $stf["tgllhr"]; ?></td>
                            <td><?= $stf["sdivisi"]; ?></td>
                            <td class="aksi">
                                <a href="ubah.php?id=<?= $stf["idstaff"] ?>" class="btn btn-success badge">ubah</a>
                                <a href="hapus.php?id=<?= $stf["idstaff"] ?>" class="btn btn-danger badge"
                                    onclick="return confirm('Yakin ingin menghapus data <?= $stf['snama'] ?>?')">hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- akhir table -->

    </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>