<?php
include 'database2.php'; // Koneksi ke database2

class Controller
{
    public function handleRequest()
    {
        // Cek apakah request datang dari API atau tampilan biasa
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Cek apakah permintaan datang dari Postman (untuk API)
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
            // Menangani permintaan tampilan biasa
            $this->renderView();
        }
    }

    private function processAPIRequest($username, $ticketId)
    {
        global $conn; // Pastikan koneksi database tersedia

        // Query untuk mencari user berdasarkan username dan mengambil voucher dari tabel tbl_perguruan_tinggi
        $stmt = $conn->prepare("SELECT l.voucher, u.username, u.nama_pt, lb.nama_lomba
                                FROM tbl_lomba_mahasiswa AS l
                                JOIN user_lists AS u ON l.id_userx = u.id_userx
                                JOIN tbl_lomba AS lb ON l.id_lomba = lb.id_lomba
                                WHERE u.username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $voucher = $user['voucher'];  // Ambil nilai voucher dari database
            $kampus = substr($user['nama_pt'], 0, 30);
            $lomba = $user['nama_lomba'];

            // Fetch ticket details from database.php
            include 'database.php';
            $stmtTicket = $conn->prepare("SELECT harga FROM rute WHERE id = :ticketId");
            $stmtTicket->execute(['ticketId' => $ticketId]);
            $ticket = $stmtTicket->fetch(PDO::FETCH_ASSOC);

            if ($ticket) {
                $price = $ticket['harga'];

                // Jika voucher tersedia dan nilai voucher ada
                if (!empty($voucher)) {
                    // Voucher ditemukan, beri diskon 5%
                    $discountedPrice = $price * 0.95; // Apply 5% discount
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Selamat $kampus! telah memenangkan lomba $lomba <br> Anda berhak mendapat diskon 5%.",
                        'discounted_price' => number_format($discountedPrice, 0, ',', '.')
                    ]);
                } else {
                    // Voucher tidak ditemukan, beri harga normal
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Harga tiket normal!",
                        'price' => number_format($price, 0, ',', '.')
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => "Tiket tidak ditemukan."
                ]);
            }
        } else {
            // Username tidak ditemukan
            echo json_encode([
                'status' => 'error',
                'message' => "Username tidak ditemukan. Harga tiket normal!"
            ]);
        }
    }

    private function renderView()
    {
        // Menampilkan halaman view dengan data yang diperlukan
        include 'database2.php'; // Pastikan koneksi ke database tersedia

        // Contoh pengambilan data untuk ditampilkan di view
        $username = 'user123';  // Ini bisa diganti berdasarkan input pengguna
        $ticketId = 2;          // Ini juga bisa diganti sesuai input

        $stmt = $conn->prepare("SELECT l.voucher, u.username, u.nama_pt, lb.nama_lomba
                                FROM tbl_lomba_mahasiswa AS l
                                JOIN user_lists AS u ON l.id_userx = u.id_userx
                                JOIN tbl_lomba AS lb ON l.id_lomba = lb.id_lomba
                                WHERE u.username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $voucher = $user['voucher'];  // Ambil nilai voucher dari database
            $kampus = substr($user['nama_pt'], 0, 30);
            $lomba = $user['nama_lomba'];

            // Fetch ticket details from database.php
            include 'database.php';
            $stmtTicket = $conn->prepare("SELECT harga FROM rute WHERE id = :ticketId");
            $stmtTicket->execute(['ticketId' => $ticketId]);
            $ticket = $stmtTicket->fetch(PDO::FETCH_ASSOC);

            if ($ticket) {
                $price = $ticket['harga'];

                // Jika voucher tersedia dan nilai voucher ada
                if (!empty($voucher)) {
                    // Voucher ditemukan, beri diskon 5%
                    $discountedPrice = $price * 0.95; // Apply 5% discount
                    include 'view.php'; // Menampilkan tampilan untuk halaman biasa
                    echo "<h3>Selamat $kampus! Telah memenangkan lomba $lomba</h3>";
                    echo "<p>Anda berhak mendapat diskon 5%. Harga tiket setelah diskon: Rp " . number_format($discountedPrice, 0, ',', '.') . "</p>";
                } else {
                    // Voucher tidak ditemukan, beri harga normal
                    include 'view.php'; // Menampilkan tampilan untuk halaman biasa
                    echo "<h3>Harga tiket normal: Rp " . number_format($price, 0, ',', '.') . "</h3>";
                }
            } else {
                echo "<p>Tiket tidak ditemukan.</p>";
            }
        } else {
            // Username tidak ditemukan
            echo "<p>Username tidak ditemukan. Harga tiket normal!</p>";
        }
    }
}

// Inisialisasi controller dan menangani request
$controller = new Controller();
$controller->handleRequest();
?>
