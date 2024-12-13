<?php
include 'database2.php'; // Koneksi ke database2

if (isset($_POST['username']) && isset($_POST['ticketId'])) {
    $username = $_POST['username'];
    $ticketId = $_POST['ticketId'];

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
                echo "Selamat $kampus! telah memenangkan lomba $lomba <br> Anda berhak mendapat diskon 5%. Harga tiket setelah diskon: Rp " . number_format($discountedPrice, 0, ',', '.');
            } else {
                // Voucher tidak ditemukan, beri harga normal
                echo "Harga tiket normal! Rp " . number_format($price, 0, ',', '.');
            }
        } else {
            echo "Tiket tidak ditemukan.";
        }
    } else {
        // Username tidak ditemukan
        echo "Username tidak ditemukan. Harga tiket normal!";
    }
} else {
    echo "Data tidak lengkap.";
}
?>
