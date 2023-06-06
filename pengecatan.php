<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengecatan debug</title>
    <style>
    h1, form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 20vh;
        margin: 1 auto;
        text-align: center;
    }

    form input[type="text"],
    form textarea {
        width: 180px;
        padding: 4px;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    table {
        margin: 0 auto;
        border-radius: 10px;
        width: 40%;
    }

    table th,
    table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
    }
    a {
        width: 170px;
        padding: 5px;
        background-color: #7788ee;
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    a {
        text-decoration: none;
    }

    a:hover {
    background-color: #0033ee;
    }

    p {
        margin: 5 auto;
        text-align: center;
        color: black;
    }

    .button {
        border-radius: 10px;
        width: 170px;
        padding: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        margin: 4px 2px;
    } 

    .button:hover {
        background-color: green;
    }

     .lihat {
        width: 170px;
        padding: 5px;
        background-color: #7788ee;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .lihat:hover {
        background-color: #0033ee;
    }
    footer {
        display: flex;
        flex-direction: inherit;
        align-items: center;
        justify-content: center;
        height: 20vh; 
        margin: 1 auto; 
        color: red;
        text-align: center;
    }
    h4 {
        color: black;
    }
    </style>
</head>
<body>
    <?php
        // cek apakah tombol lihat atau daftar di klik
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            // statement process
            if(isset($_POST['lihat'])) {

    ?>
            <h1>Daftar Pengecatan</h1>
            <table>
            <tr>
                <th>tanggal</th>
                <th>panjang</th>
                <th>lebar</th>
                <th>tinggi</th>
                <th>pembayaran</th>
                <th>biaya cat</th>
                <th>biaya tk</th>
                <th>total</th>
            </tr>
            <?php
                $file = 'pengecatan.txt';
                $bukaFile = fopen($file, 'r');
                $tampilFile = fgets($bukaFile);
                
                while(!feof($bukaFile)) {
                    $PengecatanArray = json_decode($tampilFile, true);

                    $tanggal=$PengecatanArray['tanggal'];
                    $bulan=$PengecatanArray['bulan'];
                    $tahun=$PengecatanArray['tahun'];
                    $panjang=$PengecatanArray['panjang'];
                    $lebar=$PengecatanArray['lebar'];
                    $tinggi=$PengecatanArray['tinggi'];
                    $bayar=$PengecatanArray['cara pembayaran'];
                    $biayaCat=$PengecatanArray['biaya cat'];
                    $biayaTenagaKerja=$PengecatanArray['biaya tenaga kerja'];
                    $totalBiaya=$PengecatanArray['total biaya'];
            ?>
            <tr>
                <td><?= $tanggal ?><?= $bulan ?><?= $tahun ?></td>
                <td><?= $panjang ?></td>
                <td><?= $lebar ?></td>
                <td><?= $tinggi ?></td>
                <td><?= $bayar ?></td>
                <td><?= $biayaCat ?></td>
                <td><?= $biayaTenagaKerja ?></td>
                <td><?= $totalBiaya ?></td>
            </tr>
            <?php
                $tampilFile = fgets($bukaFile);
                };
                fclose($bukaFile); 
            ?>
            </table>
            <p><a href="pengecatan.php" class="button">tambah pengecatan</a></p>

            <?php
                } 
                elseif(isset($_POST['tambah'])) 
                {
                    // statement proses
                    $tanggal =$_POST['tanggal'];
                    $bulan =$_POST['bulan'];
                    $tahun =$_POST['tahun'];
                    $panjang =trim($_POST['panjang']);
                    $lebar =trim($_POST['lebar']);
                    $tinggi =trim($_POST['tinggi']);
                    $bayar =$_POST['bayar'];


                    if(empty($panjang) or empty($lebar) or empty($tinggi)) {
                        echo '<h1>gagal divalidasi</h1>';
                        echo '<p>silahkan isi semua dengan benar !</p>';
                        echo '<p><a href="pengecatan.php" class="button">kembali</a></p>';
                        echo '<footer>
                            <h4>made with</h4>❤
                            </footer>';
                        die();
                    };

                    if(!is_numeric($panjang) or !is_numeric($lebar) or !is_numeric($tinggi)
                        or $panjang <0 or $lebar <0 or $tinggi <0) {
                        echo '<h1>gagal divalidasi</h1>';
                        echo '<p>silahkan isi semua dengan benar !</p>';
                        echo '<p>silahkan isi dengan bilangan positif !</p>';
                        echo '<p><a href="pengecatan.php" class="button">kembali</a></p>';
                        echo '<footer>
                            <h4>made with</h4>❤
                            </footer>';
                        die();
                    };

                    $luasTembokPanjang = 2 * $panjang * $tinggi;
                    $luasTembokPendek = 2 * $lebar * $tinggi;
                    $luasLangit = $lebar * $panjang;
                    $luasTotalArea = $luasTembokPanjang + $luasTembokPendek + $luasLangit;
                    $biayaCat = $luasTotalArea /150 * 200000;
                    $biayaTenagaKerja = $luasTotalArea /30 * 20000;
                    $totalBiaya = $biayaCat + $biayaTenagaKerja;


                    // buat aray asociative untuk input user

                    $record = [
                        "tanggal" => $tanggal,
                        "bulan" => $bulan,
                        "tahun" => $tahun,
                        "panjang" => $panjang,
                        "lebar" => $lebar,
                        "tinggi" => $tinggi,
                        "cara pembayaran" => $bayar,
                        "biaya cat" => $biayaCat,
                        "biaya tenaga kerja" => $biayaTenagaKerja,
                        "total biaya" => $totalBiaya
                    ];
                    $jsonRecord=json_encode($record)."\n";

                    $file = 'pengecatan.txt';
                    $bukaFile = fopen($file, "a", true);
                    $tulisFile = fputs($bukaFile, $jsonRecord);

                    if(fclose($bukaFile)) {
                ?>
                    <h1>Catatan Berhasil disimpan</h1>
                    <p>terima kasih !</p>
                    <p>
                        <a href="pengecatan.php" class="button">tambah lagi</a>
                        <!-- belum fix -->
                        <!-- <a href="pengecatan.php" class="button catatan">lihat catatan</a> -->
                    </p>
                <?php 
                    } 
                    else 
                    { 
                ?>
                    <h1>Catatan Gagal disimpan</h1>
                    <p>eror !</p>
                    <p>
                        <a href="pengecatan.php" class="button">ulangi lagi</a>
                        <!-- belum fix -->
                        <!-- <a href="pengecatan.php" class="button catatan">lihat catatan</a> -->
                    </p>
            <?php 
                    }
                }
                
            } else 
            {
            // statement form
            ?>
            <h1>Input Pengecatan</h1>
            <div class="container">
                <form action="pengecatan.php" method="post">
                    <table>
                        <tr>
                            <td><label for="tanggal">Tanggal : </label></td>
                            <td>
                                <select name="tanggal" id="tanggal">
                                    <?php
                                        for($i=1; $i<=31; $i++) {
                                            echo '<option value="' .$i. '">' .$i. '</option>';
                                        }
                                    ?>
                                </select>
                                <select name="bulan" id="bulan">
                                    <option value="januari">januari</option>
                                    <option value="februari">februari</option>
                                    <option value="maret">maret</option>
                                    <option value="april">april</option>
                                    <option value="mei">mei</option>
                                    <option value="juni">juni</option>
                                    <option value="juli">juli</option>
                                    <option value="agustus">agustus</option>
                                    <option value="september">september</option>
                                    <option value="oktober">oktober</option>
                                    <option value="november">november</option>
                                    <option value="desember">desember</option>
                                </select>
                                <select name="tahun" id="tahun">
                                    <?php
                                        for($i=2023; $i<=2030; $i++) {
                                            echo '<option value="' .$i. '">' .$i. '</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="panjang">Panjang : </label></td>
                            <td><input type="text" name="panjang" id="panjang">m</td>
                        </tr>
                        <tr>
                            <td><label for="lebar">Lebar : </label></td>
                            <td><input type="text" name="lebar" id="lebar">m</td>
                        </tr>
                        <tr>
                            <td><label for="tinggi">Tinggi : </label></td>
                            <td><input type="text" name="tinggi" id="tinggi">m</td>
                        </tr>
                        <tr>
                            <td><label for="bayar">Pembayaran : </label></td>
                            <td>
                                <input type="radio" name="bayar" id="tunai" value="tunai" checked>
                                <label for="tunai">Tunai</label>
                                <input type="radio" name="bayar" id="hutang" value="hutang">
                                <label for="hutang">Hutang</label>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="lihat" value="lihat daftar pengecatan" class="button lihat">
                    <input type="submit" name="tambah" value="tambah pengecatan" class="button" >
                </form>
            </div>
    <?php 
        }
    ?>
    <footer>
        <h4>made with</h4>❤
    </footer>
</body>
</html>