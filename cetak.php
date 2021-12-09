<?php

require "functions.php";
require_once "dompdf/autoload.inc.php";

$staff = showData("SELECT * FROM tb_staff");
$html = "
            <!DOTYPE html>
            <body>
                <h2>Daftar Staff</h2>
                <table border='1' cellpadding='10' cellspacing='0'>
                <tr>
                    <th>No.</th>
                    <th>IdStaff</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Gaji</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Divisi</th>
                </tr> ";


$i = 1;
foreach ($staff as $stf) {
    $html .= '<tr>
                <td>' . $i++ . '</td>
                <td>' . $stf["idstaff"] . '</td>
                <td><img src="img/' . $stf["foto"] . '" width="50"></td>
                <td>' . $stf["snama"] . '</td>
                <td>' . $stf["sgaji"] . '</td>
                <td>' . $stf["jenkel"] . '</td>
                <td>' . $stf["tmplhr"] . '</td>
                <td>' . $stf["tgllhr"] . '</td>
                <td>' . $stf["sdivisi"] . '</td>
            </tr>';
}

$html .= "      </table>
            </body>
            </html>
        ";


use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("data_staff");