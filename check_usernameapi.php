<?php
include 'database2.php'; // Koneksi ke database2

class Controller
{
    public function handleRequest()
    {
        // Cek apakah request datang dengan metode POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Cek apakah permintaan datang dari API (dengan format JSON)
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['username']) && isset($data['ticketId'])) {
                // Menangani permintaan API
                $this->processAPIRequest($data['username'], $data['ticketId']);
            } else {
                // Jika data tidak lengkap
                echo json_encode([
                    'status' => 'error',
                    'message' => "Data tidak lengkap."
                ]);
            }
        } else {
            // Menangani permintaan untuk tampilan biasa jika diperlukan
            $this->renderView();
        }
    }

    private function processAPIRequest($username, $ticketId)
    {
        global $conn; // Pastikan koneksi ke database tersedia

        // Query untuk mencari user berdasarkan username dan mengambil ultah dari tabel tbl_perguruan_tinggi
        $stmt = $conn->prepare("SELECT u.kode_pt, pt.ultah, pt.nama_pts FROM user_lists u JOIN tbl_perguruan_tinggi pt ON u.kode_pt = pt.kd_pts WHERE u.username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Cek apakah hari ini adalah ulang tahun pengguna
            $today = date('m-d');
            $birthday = date('m-d', strtotime($user['ultah'])); // Format ulang tanggal ulang tahun
            $kampus = substr($user['nama_pts'], 0, 30);  // Mengambil 30 karakter pertama dari nama_pts
            
            // Ambil data tiket dari database
            include 'database.php';
            $stmtTicket = $conn->prepare("SELECT harga FROM rute WHERE id = :ticketId");
            $stmtTicket->execute(['ticketId' => $ticketId]);
            $ticket = $stmtTicket->fetch(PDO::FETCH_ASSOC);

            if ($ticket) {
                $price = $ticket['harga'];

                // Siapkan data untuk respon JSON
                $response = [];

                // Jika hari ini adalah ulang tahun pengguna
                if ($today == $birthday) {
                    $discountedPrice = $price * 0.9; // Terapkan diskon 10%
                    $response['status'] = 'success';
                    $response['message'] = "Selamat Ulang Tahun untuk $kampus! Anda mendapatkan diskon 10%.";
                    $response['discounted_price'] = number_format($discountedPrice, 0, ',', '.');
                } else {
                    // Tidak ada diskon, harga normal
                    $response['status'] = 'success';
                    $response['message'] = "Harga tiket normal! Rp " . number_format($price, 0, ',', '.');
                }

                echo json_encode($response); // Kirim respons dalam format JSON
            } else {
                // Tiket tidak ditemukan
                echo json_encode([
                    'status' => 'error',
                    'message' => "Tiket tidak ditemukan."
                ]);
            }
        } else {
            // Username tidak ditemukan
            echo json_encode([
                'status' => 'error',
                'message' => "Username tidak ditemukan."
            ]);
        }
    }

    private function renderView()
    {
        // Menangani tampilan biasa (misalnya untuk halaman HTML)
        global $conn;

        // Contoh data untuk pengujian tampilan biasa
        $username = 'user123'; // Ganti dengan input yang relevan
        $ticketId = 1;         // Ganti dengan ID tiket yang relevan

        // Query untuk mencari user berdasarkan username dan mengambil ultah dari tabel tbl_perguruan_tinggi
        $stmt = $conn->prepare("SELECT u.kode_pt, pt.ultah, pt.nama_pts FROM user_lists u JOIN tbl_perguruan_tinggi pt ON u.kode_pt = pt.kd_pts WHERE u.username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Cek apakah hari ini adalah ulang tahun pengguna
            $today = date('m-d');
            $birthday = date('m-d', strtotime($user['ultah'])); // Format ulang tanggal ulang tahun
            $kampus = substr($user['nama_pts'], 0, 30);  // Mengambil 30 karakter pertama dari nama_pts

            // Ambil data tiket dari database
            include 'database.php';
            $stmtTicket = $conn->prepare("SELECT harga FROM rute WHERE id = :ticketId");
            $stmtTicket->execute(['ticketId' => $ticketId]);
            $ticket = $stmtTicket->fetch(PDO::FETCH_ASSOC);

            if ($ticket) {
                $price = $ticket['harga'];

                // Siapkan data untuk tampilan
                $response = [];

                // Jika hari ini adalah ulang tahun pengguna
                if ($today == $birthday) {
                    $discountedPrice = $price * 0.95; // Terapkan diskon 10%
                    $response['status'] = 'success';
                    $response['message'] = "Selamat Ulang Tahun untuk $kampus! Anda mendapatkan diskon 10%.";
                    $response['discounted_price'] = number_format($discountedPrice, 0, ',', '.');
                } else {
                    // Tidak ada diskon, harga normal
                    $response['status'] = 'success';
                    $response['message'] = "Harga tiket normal! Rp " . number_format($price, 0, ',', '.');
                }

                // Tampilkan hasil pada halaman HTML
                echo "<h3>{$response['message']}</h3>";
                if (isset($response['discounted_price'])) {
                    echo "<p>Harga tiket setelah diskon: Rp {$response['discounted_price']}</p>";
                } else {
                    echo "<p>Harga tiket: Rp {$price}</p>";
                }
            } else {
                echo "<p>Tiket tidak ditemukan.</p>";
            }
        } else {
            // Username tidak ditemukan
            echo "<p>Username tidak ditemukan.</p>";
        }
    }
}

// Inisialisasi controller dan menangani request
$controller = new Controller();
$controller->handleRequest();
?>
