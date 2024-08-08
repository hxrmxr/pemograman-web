<?php
require_once('koneksi.php');

//INSERT DATA
if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == "oiaya")) {

    $insertSQL = sprintf(
        "INSERT INTO `tb_user` (`nama`, `nohp`, `alamat`,`username`, `password`) VALUES (%s, %s, %s, %s, %s)",
        app($koneksi, $_POST['nama'], "text"),
        app($koneksi, $_POST['nohp'], "text"),
        app($koneksi, $_POST['alamat'], "text"),
        app($koneksi, $_POST['username'], "text"),
        app($koneksi, $_POST['password'], "text")
    );

    $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));


    if ($Result1) {
        $response['kode'] = 1;
        $response['pesan'] = "Data berhasil disimpan";
    } else {
        $response['kode'] = 0;
        $response['pesan'] = "Data gagal disimpan";
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}


//VIEW DATA
if ((isset($_GET['MM_view'])) && ($_GET['MM_view'] == "oiaya")) {
    $id = "-1";
    if (isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $query = sprintf(
    "SELECT * FROM tb_user WHERE id=%s",
    app($koneksi,$id,"int"));
    $data = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    $rs_data = mysqli_fetch_assoc($data);
    $ResultData = mysqli_num_rows($data);

    if ($ResultData > 0) {

        $response['kode'] = 1;
        $response['pesan'] = "Data Tersedia";
        $response['data'] = array();
        foreach ($data as $user) {
            $arr['id'] = $user['id'];
            $arr['nama'] = $user['nama'];
            $arr['nohp'] = $user['nohp'];
            $arr['alamat'] = $user['alamat'];
            array_push($response['data'], $arr);
        }
    } else {
        $response['kode'] = 0;
        $response['pesan'] = "Data tidak ditemukan!";
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}



//EDIT DATA
if ((isset($_POST['MM_update'])) && ($_POST['MM_update'] == "oiaya")) {

    $id = $_POST['id'];
    $cari_query = sprintf(
        "SELECT id FROM tb_user WHERE id=%s",
        app($koneksi, $id, "int")
    );
    $cari = mysqli_query($koneksi, $cari_query) or die(mysqli_error($koneksi));
    $ResultCari = mysqli_num_rows($cari);

    if ($ResultCari > 0) {
        $updateSQL = sprintf(
            "UPDATE `tb_user` SET `nama`=%s,`nohp`=%s,`alamat`=%s WHERE `id`=%s",
            app($koneksi, $_POST['nama'], "text"),
            app($koneksi, $_POST['nohp'], "text"),
            app($koneksi, $_POST['alamat'], "text"),
            app($koneksi, $_POST['id'], "int")
        );

        $Result1 = mysqli_query($koneksi, $updateSQL) or die(mysqli_error($koneksi));

        if ($Result1) {
            $response['kode'] = 1;
            $response['pesan'] = "Data berhasil diubah";
        }
    } else {
        $response['kode'] = 0;
        $response['pesan'] = "ID tidak ditemukan!";
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}

//DELETE DATA
if ((isset($_POST['MM_delete'])) && ($_POST['MM_delete'] == "oiaya")) {

    $id = $_POST['id'];
    $cari_query = sprintf(
        "SELECT id FROM tb_user WHERE id=%s",
        app($koneksi, $id, "int")
    );
    $cari = mysqli_query($koneksi, $cari_query) or die(mysqli_error($koneksi));
    $ResultCari = mysqli_num_rows($cari);

    if ($ResultCari > 0) {

        $deleteSQL = sprintf(
            "DELETE FROM `tb_user` WHERE id = %s",
            app($koneksi, $_POST['id'], "int")
        );

        $Result1 = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error($koneksi));

        if ($Result1) {
            $response['kode'] = 1;
            $response['pesan'] = "Data berhasil dihapus!";
        }
    } else {
        $response['kode'] = 0;
        $response['pesan'] = "ID tidak ditemukan!";
    }


    echo json_encode($response);
    mysqli_close($koneksi);
}
