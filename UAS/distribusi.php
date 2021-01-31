<?php
    include_once("config.php");

    if(isset($_GET['hapus'])){
        $id = $_GET['id'];
        $jumlah = $_GET['jumlah'];        
        $kelas = $_GET['kelas'];        

        $sql = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE kelas = $kelas");
        $row = mysqli_fetch_assoc($sql);

        $jumlah_baru = $row['jumlah'] + $jumlah;
        $persediaan_baru = $row['harga'] * $jumlah_baru;
        $update = mysqli_query($mysqli, "UPDATE tbl_stock SET kelas ='$kelas', jumlah='$jumlah_baru', harga='$row[harga]', persediaan='$persediaan_baru' WHERE kelas=$kelas") or die ("data salah : ".mysqli_error($mysqli));


        $sql = "DELETE FROM tbl_distribusi WHERE id=$id";

        if (mysqli_query($mysqli, $sql) === TRUE && $update == TRUE) {
            echo "<script>alert('Data berhasil dihapus')</script>";
        } else {
            echo "<script>alert('Gagall delete: '. $mysqli->error)</script>";
        }
        echo '<script>window.location = "distribusi.php"</script>';
    }

    if(isset($_GET['edit'])){
        $id = $_GET['id'];
        
    
        $result = mysqli_query($mysqli, "SELECT * FROM tbl_distribusi WHERE id=$id");        
        while($data = mysqli_fetch_array($result))
        {
            $nama_sekolah = $data['nama_sekolah'];
            $kelas = $data['kelas'];
            $jumlah = $data['jumlah'];
        }
    }

    if(isset($_POST['update']))
    {
        $id = $_GET['id'];
        $jumlah_lama = $_GET['jumlah'];
        $kelas_lama = $_GET['kelas'];
        
        $nama_sekolah = $_POST['sekolah'];
        $kelas = $_POST['kelas'];
        $jumlah = $_POST['jumlah'];

        $sql = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE kelas = $kelas");
        $row = mysqli_fetch_assoc($sql);
        
        if (!empty($row)) {
            if($row['jumlah'] == 0){
                echo "<script>alert('Stok habis')</script>";
            }elseif($row['jumlah'] < $jumlah){
                echo "<script>alert('Jumlah yang anda masukkan melebihi stok yang ada')</script>";
            }else{
                if($kelas != $kelas_lama){
                    $sql = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE kelas = $kelas_lama");
                    $rows = mysqli_fetch_assoc($sql);
                    if($jumlah_lama > $jumlah){
                        $jumlah_count = ($jumlah);
                        $jumlah_baru = $row['jumlah'] - $jumlah_count;
                    }else{
                        $jumlah_count = ($jumlah - $jumlah_lama) + $jumlah_lama;
                        $jumlah_baru = $row['jumlah'] - $jumlah_count;
                    }
                    $jumlah_kelas_lama = $rows['jumlah'] + $jumlah_lama;
                    $persediaan_kelas_lama = $row['harga'] * $jumlah_kelas_lama;
                    $persediaan_baru = $jumlah_baru * $row['harga'];
                    // print_r($jumlah_baru);
                    // print_r($jumlah_baru);
                    $result = mysqli_query($mysqli, "UPDATE tbl_distribusi SET kelas ='$kelas', jumlah='$jumlah', nama_sekolah='$nama_sekolah' WHERE id=$id");
                    $update1 = mysqli_query($mysqli, "UPDATE tbl_stock SET jumlah='$jumlah_kelas_lama', persediaan='$persediaan_kelas_lama' WHERE kelas=$kelas_lama") or die ("data salah : ".mysqli_error($mysqli));
                    $update2 = mysqli_query($mysqli, "UPDATE tbl_stock SET jumlah='$jumlah_baru', persediaan='$persediaan_baru' WHERE kelas=$kelas") or die ("data salah : ".mysqli_error($mysqli));
                    if ($result == TRUE && $update1 == TRUE && $update2 == TRUE) {
                        echo "<script>alert('Berhasil Disimpan')</script>";
                    }else{
                        echo "<script>alert('Gagal Tersimpan')</script>";
                    }
                }else{
                    if($jumlah_lama > $jumlah){
                        $jumlah_count = $jumlah_lama - $jumlah;
                        $jumlah_baru = $row['jumlah'] + $jumlah_count;
                    }else{
                        $jumlah_count = $jumlah - $jumlah_lama;
                        $jumlah_baru = $row['jumlah'] - $jumlah_count;
                    }
                    // print_r($jumlah_baru);
                    $persediaan_baru = $row['harga'] * $jumlah_baru;
                    $result = mysqli_query($mysqli, "UPDATE tbl_distribusi SET kelas ='$kelas', jumlah='$jumlah', nama_sekolah='$nama_sekolah' WHERE id=$id");
                    $update = mysqli_query($mysqli, "UPDATE tbl_stock SET jumlah='$jumlah_baru', persediaan='$persediaan_baru' WHERE kelas=$kelas") or die ("data salah : ".mysqli_error($mysqli));
                    if ($result == TRUE && $update) {
                        echo "<script>alert('Berhasil Disimpan')</script>";
                    }else{
                        echo "<script>alert('Gagal Tersimpan')</script>";
                    }
                }
            }
        }else{
            echo "<script>alert('Stok kelas $kelas belum terdaftar')</script>";
        }
        echo '<script>window.location = "distribusi.php"</script>';
    }

    if (isset($_POST['Submit'])) {
        $kelas = $_POST['kelas'];
        $jumlah = $_POST['jumlah'];
        $sekolah = $_POST['sekolah'];
		if ($kelas == "" || $jumlah == "" || $sekolah == "") {
			echo "<script>alert('Data Tidak Boleh Ada Yang Kosong')</script>";
		}else{
            $sql = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE kelas = $kelas");
            $row = mysqli_fetch_assoc($sql);
            if (!empty($row)) {
                if($row['jumlah'] == 0){
                    echo "<script>alert('Stok habis')</script>";
                }elseif($row['jumlah'] < $jumlah){
                    echo "<script>alert('Jumlah yang anda masukkan melebihi stok yang ada')</script>";
                }else{
                    $jumlah_baru = $row['jumlah'] - $jumlah;
                    $persediaan_baru = $row['harga'] * $jumlah_baru;
                    $simpan = mysqli_query($mysqli, "INSERT INTO tbl_distribusi SET nama_sekolah ='$sekolah', jumlah='$jumlah', kelas='$kelas'") or die ("data salah : ".mysqli_error($mysqli));
                    $update = mysqli_query($mysqli, "UPDATE tbl_stock SET kelas ='$kelas', jumlah='$jumlah_baru', harga='$row[harga]', persediaan='$persediaan_baru' WHERE kelas=$kelas") or die ("data salah : ".mysqli_error($mysqli));
                    if ($simpan == TRUE && $update == TRUE) {
                        echo "<script>alert('Berhasil Disimpan')</script>";
                    }else{
                        echo "<script>alert('Gagal Tersimpan')</script>";
                    }
                }
            }else{
                echo "<script>alert('Stok kelas $kelas belum terdaftar')</script>";
            }
        }
        echo '<script>window.location = "distribusi.php"</script>';
	}
