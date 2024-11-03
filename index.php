<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet JS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #map {
            width: 100%;
            height: 500px;
            margin-bottom: 20px;
        }

        /* Gaya Umum */
        body {
            font-family: 'Segoe UI';
            background-color: #2b0066;
            font-weight: bold;
            color: #250065;
            text-align: center;
        }

        /* Gaya Tabel */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            font-size: 14px;
            font-weight: bold;
            background-color: #bddcff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid white;
        }

        th {
            background-color: #330078;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #9fbbfc;
        }

        /* Gaya Teks Sukses dan Gagal */
        .message {
            margin: 8px auto;
            width: 80%;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        /* Gaya Tombol Hapus */
        a {
            color: #ff004c;
            text-decoration: none;
            font-weight: bold;
        }

        tr:hover {
            background-color: #0fefff;
        }

        button {
            padding: 5px 10px;
            background-color: #800042;
            color: #0fefff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #ff004c;
        }
    </style>
</head>

<body>

    <main>
        <div class="container border border-primary rounded">

            <div class="alert alert-primary text-center h2-bold" role="alert">
                <h2>DAERAH ISTIMEWA YOGYAKARTA</h2>
                <h3>Informasi Kependudukan</h3>
            </div>

            <div class="card mt-3">
                <div class="card-header alert alert-primary text-center">
                    <h4 id="peta">ヾ(≧▽≦ )\ ===[[ Peta ]]=== (〃￣︶￣)/</h4>
                </div>
                <div class="card-body">
                    <div class="mapouter">
                        <div id="map"></div>

                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

                        <script>
                            // Inisialisasi peta
                            var map = L.map("map").setView([-7.774835, 110.374301], 10);

                            // Tile Layer Base Map
                            var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            });

                            // Menambahkan basemap ke dalam peta
                            osm.addTo(map);
                        </script>

                        <script>
                            <?php
                            // Sesuaikan dengan setting MySQL
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "pgweb8";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Menghapus data jika ada parameter hapus
                            if (isset($_GET['hapus'])) {
                                $id_hapus = $_GET['hapus'];
                                $sql_hapus = "DELETE FROM pgweb_7b WHERE id = $id_hapus";
                                if ($conn->query($sql_hapus) === TRUE) {
                                    echo "alert('Data dengan ID $id_hapus berhasil dihapus.');";
                                } else {
                                    echo "alert('Error: " . $conn->error . "');";
                                }
                            }

                            // Query data
                            $sql = "SELECT * FROM pgweb_7b";
                            $result = $conn->query($sql);

                            // Menambahkan marker pada peta
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $long = $row["longitude"];
                                    $lat = $row["latitude"];
                                    $kec = $row["kecamatan"];

                                    echo "L.marker([$lat, $long], {
    icon: L.icon({
        iconUrl: 'icon/leaf-red.png', // Ganti dengan path ke gambar ikon Anda
        iconSize: [32, 80], // Ukuran ikon (sesuaikan sesuai kebutuhan)
        iconAnchor: [32, 80], // Posisi titik jangkar, biasanya di tengah bawah
        popupAnchor: [0, -32] // Posisi popup relatif terhadap ikon
    })
}).addTo(map).bindPopup('$kec');
;\n";
                                }
                            } else {
                                echo "console.log('0 results');";
                            }
                            ?>
                        </script>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header alert alert-primary text-center">
                    <h4 id="penduduk">ヾ(≧▽≦ )\ ===[[ Penduduk ]]=== (〃￣︶￣)/</h4>
                </div>
                <div class="card-body">
                    <?php
                    // Tabel data dari database
                    if ($result->num_rows > 0) {
                        echo "<table><tr>
                        <th>Id</th>
                        <th>Kecamatan</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Luas</th>
                        <th>Jumlah Penduduk</th>
                        <th>Aksi</th>
                        </tr>";

                        // Output data tiap baris
                        $result->data_seek(0); // Mengembalikan pointer hasil ke baris pertama untuk digunakan kembali
                        while ($row = $result->fetch_assoc()) {
                            echo
                            "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["kecamatan"] . "</td>
                            <td>" . $row["longitude"] . "</td>
                            <td>" . $row["latitude"] . "</td>
                            <td>" . $row["luas"] . "</td>
                            <td>" . $row["jumlah_penduduk"] . "</td>
                            <td>
                            <button type='button' onclick='editData(" . $row["id"] . ")'>Edit</button>
                            <button type='submit' name='delete_id' value='" . $row["id"] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</button>
                            </td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>Tidak ada data</p>";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>

            <script>
                function editData(id) {
                    window.location.href = "edit.php?id=" + id; // Ubah "edit.php" dengan halaman edit Anda
                }
            </script>

        </div>

    </main>





</body>

</html>