<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";
//menangkap $_GET["id"]
$id = $_GET["id"];
$staff = showData("SELECT * FROM tb_staff WHERE idstaff='$id'")[0];

if (isset($_POST["ubah"])) {
    if (ubahData($_POST) > 0) {
        echo "
                <script>
                    alert('Data berhasil diubah!');
                    window.location.href = 'index.php';
                </script>
            ";
    } else {
        // echo "
        //         <script>
        //             alert('Data gagal diubah!');
        //         </script>
        //     ";
        echo mysqli_error($conn);
    }
}
?>


<!doctype html>
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

    <title>Form ubah data | PHP</title>
    <style>
    .container {
        height: 950px;
    }

    h3 {
        font-family: 'Yanone Kaffeesatz', sans-serif;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="d-flex justify-content-center mt-3">Formulir ubah data</h3>
            <div class="col-md-3 mt-2">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="fotoLama" id="fotoLama" value="<?= $staff['foto'] ?>">
                    <div class="mb-3">
                        <label for="idstaff" class="form-label">Id Staff</label>
                        <input type="text" class="form-control" id="idstaff" name="idstaff" required autofocus
                            autocomplete="off" value="<?= $staff["idstaff"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="snama" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="snama" name="nama" required autocomplete="off"
                            value="<?= $staff["snama"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sgaji" class="form-label">Gaji</label>
                        <input type="text" class="form-control" id="sgaji" name="gaji" required
                            value="<?= $staff["sgaji"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jenkel" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenkel" name="jenkel" aria-label="Default select example"
                            required>
                            <option selected>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tmplhr" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tmplhr" name="tmplhr" required
                            value="<?= $staff["tmplhr"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tgllhr" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tgllhr" name="tgllhr" required
                            value="<?= $staff["tgllhr"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sdivisi" class="form-label">Divisi</label>
                        <input type="text" class="form-control" id="sdivisi" name="divisi" required
                            value="<?= $staff["sdivisi"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <div class="foto mb-2">
                            <img src="img/<?= $staff["foto"] ?>" width="60" height="60" class="rounded"
                                alt="<?= $staff["foto"] ?>">
                        </div>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>
                    <div class="row gx-5 mt-4">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-success btn-sm" name="ubah">Ubah</button>
                        </div>
                        <div class="col-md-4">
                            <a href="index.php" class="btn btn-sm btn-danger">Batal</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>