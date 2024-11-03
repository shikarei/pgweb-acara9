<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM pgweb_7b WHERE id = $id";
$result = $conn->query($sql);

// Periksa apakah data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan";
    exit();
}

// Update data ketika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    $sql_update = "UPDATE pgweb_7b SET kecamatan='$kecamatan', longitude='$longitude', latitude='$latitude', luas='$luas', jumlah_penduduk='$jumlah_penduduk' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data berhasil diperbarui";
        header("Location: index.php"); // Redirect ke halaman utama setelah update
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI';
            background-color: #ffffff;
            color: #330078;
        }

        .container {
            font-family: 'Segoe UI';
            max-width: 600px;
            background-color: #bddcff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            font-family: 'Segoe UI';
            color: #330078;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            color: #330078;
            font-weight: 500
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #330078;
        }

        .form-control:focus {
            border-color: #9fbbfc;
            box-shadow: 0 0 5px rgba(74, 105, 189, 0.3);
        }

        .btn-primary {
            background-color: #330078;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0fefff;
        }

        .btn-secondary {
            background-color: #2b0066;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #0fefff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Data Kecamatan</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $row['longitude']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $row['latitude']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="luas" class="form-label">Luas</label>
                <input type="text" class="form-control" id="luas" name="luas" value="<?php echo $row['luas']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_penduduk" class="form-label">Jumlah Penduduk</label>
                <input type="text" class="form-control" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo $row['jumlah_penduduk']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>
