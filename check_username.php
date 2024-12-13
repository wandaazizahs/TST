<?php
include 'database2.php'; // Koneksi ke database2

if (isset($_POST['username']) && isset($_POST['ticketId'])) {
    $username = $_POST['username'];
    $ticketId = $_POST['ticketId'];

    // Query untuk mencari user berdasarkan username dan mengambil ultah dari tabel tbl_perguruan_tinggi
    $stmt = $conn->prepare("SELECT u.kode_pt, pt.ultah, pt.nama_pts FROM user_lists u JOIN tbl_perguruan_tinggi pt ON u.kode_pt = pt.kd_pts WHERE u.username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if today is the user's birthday
        $today = date('m-d');
        $birthday = date('m-d', strtotime($user['ultah'])); // Format ulang tanggal ulang tahun
        $kampus = substr($user['nama_pts'], 0, 30);  // Mengambil 5 karakter pertama dari nama_pts
        // Fetch ticket details from database.php
        include 'database.php';
        $stmtTicket = $conn->prepare("SELECT harga FROM rute WHERE id = :ticketId");
        $stmtTicket->execute(['ticketId' => $ticketId]);
        $ticket = $stmtTicket->fetch(PDO::FETCH_ASSOC);

        if ($ticket) {
            $price = $ticket['harga'];

            // Check for birthday discount
            if ($today == $birthday) {
                $discountedPrice = $price * 0.9; // Apply 10% discount
                echo "Selamat Ulang Tahun untuk $kampus! <br> Anda mendapatkan diskon 10%. Harga tiket setelah diskon: Rp " . number_format($discountedPrice, 0, ',', '.');
            } else {
                echo "Harga tiket normal! Rp " . number_format($price, 0, ',', '.');
            }
        } else {
            echo "Tiket tidak ditemukan.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>
