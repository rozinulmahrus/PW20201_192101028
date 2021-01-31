<?php
    $host = 'localhost';
    $databaseName = 'db_logistik_lks';
    $databaseUsername = 'root';
    $databasePassword = '';
    
    $mysqli = new mysqli ($host, $databaseUsername, $databasePassword, $databaseName);
    if (mysqli_connect_errno()) {
        echo 'Koneksi gagal dilakukan dengan alasan : '.mysqli_connect_error();
        exit();
        mysqli_close($mysqli);
    } 
?>