<?php
require_once('koneksi.php');
if ((isset($_POST['key'])) && ($_POST['key'] == "api")) {
    $loginUsername = $_POST['username'];
    $password = $_POST['password'];

    $LoginRS__query = sprintf("SELECT id, username, password FROM tb_user WHERE  username=%s AND password=%s", 
    app($koneksi, $loginUsername, "text"), 
    app($koneksi, $password, "text"));
    $LoginRS = mysqli_query($koneksi, $LoginRS__query) or die(mysqli_error($koneksi));
    $row_rs_LoginRS = mysqli_fetch_assoc($LoginRS);
    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser) {
        $response['kode'] = 1;
        $response['pesan'] = "Selamat!! Anda Berhasil Login";
        $response['halaman'] = "Dashboard";

        //--- tambahan pada toturial selanjutnya
        $response['data'] = array();
        $no = 1;
        foreach ($LoginRS as $row_rs_LoginRS) {
            $Data['id'] = $row_rs_LoginRS['id'];
            $Data['username'] = $row_rs_LoginRS['username'];
            $Data['password'] = $row_rs_LoginRS['password'];
            array_push($response['data'], $Data);
            $no++;
        }
        //---
    } else {
        $response['kode'] = 0;
        $response['pesan'] = "Oops!! Login Gagal";
        $response['halaman'] = "Login";
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}