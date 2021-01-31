<?php
    include_once("config.php");

    if(isset($_GET['hapus'])){
        $id = $_GET['id'];

        if (mysqli_query($mysqli, "DELETE FROM tbl_stock WHERE id=$id") === TRUE) {
            echo "<script>alert('Data berhasil dihapus')</script>";

        } else {
            echo "<script>alert('Gagall delete: '. $mysqli->error)</script>";
        }
        echo '<script>window.location = "input_stock.php"</script>';
    }

    if(isset($_GET['edit'])){
        $id = $_GET['id'];
    
        $result = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE id=$id");        
        while($data = mysqli_fetch_array($result))
        {
            $kelas = $data['kelas'];
            $jumlah = $data['jumlah'];
            $harga = $data['harga'];
        }
    }

    if(isset($_POST['update']))
    {	
        $id = $_GET['id'];
        
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $persediaan = $_POST['jumlah'] * $_POST['harga'];
            
        $result = mysqli_query($mysqli, "UPDATE tbl_stock SET jumlah='$jumlah', harga='$harga', persediaan='$persediaan' WHERE id=$id");
        if ($result == TRUE) {
            echo "<script>alert('Berhasil Tersimpan')</script>";
        }else{
            echo "<script>alert('Gagal Tersimpan')</script>";
        }
        echo '<script>window.location = "input_stock.php"</script>';
    }

    if (isset($_POST['Submit'])) {
        $kelas = $_POST['kelas'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];   
        $persediaan = $_POST['jumlah'] * $_POST['harga'];
		if ($kelas == "" || $jumlah == "" || $persediaan == "" || $harga == "") {
			echo "<script>alert('Data Tidak Boleh Ada Yang Kosong')</script>";
		}else{
            // $sql = "SELECT * FROM tbl_stock WHERE kelas = $kelas";
            $sql = mysqli_query($mysqli, "SELECT * FROM tbl_stock WHERE kelas = $kelas");
            $row = mysqli_fetch_assoc($sql);
            if (empty($row)) {
                $simpan = mysqli_query($mysqli, "INSERT INTO tbl_stock SET kelas ='$kelas', jumlah='$jumlah', harga='$harga', persediaan='$persediaan'") or die ("data salah : ".mysqli_error($mysqli));
                if ($simpan == TRUE) {
                    echo "<script>alert('Berhasil Disimpan')</script>";
                }else{
                    echo "<script>alert('Gagal Tersimpan')</script>";
                }
            }else{
                echo "<script>alert('Data kelas tersebut sudah ada')</script>";
            }
        }
        echo '<script>window.location = "input_stock.php"</script>';
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
    <font size= 4 color="blue"> | <a href="input_stock.php" style="text-decoration: none">Input Stock</a> | <a href="distribusi.php">Distribusi</a> | <a href="cek_stock.php">Cek Stock</a> |</font>
    <br>
    <h4>Form Input Stock LKS</h4>
    <form method="post">
    <table>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>
                <select name="kelas" required="" <?php if(isset($_GET['edit'])){echo 'disabled';}?>>
                    <option value="" selected disabled>Semua</option>
                    <option value="1" <?php if(isset($_GET['edit'])){echo $kelas == '1' ? "selected" : "";} ?>>1</option>
                    <option value="2" <?php if(isset($_GET['edit'])){echo $kelas == '2' ? "selected" : "";} ?>>2</option>
                    <option value="3" <?php if(isset($_GET['edit'])){echo $kelas == '3' ? "selected" : "";} ?>>3</option>
                    <option value="4" <?php if(isset($_GET['edit'])){echo $kelas == '4' ? "selected" : "";} ?>>4</option>
                    <option value="5" <?php if(isset($_GET['edit'])){echo $kelas == '5' ? "selected" : "";} ?>>5</option>
                    <option value="6" <?php if(isset($_GET['edit'])){echo $kelas == '6' ? "selected" : "";} ?>>6</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>:</td>
            <td><input type="text" name="jumlah" required="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php if(isset($_GET['edit'])){echo $jumlah;}?>"></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td>:</td>
            <td><input type="text" name="harga" required="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php if(isset($_GET['edit'])){echo $harga;}?>"></td>
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
    <h4>Data Stock LKS</h4>
        <table border='1' style='border-collapse: collapse'>
            <tr>
                <td>No</td>
                <td>Kelas</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Nilai Persediaan</td>
                <td>Action</td>
            </tr>
            <?php
                $no=1;
                $result = mysqli_query($mysqli, "SELECT * FROM tbl_stock ORDER BY id ASC");
                if(mysqli_num_rows($result) < 1 ){
            ?>
                <tr>
                    <td colspan=6 style='text-align: center'>Tidak ada data</td>
                </tr>
            <?php
                }else{
                $sumJumlah = 0;
                $sumTotal = 0;
                while($data = mysqli_fetch_array($result)) {         
                    $sumJumlah += $data['jumlah'];
                    $sumTotal += $data['persediaan'];
            ?>
                <tr>
                    <td><?php echo $no?></td>
                    <td><?php echo $data['kelas']?></td>
                    <td><?php echo number_format($data['jumlah'])?></td>
                    <td><?php echo number_format($data['harga'])?></td>
                    <td><?php echo number_format($data['persediaan'])?></td>
                    <td style="text-align: center;">
                        <a onclick="return confirm('Apakah yakin data akan di hapus?')" href="?hapus&id=<?php echo $data['id'];?>" class="btn btn-danger btn-sm" style="text-decoration: none">Hapus | </span></a>
                        <a href="?edit&id=<?php echo $data['id'];?>" class="btn btn-success btn-sm" style="text-decoration: none">Edit </a>
                    </td>
                </tr>

            <?php
                $no++;
                }
                }
            ?>
        </table>
        <table> 
            <?php
                $resultLKS = mysqli_query($mysqli, 'SELECT SUM(jumlah) AS JumlahLks FROM tbl_stock'); 
                $rowLKS = mysqli_fetch_assoc($resultLKS); 
                $SumJumlahLks = $rowLKS['JumlahLks'];

                $resultPersediaan = mysqli_query($mysqli, 'SELECT SUM(persediaan) AS NilaiPersediaan FROM tbl_stock'); 
                $rowPersediaan = mysqli_fetch_assoc($resultPersediaan); 
                $SumNilaiPersediaan = $rowPersediaan['NilaiPersediaan'];
            ?>
            <tr>
                <td><b>Jumlah LKS Seluruh</b></td>
                <td><b> : </b></td>
                <td><b><?php echo $SumJumlahLks?></b></td>
            </tr>
            <tr>
                <td><b>Total Nilai Persediaan</b></td>
                <td><b> : </b></td>
                <td><b><?php echo number_format($SumNilaiPersediaan) ?></b></td>
            </tr>
        </table>
    </form>
</body>
</html>