<?php
session_start(); 
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    
    $id_karyawan = $_POST['id_karyawan'];
    $username = $_POST['username'];
    $password = ($_POST['password']);
    $nama = $_POST['nama'];
    $tmp_tgl_lahir = $_POST['tmp_tgl_lahir'];
    $jenkel = $_POST['jenkel'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $no_tel = $_POST['no_tel'];
    $jabatan = $_POST['jabatan'];

    //untuk gambar
    $foto     = $_FILES['foto']['name'];
    $tmp      = $_FILES['foto']['tmp_name'];
    $fotobaru = date('dmYHis').$foto;
    $path     = "images/".$fotobaru;

    // Memeriksa apakah NIP terdiri dari 9 karakter angka
    if(strlen($id_karyawan) != 9 || !ctype_digit($id_karyawan)){
        echo "<script>alert('NIP harus terdiri dari 9 karakter angka.')</script>";
        echo "<script>window.location.href = \"datakaryawan.php\"</script>";
        // Menghentikan eksekusi skrip jika validasi gagal
    } else {
        // Memeriksa apakah NIP sudah ada dalam database
        $sql = "SELECT * FROM tb_karyawan WHERE id_karyawan = '".$id_karyawan."'";
        $tambah = mysqli_query($koneksi, $sql);

        if ($row = mysqli_fetch_row($tambah)) {
            echo "<script>alert('Data Dengan NIP = ".$id_karyawan." sudah ada')</script>";
            echo "<script>window.location.href = \"datakaryawan.php\"</script>";
            // Menghentikan eksekusi skrip setelah menampilkan pesan kesalahan
        } else {
            // Memeriksa apakah username sudah ada dalam database
            $sql_username = "SELECT * FROM tb_karyawan WHERE username = '".$username."'";
            $result_username = mysqli_query($koneksi, $sql_username);

            if (mysqli_num_rows($result_username) > 0) {
                echo "<script>alert('Username sudah ada')</script>";
                echo "<script>window.location.href = \"datakaryawan.php\"</script>";
                exit(); // Menghentikan eksekusi skrip jika username sudah ada
            }

            // Pindahkan file foto ke direktori upload
            if (move_uploaded_file($tmp, $path)) {
                // Lakukan operasi penyimpanan data ke database
                $query = "INSERT INTO tb_karyawan set id_karyawan='$id_karyawan', username='$username', password='$password', nama='$nama', tmp_tgl_lahir='$tmp_tgl_lahir', jenkel='$jenkel', agama='$agama', alamat='$alamat', no_tel='$no_tel', jabatan='$jabatan', foto='$fotobaru'";
                mysqli_query($koneksi, $query);

                // Redirect ke halaman data karyawan setelah penyimpanan berhasil
                header("location: datakaryawan.php");
                // Menghentikan eksekusi skrip setelah melakukan redirect
            } else {
                echo "Gagal mengunggah file.";
            }
        }
    }
}
?>
