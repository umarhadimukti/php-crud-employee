<?php
$conn = mysqli_connect("localhost", "root", "", "db_pabrik");
if (!$conn) {
    die("Cannot connect : " . mysqli_connect_error($conn));
}

function showData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($staff = mysqli_fetch_assoc($result)) {
        $data[] = $staff;
    }
    return $data;
}

function tambahData($data)
{
    global $conn;

    //menangkap seluruh isi data
    $idstaff = htmlspecialchars($data["idstaff"]);
    $snama = htmlspecialchars($data["nama"]);
    $sgaji = htmlspecialchars($data["gaji"]);
    $jenkel = htmlspecialchars($data["jenkel"]);
    $tmplhr = htmlspecialchars($data["tmplhr"]);
    $tgllhr = htmlspecialchars($data["tgllhr"]);
    $sdivisi = htmlspecialchars($data["divisi"]);
    // $foto = htmlspecialchars($data["foto"]);

    //upload gambar
    $foto = uploadFoto();

    if (!$foto) {
        return false;
    }

    //memasukkan query ke dalam variabel
    $query = "INSERT INTO tb_staff VALUES
             ('$idstaff','$snama',$sgaji,'$jenkel','$tmplhr','$tgllhr',$sdivisi,'$foto')
             ";

    //melakukan query
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function uploadFoto()
{
    //menangkap isi variabel $_FILES
    $namaFile = $_FILES["foto"]["name"];
    $ukuranFile = $_FILES["foto"]["size"];
    $tmpName = $_FILES["foto"]["tmp_name"];
    $error = $_FILES["foto"]["error"];

    //cek apakah gambar ada yang diupload atau tidak
    if ($error == 4) {
        echo "
            <script>
                alert('Pilih foto yang ingin di upload dahulu!');
            </script>
        ";
        return false;
    }

    $ekstensiValid = ["jpg", "jpeg", "png", "jfif"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "
            <script>
                alert('hanya bisa mengupload foto / gambar');
            </script>
        ";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "
            <script>
                alert('ukuran foto melebihi 1 mb');
            </script>
        ";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, "img/" . $namaFileBaru);
    return $namaFileBaru;
}

function ubahData($data)
{
    global $conn;
    //menangkap seluruh isi data
    $idstaff = htmlspecialchars($data["idstaff"]);
    $snama = htmlspecialchars($data["nama"]);
    $sgaji = htmlspecialchars($data["gaji"]);
    $jenkel = htmlspecialchars($data["jenkel"]);
    $tmplhr = htmlspecialchars($data["tmplhr"]);
    $tgllhr = htmlspecialchars($data["tgllhr"]);
    $sdivisi = htmlspecialchars($data["divisi"]);
    $fotoLama = htmlspecialchars($data["fotoLama"]);

    //jika tidak ada file yang diupload maka pakai foto lama
    if ($_FILES["foto"] == 4) {
        $foto = $fotoLama;
    } else {
        $foto = uploadFoto();
    }

    if ($_FILES["foto"]["size"] > 1000000) {
        return false;
    }

    $query = "UPDATE tb_staff SET
            idstaff = '$idstaff',
            snama = '$snama',
            sgaji = $sgaji,
            jenkel = '$jenkel',
            tmplhr = '$tmplhr',
            tgllhr = '$tgllhr',
            sdivisi = $sdivisi,
            foto = '$foto'
            WHERE idstaff = '$idstaff'
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusData($id)
{
    global $conn;

    //query hapus baris
    mysqli_query($conn, "DELETE FROM tb_staff WHERE idstaff='$id'");

    return mysqli_affected_rows($conn);
}

function cariData($keyword)
{
    $query = "SELECT * FROM tb_staff
                WHERE
                idstaff LIKE '%$keyword%' OR
                snama LIKE '%$keyword%' OR
                sgaji LIKE '%$keyword%' OR
                jenkel LIKE '%$keyword%' OR
                tmplhr LIKE '%$keyword%' OR
                tgllhr LIKE '%$keyword%' OR
                sdivisi LIKE '%$keyword%'
            ";
    return showData($query);
}

function registrasi($data)
{
    global $conn;

    $email = strtolower(stripslashes($data["username"]));
    $username = strtolower(stripslashes($data["username"]));
    $password =  mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek apakah ada email yang sudah terdaftar
    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('Email sudah terdaftar, silahkan gunakan yang lain!');
            </script>
        ";
        return false;
    }

    //cek apakah ada username username
    $result2 = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result2)) {
        echo "
            <script>
                alert('Username sudah terdaftar, silahkan gunakan yang lain!');
            </script>
        ";
        return false;
    }

    //cek konfirmasi password
    if ($password !== $password2) {
        echo "
                <script>
                    alert('konfirmasi password tidak sesuai!');
                </script>
            ";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //masukkan data ke dalam database
    mysqli_query($conn, "INSERT INTO tb_users VALUES
                ('','$email','$username','$password')
                ");

    return mysqli_affected_rows($conn);
}