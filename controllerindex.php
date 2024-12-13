<?php
include 'database.php';

class TstController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTicket() {
        // Query dengan JOIN antara transportasi dan rute berdasarkan transportasi_id
        $query = "SELECT t.id, t.name AS transportasi, r.tujuan, r.jam, r.harga, r.start, r.end
                  FROM transportasi t
                  INNER JOIN rute r ON t.id = r.transportasi_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$ticketController = new TstController($conn);
$ticketData = $ticketController->getTicket();
?>
