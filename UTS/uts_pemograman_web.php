<?php error_reporting(0)?>
<html>
    <head>
        <title>Nusantara Computer Center</title>
    </head>
    <style>
        h2, h3{
            text-align: center;
        }
    </style>
    <script>
        function hide() {
            document.getElementById("output").style.display = "none";
        }
       
    </script>
    <body>
        <h2>NUSANTARA COMPUTER CENTER</h2>
        <div class="root">
            <form action="" method="POST" style='width: 100%'>
               <table>
                   <tr>
                       <td><label>Nama</label></td>
                       <td><label>:</label></td>
                       <td><input type="text" name='nama' required></input></td>
                       <td style='width: 30px'></td>
                   </tr>
                   <tr>
                       <td><label>Kode Pendaftaran</label></td>
                       <td><label>:</label></td>
                       <td>
                           <select name="kode_pendaftaran" id="" required>
                               <option value="" disabled selected>Pilih</option>
                               <option value="VBSK00108">VBSK00108</option>
                               <option value="DPSJ00210">DPSJ00210</option>
                               <option value="LXSM10105">LXSM10105</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td><label>Kelas</label></td>
                       <td><label>:</label></td>
                       <td>
                           <select name="kelas" id="" required>
                                <option value="" disabled selected>Pilih</option>
                                <option value="Reguler">Reguler</option>
                                <option value="Private">Private</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td><label>Jumlah Peserta</label></td>
                       <td><label>:</label></td>
                       <td><input type="number" name='peserta' required></input></td>
                       <td style='width: 60px'><label>orang</label></td>
                       <td><label>Jumlah Pertemuan</label></td>
                       <td><label>:</label></td>
                       <td><input type="number" name='pertemuan' required></input></td>

                   </tr>
                   <tr>
                       <td><label>Hasil Test Awal</label></td>
                       <td><label>:</label></td>
                       <td>
                           <select name="hasil" id="" required>
                               <option value="" disabled selected>Pilih</option>
                               <option value="A">Grade A</option>
                               <option value="B">Grade B</option>
                               <option value="C">Grade C</option>
                           </select>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           <button type="submit" id='proses' onclick="show()">Proses</>
                           <button type="submit" id='hapus' onclick="hide()">Hapus</>
                        </td>
                   </tr>    
               </table>
               <br><br>
               <div id="output">
                   <b>Output:</b>
                   <h2>NUSANTARA COMPUTER CENTER</h2>
                   <h3>Kode Pendaftaran: <?php echo $_POST["kode_pendaftaran"]?></h3>
                   <table>
                       <tr>
                           <td>Nama</td>
                           <td>:</td>
                           <td><?php echo $_POST["nama"];?></td>
                           <td style="width: 20px"></td>
                           <td>Jenis Kursus</td>
                           <td>:</td>
                           <td>
                               <?php
                                    if(substr($_POST["kode_pendaftaran"], 0, 2) == "VB"){
                                        echo "Visual Basic";
                                    }elseif(substr($_POST["kode_pendaftaran"], 0, 2) == "DP"){
                                        echo "Delphi";
                                    }elseif(substr($_POST["kode_pendaftaran"], 0, 2) == "LX"){
                                        echo "Linux";
                                    }
                               ?>
                           </td>
                       </tr>
                       <tr>
                           <td>Kelas</td>
                           <td>:</td>
                           <td><?php echo $_POST["kelas"];?></td>
                           <td style="width: 20px"></td>
                           <td>No. Urut</td>
                           <td>:</td>
                           <td>
                                <?php
                                   echo substr($_POST["kode_pendaftaran"], 4, 3);
                                ?>
                           </td>
                       </tr>
                       <tr>
                           <td>Hasil Test Awal</td>
                           <td>:</td>
                           <td><?php echo $_POST["hasil"];?></td>
                           <td style="width: 20px"></td>
                           <td>Hari</td>
                           <td>:</td>
                           <td>
                                <?php
                                    if(substr($_POST["kode_pendaftaran"], 3, 1) == "K"){
                                        echo "Kamis";
                                    }elseif(substr($_POST["kode_pendaftaran"], 3, 1) == "J"){
                                        echo "Jumat";
                                    }elseif(substr($_POST["kode_pendaftaran"], 3, 1) == "M"){
                                        echo "Minggu";
                                    }
                               ?>
                           </td>
                       </tr>
                       <tr>
                           <td>Jumlah Peserta</td>
                           <td>:</td>
                           <td><?php echo $_POST["peserta"];?></td>
                           <td style="width: 20px"></td>
                           <td>Jumlah Pertemuan</td>
                           <td>:</td>
                           <td><?php echo $_POST["pertemuan"];?></td>
                       </tr>
                       <tr>
                           <td>Biaya Kursus</td>
                           <td>:</td>
                           <td>
                                <?php
                                    $biaya_kursus = 0;
                                    if(substr($_POST["kode_pendaftaran"], 0, 2) == "VB"){
                                        $biaya_kursus = 750000;
                                        echo "750000";
                                    }elseif(substr($_POST["kode_pendaftaran"], 0, 2) == "DP"){
                                        $biaya_kursus = 650000;
                                        echo "650000";
                                    }elseif(substr($_POST["kode_pendaftaran"], 0, 2) == "LX"){
                                        $biaya_kursus = 800000;
                                        echo "800000";
                                    }
                               ?>
                           </td>
                           <td style="width: 20px"></td>
                           <td>Biaya Tambahan</td>
                           <td>:</td>
                           <td>
                                <?php
                                    $biaya_tambahan = 0;
                                    if($_POST["kelas"] == "Reguler" && $_POST['peserta'] <= 10){
                                        $biaya_tambahan = 50000;
                                        echo 50000;
                                    }else if($_POST["kelas"] == "Reguler" && $_POST['peserta'] > 10){
                                        echo 0 ;
                                    }elseif($_POST["kelas"] == "Private" && $_POST['peserta'] > 5){
                                        $biaya_tambahan = 75000;
                                        echo 75000;
                                    }elseif($_POST["kelas"] == "Private" && $_POST['peserta'] <= 5){
                                        $biaya_tambahan = 200000;
                                        echo 200000 ;
                                    }
                               ?>
                           </td>
                       </tr>
                       <tr>
                           <td>Biaya Subsidi</td>
                           <td>:</td>
                           <td>
                                <?php
                                    $subsidi = 0;
                                    if($_POST["hasil"] == "A"){
                                        $subsidi = (5*$biaya_kursus)/100;
                                        echo $subsidi;
                                    }elseif($_POST["hasil"] == "B"){
                                        $subsidi = (2*$biaya_kursus)/100;
                                        echo $subsidi;
                                    }elseif($_POST["hasil"] == "C"){
                                        echo "tidak dapat subsidi";
                                    }
                               ?>
                           </td>
                           <td style="width: 20px"></td>
                           <td>Biaya Yang Dibayar</td>
                           <td>:</td>
                           <td>
                               <?php
                                    $bayar = ($biaya_kursus + $biaya_tambahan) - $subsidi;
                                    echo $bayar;
                               ?>
                           </td>
                       </tr>
                   </table>
               </div>
            </form>
        </div>
    </body>
</html>