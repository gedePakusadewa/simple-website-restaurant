<?php

    session_start(); // Starting Session
    
    if (isset( $_SESSION['id_user'])) {
        header("Location: /websiteResto/pesan_meja.php");
        exit();
    }else{
        //lanjut beberas login dan bikin buat sign up
        $namaErr = $passErr = $emailErr = "";
        $namar = $pass = $email = $message = "";
        $cekNama = $cekPass = $cekEmail = $gagalDB =  false;

        $serverName = "localhost";
        $userName = "root";
        $password = "root";
        $dbName = "resto";

        $conn = new mysqli($serverName, $userName, $password, $dbName);

        if($conn->connect_error){
            echo "Koneksi gagal ".$conn->connect_error; 
        }

        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            if (empty($_POST['nama']) || empty($_POST['pass'])) {
                //$error = "Username or Password nggak boleh kosong";
                echo "<script type='text/javascript'>alert(\"username dan password tidak
                boleh kosong.\");</script>";
            }else{
                $nama = $_POST['nama'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                $sql = "INSERT INTO pelanggan (nama_pelanggan, password_pelanggan,
                email_pelanggan) VALUES ('$nama', '$pass', '$email')";
                if($conn->query($sql) == true){
                    $_SESSION['id_user'] = $nama;
                    header ("Location: /websiteResto/pesan_meja.php");
                    exit();
                }else{
                    $gagalDB = true;
                    $message = "Ada kesalahan dalam penyimpanan DATABASE. \n".
                    "Error: " . $sql . "<br>" . $conn->error;                            
                }
            }
        }
        $conn->close();
    }
?>


<!DOCTYPE html>
<html>
    <head>
        
        <title>RESTOSAN SATU</title>
        <meta charset="utf-8" />
        <meta name="description" content="halaman utama website RESTORAN SATU" />
        <meta name="keywords" content="website, restora, tempat makan, makan, warung, murah" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="css_resto.css" />
    </head>
    <body>
        
        <div class="header">
        <h1>Resto Satu</h1>
        <h5>Salah satu resto terbaik di ubud.</h5>
        </div>

        <div class="topnav">
            <a href="/websiteResto/index.php">Beranda</a>
            <a href="/websiteResto/sign-up.php">Pesan Meja</a>
            <a href="/websiteResto/tentang_kami.php">Tentang Kami</a>
            
        </div>

        <div class="row">
            
                <form action="" method="post">
                Username : <input type="text" name="nama"  />
                <span class="merahErr">*<?php //echo $namaErr; ?></span><br /><br />
                E-mail : <input type="text" name="email" />
                <span class="merahErr">*<?php //echo $emailErr; ?></span><br /><br />
                PASSWORD:<input type="text" name="pass" />
                <span class="merahErr">*<?php //echo $passErr; ?></span><br />
                
                <input type="submit" value="DAFTAR" />
                
                </form>
        </div>

        <div class = "row" >
            <div class="footer">
                <p>Footer</p>
            </div>
        </div>
    </body>
</html>