<?php

class Inventory {
    public $id;
    public $type; // pig, chicken, beef
    public $quantity;
    public $price;

    public function __construct($id, $type, $quantity, $price) {
        $this->id = $id;
        $this->type = $type;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function save() {
        // Logic to save inventory item to the database
    }

    public function update() {
        // Logic to update inventory item in the database
    }

    public function delete() {
        // Logic to delete inventory item from the database
    }

    public static function findAll() {
        // Logic to retrieve all inventory items from the database
    }

    public static function findById($id) {
        // Logic to retrieve a specific inventory item by ID from the database
    }
}