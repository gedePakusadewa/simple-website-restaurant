<?php

    session_start(); // Starting Session
    
    if (isset( $_SESSION['id_user'])) {
        header("Location: /websiteResto/pesan_meja.php");
        exit();
    }else{
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_POST['nama']) || empty($_POST['pass'])) {
                //$error = "Username or Password nggak boleh kosong";
                echo "<script type='text/javascript'>alert(\"username dan password tidak
                boleh kosong.\");</script>";
            }else{
                // Define $username and $password
                $usernameLogin = $_POST['nama'];
                $passwordLogin = $_POST['pass'];

                $serverName = "localhost";
                $userName = "root";
                $password = "root";
                $dbName = "resto";
                
                // Establishing Connection with Server by passing server_name, user_id and password as a parameter
                $conn = new mysqli($serverName, $userName, $password, $dbName);
                if($conn->connect_error){
                    echo "<script type='text/javascript'>alert(\"Koneksi gagal \".
                        $conn->connect_error);</script>";
                }

                // To protect MySQL injection for Security purpose
                $usernameLogin = stripslashes($usernameLogin);
                $passwordLogin = stripslashes($passwordLogin);
                $usernameLogin = mysqli_real_escape_string($conn, $usernameLogin);
                $passwordLogin = mysqli_real_escape_string($conn, $passwordLogin);

                // SQL query to fetch information of registerd users and finds user match.
                $sql = "SELECT nama_pelanggan, password_pelanggan FROM pelanggan";
                $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            if(($row['nama_pelanggan'] == $usernameLogin) && 
                            ($row['password_pelanggan'] == $passwordLogin)  ){

                                $_SESSION['id_user'] = $row['nama_pelanggan']; // Initializing Session
                                header("Location: /websiteResto/pesan_meja.php"); // Redirecting To Other Page
                                exit();
                                break;
                            }
                        }
                    }else{
                        echo "<script type='text/javascript'>alert(\"Kesalaha 
                        di pencocokan nama dan password.\");</script>";
                    }
                $conn->close(); // Closing Connection
            }
        }
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
            <a href="/websiteResto/login.php">Pesan Meja</a>
            <a href="/websiteResto/tentang_kami.php">Tentang Kami</a>
        </div>

        <div class="row">
            <div>
            
                <?php
                /*
                //lanjut beberas login dan bikin buat sign up
                $namaErr = $passErr = "";
                $namar = $pass = "";
                $cekNama = $cekPass = false;

                $serverName = "localhost";
                $userName = "root";
                $password = "root";
                $dbName = "resto";

                $conn = new mysqli($serverName, $userName, $password, $dbName);

                if($conn->connect_error){
                    echo "Koneksi gagal ".$conn->connect_error; 
                }

                function validasiNama($data1){
                    global $conn;
                    $data = $data1;
                    $sql = "SELECT nama_pelanggan FROM pelanggan";
                    $ready = false;
                    $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            if($row['nama_pelanggan'] == $data){
                                $ready = true;
                                break;
                            }
                        }
                    }
                    return $ready;
                }

                function validasiPass($data1){                
                    global $conn;
                    $data = $data1;
                    $sql = "SELECT password_pelanggan FROM pelanggan";
                    $ready = false;
                    $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            if($row['password_pelanggan'] == $data){
                                $ready = true;
                                break;
                            }
                        }
                    }
                    return $ready;
                }

                if($_SERVER['REQUEST_METHOD']=="POST"){
                    
                    //BAGIAN NAMA
                    if(empty($_POST['nama'])){
                        $namaErr = "Username nggak boleh kosong";
                    }elseif(validasiNama($_POST['nama']) == true){
                        $cekNama = true;
                    }else{
                        $namaErr = "Anda salah memasukkan nomer";
                    }
                    
                    //bagian PASS
                    if(empty($_POST['pass'])){
                        $passErr = "pass harus diisi";
                    }elseif(validasiPass($_POST['pass']) == true){
                        $cekPass = true;
                    }else{
                        $passErr = "Anda salah memasukan password";
                    }
                }        
                
                $conn->close();
                
                if($cekNama == true && $cekPass == true){
                    $myFile = fopen("pesan.txt", "a+") or die ("file nggak ada");
                    $text = $name." |+| ".$email." |+| ".$pesan." |+| ";
                    fwrite($myFile, $text);
                    fclose($myFile);
                    
                    header ("Location: /websiteResto/pesan_meja.php");
                    exit();
                }   
                */                 
            ?>
            
            <form action="" method="post">
            Username : <input type="text" name="nama" />
            <span class="merahError">*<?php //echo $namaErr; ?></span><br /><br />
            PASSWORD:<input type="text" name="pass" />
            <span class="merahError">*<?php //echo $passErr; ?></span><br />
            
            <input type="submit" value="MASUK" />
            
            </form>
            <br /><br />
            <a href="/websiteResto/sign-up.php"><button>SIGN UP</button></a>
            </div>
        </div>

        <div class = "row" >
            <div class="footer">
                <p>Footer</p>
            </div>
        </div>
    </body>
</html>