<?php
require "functions.php";
if (isset($_POST["daftar"])) {
    if (registrasi($_POST) > 0) {
        echo "
                <script>
                    alert('Akun sudah berhasil di daftar!');
                    window.location.href = 'login.php';
                    </script>
             ";
    } else {
        // echo "
        //         <script>
        //             alert('Akun gagal terdaftar!');
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

    <title>Halaman Registrasi</title>
    <style>
    .daftar {
        padding-right: 15px;
        padding-left: 15px;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <h3 class="text-center mt-3 mb-4">Daftar Akun</h3>
            <div class="col-md-3">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                            required autofocus autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="password2" id="password2" required>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="daftar btn btn-sm btn-success" name="daftar">Daftar</button>
                        </div>
                        <div class="col-md-9 justify-content-end d-flex">
                            <p class="fw-light"><small>Sudah punya akun? <a href="login.php"
                                        class="fw-normal">Login</a></small></p>
                        </div>
                    </div>



                </form>
            </div>
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