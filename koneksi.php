<?php 
$koneksi = mysqli_connect("localhost", "root", "", "karyawansi_1");

if (mysqli_connect_errno()) {
	echo "koneksi gagal " . mysql_connect_error();
}
 ?>