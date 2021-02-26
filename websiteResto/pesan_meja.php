<?php

session_start();

if (!isset( $_SESSION['id_user'])) {
    header("Location: /websiteResto/login.php");
    exit();
} 
?>

<!DOCTYPE html>
<html>
    <head>
        <!--lanjut bikin link login/sign up dan benerin button biar bisa di insert ke DB-->
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
            <a href="/websiteResto/log_out.php" style="float:right;">Log Out</a>
        </div>

        <div class="leftKolum">
            <h2>Pilihlah salah satu meja yang sesuai dengan kebutuhna anda.</h2>
        </div>
        <div class="rightKolum">
                
                <?php
                
                $serverName = "localhost";
                $userName = "root";
                $password = "root";
                $dbName = "resto";
                $nomorMeja = $kapasitasMeja = $nama = "";
                $data = array("2", "4", "2", "4", "2", "4", "2", "4", "2");

                $conn = new mysqli($serverName, $userName, $password, $dbName);

                if($conn->connect_error){
                     
                    echo "<script type='text/javascript'>alert(\"Koneksi gagal \".
                    $conn->connect_error)</script>";
                }

                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    $nomorMeja = (int)$_POST['button1'];
                    $kapasitasMeja = (int)$data[$nomorMeja - 1];
                    $nama = $_SESSION['id_user'];

                    $sql = "INSERT INTO pesan_data (nama_pemesan, kapasitasMeja, nomorMeja)
                    VALUES ('$nama', '$kapasitasMeja', '$nomorMeja')";
                    $result = $conn->query($sql);
 
                    if($conn->query($sql) == true){
                        echo "<script type='text/javascript'>alert(\"Meja nomor $nomorMeja 
                        berhasil dipesan atas nama $nama.\")</script>";
                    }else{
                        echo "<script type='text/javascript'>alert(\"Ada kesalahan dalam penyimpanan DATABASE.
                         \n Error: \" . $sql . \"<br>\" . $conn->error;)</script>";                          
                    }
                }        
                
                $conn->close();
                ?>

                <form action="" method="post">
                
                    <button name="button1" class="button" id="meja1" value="1">meja 1(2 kursi)</button>
                    <button name="button1" class="button" id="meja2" value="2">meja 2(4 kursi)</button>
                    <button name="button1" class="button" id="meja3" value="3">meja 3(2 kursi)</button>
                    <br /><br />
               
                    <button name="button1" class="button" id="meja4">meja 4(4 kursi)</button>
                    <button name="button1" class="button" id="meja5">meja 5(2 kursi)</button>
                    <button name="button1" class="button" id="meja6">meja 6(4 kursi)</button>
                    <br /><br />
                    <button name="button1" class="button" id="meja7">meja 7(2 kursi)</button>
                    <button name="button1" class="button" id="meja8">meja 8(4 kursi)</button>
                    <button name="button1" class="button" id="meja9">meja 9(2 kursi)</button>
                
                </form>
                <?php
                    $serverName = "localhost";
                    $userName = "root";
                    $password = "root";
                    $dbName = "resto";

                    $conn = new mysqli($serverName, $userName, $password, $dbName);

                    if($conn->connect_error){
                        echo "Koneksi gagal ".$conn->connect_error; 
                    }

                    function cariDataMeja(){
                        global $conn;
                        $sql = "SELECT nomorMeja FROM pesan_data";
                        $result = $conn->query($sql);
                        $simpan = "";

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $simpan .= $row['nomorMeja'];
                                $simpan .= " ";
                            }
                        }
                        return $simpan;
                    }                   

                    function mejaPenuh($data){
                        $dataFix = explode(" ", $data);
                        $tmp = "";
                        for($i = 0; $i < count($dataFix); $i++){
                            $tmp = "meja".$dataFix[$i];
                            //wajib naruh javascript di bagian paling bawah; nggak tau kenapa
                            //PERHATIKAN gak ada tanda STRIP " - "
                            echo 
                            "<script>
                              document.getElementById(\"$tmp\").style.backgroundColor = \"#f44336\";
                              document.getElementById(\"$tmp\").style.borderColor = \"#f44336\";
                              document.getElementById(\"$tmp\").style.color = \"white\";
                            </script>";
                            $tmp = "";
                        }
                    }
                    mejaPenuh(cariDataMeja())."";
                    $conn->close();
                ?>
        </div>

        <div class = "row" >
            <div class="footer">
                <p>Footer</p>
            </div>
        </div>
    </body>
</html>