<?php
$servername = "localhost";
$username = "id20975908_aldatabase";
$password = "MYdatabase1999!";
$dbname = "id20975908_aldatabase";

$maxRetries = 5; // Jumlah maksimum percobaan ulang
$retryDelay = 2; // Waktu jeda (detik) sebelum percobaan ulang

try {
    // Buat koneksi ke database menggunakan PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set error mode ke Exception agar bisa menangkap kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fungsi untuk melakukan pengiriman data ke database
    function sendDataToDatabase($conn, $formattedDate, $formattedTime, $cycleTime) {
        global $maxRetries, $retryDelay;

        $sql = "INSERT INTO Casting (Date, Time, Cycle_s) VALUES (:date, :time, :cycle)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $formattedDate);
        $stmt->bindParam(':time', $formattedTime);
        $stmt->bindParam(':cycle', $cycleTime);

        $retryCount = 0;
        while ($retryCount <= $maxRetries) {
            try {
                $stmt->execute();
                echo "Data berhasil disimpan ke dalam database.";
                return; // Keluar dari fungsi jika pengiriman berhasil
            } catch (PDOException $e) {
                $retryCount++;
                if ($retryCount <= $maxRetries) {
                    echo "Gagal menyimpan data. Melakukan percobaan ulang ke-" . $retryCount . "<br>";
                    sleep($retryDelay);
                } else {
                    echo "Gagal menyimpan data setelah " . $maxRetries . " percobaan.";
                    return;
                }
            }
        }
    }

    // Menerima data dari program Wemos
    $formattedDate = $_GET['date'];
    $formattedTime = $_GET['time'];
    $cycleTime = $_GET['cycle'];

    // Lakukan validasi atau manipulasi data sesuai kebutuhan
    // ...

    // Ubah format tanggal dari "d-m-Y" menjadi format "Y-m-d" (format tipe data Date MySQL)
    $formattedDate = date('Y-m-d', strtotime($formattedDate));

    // Panggil fungsi untuk melakukan pengiriman data ke database
    sendDataToDatabase($conn, $formattedDate, $formattedTime, $cycleTime);

} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
} finally {
    // Tutup koneksi ke database
    $conn = null;
}
?>
