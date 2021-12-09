<?php
usleep(500000);
require "../functions.php";

$keyword = $_GET["keyword"];
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
$staff = showData($query);
$staffLength = count(showData($query));

?>

<!-- jika isi tabel tb_staff === 0 -->
<?php if ($staffLength === 0) : ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="text-center">
                Data tidak ditemukan!
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- akhir error -->

<?php if ($staffLength > 0) : ?>
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
                    <th scope="col" class="d-flex justify-content-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($staff as $stf) : ?>
                <tr>
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
                    <td>
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
<?php endif; ?>