<?php

class InventoryController {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($type, $quantity, $price) {
        $stmt = $this->db->prepare("INSERT INTO inventory (type, quantity, price) VALUES (?, ?, ?)");
        $stmt->execute([$type, $quantity, $price]);
    }

    public function read() {
        $stmt = $this->db->query("SELECT * FROM inventory");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $type, $quantity, $price) {
        $stmt = $this->db->prepare("UPDATE inventory SET type = ?, quantity = ?, price = ? WHERE id = ?");
        $stmt->execute([$type, $quantity, $price, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->execute([$id]);
    }
}