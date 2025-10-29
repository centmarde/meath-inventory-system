<?php
session_start();
require_once '../../src/controllers/InventoryController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$inventoryController = new InventoryController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $inventoryController->deleteInventoryItem($id);
    
    if ($result) {
        header('Location: /views/inventory/list.php?message=Item deleted successfully');
    } else {
        echo "Error deleting item.";
    }
} else {
    echo "No item ID provided.";
}
?>