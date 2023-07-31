<?php
$servername = "localhost";
$username = "id20975908_aldatabase";
$password = "MYdatabase1999!";
$dbname = "id20975908_aldatabase";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM Casting";
$result = $conn->query($sql);

// Cek apakah ada data yang diambil
if ($result->num_rows > 0) {
    // Membuat array kosong untuk menyimpan data
    $data = array();

    // Mengambil setiap baris data dan menyimpannya ke dalam array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Mengkonversi data menjadi format JSON dan mengirimkannya sebagai respons
    echo json_encode($data);
} else {
    // Jika tidak ada data, kirimkan pesan kosong
    echo "Data tidak ditemukan.";
}

// Tutup koneksi ke database
$conn->close();
?>
