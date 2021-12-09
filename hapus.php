<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";

//menangkap id dari URL
$id = $_GET["id"];

if (hapusData($id) > 0) {
    echo "
                <script>
                    alert('Data berhasil dihapus!');
                    window.location.href = 'index.php';
                </script>
            ";
} else {
    // echo "
    //         <script>
    //             alert('Data gagal dihapus!');
    //         </script>
    //     ";
    echo mysqli_error($conn);
}