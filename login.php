<?php
require "functions.php";
session_start();

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash("sha256", $row["username"])) {
        $_SESSION["login"] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        //mengambil data dari $result
        $row = mysqli_fetch_assoc($result);

        //verifikasi password, jika input password === password yang ada
        if (password_verify($password, $row["password"])) {

            //set session
            $_SESSION["login"] = true;

            //apakah remember me di ceklis?
            if (isset($_POST["remember"])) {
                setcookie("id", $row["id"], time() + 3600);
                setcookie("key", hash("sha256", $row["username"]), time() + 3600);
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true;
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

    <title>Halaman Login</title>
    <style>
    .err {
        color: red;
    }

    .akun-baru {
        color: green;

    }

    .akun-baru:hover {
        color: green
    }

    .login {
        padding-right: 15px;
        padding-left: 15px;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <h3 class="text-center mt-3 mb-4">Login Akun</h3>
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
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <!-- Jika $error true -->
                    <?php if (isset($error)) : ?>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="fw-light err"><small>Username atau Password Salah!</small></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="login btn btn-sm btn-primary" name="login">Login</button>
                        </div>
                        <div class="col-md-9 justify-content-end d-flex">
                            <p class="fw-light"><small>Belum punya akun? <a href="registrasi.php"
                                        class="akun-baru fw-normal">Buat Akun</a></small></p>
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