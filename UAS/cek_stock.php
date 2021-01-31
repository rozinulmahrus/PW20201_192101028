<?php
    include_once("config.php");
?>
<html>
<head>
    <title>Logitik LKS</title>
</head>
<body>
    <h3>DATA LOGISTIK LEMBAR KERJA SISWA (LKS)</h3>
    <h4>Programmer : Muhammad Rozinul Mahrus</h4>
    <br>
    <font size= 4 color="blue"> | <a href="input_stock.php">Input Stock</a> | <a href="distribusi.php">Distribusi</a> | <a href="cek_stock.php" style="text-decoration: none">Cek Stock</a> |</font>
    <br>
    <h4>Cek Stock</h4>
        <table border='1' style='border-collapse: collapse'>
            <tr>
                <td>No</td>
                <td>Kelas</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Nilai Persediaan</td>
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
                </tr>

            <?php
                $no++;
                }
                }
            ?>
        </table>
</body>
</html>