?>
<html>
<head>
    <title>Logitik LKS</title>
</head>
<body>
    <h3>DATA LOGISTIK LEMBAR KERJA SISWA (LKS)</h3>
    <h4>Programmer : Muhammad Rozinul Mahrus</h4>
    <br>
    <font size= 4 color="blue"> | <a href="input_stock.php">Input Stock</a> | <a href="distribusi.php" style="text-decoration: none">Distribusi</a> | <a href="cek_stock.php">Cek Stock</a> |</font>
    <br>
    <h4>Distribusi LKS</h4>
    <form method="post">
    <table>
        <tr>
            <td>Nama Sekolah</td>
            <td>:</td>
            <td><input type="text" name="sekolah" required="" value="<?php if(isset($_GET['id'])){echo $nama_sekolah;}?>"></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>
                <input type="radio" name='kelas' value='1' <?php if(isset($_GET['edit'])){echo $kelas == '1' ? "checked" : "";} ?>>1
                <input type="radio" name='kelas' value='2' <?php if(isset($_GET['edit'])){echo $kelas == '2' ? "checked" : "";} ?>>2
                <input type="radio" name='kelas' value='3' <?php if(isset($_GET['edit'])){echo $kelas == '3' ? "checked" : "";} ?>>3
                <input type="radio" name='kelas' value='4' <?php if(isset($_GET['edit'])){echo $kelas == '4' ? "checked" : "";} ?>>4
                <input type="radio" name='kelas' value='5' <?php if(isset($_GET['edit'])){echo $kelas == '5' ? "checked" : "";} ?>>5
                <input type="radio" name='kelas' value='6' <?php if(isset($_GET['edit'])){echo $kelas == '6' ? "checked" : "";} ?>>6
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>:</td>
            <td><input type="text" name="jumlah" required="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php if(isset($_GET['edit'])){echo $jumlah;}?>"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <?php if (isset($_GET['edit'])) { ?>
                <input type="submit" name="update" value="Update" class="btn">
                <?php }else{ ?> 
                <input type="submit" name="Submit" value="Simpan" class="btn">
                <?php }	 ?>
            </td>
        </tr>
    </table>
    <br>
    <h4>Data Distribusi</h4>
    <table border='1' style='border-collapse: collapse'>
        <tr>
            <td>No</td>
            <td>Nama Sekolah</td>
            <td>Kelas</td>
            <td>Jumlah</td>
            <td>Action</td>
        </tr>
        <?php
            $no=1;
            $result = mysqli_query($mysqli, "SELECT * FROM tbl_distribusi ORDER BY id ASC");
            if(mysqli_num_rows($result) < 1 ){
        ?>
            <tr>
                <td colspan=6 style='text-align: center'>Tidak ada data</td>
            </tr>
        <?php
            }else{  
                while($data = mysqli_fetch_array($result)) {    
        ?> 
            <tr>
                <td><?php echo $no?></td>
                <td><?php echo $data['nama_sekolah']?></td>
                <td><?php echo $data['kelas']?></td>
                <td><?php echo ($data['jumlah'])?></td>
                <td style="text-align: center;">
                    <a onclick="return confirm('Apakah yakin data akan di hapus?')" href="?hapus&id=<?php echo $data['id']?>&jumlah=<?php echo $data['jumlah']?>&kelas=<?php echo $data['kelas']?>" class="btn btn-danger btn-sm">Hapus | </span></a>
                    <a href="?edit&id=<?php echo $data['id'];?>&jumlah=<?php echo $data['jumlah']?>&kelas=<?php echo $data['kelas']?>" class="btn btn-success btn-sm">Edit</a>
                </td>
            </tr>
        <?php
                $no++;
                }
            }
        ?>
    </table>
    </form>
</body>
</html>